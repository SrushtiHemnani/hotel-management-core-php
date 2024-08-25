<?php

namespace App\models;

use App\models\Customer;
use Illuminate\Database\Eloquent\Model;


/**
 * @method booking_guest()
 */
class Booking extends Model
{
	protected $table   = 'bookings';
	protected $guarded = [];
	
	 public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function guests() {
        return $this->belongsToMany(Guest::class, 'booking_guest');
    }

    public function parent() {
        return $this->belongsTo(Booking::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Booking::class, 'parent_id');
    }
	public function associatedBookings()
    {
        return $this->hasMany(Booking::class, 'parent_id');
    }
	
	public function bookingGuest()
{
    return $this->hasMany(BookingGuest::class);
}
	
}