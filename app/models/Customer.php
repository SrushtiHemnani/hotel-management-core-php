<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate( array $array, array $customerData )
 */
class Customer extends Model
{
	protected $table = 'customers';
	
	protected $fillable = ['name', 'email', 'phone', 'address', 'age'];
	
	
	public function bookings()
	{
		return $this->hasMany(Booking::class);
	}
	
	public function guests()
	{
		return $this->hasMany(Guest::class);
	}
}