<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'checked_by_id',
        'verdict',
        'denied_reason',
        'submitted_id_image_url',
        'identification_card_type_id',
        'address',
        'contact_number',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function checked_by()
    {
        return $this->belongsTo(User::class, 'checked_by_id');
    }
    public function identification_card_type()
    {
        return $this->belongsTo(IdentificationCardType::class, 'identification_card_type_id');
    }
}
