<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reported_by',
        'reason',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reported_by()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
