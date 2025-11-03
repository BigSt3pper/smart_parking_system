<?php
// app/Models/Reservation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'reservationID';
    
    protected $fillable = [
        'userID',
        'vehicleID',
        'slotID',
        'startTime',
        'endTime', 
        'totalHours',
        'totalCost',
        'paymentStatus',
        'reservationStatus',
        'createdAt'
    ];

    protected $casts = [
        'startTime' => 'datetime',
        'endTime' => 'datetime',
        'createdAt' => 'datetime',
        'totalCost' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class, 'slotID');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicleID');
    }

    public function index() 
{
    $reservations = Reservation::with(['user', 'parkingSlot'])->latest()->get();
    return view('admin.reservations.index', compact('reservations'));
    
}
}