<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitInclusion extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'inclusion_id',
    ];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function inclusion()
    {
        return $this->belongsTo(Inclusion::class, 'inclusion_id');
    }
}
