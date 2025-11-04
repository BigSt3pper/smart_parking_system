<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'Payment';
    protected $primaryKey = 'paymentID';
    
    protected $fillable = [
        'reservationID',
        'userID',
        'amountPaid',
        'paymentMethod',
        'transactionCode'
    ];

    protected $casts = [
        'paymentDate' => 'datetime',
        'amountPaid' => 'decimal:2'
    ];

    // Relationships
    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservationID', 'reservationID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}