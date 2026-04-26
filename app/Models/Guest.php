<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
       protected $fillable = [
        'fname',
        'lname',
        'age',
        'birthday',
        'mobile_num',
        'email_add',
        'last_update_by',
    ];

    public function reservations()
{
    return $this->hasMany(Reservation::class);
}
public function facilityBookings()
{
    return $this->hasMany(FacilityBooking::class);
}

}
