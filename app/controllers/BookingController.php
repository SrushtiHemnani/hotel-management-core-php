<?php


namespace App\controllers;


use App\models\BookingGuest;
use DateTime;
use App\models\Room;
use App\models\Guest;
use App\models\Booking;
use App\models\Customer;
use App\services\BookingService;
use function Symfony\Component\Clock\now;


/**
 *
 */
class BookingController extends BaseController
{
    /**
     * @return void
     */
    // File: app/controllers/BookingController.php


    public function index()
    {
        $bookings = Booking::with(['customer', 'associatedBookings', 'room', 'guests', 'associatedBookings.guests', 'associatedBookings.room'])
            ->whereNull('parent_id')
            ->groupBy(['customer_id','booking_number', 'check_in', 'check_out', 'room_number', 'room_type','room_price','total_price'])
            ->selectRaw('MAX(id) as id, booking_number , customer_id, check_in, check_out, room_number, room_type,room_price, total_price') // Include room_number, room_type, total_price
            ->get();


        $this->view('booking/index', ["bookings" => $bookings]);
    }

    public function index_old()
    {
        $booking = Booking::with([
            'customer' => function ($query) {
                $query->with('guests');
            },
            'rooms',
        ])->get()->toArray();




        $this->view('booking/index_old', [ "booking" => $booking ]);


    }


    public function edit($id)
    {
        $booking = Booking::with([ 'customer', 'associatedBookings', 'room', 'guests', 'associatedBookings.guests', 'associatedBookings.room' ])
            ->whereNull('parent_id')->where('id', $id)
            ->firstOrFail();


        $this->view('booking/edit', [ "booking" => $booking ]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [ $check_in_date, $check_out_date, $nights ] = $this->handleDates($_POST['daterange']);
            $guestData = $this->mapGuestNameAndAge($_POST);
            $bookingService = new BookingService();
            $result = $bookingService->calculateRooms($guestData);

            // Update or create customer
            $customerData = $this->getCustomerData($_POST);
            $customer = $this->createOrUpdateCustomer($customerData);

            // Find the booking to update
            $booking = Booking::with([ 'room', 'guests' ])
                ->where('id', $id)
                ->firstOrFail();

            // Update booking details
            $roomAllocations = $result['ROOM_ALLOCATION'];
            $parentBookingData = $this->findCustomer($roomAllocations, $customerData['name'], $customerData['age']);


            $this->updateBooking(
                $booking,
                $parentBookingData,
                $customer,
                $check_in_date,
                $check_out_date,
                $nights,
                $bookingService
            );

            // Update or create guests for the booking
            $this->updateGuests($parentBookingData, $customer, $booking);


            // Update room allocations for the booking
            $this->updateRoomAllocations(
                $roomAllocations,
                $customer,
                $check_in_date,
                $check_out_date,
                $nights,
                $bookingService,
                $booking->id
            );
            // Update extra bed booking if needed
            $this->updateExtraBedBooking(
                $parentBookingData,
                $customer,
                $booking,
                $check_in_date,
                $check_out_date,
                $nights,
                $bookingService
            );


            header('Location: /booking');
        } else {
            // Display the form for editing if GET request
            $booking = Booking::with([ 'customer', 'associatedBookings', 'room', 'guests', 'associatedBookings.guests', 'associatedBookings.room' ])
                ->where('id', $id)
                ->firstOrFail();

            $this->view('booking/edit', [ "booking" => $booking ]);
        }
    }

    private function updateBooking($booking, $parentBookingData, $customer, $check_in_date, $check_out_date, $nights, $bookingService)
    {
        $room = Room::where('room_type', $parentBookingData['type'])->first();

        $booking->update([
            'room_id'     => $room->id,
            'room_number' => $booking->room_number ?? $this->generateRoomNumber(),
            'room_type'   => $room->room_type,
            'room_price'  => $room->room_price,
            'customer_id' => $customer->id,
            'check_in'    => $check_in_date,
            'check_out'   => $check_out_date,
            'total_price' => $bookingService->calculateCost($nights),
        ]);
    }

