<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAmenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'amenity_id',
    ];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenity_id');
    }
}
