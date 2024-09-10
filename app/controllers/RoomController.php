<?php

namespace App\controllers;

use App\Enums\RoleType;
use App\models\Room;

class RoomController extends BaseController
{
    public function index()
    {
        $this->view('room/index');
    }

    public function getRoom()
    {
        global $connection;
        $personId = $_SESSION['person_id'];

        if (!$personId) {
            header('Location: /login');
        }
        $role = RoleType::Admin;
        // get all rooms for daataatable

        $sql = "SELECT 
            r.id AS room_id,
            r.room_number,
            r.is_available,
            r.created_at AS room_created_at,
            r.updated_at AS room_updated_at,
            h.name AS hotel_name,
            h.location AS hotel_location,
            rp.price AS room_price,
            rp.start_date AS pricing_start_date,
            rc.name AS room_category_name  -- Added room category name
        FROM 
            rooms r
        JOIN 
            hotels h ON h.id = r.hotel_id
        JOIN 
            roles r2 ON r2.hotel_id = h.id
        JOIN 
            room_pricing rp ON rp.room_id = r.id
        JOIN 
            room_categories rc ON rc.id = r.room_category_id  -- Join with room_categories table
        WHERE 
             r2.person_id = $personId
                    AND r2.role = '" . $role->value . "'
            AND rp.end_date IS NULL
        ORDER BY 
            r.id;";

        $stmt = $connection->prepare($sql);

        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch all rows as objects of the model class
        $rows = [];
        while ($object = $result->fetch_object(static::class)) {
            $rows[] = $object;
        }

        $data = [];
        foreach ($rows as $row) {
        
            $data[] = [
                "id" => $row->room_id,
                "room_number" => $row->room_number,
                "is_available" => $row->is_available,
                "created_at" => $row->room_created_at,
                "updated_at" => $row->room_updated_at,
                "hotel_name" => $row->hotel_name,
                "hotel_location" => $row->hotel_location,
                "room_price" => $row->room_price,
                "pricing_start_date" => $row->pricing_start_date,
                "room_category_name" => $row->room_category_name,
                "action" => "<ul class='action'>
                            <li class='edit'> <a href=room-edit/' . $row->room_id . ' ><i class='icon-pencil-alt'></i></a></li>
                            <li class='delete'><a href=room-delete/' . $row->room_id . ' ><i class='icon-trash'></i></a></li>
                        </ul>",
            ];
        }

        echo json_encode([
            'data' => $data,
            'recordsTotal' => count($data),
            'recordsFiltered' => count($data),
        ]);


    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $roomData = [
                'room_type' => $_POST['room_type'],
                'room_price' => $_POST['room_price'],
                'capacity' => $_POST['capacity'],
                'room_count' => $_POST['room_count'],
                'is_extra' => $_POST['is_extra'],
            ];


            Room::create($roomData);

            header('Location: /rooms');
        }

        $this->view('room/create');
    }

    public function store()
    {
        // store the room
    }

    public function edit($id)
    {
        $room = Room::where('id', $id)->first();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $roomData = [
                'room_type' => $_POST['room_type'],
                'room_price' => $_POST['room_price'],
                'capacity' => $_POST['capacity'],
                'room_count' => $_POST['room_count'],
                'is_extra' => $_POST['is_extra'],
            ];

            Room::where('id', $id)->update($roomData);

            header('Location: /rooms');
        }

        $this->view('room/edit', ['room' => $room]);
    }

    public function update()
    {
        // update the room
    }

    public function delete($id)
    {
        Room::where('id', $id)->delete();
        header('Location: /rooms');
    }

    public function show()
    {
        $this->view('room/show');
    }

}