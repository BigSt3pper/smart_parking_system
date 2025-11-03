<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('parking_slots', function (Blueprint $table) {
            $table->id('slotID');
            $table->string('slotNumber')->unique();
            $table->string('location')->nullable();
            $table->string('status')->default('Available');
            $table->decimal('pricePerHour', 8, 2)->default(50.00);
            $table->timestamp('lastUpdated')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('parking_slots');
    }
};
