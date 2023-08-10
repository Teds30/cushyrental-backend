<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'details',
        'price',
        'hex_color',
        'features',
        'duration',
        'is_available',
        'status',
    ];
}
