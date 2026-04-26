<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         \App\Models\Guest::insert([
        ['fname' => 'Juan', 'lname' => 'Dela Cruz', 'age' => 35,
         'mobile_num' => '09171234567', 'email_add' => 'juan@email.com',
         'created_at' => now(), 'updated_at' => now()],
        ['fname' => 'Maria', 'lname' => 'Santos', 'age' => 28,
         'mobile_num' => '09181234567', 'email_add' => 'maria@email.com',
         'created_at' => now(), 'updated_at' => now()],
    ]);
    }
}
