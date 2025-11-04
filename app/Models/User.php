<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'User';
    protected $primaryKey = 'userID';
    
    protected $fillable = [
        'fullName',
        'email', 
        'password',
        'phoneNumber',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'dateRegistered' => 'datetime',
    ];

    // Relationships
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'userID', 'userID');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'userID', 'userID');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'userID', 'userID');
    }
}