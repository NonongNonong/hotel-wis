<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           \App\Models\Service::insert([
        [
            'service_name' => 'Housekeeping',
            'description'  => 'Daily room cleaning and bed making',
            'price'        => 200.00,
            'availability' => 'Available',
            'created_at'   => now(),
            'updated_at'   => now(),
        ],
        [
            'service_name' => 'Laundry',
            'description'  => 'Wash, dry and fold clothes per kg',
            'price'        => 150.00,
            'availability' => 'Available',
            'created_at'   => now(),
            'updated_at'   => now(),
        ],
        [
            'service_name' => 'Room Service',
            'description'  => 'Food and beverage delivery to room',
            'price'        => 100.00,
            'availability' => 'Available',
            'created_at'   => now(),
            'updated_at'   => now(),
        ],
    ]);
    }
}
