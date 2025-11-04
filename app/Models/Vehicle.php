<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'Vehicle';
    protected $primaryKey = 'vehicleID';
    public $timestamps = false;
    protected $fillable = [
        'userID',
        'NumberPlate',
        'model',
        'color'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'vehicleID', 'vehicleID');
    }
}
