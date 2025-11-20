<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        /**
         * FIX 1: Rename wrong/uppercase table names
         * SQLite is case-sensitive, so we unify naming.
         */

        // Rename ParkingSlot → parking_slots (if it exists)
        if (Schema::hasTable('ParkingSlot')) {
            Schema::rename('ParkingSlot', 'parking_slots');
        }

        // Rename User → users (if it exists)
        if (Schema::hasTable('User')) {
            Schema::rename('User', 'users');
        }

        /**
         * FIX 2: Ensure correct schema for parking_slots
         */

        if (!Schema::hasTable('parking_slots')) {
            Schema::create('parking_slots', function (Blueprint $table) {
                $table->id();
                $table->string('slotNumber');
                $table->string('location')->nullable();
                $table->string('status')->default('Available');
                $table->decimal('pricePerHour', 8, 2)->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        /**
         * FIX 3: Ensure correct schema for users
         */

        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('fullName');
                $table->string('email')->unique();
                $table->string('password');
                $table->string('phoneNumber')->nullable();
                $table->string('role')->default('Driver');
                $table->timestamps();
            });
        }

        /**
         * FIX 4: Ensure reservations table exists
         */

        if (!Schema::hasTable('reservations')) {
            Schema::create('reservations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('slot_id')->constrained('parking_slots')->onDelete('cascade');
                $table->timestamp('startTime')->nullable();
                $table->timestamp('endTime')->nullable();
                $table->decimal('totalAmount', 8, 2)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Do NOT drop anything — this migration is a fixer.
    }
};
