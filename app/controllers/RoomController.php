<?php

namespace App\controllers;

use App\models\Room;

class RoomController extends BaseController
{
	public function index()
	{
		$this->view('room/index');
	}
	
	public function getRoom()
	{
		// get all rooms for daataatable
		$rows = Room::all()->toArray();
		
		$data = [];
		foreach ($rows as $row) {
			$data[] = [
				"id"         => $row['id'],
				"room_type"  => $row['room_type'],
				"room_price" => $row['room_price'],
				"capacity"   => $row['capacity'],
				"room_count" => $row['room_count'],
				"is_extra"   => $row['is_extra'],
				"action"     => '<ul class="action">
					<li class="edit"> <a href=room-edit/' . $row['id'] . ' ><i class="icon-pencil-alt"></i></a></li>
                    <li class="delete"><a href=room-delete/' . $row['id'] . ' ><i class="icon-trash"></i></a></li>
                </ul>',
			];
		}
		
		echo json_encode([ 'data'            => $data,
		                   'recordsTotal'    => count($data),
		                   'recordsFiltered' => count($data),
		                 ]);
		
		
	}
	
	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$roomData = [
				'room_type'  => $_POST['room_type'],
				'room_price' => $_POST['room_price'],
				'capacity'   => $_POST['capacity'],
				'room_count' => $_POST['room_count'],
				'is_extra'   => $_POST['is_extra'],
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
				'room_type'  => $_POST['room_type'],
				'room_price' => $_POST['room_price'],
				'capacity'   => $_POST['capacity'],
				'room_count' => $_POST['room_count'],
				'is_extra'   => $_POST['is_extra'],
			];
			
			Room::where('id', $id)->update($roomData);
			
			header('Location: /rooms');
		}
		
		$this->view('room/edit', [ 'room' => $room ]);
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