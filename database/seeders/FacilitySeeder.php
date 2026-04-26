<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            \App\Models\Facility::insert([
        [
            'facility_name'     => 'Swimming Pool',
            'facility_category' => 'Recreation',
            'description'       => 'Outdoor pool open 6am to 10pm',
            'capacity'          => 30,
            'status'            => 'Available',
            'reservable'        => true,
            'need_payment'      => false,
            'price'             => 0.00,
            'created_at'        => now(),
            'updated_at'        => now(),
        ],
        [
            'facility_name'     => 'Function Hall',
            'facility_category' => 'Events',
            'description'       => 'Air-conditioned hall for events, capacity 100 pax',
            'capacity'          => 100,
            'status'            => 'Available',
            'reservable'        => true,
            'need_payment'      => true,
            'price'             => 15000.00,
            'created_at'        => now(),
            'updated_at'        => now(),
        ],
        [
            'facility_name'     => 'Gym',
            'facility_category' => 'Recreation',
            'description'       => 'Fully equipped gym open 24 hours',
            'capacity'          => 20,
            'status'            => 'Available',
            'reservable'        => false,
            'need_payment'      => false,
            'price'             => 0.00,
            'created_at'        => now(),
            'updated_at'        => now(),
        ],
    ]);
    }
}
