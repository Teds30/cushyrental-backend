<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitFacility extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'facility_id',
        'is_shared',
    ];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}
