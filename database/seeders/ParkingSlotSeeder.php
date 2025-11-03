<?php
// database/seeders/ParkingSlotSeeder.php

namespace Database\Seeders;

use App\Models\ParkingSlot;
use Illuminate\Database\Seeder;

class ParkingSlotSeeder extends Seeder
{
    public function run()
    {
        $slots = [
            ['slotNumber' => 'A1', 'location' => 'Ground Floor', 'status' => 'Available', 'pricePerHour' => 50],
            ['slotNumber' => 'A2', 'location' => 'Ground Floor', 'status' => 'Occupied', 'pricePerHour' => 50],
            ['slotNumber' => 'A3', 'location' => 'Ground Floor', 'status' => 'Available', 'pricePerHour' => 50],
            ['slotNumber' => 'B1', 'location' => 'First Floor', 'status' => 'Available', 'pricePerHour' => 45],
            ['slotNumber' => 'B2', 'location' => 'First Floor', 'status' => 'Maintenance', 'pricePerHour' => 45],
        ];

        foreach ($slots as $slot) {
            ParkingSlot::create($slot);
        }
    }
}
