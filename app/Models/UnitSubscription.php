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
        'pop_image_id',
        'account_name',
        'account_number',
        'email_address',
        'date_start',
        'date_end',
        'type',
        'verdict',
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
    public function proof_of_payment()
    {
        return $this->belongsTo(Image::class, 'pop_image_id');
    }
}
