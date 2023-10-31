<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'redirect_url',
        'user_id',
        'is_read',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
