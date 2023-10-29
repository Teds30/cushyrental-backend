<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'phone_number',
        'profile_picture_img',
        'user_type_id',
        'is_verified',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_verified' => 'boolean'
    ];

    public function user_type()
    {
        return $this->belongsTo(UserTypes::class, 'user_type_id');
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'landlord_id');
    }

    public function reported()
    {
        return $this->hasMany(ReportedUser::class, 'user_id');
    }

    public function get_total_ratings()
    {
        $id = $this->attributes['id'];
        $units = Unit::get()->where('landlord_id', $id);
        $ratings = [];
        foreach ($units as $unit) {
            $ratings[] = $unit->get_average_ratings();
        }

        if (count($ratings) == 0) {
            return 0;
        }

        $total = array_sum($ratings) / count($ratings);
        return $total;
    }
    public function bookmark()
    {
        return $this->hasMany(Bookmark::class, 'user_id');
    }
}
