<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'image_id',
        'is_thumbnail',
    ];


    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
