<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'rule_id',
    ];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function rule()
    {
        return $this->belongsTo(Rule::class, 'rule_id');
    }
}
