<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSchemaSeeder extends Seeder
{
    public function run()
    {
        // Sample Users
        DB::table('User')->insert([
            [
                'fullName' => 'Admin User',
                'email' => 'admin@parksmart.com',
                'password' => Hash::make('password123'),
                'phoneNumber' => '1234567890',
                'role' => 'Admin'
            ],
            [
                'fullName' => 'John Driver',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'phoneNumber' => '0987654321',
                'role' => 'Driver'
            ]
        ]);

        // Sample Parking Slots
        DB::table('ParkingSlot')->insert([
            ['slotNumber' => 'A1', 'location' => 'Ground Floor - Section A', 'status' => 'Available', 'pricePerHour' => 50.00],
            ['slotNumber' => 'A2', 'location' => 'Ground Floor - Section A', 'status' => 'Available', 'pricePerHour' => 50.00],
            ['slotNumber' => 'A3', 'location' => 'Ground Floor - Section A', 'status' => 'Occupied', 'pricePerHour' => 50.00],
            ['slotNumber' => 'B1', 'location' => 'First Floor - Section B', 'status' => 'Available', 'pricePerHour' => 45.00],
            ['slotNumber' => 'B2', 'location' => 'First Floor - Section B', 'status' => 'Maintenance', 'pricePerHour' => 45.00],
            ['slotNumber' => 'C1', 'location' => 'Basement - Section C', 'status' => 'Available', 'pricePerHour' => 40.00],
        ]);

        // Sample Vehicles
        DB::table('Vehicle')->insert([
            [
                'userID' => 2,
                'NumberPlate' => 'KCA123A',
                'model' => 'Toyota Premio',
                'color' => 'White'
            ],
            [
                'userID' => 2, 
                'NumberPlate' => 'KDB456B',
                'model' => 'Honda CR-V',
                'color' => 'Black'
            ]
        ]);

        echo "✅ Sample data seeded successfully!\n";
    }
}