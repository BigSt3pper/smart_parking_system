<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservationID');
            $table->foreignId('userID')->constrained('users', 'id');
            $table->foreignId('vehicleID')->constrained('vehicles', 'vehicleID');
            $table->foreignID('slotID')->constrained('parking_slots', 'slotID');
            $table->timestamp('startTime');
            $table->timestamp('endTime');
            $table->integer('totalHours');
            $table->decimal('totalCost', 10, 2);
            $table->string('paymentStatus')->default('Pending');
            $table->string('reservationStatus')->default('Active');
            $table->timestamp('createdAt')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
