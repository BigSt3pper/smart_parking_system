<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;

    protected $table = 'ParkingSlot';
    protected $primaryKey = 'slotID';
    public $timestamps = false; 
    protected $fillable = [
        'slotNumber',
        'location',
        'status',
        'pricePerHour'
    ];

    protected $casts = [
        'pricePerHour' => 'decimal:2',
        'lastUpdated' => 'datetime'
    ];

    // Relationships
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'slotID', 'slotID');
    }

    public function ratings()
    {
        return $this->hasMany(ServiceRating::class, 'slotID', 'slotID');
    }
}
