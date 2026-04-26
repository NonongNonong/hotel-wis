<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
        protected $fillable = [
        'facility_name',
        'facility_category',
        'description',
        'capacity',
        'status',
        'reservable',
        'need_payment',
        'price',
        'last_update_by',
    ];

    public function bookings()
{
    return $this->hasMany(FacilityBooking::class);
}
}
