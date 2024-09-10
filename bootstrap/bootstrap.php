<?php

use App\Helpers\ErrorHandler;
use App\Models\BaseModel;

define("BASE_PATH", "http://localhost:8000/");

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'hotel_db_1';
global $connection;
// Create a connection
$connection = new mysqli($host, $username, $password, $database);

// Check the connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Set the character set
if (!$connection->set_charset("utf8")) {
    die("Error loading character set utf8: " . $connection->error);
}
// Set the connection in BaseModel so all models can use it
//
//// Connection successful
//echo "Connected successfully";
//
//// Your application logic here
//
//// Close the connection when done
//$connection->close();

// Register the global exception handler
set_exception_handler([ErrorHandler::class, 'handleException']);