    private function updateGuests($parentBookingData, $customer, $booking)
    {
        // Remove existing guests
        BookingGuest::where('booking_id', $booking->id)->delete();
        // Add or update guests
        foreach ($parentBookingData['guests'] as $guest) {
            if ($guest['name'] === $customer->name && $guest['age'] === $customer->age) {
                continue;
            }
            $guestModel = Guest::updateOrCreate(
                [ 'name' => $guest['name'], 'age' => $guest['age'], 'customer_id' => $customer->id ],
                [ 'name' => $guest['name'], 'age' => $guest['age'] ]
            );
            BookingGuest::updateOrCreate(
                [ 'booking_id' => $booking->id, 'guest_id' => $guestModel->id ],
                [ 'booking_id' => $booking->id, 'guest_id' => $guestModel->id ]
            );
        }
    }

    private function updateExtraBedBooking($parentBookingData, $customer, $booking, $check_in_date, $check_out_date, $nights, $bookingService)
    {
        // Remove existing extra bed booking if it exists
        Booking::where('parent_id', $booking->id)->where('room_type', 'EXTRA_BED')->delete();

        if (isset($parentBookingData['extra'])) {

            // Ensure the room type for the extra bed exists
            $extraBed = Room::where('room_type', "EXTRA_BED")->first();

            if (!$extraBed) {
                // Log or handle the case where the extra bed room type is not found
                error_log('Extra bed room type not found');
                return;
            }

            // Create new booking for the extra bed
            $extraBedBooking = Booking::create([
                'room_id'     => $extraBed->id,
                'room_number' => $this->generateRoomNumber(), // Ensure this generates a unique room number
                'room_type'   => $extraBed->room_type,
                'room_price'  => $extraBed->room_price,
                'customer_id' => $customer->id,
                'check_in'    => $check_in_date,
                'check_out'   => $check_out_date,
                'total_price' => $bookingService->calculateCost($nights),
                'parent_id'   => $booking->id,
            ]);

            // Add or update guest for the extra bed
            $extra = Guest::updateOrCreate(
                [ 'name' => $parentBookingData['extra']['name'], 'age' => $parentBookingData['extra']['age'], 'customer_id' => $customer->id ],
                [ 'name' => $parentBookingData['extra']['name'], 'age' => $parentBookingData['extra']['age'] ]
            );

            BookingGuest::updateOrCreate(
                [ 'booking_id' => $extraBedBooking->id, 'guest_id' => $extra->id ],
                [ 'booking_id' => $extraBedBooking->id, 'guest_id' => $extra->id ]
            );
        }
    }

    private function updateRoomAllocations($roomAllocations, $customer, $check_in_date, $check_out_date, $nights, $bookingService, $parentId = null)
    {
        if (!isset($roomAllocations)) {
            return;
        }
        // Remove existing room allocations for the booking
        Booking::where('parent_id', $parentId)->delete();

        foreach ($roomAllocations as $roomAllocation) {
            $room = Room::where('room_type', $roomAllocation['type'])->first();
            $booking = Booking::updateOrCreate(
                [ 'room_id' => $room->id, 'room_number' => $this->generateRoomNumber(), 'room_type' => $room->room_type, 'customer_id' => $customer->id, 'check_in' => $check_in_date, 'check_out' => $check_out_date, 'parent_id' => $parentId ],
                [ 'room_price' => $room->room_price, 'total_price' => $bookingService->calculateCost($nights) ]
            );

            foreach ($roomAllocation['guests'] as $guest) {
                $guestModel = Guest::updateOrCreate(
                    [ 'name' => $guest['name'], 'age' => $guest['age'], 'customer_id' => $customer->id ],
                    [ 'name' => $guest['name'], 'age' => $guest['age'] ]
                );
                BookingGuest::updateOrCreate(
                    [ 'booking_id' => $booking->id, 'guest_id' => $guestModel->id ],
                    [ 'booking_id' => $booking->id, 'guest_id' => $guestModel->id ]
                );
            }

            if (isset($roomAllocation['extra'])) {
                $extraBed = Room::where('room_type', "EXTRA_BED")->first();
                $extraBedBooking = Booking::updateOrCreate(
                    [ 'room_id' => $extraBed->id, 'room_number' => $booking->room_number, 'room_type' => $extraBed->room_type, 'customer_id' => $customer->id, 'check_in' => $check_in_date, 'check_out' => $check_out_date, 'parent_id' => $booking->id ],
                    [ 'room_price' => $extraBed->room_price, 'total_price' => $bookingService->calculateCost($nights) ]
                );
                $extra = Guest::updateOrCreate(
                    [ 'name' => $roomAllocation['extra']['name'], 'age' => $roomAllocation['extra']['age'], 'customer_id' => $customer->id ],
                    [ 'name' => $roomAllocation['extra']['name'], 'age' => $roomAllocation['extra']['age'] ]
                );
                BookingGuest::updateOrCreate(
                    [ 'booking_id' => $extraBedBooking->id, 'guest_id' => $extra->id ],
                    [ 'booking_id' => $extraBedBooking->id, 'guest_id' => $extra->id ]
                );
            }
        }
    }


