<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRating extends Model
{
    use HasFactory;

    protected $table = 'ServiceRating';
    protected $primaryKey = 'ratingID';
    public $timestamps = false;
    protected $fillable = [
        'userID',
        'slotID',
        'ratingValue'
    ];

    protected $casts = [
        'dateRated' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function parkingSlot()
    {
        return $this->belongsTo(ParkingSlot::class, 'slotID', 'slotID');
    }
}
