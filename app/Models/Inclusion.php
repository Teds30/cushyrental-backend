<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inclusion extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'is_available',
        'status',
    ];
}
