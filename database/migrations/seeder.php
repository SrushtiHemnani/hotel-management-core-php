<?php

require __DIR__ . '/../../bootstrap/bootstrap.php';

use Illuminate\Database\Capsule\Manager as Capsule;


Capsule::statement('SET FOREIGN_KEY_CHECKS=0;');

// truncate tables
Capsule::table('activity_log')->truncate();
Capsule::table('reservations')->truncate();
Capsule::table('booking_details')->truncate();
Capsule::table('bookings')->truncate();
Capsule::table('roles')->truncate();
Capsule::table('identifications')->truncate();
Capsule::table('room_pricing')->truncate();
Capsule::table('rooms')->truncate();
Capsule::table('hotels')->truncate();
Capsule::table('persons')->truncate();


Capsule::statement('SET FOREIGN_KEY_CHECKS=1;');


// Insert persons
Capsule::table('persons')->insertOrIgnore([
    ['name' => 'John Doe', 'email' => 'john.doe@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '123-456-7890', 'age' => 30, 'address' => '123 Elm Street', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['name' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '987-654-3210', 'age' => 28, 'address' => '456 Oak Avenue', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['name' => 'Alice Johnson', 'email' => 'alice.johnson@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '555-555-5555', 'age' => 35, 'address' => '789 Pine Road', 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['name' => 'Tom Brown', 'email' => 'tom.brown@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '111-222-3333', 'age' => 40, 'address' => '321 Maple Street', 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['name' => 'Emma White', 'email' => 'emma.white@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '444-555-6666', 'age' => 32, 'address' => '654 Birch Lane', 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['name' => 'Oliver Green', 'email' => 'oliver.green@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '777-888-9999', 'age' => 29, 'address' => '987 Cedar Avenue', 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['name' => 'Sophia Black', 'email' => 'sophia.black@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '000-111-2222', 'age' => 27, 'address' => '654 Willow Drive', 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

    ['name' => 'Liam Brown', 'email' => 'liam.brown@example.com', 'password' => password_hash('password123', PASSWORD_DEFAULT), 'phone' => '333-444-5555', 'age' => 35, 'address' => '321 Elm Street', 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

]);

// Insert roles
Capsule::table('roles')->insertOrIgnore([
    ['person_id' => 1, 'role' => 'admin', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 2, 'role' => 'user', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 3, 'role' => 'user', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 4, 'role' => 'user', 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['person_id' => 5, 'role' => 'user', 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['person_id' => 6, 'role' => 'user', 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['person_id' => 7, 'role' => 'user', 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['person_id' => 8, 'role' => 'user', 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

]);

// Insert identifications
Capsule::table('identifications')->insertOrIgnore([
    ['person_id' => 1, 'identification_type' => 'passport', 'identification_number' => 'P123456789', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 2, 'identification_type' => 'driver_license', 'identification_number' => 'D987654321', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 3, 'identification_type' => 'ID_card', 'identification_number' => 'ID55555555', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 4, 'identification_type' => 'passport', 'identification_number' => 'P987654321', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 5, 'identification_type' => 'driver_license', 'identification_number' => 'D123456789', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 6, 'identification_type' => 'ID_card', 'identification_number' => 'ID98765432', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 7, 'identification_type' => 'passport', 'identification_number' => 'P123987654', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 8, 'identification_type' => 'driver_license', 'identification_number' => 'D567890123', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

]);

// Insert hotels
Capsule::table('hotels')->insertOrIgnore([
    ['name' => 'Hotel 1', 'location' => 'Downtown City', 'created_at' => now(), 'updated_at' => now()],
    ['name' => 'Hotel 2', 'location' => 'Suburbia', 'created_at' => now(), 'updated_at' => now()],
]);

// Insert rooms
Capsule::table('rooms')->insertOrIgnore([
    ['hotel_id' => 1, 'room_type' => 'SINGLE_ROOM', 'capacity' => 1, 'is_extra' => 0, 'created_at' => now(), 'updated_at' => now()],

    ['hotel_id' => 1, 'room_type' => 'DOUBLE_ROOM', 'capacity' => 2, 'is_extra' => 0, 'created_at' => now(), 'updated_at' => now()],

    ['hotel_id' => 1, 'room_type' => 'TRIPLE_ROOM', 'capacity' => 3, 'is_extra' => 0, 'created_at' => now(), 'updated_at' => now()],

    ['hotel_id' => 1, 'room_type' => 'EXTRA_BED', 'capacity' => 1, 'is_extra' => 1, 'created_at' => now(), 'updated_at' => now()],

    ['hotel_id' => 2, 'room_type' => 'SINGLE_ROOM', 'capacity' => 1, 'is_extra' => 0, 'created_at' => now(), 'updated_at' => now()],

    ['hotel_id' => 2, 'room_type' => 'DOUBLE_ROOM', 'capacity' => 2, 'is_extra' => 0, 'created_at' => now(), 'updated_at' => now()],

    ['hotel_id' => 2, 'room_type' => 'TRIPLE_ROOM', 'capacity' => 3, 'is_extra' => 0, 'created_at' => now(), 'updated_at' => now()],

    ['hotel_id' => 2, 'room_type' => 'EXTRA_BED', 'capacity' => 1, 'is_extra' => 1, 'created_at' => now(), 'updated_at' => now()],

]);

// Insert room pricing
function now()
{
    return date('Y-m-d H:i:s');
}

Capsule::table('room_pricing')->insertOrIgnore([
    ['room_id' => 1, 'price' => 1500, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

    ['room_id' => 2, 'price' => 2000, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

    ['room_id' => 3, 'price' => 2750, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

    ['room_id' => 4, 'price' => 500, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

    ['room_id' => 5, 'price' => 1500, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

    ['room_id' => 6, 'price' => 2000, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

    ['room_id' => 7, 'price' => 2750, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

    ['room_id' => 8, 'price' => 500, 'start_date' => '2024-01-01', 'created_at' => now(), 'updated_at' => now()],

]);

// Insert bookings
Capsule::table('bookings')->insertOrIgnore([
    ['person_id' => 2, 'total_guests' => 5, 'total_rooms' => 3, 'total_days' => 3, 'total_price' => 7000, 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 3, 'total_guests' => 4, 'total_rooms' => 2, 'total_days' => 2, 'total_price' => 5000, 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['person_id' => 4, 'total_guests' => 6, 'total_rooms' => 4, 'total_days' => 1, 'total_price' => 5000, 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['person_id' => 5, 'total_guests' => 4, 'total_rooms' => 2, 'total_days' => 4, 'total_price' => 6000, 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

    ['person_id' => 6, 'total_guests' => 7, 'total_rooms' => 3, 'total_days' => 3, 'total_price' => 7500, 'created_at' => '2024-11-01 09:00:00', 'updated_at' => '2024-11-01 09:00:00'],

]);

// Insert booking details
Capsule::table('booking_details')->insertOrIgnore([
    ['booking_id' => 1, 'room_id' => 2, 'check_in' => '2024-08-01', 'check_out' => '2024-08-04', 'price_at_booking' => 2000, 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['booking_id' => 1, 'room_id' => 3, 'check_in' => '2024-08-01', 'check_out' => '2024-08-04', 'price_at_booking' => 2750, 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['booking_id' => 2, 'room_id' => 2, 'check_in' => '2024-08-08', 'check_out' => '2024-08-10', 'price_at_booking' => 2000, 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['booking_id' => 2, 'room_id' => 3, 'check_in' => '2024-08-08', 'check_out' => '2024-08-10', 'price_at_booking' => 2750, 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['booking_id' => 3, 'room_id' => 1, 'check_in' => '2024-08-10', 'check_out' => '2024-08-11', 'price_at_booking' => 1500, 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['booking_id' => 3, 'room_id' => 2, 'check_in' => '2024-08-10', 'check_out' => '2024-08-11', 'price_at_booking' => 2000, 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['booking_id' => 4, 'room_id' => 1, 'check_in' => '2024-08-15', 'check_out' => '2024-08-19', 'price_at_booking' => 1500, 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['booking_id' => 4, 'room_id' => 2, 'check_in' => '2024-08-15', 'check_out' => '2024-08-19', 'price_at_booking' => 2000, 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['booking_id' => 5, 'room_id' => 3, 'check_in' => '2024-08-20', 'check_out' => '2024-08-23', 'price_at_booking' => 2750, 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

    ['booking_id' => 5, 'room_id' => 4, 'check_in' => '2024-08-20', 'check_out' => '2024-08-23', 'price_at_booking' => 500, 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

]);

// Insert reservations
Capsule::table('reservations')->insertOrIgnore([
    ['booking_detail_id' => 1, 'person_id' => 2, 'person_type' => 'customer', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['booking_detail_id' => 2, 'person_id' => 3, 'person_type' => 'guest', 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['booking_detail_id' => 3, 'person_id' => 4, 'person_type' => 'customer', 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['booking_detail_id' => 4, 'person_id' => 5, 'person_type' => 'guest', 'created_at' => '2024-08-01 09:00:00', 'updated_at' => '2024-08-01 09:00:00'],

    ['booking_detail_id' => 5, 'person_id' => 6, 'person_type' => 'customer', 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['booking_detail_id' => 6, 'person_id' => 2, 'person_type' => 'guest', 'created_at' => '2024-09-01 09:00:00', 'updated_at' => '2024-09-01 09:00:00'],

    ['booking_detail_id' => 7, 'person_id' => 4, 'person_type' => 'guest', 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

    ['booking_detail_id' => 8, 'person_id' => 5, 'person_type' => 'customer', 'created_at' => '2024-10-01 09:00:00', 'updated_at' => '2024-10-01 09:00:00'],

]);

// Insert activity logs 2 no wala phle c
Capsule::table('activity_log')->insertOrIgnore([
    ['person_id' => 1, 'event' => 'created', 'subject_type' => 'Booking', 'subject_id' => 1, 'properties' => json_encode(['total_price' => 7000]), 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 2, 'event' => 'created', 'subject_type' => 'Booking', 'subject_id' => 2, 'properties' => json_encode(['total_price' => 5000]), 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 3, 'event' => 'created', 'subject_type' => 'Booking', 'subject_id' => 3, 'properties' => json_encode(['total_price' => 5000]), 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 4, 'event' => 'created', 'subject_type' => 'Booking', 'subject_id' => 4, 'properties' => json_encode(['total_price' => 6000]), 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

    ['person_id' => 5, 'event' => 'updated', 'subject_type' => 'Booking', 'subject_id' => 5, 'properties' => json_encode(['total_price' => 7500]), 'created_at' => '2024-07-01 09:00:00', 'updated_at' => '2024-07-01 09:00:00'],

]);

echo "Seeder completed.\n";
