<?php

$mysqli = new mysqli("localhost", "root", "", "hotel_db_1");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Drop tables in reverse order of dependencies
$tables = [
    'extra_reservations',
    'reservations',
    'payments',
    'billing',
    'booking_details',
    'bookings',
    'room_pricing',
    'room_facilities',
    'facilities',
    'rooms',
    'floors',
    'buildings',
    'room_categories',
    'extra_pricing',
    'extras',
    'roles',
    'hotels',
    'identifications',
    'activity_log',
    'persons'
];

foreach ($tables as $table) {
    $mysqli->query("DROP TABLE IF EXISTS $table");
}

// Create 'persons' table
$mysqli->query("
    CREATE TABLE persons (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE,
        password VARCHAR(255),
        phone VARCHAR(20),
        date_of_birth DATE,
        address VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL
    )
");

// Create 'hotels' table
$mysqli->query("
    CREATE TABLE hotels (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        star_rating DECIMAL(2, 1),
        location VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL
    )
");

// Create 'roles' table
$mysqli->query("
    CREATE TABLE roles (
        id INT AUTO_INCREMENT PRIMARY KEY,
        person_id INT NOT NULL,
        hotel_id INT,
        role ENUM('admin', 'user') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE(person_id, role, hotel_id),
        FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE,
        FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE SET NULL
    )
");

// Create 'buildings' table
$mysqli->query("
    CREATE TABLE buildings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hotel_id INT NOT NULL,
        name VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
    )
");

// Create 'floors' table
$mysqli->query("
    CREATE TABLE floors (
        id INT AUTO_INCREMENT PRIMARY KEY,
        building_id INT,
        hotel_id INT NOT NULL,
        floor_number INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        UNIQUE(hotel_id, building_id, floor_number),
        FOREIGN KEY (building_id) REFERENCES buildings(id) ON DELETE SET NULL,
        FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
    )
");

// Create 'room_categories' table
$mysqli->query("
    CREATE TABLE room_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        capacity INT NOT NULL,
        description VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL
    )
");

// Create 'rooms' table
$mysqli->query("
    CREATE TABLE rooms (
        id INT AUTO_INCREMENT PRIMARY KEY,
        hotel_id INT NOT NULL,
        floor_id INT NOT NULL,
        room_category_id INT NOT NULL,
        room_number VARCHAR(10) NOT NULL,
        is_available BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        UNIQUE(hotel_id, floor_id, room_number),
        FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE,
        FOREIGN KEY (floor_id) REFERENCES floors(id) ON DELETE CASCADE,
        FOREIGN KEY (room_category_id) REFERENCES room_categories(id) ON DELETE CASCADE
    )
");

// Create 'facilities' table
$mysqli->query("
    CREATE TABLE facilities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        facility VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL
    )
");

// Create 'room_facilities' table
$mysqli->query("
    CREATE TABLE room_facilities (
        id INT AUTO_INCREMENT PRIMARY KEY,
        room_id INT NOT NULL,
        facility_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
        FOREIGN KEY (facility_id) REFERENCES facilities(id) ON DELETE CASCADE
    )
");

// Create 'room_pricing' table
$mysqli->query("
    CREATE TABLE room_pricing (
        id INT AUTO_INCREMENT PRIMARY KEY,
        room_id INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        start_date DATE,
        end_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        UNIQUE(room_id, start_date),
        FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
    )
");

// Create 'extras' table
$mysqli->query("
    CREATE TABLE extras (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        description VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL
    )
");

// Create 'extra_pricing' table
$mysqli->query("
    CREATE TABLE extra_pricing (
        id INT AUTO_INCREMENT PRIMARY KEY,
        extra_id INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        start_date DATE,
        end_date DATE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        UNIQUE(extra_id, start_date),
        FOREIGN KEY (extra_id) REFERENCES extras(id) ON DELETE CASCADE
    )
");

// Create 'bookings' table
$mysqli->query("
    CREATE TABLE bookings (
        id INT AUTO_INCREMENT PRIMARY KEY,
        person_id INT NOT NULL,
        hotel_id INT NOT NULL,
        check_in DATE NOT NULL,
        check_out DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE,
        FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
    )
");

// Create 'booking_details' table
$mysqli->query("
    CREATE TABLE booking_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        booking_id INT NOT NULL,
        room_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
        FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
    )
");

// Create 'billing' table
$mysqli->query("
    CREATE TABLE billing (
        id INT AUTO_INCREMENT PRIMARY KEY,
        booking_id INT NOT NULL,
        total_amount DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
    )
");

// Create 'payments' table
$mysqli->query("
    CREATE TABLE payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        billing_id INT NOT NULL,
        payment_method ENUM('credit_card', 'cash', 'bank_transfer') NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (billing_id) REFERENCES billing(id) ON DELETE CASCADE
    )
");

// Create 'reservations' table
$mysqli->query("
    CREATE TABLE reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        person_id INT NOT NULL,
        room_id INT NOT NULL,
        check_in DATE NOT NULL,
        check_out DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (person_id) REFERENCES persons(id) ON DELETE CASCADE,
        FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
    )
");

// Create 'extra_reservations' table
$mysqli->query("
    CREATE TABLE extra_reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        reservation_id INT NOT NULL,
        extra_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        deleted_at TIMESTAMP NULL,
        FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
        FOREIGN KEY (extra_id) REFERENCES extras(id) ON DELETE CASCADE
    )
");

// Close the connection
$mysqli->close();

?>
