<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guest;

class GuestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Get the first guest from the guests table
        $guest = Guest::first();

        if ($guest) {
            User::create([
                'name'     => $guest->fname . ' ' . $guest->lname,
                'email'    => $guest->email_add,
                'password' => Hash::make('guest1234'),
                'role'     => 'guest',
                'guest_id' => $guest->id,
            ]);
        }
    }
}