<?php

require __DIR__ . '/../vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Container\Container;

// Initialize Capsule
$capsule = new Capsule;

define("BASE_PATH", "http://localhost:8000/");

// Add database connection
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'hotel_db',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set Capsule instance globally
$capsule->setAsGlobal();

// Boot Eloquent ORM
$capsule->bootEloquent();
