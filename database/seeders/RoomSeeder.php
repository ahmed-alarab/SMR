<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Room::insert([
            [
                'capacity' => 15,
                'location' => 'beirut',
                'is_booked' => false,
            ],
            [
                'capacity' => 20,
                'location' => 'baalbeck',
                'is_booked' => false,
            ],
            [
                'capacity' => 11,
                'location' => 'jounieh',
                'is_booked' => false,
            ]
        ]);

    }
}
