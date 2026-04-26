<?php

namespace Database\Seeders;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\GuestSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\ServiceSeeder;
use Database\Seeders\FacilitySeeder;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        AdminUserSeeder::class,
        GuestSeeder::class,
        RoomSeeder::class,
        EmployeeSeeder::class,
        ServiceSeeder::class,
        FacilitySeeder::class,
    ]);// User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
