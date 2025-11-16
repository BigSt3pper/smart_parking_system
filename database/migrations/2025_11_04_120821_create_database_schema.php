<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
  
        DB::statement("
            CREATE TABLE User (
                userID INTEGER PRIMARY KEY AUTO_INCREMENT,
                fullName VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                phoneNumber VARCHAR(15),
                role VARCHAR(20) DEFAULT 'Driver',
                dateRegistered TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        DB::statement("
            CREATE TABLE ParkingSlot (
                slotID INTEGER PRIMARY KEY AUTO_INCREMENT,
                slotNumber VARCHAR(10) UNIQUE NOT NULL,
                location VARCHAR(100),
                status VARCHAR(20) DEFAULT 'Available',
                pricePerHour DECIMAL(8,2) DEFAULT 50.00,
                lastUpdated TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        DB::statement("
            CREATE TABLE Vehicle (
                vehicleID INTEGER PRIMARY KEY AUTO_INCREMENT,
                userID INTEGER,
                NumberPlate VARCHAR(20) UNIQUE NOT NULL,
                model VARCHAR(50),
                color VARCHAR(30),
                FOREIGN KEY (userID) REFERENCES User(userID) ON DELETE CASCADE
            )
        ");

        DB::statement("
            CREATE TABLE Reservation (
                reservationID INTEGER PRIMARY KEY AUTO_INCREMENT,
                userID INTEGER,
                vehicleID INTEGER,
                slotID INTEGER,
                startTime DATETIME,
                endTime DATETIME,
                totalHours INTEGER,
                totalCost DECIMAL(10,2),
                paymentStatus VARCHAR(20) DEFAULT 'Pending',
                reservationStatus VARCHAR(20) DEFAULT 'Active',
                createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (userID) REFERENCES User(userID) ON DELETE CASCADE,
                FOREIGN KEY (vehicleID) REFERENCES Vehicle(vehicleID) ON DELETE CASCADE,
                FOREIGN KEY (slotID) REFERENCES ParkingSlot(slotID) ON DELETE CASCADE
            )
        ");

        DB::statement("
            CREATE TABLE Payment (
                paymentID INTEGER PRIMARY KEY AUTO_INCREMENT,
                reservationID INTEGER,
                userID INTEGER,
                amountPaid DECIMAL(10,2),
                paymentMethod VARCHAR(30),
                transactionCode VARCHAR(50) UNIQUE,
                paymentDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (reservationID) REFERENCES Reservation(reservationID) ON DELETE CASCADE,
                FOREIGN KEY (userID) REFERENCES User(userID) ON DELETE CASCADE
            )
        ");

        DB::statement("
            CREATE TABLE ServiceRating (
                ratingID INTEGER PRIMARY KEY AUTO_INCREMENT,
                userID INTEGER,
                slotID INTEGER,
                ratingValue INTEGER,
                dateRated TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (userID) REFERENCES User(userID) ON DELETE CASCADE,
                FOREIGN KEY (slotID) REFERENCES ParkingSlot(slotID) ON DELETE CASCADE
            )
        ");

        DB::statement("
            CREATE TABLE Feedback (
                feedbackID INTEGER PRIMARY KEY AUTO_INCREMENT,
                userID INTEGER,
                message TEXT,
                dateSubmitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (userID) REFERENCES User(userID) ON DELETE CASCADE
            )
        ");

        DB::statement("
            CREATE TABLE Admin (
                logID INTEGER PRIMARY KEY AUTO_INCREMENT,
                adminID INTEGER,
                action VARCHAR(255),
                timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (adminID) REFERENCES User(userID) ON DELETE CASCADE
            )
        ");
    }

    public function down()
    {
        // Drop all tables in correct order
        Schema::dropIfExists('Admin');
        Schema::dropIfExists('Feedback');
        Schema::dropIfExists('ServiceRating');
        Schema::dropIfExists('Payment');
        Schema::dropIfExists('Reservation');
        Schema::dropIfExists('Vehicle');
        Schema::dropIfExists('ParkingSlot');
        Schema::dropIfExists('User');
    }
};
