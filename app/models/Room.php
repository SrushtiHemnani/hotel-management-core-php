<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
	protected $table   = 'rooms';
	protected $guarded = [];
	
	public function booking()
	{
		return $this->hasMany(Booking::class);
	}
}