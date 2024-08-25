<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class BookingGuest extends Model
{
    protected $table = 'booking_guest';

    protected $fillable = [
        'booking_id',
        'guest_id',
        'customer_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}