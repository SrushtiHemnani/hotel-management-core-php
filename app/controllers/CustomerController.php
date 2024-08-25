<?php

namespace App\controllers;

use App\models\Customer;

class CustomerController extends BaseController
{
    public function index()
    {
        $this->view('customer/index');
    }

   // app/controllers/CustomerController.php
    public function getCustomers()
    {
        header('Content-Type: application/json');
        $request = $_GET;
        $query = Customer::with('guests');

        $start = intval($request['start']);
        $length = intval($request['length']);
        $totalRecords = $query->count();
        $data = $query->skip($start)->take($length)->get();

        $formattedData = $data->map(function ($customer) {
            $guests = $customer->guests->map(function ($guest) {
                return [
                    'id' => $guest->id,
                    'name' => $guest->name,
                    'age' => $guest->age,
                ];
            });
            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'age' => $customer->age,
                'guests' => $guests,
                'action' => '' // No action needed for tree view
            ];
        });

        $response = [
            'draw' => intval($request['draw']),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $formattedData,
        ];

        echo json_encode($response);
    }

}