    /**
     * @return void
     */
    public function getBooking()
    {
        header('Content-Type: application/json');
        $request = $_GET;
        $query = Booking::with('customer', 'rooms');    // Eager load the customer and rooms

        $start = intval($request['start']);
        $length = intval($request['length']);
        $totalRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();


        $formattedData = $data->map(function ($booking) {
            $rooms = $booking?->rooms?->room_type;
            return [
                'customer_name' => $booking->customer->name,
                'total_price'   => '&#8377;' . $booking->total_price,
                'check_in'      => $booking->check_in,
                'check_out'     => $booking->check_out,
                'guest'         => $booking->customer->guests,
                'rooms'         => $rooms,
            ];
        });

        $response = [
            'draw'            => intval($request['draw']),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $formattedData,
        ];

        echo json_encode($response);
    }

    private function mapGuestNameAndAge(array $guestData)
    {
        $bookingData = [
            [
                'name' => $guestData['name'],
                'age'  => $guestData['age'],
            ],
        ];
        foreach ($guestData['guest_name'] as $index => $guestName) {
            $bookingData[] = [
                'name' => $guestName,
                'age'  => $guestData['guest_age'][ $index ],
            ];
        }
        return $bookingData;
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            [ $check_in_date, $check_out_date, $nights ] = $this->handleDates($_POST['daterange']);
            $guestData = $this->mapGuestNameAndAge($_POST);
            $bookingService = new BookingService();
            $result = $bookingService->calculateRooms($guestData);

            // Create or update customer
            $customerData = $this->getCustomerData($_POST);
            $customer = $this->createOrUpdateCustomer($customerData);

            // Find the parent booking
            $roomAllocations = $result['ROOM_ALLOCATION'];
            $parentBookingData = $this->findCustomer($roomAllocations, $customerData['name'], $customerData['age']);

            // Create the parent booking
            $parentBooking = $this->createBooking(
                $parentBookingData,
                $customer,
                $check_in_date,
                $check_out_date,
                $nights,
                $bookingService
            );

            // Create guests for the parent booking
            $this->createGuests($parentBookingData, $customer, $parentBooking);

            // Create extra bed booking if needed
            $this->createExtraBedBooking(
                $parentBookingData,
                $customer,
                $parentBooking,
                $check_in_date,
                $check_out_date,
                $nights,
                $bookingService
            );

            // Create room allocations for the parent booking
            $this->createRoomAllocations(
                $roomAllocations,
                $customer,
                $check_in_date,
                $check_out_date,
                $nights,
                $bookingService,
                $parentBooking->id // Pass parent booking ID here
            );

            header('Location: /booking');
        }
        $this->view('booking/create');
    }

    private function createRoomAllocations($roomAllocations, $customer, $check_in_date, $check_out_date, $nights, $bookingService, $parentId = null)
    {
        if (isset($roomAllocations)) {
            foreach ($roomAllocations as $roomAllocation) {
                $room = Room::where('room_type', $roomAllocation['type'])->first();
                $booking = Booking::create([
                    'room_id'     => $room->id,
                    'room_number' => $this->generateRoomNumber(),
                    'room_type'   => $room->room_type,
                    'room_price'  => $room->room_price,
                    'customer_id' => $customer->id,
                    'check_in'    => $check_in_date,
                    'check_out'   => $check_out_date,
                    'total_price' => $bookingService->calculateCost($nights),
                    'parent_id'   => $parentId, // Set parent ID for child bookings
                ]);

                foreach ($roomAllocation['guests'] as $guest) {
                    $guest = Guest::create([
                        'name'        => $guest['name'],
                        'age'         => $guest['age'],
                        'customer_id' => $customer->id,
                    ]);
                    BookingGuest::create([
                        'booking_id' => $booking->id,
                        'guest_id'   => $guest->id,
                    ]);
                }

                if (isset($roomAllocation['extra'])) {
                    $extraBed = Room::where('room_type', "EXTRA_BED")->first();
                    $extraBedBooking = Booking::create([
                        'room_id'     => $extraBed->id,
                        'room_number' => $booking->room_number,
                        'room_type'   => $extraBed->room_type,
                        'room_price'  => $extraBed->room_price,
                        'customer_id' => $customer->id,
                        'check_in'    => $check_in_date,
                        'check_out'   => $check_out_date,
                        'total_price' => $bookingService->calculateCost($nights),
                        'parent_id'   => $booking->id,
                    ]);
                    $extra = Guest::create([
                        'name'        => $roomAllocation['extra']['name'],
                        'age'         => $roomAllocation['extra']['age'],
                        'customer_id' => $customer->id,
                    ]);
                    BookingGuest::create([
                        'booking_id' => $extraBedBooking->id,
                        'guest_id'   => $extra->id,
                    ]);
                }
            }
        }
    }

    private function handleDates($daterange)
    {
        if (isset($daterange)) {
            $dates = explode(' - ', $daterange);
            $check_in_date = $dates[0];
            $check_out_date = $dates[1];
        } else {
            $check_in_date = now();
            $check_out_date = now();
        }
        $check_in = DateTime::createFromFormat('m/d/Y', $check_in_date);
        $check_out = DateTime::createFromFormat('m/d/Y', $check_out_date);
        $interval = $check_in->diff($check_out);
        $nights = $interval->days;
        return [ $check_in_date, $check_out_date, $nights ];
    }

    private function getCustomerData($postData)
    {
        return [
            'name'    => $postData['name'],
            'age'     => $postData['age'],
            'email'   => $postData['email'],
            'phone'   => $postData['phone'],
            'address' => $postData['address'] ?? "",
        ];
    }

    private function createOrUpdateCustomer($customerData)
    {
        return Customer::updateOrCreate(
            [
                'email' => $customerData['email'],
                'phone' => $customerData['phone'],
            ],
            $customerData
        );
    }

    // File: app/controllers/BookingController.php


