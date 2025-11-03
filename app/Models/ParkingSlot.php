<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $primaryKey = 'slotID';
    
    protected $fillable = [
        'slotNumber',
        'location', 
        'status',
        'pricePerHour',
        'lastUpdated'
    ];

    protected $casts = [
        'pricePerHour' => 'decimal:2',
        'lastUpdated' => 'datetime'
    ];
}