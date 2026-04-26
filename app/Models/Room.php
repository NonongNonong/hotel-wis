<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
        protected $fillable = [
        'room_number',
        'room_type',
        'capacity',
        'status',
        'room_details',
        'base_rate',
        'last_update_by',
    ];
    public function reservations()
{
    return $this->hasMany(Reservation::class);
}
}