// File: app/controllers/BookingController.php


    private function createBooking($parentBooking, $customer, $check_in_date, $check_out_date, $nights, $bookingService)
    {
        $room = Room::where('room_type', $parentBooking['type'])->first();


        if (!$room) {
            // Handle the case where the room is not found
            throw new \Exception('Room type not found: ' . $parentBooking['type']);
        }


        return Booking::create([
            'room_id'     => $room->id,
            'room_number' => $this->generateRoomNumber(),
            'room_type'   => $room->room_type,
            'room_price'  => $room->room_price,
            'customer_id' => $customer->id,
            'check_in'    => $check_in_date,
            'check_out'   => $check_out_date,
            'total_price' => $bookingService->calculateCost($nights),
        ]);
    }

    private function createGuests($parentBooking, $customer, $booking)
    {
        foreach ($parentBooking['guests'] as $guest) {
            if ($guest['name'] === $customer->name && $guest['age'] === $customer->age) {
                continue;
            }
            $guest = Guest::create([
                'name'        => $guest['name'],
                'age'         => $guest['age'],
                'customer_id' => $customer->id,
            ]);
            BookingGuest::create([
                'booking_id' => $booking->id,
                'guest_id'   => $guest->id,
            ]);
        }
    }

    private function createExtraBedBooking($parentBooking, $customer, $booking, $check_in_date, $check_out_date, $nights, $bookingService)
    {
        if (isset($parentBooking['extra'])) {
            $extraBed = Room::where('room_type', "EXTRA_BED")->first();
            $extraBedBooking = Booking::create([
                'room_id'     => $extraBed->id,
                'room_number' => $booking->room_number,
                'room_type'   => $extraBed->room_type,
                'room_price'  => $extraBed->room_price,
                'customer_id' => $customer->id,
                'check_in'    => $check_in_date,
                'check_out'   => $check_out_date,
                'total_price' => $bookingService->calculateCost($nights),
                'parent_id'   => $booking->id,
            ]);
            $extra = Guest::create([
                'name'        => $parentBooking['extra']['name'],
                'age'         => $parentBooking['extra']['age'],
                'customer_id' => $customer->id,
            ]);
            BookingGuest::create([
                'booking_id' => $extraBedBooking->id,
                'guest_id'   => $extra->id,
            ]);
        }
    }


    function findCustomer(&$roomAllocations, $customerName, $customerAge)
    {

        foreach ($roomAllocations as $index => $room) {

            // Check in the guests array
            if (isset($room['guest'])) {
                if ($room['guest']['name'] === $customerName && $room['guest']['age'] === $customerAge) {
                    // unset found room
                    unset($roomAllocations[ $index ]);  // remove the room from the list
                    return $room;
                }

            }
            if (isset($room['guests'])) {
                foreach ($room['guests'] as $guest) {
                    if ($guest['name'] === $customerName && $guest['age'] === $customerAge) {
                        unset($roomAllocations[ $index ]);  // remove the room from the list
                        return $room;
                    }
                }
            }

            // Check in the extra field if it exists
            if (isset($room['extra']) && $room['extra']['name'] === $customerName && $room['extra']['age'] === $customerAge) {
                unset($roomAllocations[ $index ]);  // remove the room from the list
                return $room;
            }
        }
        return null; // Customer not found
    }


    /**
     * @return int
     */
    private function generateRoomNumber()
    {
        // Generate room number logic, could be more complex if needed
        return rand(100, 999);
    }


    /**
     * @return void
     */
    public function calculateCostEstimateAndAllocation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate the data
            $errors = $this->validateBookingData();
            if (!empty($errors)) {
                header('Content-Type: application/json');
                echo json_encode([ 'errors' => $errors ]);
                return;
            }
            [ $check_in_date, $check_out_date, $nights ] = $this->handleDates($_POST['daterange']);
            $guestData = $this->mapGuestNameAndAge($_POST);
            $bookingService = new BookingService();
            $result = $bookingService->calculateRooms($guestData);


            $cost = $bookingService->calculateCost($nights);

            // Return the result as a JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'rooms' => $result,
                'cost'  => $cost,
            ]);
        }
    }

    /**
     * @return array
     */
    public function validateBookingData()
    {
        $errors = [];

        // Check if age is set and is a number
        if (!isset($_POST['age']) || !is_numeric($_POST['age'])) {
            $errors[] = 'Invalid age.';
        }

        // Check if guest_age is set and is an array
        if (!isset($_POST['guest_age']) || !is_array($_POST['guest_age'])) {
            $errors[] = 'Invalid guest age data.';
        } else {
            // Check if all guest ages are numbers
            foreach ($_POST['guest_age'] as $guest_age) {
                if (!is_numeric($guest_age)) {
                    $errors[] = 'Invalid guest age data.';
                    break;
                }
            }
        }

        return $errors;
    }

    public function delete($id)
    {
        $booking = Booking::with([ 'bookingGuest', 'parent', 'children' ])->where('id', $id)->first();  // Find the booking
        if ($booking) {
            $booking->delete();  // This will also delete related guests and children bookings due to cascading delete
        }                          // Delete the booking
        header('Location: /booking');
    }
}
