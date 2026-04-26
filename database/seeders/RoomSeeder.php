<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            \App\Models\Room::insert([
        [
            'room_number' => '101',
            'room_type'   => 'Standard',
            'capacity'    => 2,
            'status'      => 'Available',
            'room_details'=> 'Single bed, city view, free WiFi',
            'base_rate'   => 1500.00,
            'created_at'  => now(),
            'updated_at'  => now(),
        ],
        [
            'room_number' => '102',
            'room_type'   => 'Deluxe',
            'capacity'    => 3,
            'status'      => 'Available',
            'room_details'=> 'Double bed, garden view, free WiFi, breakfast included',
            'base_rate'   => 2500.00,
            'created_at'  => now(),
            'updated_at'  => now(),
        ],
        [
            'room_number' => '201',
            'room_type'   => 'Suite',
            'capacity'    => 4,
            'status'      => 'Available',
            'room_details'=> 'King bed, ocean view, jacuzzi, free WiFi',
            'base_rate'   => 5000.00,
            'created_at'  => now(),
            'updated_at'  => now(),
        ],
    ]);
    }
}
