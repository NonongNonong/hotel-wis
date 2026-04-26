<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            \App\Models\Employee::insert([
        [
            'fname'          => 'Carlos',
            'lname'          => 'Reyes',
            'age'            => 30,
            'birthday'       => '1994-03-15',
            'role'           => 'Receptionist',
            'department'     => 'Front Desk',
            'mobile_num'     => '09201234567',
            'email_add'      => 'carlos@hotel.com',
            'hire_date'      => '2022-01-10',
            'status'         => 'Active',
            'created_at'     => now(),
            'updated_at'     => now(),
        ],
        [
            'fname'          => 'Ana',
            'lname'          => 'Flores',
            'age'            => 26,
            'birthday'       => '1998-07-22',
            'role'           => 'Housekeeper',
            'department'     => 'Housekeeping',
            'mobile_num'     => '09211234567',
            'email_add'      => 'ana@hotel.com',
            'hire_date'      => '2023-03-01',
            'status'         => 'Active',
            'created_at'     => now(),
            'updated_at'     => now(),
        ],
        [
            'fname'          => 'Ramon',
            'lname'          => 'Cruz',
            'age'            => 40,
            'birthday'       => '1984-11-05',
            'role'           => 'Chef',
            'department'     => 'Food and Beverage',
            'mobile_num'     => '09221234567',
            'email_add'      => 'ramon@hotel.com',
            'hire_date'      => '2020-06-15',
            'status'         => 'Active',
            'created_at'     => now(),
            'updated_at'     => now(),
        ],
    ]);
    }
}
