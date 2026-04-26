<?php

namespace App\Models;
use App\Models\CheckInOut;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'guest_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'status',
        'base_room_cost',
        'created_by',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function checkInOut()
{
    return $this->hasOne(CheckInOut::class, 'reservation_id');
}
}