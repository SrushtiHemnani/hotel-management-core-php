<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
	protected $table = 'guests';
	
	protected $guarded = [];
	
	public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}