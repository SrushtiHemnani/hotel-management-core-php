<?php
include( 'partial/header.php' ); ?>

<link rel="stylesheet" type="text/css" href="<?= BASE_PATH ?>assets/css/vendors/daterange-picker.css">
<link rel="stylesheet" type="text/css" href="<?= BASE_PATH ?>assets/css/vendors/sweetalert2.css">

<?php
//include('partial/loader.php'); ?>

<div class="page-wrapper compact-wrapper" id="pageWrapper">
    <!-- Page Header Start-->
	<?php
	include( 'partial/topbar.php' ); ?>
    <!-- Page Header Ends -->

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
		<?php
		include( 'partial/sidebar.php' ); ?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
			<?php
			include( 'partial/breadcrumb.php' ); ?>
            <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Edit Booking</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="bookingForm" class="theme-form mega-form" method="post"
                                              action="<?= BASE_PATH ?>booking-update/<?=$booking->id?>">
                                            <h6>Personal Details</h6>
                                            <div class="mb-3">
                                                <label class="col-form-label">Full Name</label>
                                                <input class="form-control" type="text" id="fullName" name="name"
                                                       value="<?php
												       echo $booking->customer->name; ?>" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="email" id="email" name="email"
                                                       value="<?php
												       echo $booking->customer->email; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Phone Number</label>
                                                <input class="form-control" type="text" id="phoneNumber" name="phone"
                                                       value="<?php
												       echo $booking->customer->phone; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Customer Age</label>
                                                <input class="form-control" type="number" id="customerAge" name="age"
                                                       value="<?php
												       echo $booking->customer->age; ?>" required>
                                            </div>

                                            <h6>Booking Details</h6>
                                            <div class="mb-3">
                                                <label class="col-form-label">Check-in and Check-out</label>
                                                <input class="form-control" type="text" name="daterange" value="<?php
												echo $booking->check_in . ' - ' . $booking->check_out; ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Number of Nights</label>
                                                <input class="form-control" type="number" id="nights" name="nights"
                                                       readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label">Total Cost</label>
                                                <input class="form-control" type="text" id="totalCost" name="total_cost"
                                                       value="<?php
												       echo $booking->total_price; ?>" readonly>
                                            </div>

                                            <h6>Guests</h6>
                                            <div id="guests">
												
												<?php
												
												$customerName = $booking->customer->name;
												$customerAge = $booking->customer->age;
												
												$allGuests = $booking->guests
													->concat($booking->associatedBookings->pluck('guests')->flatten(1))
													->reject(function ($guest) use ($customerName, $customerAge) {
														return $guest->name == $customerName && $guest->age == $customerAge;
													});
												?>
												
												<?php
												foreach ($allGuests as $index => $guest) : ?>
                                                    <div class="guest card mb-3 p-3">
                                                        <h4>Guest <?php
															echo $index + 1; ?></h4>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Guest Name</label>
                                                            <input class="form-control" type="text" name="guest_name[]"
                                                                   value="<?php
															       echo $guest->name; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Guest Age</label>
                                                            <input class="form-control" type="number" name="guest_age[]"
                                                                   value="<?php
															       echo $guest->age; ?>">
                                                        </div>
                                                        <!-- show remove button in right side with small -->
                                                        <div class="row">
                                                            <button type="button" class="btn btn-danger remove-guest">
                                                                Remove
                                                            </button>
                                                        </div>
                                                    </div>
												<?php
												endforeach; ?>
                                            </div>
                                            <button type="button" class="btn btn-secondary mb-3" onclick="addGuest()">
                                                Add Guest
                                            </button>

                                            <div class="text-end">
                                                <button type="button" class="btn btn-primary" id="calculateCost">
                                                    Calculate Cost
                                                </button>
                                                <button type="submit" class="btn btn-success">Update Booking</button>
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </div>
		<?php
		include( 'partial/footer.php' ); ?>
    </div>
</div>

<?php
include( 'partial/scripts.php' ); ?>
<script src="<?= BASE_PATH ?>assets/js/tooltip-init.js"></script>
<?php
include( 'partial/footer-end.php' ); ?>

