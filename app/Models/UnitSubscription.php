<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'subscription_id',
        'date_start',
        'date_end',
        'type',
        'request_status',
    ];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }
}
