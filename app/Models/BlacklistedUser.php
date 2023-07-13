<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistedUser extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'reason',
        'restricted_until',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