<script src="<?= BASE_PATH ?>assets/js/datepicker/daterange-picker/moment.min.js"></script>
<script src="<?= BASE_PATH ?>assets/js/datepicker/daterange-picker/daterangepicker.js"></script>
<script src="<?= BASE_PATH ?>assets/js/sweet-alert/sweetalert.min.js"></script>
<script src="<?= BASE_PATH ?>assets/js/sweet-alert/app.js"></script>
<script>
    let guestCounter = <?php echo count($allGuests); ?>;

    function addGuest() {
        guestCounter++;
        const guestDiv = document.createElement('div');
        guestDiv.classList.add('guest', 'card', 'mb-3', 'p-3');
        guestDiv.innerHTML = `
            <h4>Guest ${ guestCounter }</h4>
            <div class="form-group">
                <label class="form-label">Guest Full Name</label>
                <input class="form-control" type="text" name="guest_name[]" required>
            </div>

            <div class="form-group">
                <label class="form-label">Guest Age</label>
                <input class="form-control" type="number" name="guest_age[]" required>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-start mt-2 ">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeGuest(this)">Remove</button>
                    </div>
                </div>
            </div>
        `;
        document.getElementById('guests').appendChild(guestDiv);
    }

    function removeGuest(button) {
        const guestDiv = button.parentElement.parentElement.parentElement.parentElement;
        guestDiv.remove();
    }

    function calculateNights() {
        const dateRange = document.getElementsByName('daterange')[0].value.split(' - ');
        const checkInDate = moment(dateRange[0], 'MM/DD/YYYY');
        const checkOutDate = moment(dateRange[1], 'MM/DD/YYYY');

        if (checkInDate && checkOutDate) {
            const daysDifference = checkOutDate.diff(checkInDate, 'days');

            if (daysDifference > 0) {
                $("#nights").val(daysDifference);
                return daysDifference;
            } else {
                $("#nights").val(0);
                alert('Check-out date must be after the check-in date.');
            }
        } else {
            $("#nights").val(0); // Reset if dates are not fully selected
        }
    }

    $(function () {
        $('input[name="daterange"]').daterangepicker({
            autoUpdateInput: false,
            minDate: moment(), // Disallow past dates
            startDate: moment(), // Default start date is today
            endDate: moment(), // Default end date is today
            locale: {
                cancelLabel: 'Clear'
            }
        });
        $('input[name="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            calculateNights(); // Automatically calculate nights when date range is selected
        });

        $('input[name="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });

    });
    $(document).ready(function () {
        $('#calculateCost').click(function (event) {
            event.preventDefault();

            calculateNights();
            // Gather form data
            let formData = $('#bookingForm').serialize();

            // Send a POST request to the endpoint
            $.ajax({
                url: '<?=BASE_PATH?>booking-calculate-cost-estimate-and-allocation',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (data) {
                    // Populate form fields with returned data
                    $('#totalCost').val(data.cost);
                    $('#singleRooms').val(data.rooms.SINGLE_ROOM);
                    $('#doubleRooms').val(data.rooms.DOUBLE_ROOM);
                    $('#tripleRooms').val(data.rooms.TRIPLE_ROOM);
                    $('#extraBeds').val(data.rooms.EXTRA_BED);

                    if (!data.cost) {
                        // Display a sweet alert with an error message
                        swal({
                            title: 'Cost Calculation',
                            text: 'Please select a valid date range.',
                            icon: 'error'
                        });
                        return;
                    }

                    // Display a sweet alert with the returned data
                    swal({
                        title: 'Cost Calculation',
                        text: `Total Cost: ${ data.cost }\nSingle Rooms: ${ data.rooms.SINGLE_ROOM }\nDouble Rooms: ${ data.rooms.DOUBLE_ROOM }\nTriple Rooms: ${ data.rooms.TRIPLE_ROOM }\nExtra Beds: ${ data.rooms.EXTRA_BED }`,
                        icon: 'info'
                    });
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                }
            });
        });
        // check iff
    });
</script>
