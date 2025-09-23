<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {

        User::insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'admin',
                'phone' => '522354',
                'address' => 'Admin Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
            [
                'name' => 'employee User',
                'email' => 'employee@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'employee',
                'phone' => '522354',
                'address' => 'emp Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
            [
                'name' => 'guest User',
                'email' => 'guest@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'guest',
                'phone' => '522354',
                'address' => 'guest Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
            [
                'name' => 'guest User',
                'email' => 'guest2@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'guest',
                'phone' => '522354',
                'address' => 'guest Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
            [
                'name' => 'guest User',
                'email' => 'guest3@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'guest',
                'phone' => '522354',
                'address' => 'guest Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
            [
                'name' => 'guest User',
                'email' => 'guest4@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'guest',
                'phone' => '522354',
                'address' => 'guest Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'admin',
                'phone' => '522354',
                'address' => 'Admin Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
            [
                'name' => 'employee User',
                'email' => 'employee2@gmail.com',
                'password' => Hash::make('ahmad1'), // Use Hash facade to hash passwords
                'role' => 'employee',
                'phone' => '522354',
                'address' => 'emp Address',
                'dob' => '1990-01-01',
                'profile_picture' => null,
            ],
        ]);

    }
}
