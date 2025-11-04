<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('User')->insert([
            'fullName' => 'System Administrator',
            'email' => 'admin@parksmart.com',
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
            'phoneNumber' => '1234567890',
            'dateRegistered' => now()
        ]);

        echo "✅ Admin user created: admin@parksmart.com / admin123\n";
    }
}
