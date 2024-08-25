<?php

use App\controllers\CustomerController;
use App\controllers\UserController;
use App\controllers\AuthController;
use App\controllers\RoomController;
use App\controllers\BookingController;

return [
	'/'     => [ UserController::class, 'index' ],
	'login' => [ AuthController::class, 'login' ],
	'sign-up' => [ AuthController::class, 'signUp' ],
	'log-out' => [ AuthController::class, 'logOut' ],
	
	/**
	 * booking
	 */
	
	'booking' => [ BookingController::class, 'index' ],
    'booking2' => [ BookingController::class, 'index_old' ],
	'booking-create' => [ BookingController::class, 'create' ],
	'booking-edit/:id' => [ BookingController::class, 'edit' ],
	'booking-update/:id' => [ BookingController::class, 'update' ],
	'booking-delete/:id' => [ BookingController::class, 'delete' ],
	'booking-calculate-cost-estimate-and-allocation' => [ BookingController::class, 'calculateCostEstimateAndAllocation' ],
	'get-booking' => [ BookingController::class, 'getBooking' ],
	
	/**
	 * rooms
	 */
	'rooms' => [ RoomController::class, 'index' ],
	'room-create' => [ RoomController::class, 'create' ],
	'get-rooms' => [RoomController::class, 'getRoom' ],
	'room-edit/:id' => [RoomController::class, 'edit'],
	'room-delete/:id' => [RoomController::class, 'delete'],

    "customers" => [CustomerController::class, 'index'],
    "get-customers" => [CustomerController::class, 'getCustomers'],
];
