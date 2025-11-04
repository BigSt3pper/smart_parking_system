<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Use Hamza's exact SQL schema
        DB::statement("
            CREATE TABLE User (
                userID INTEGER PRIMARY KEY AUTOINCREMENT,
                fullName VARCHAR(100) NOT NULL,
                email VARCHAR(100) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                phoneNumber VARCHAR(15),
                role VARCHAR(20) DEFAULT 'Driver',
                dateRegistered DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        DB::statement("
            CREATE TABLE ParkingSlot (
                slotID INTEGER PRIMARY KEY AUTOINCREMENT,
                slotNumber VARCHAR(10) UNIQUE NOT NULL,
                location VARCHAR(100),
                status VARCHAR(20) DEFAULT 'Available',
                pricePerHour DECIMAL(8,2) DEFAULT 50.00,
                lastUpdated DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

        DB::statement("
            CREATE TABLE Vehicle (
                vehicleID INTEGER PRIMARY KEY AUTOINCREMENT,
                userID INTEGER,
                NumberPlate VARCHAR(20) UNIQUE NOT NULL,
                model VARCHAR(50),
                color VARCHAR(30),
                FOREIGN KEY (userID) REFERENCES User(userID)
            )
        ");

        DB::statement("
            CREATE TABLE Reservation (
                reservationID INTEGER PRIMARY KEY AUTOINCREMENT,
                userID INTEGER,
                vehicleID INTEGER,
                slotID INTEGER,
                startTime DATETIME,
                endTime DATETIME,
                totalHours INTEGER,
                totalCost DECIMAL(10,2),
                paymentStatus VARCHAR(20) DEFAULT 'Pending',
                reservationStatus VARCHAR(20) DEFAULT 'Active',
                createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (userID) REFERENCES User(userID),
                FOREIGN KEY (vehicleID) REFERENCES Vehicle(vehicleID),
                FOREIGN KEY (slotID) REFERENCES ParkingSlot(slotID)
            )
        ");

        DB::statement("
            CREATE TABLE Payment (
                paymentID INTEGER PRIMARY KEY AUTOINCREMENT,
                reservationID INTEGER,
                userID INTEGER,
                amountPaid DECIMAL(10,2),
                paymentMethod VARCHAR(30),
                transactionCode VARCHAR(50) UNIQUE,
                paymentDate DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (reservationID) REFERENCES Reservation(reservationID),
                FOREIGN KEY (userID) REFERENCES User(userID)
            )
        ");

        DB::statement("
            CREATE TABLE ServiceRating (
                ratingID INTEGER PRIMARY KEY AUTOINCREMENT,
                userID INTEGER,
                slotID INTEGER,
                ratingValue INTEGER CHECK (ratingValue BETWEEN 1 AND 5),
                dateRated DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (userID) REFERENCES User(userID),
                FOREIGN KEY (slotID) REFERENCES ParkingSlot(slotID)
            )
        ");

        DB::statement("
            CREATE TABLE Feedback (
                feedbackID INTEGER PRIMARY KEY AUTOINCREMENT,
                userID INTEGER,
                message TEXT,
                dateSubmitted DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (userID) REFERENCES User(userID)
            )
        ");

        DB::statement("
            CREATE TABLE Admin (
                logID INTEGER PRIMARY KEY AUTOINCREMENT,
                adminID INTEGER,
                action VARCHAR(255),
                timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (adminID) REFERENCES User(userID)
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