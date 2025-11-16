<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'fullName' => 'System Administrator',
            'email' => 'admin@smartparking.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
            'phoneNumber' => '+1234567890',
        ]);
    }
}