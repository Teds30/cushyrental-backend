<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rental_id',
        'environment_star',
        'unit_star',
        'landlord_star',
        'star',
        'message',
        'landlord_reply',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}
