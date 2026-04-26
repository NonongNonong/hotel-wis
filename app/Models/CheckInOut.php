<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use App\Models\Guest;
use App\Models\Room;

class CheckInOut extends Model
{
    protected $table = 'check_in_out';

    protected $fillable = [
        'reservation_id',
        'guest_id',
        'room_id',
        'actual_check_in',
        'actual_check_out',
        'status',
        'total_amount',
        'payment_method',
        'last_update_by',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}