<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'icon',
        'status',
    ];


    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
