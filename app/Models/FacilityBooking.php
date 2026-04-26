<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityBooking extends Model
{
    protected $fillable = [
        'guest_id',
        'facility_id',
        'reservation_id',
        'booking_start',
        'booking_end',
        'status',
        'total_cost',
        'rating',
        'last_update_by',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}