<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'Feedback';
    protected $primaryKey = 'feedbackID';
    public $timestamps = false;
    protected $fillable = [
        'userID',
        'message'
    ];

    protected $casts = [
        'dateSubmitted' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
}
