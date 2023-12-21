<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'landlord_id',
        'name',
        'details',
        'price',
        'month_advance',
        'month_deposit',
        'location',
        'address',
        'target_gender',
        'slots',
        'subscription_id',
        'is_listed',
        'request_status',
        'verdict',
        'status',
    ];


    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function facilities()
    {
        return $this->hasMany(UnitFacility::class);
    }
    public function amenities()
    {
        return $this->hasMany(UnitAmenity::class);
    }
    public function inclusions()
    {
        return $this->hasMany(UnitInclusion::class);
    }
    public function rules()
    {
        return $this->hasMany(UnitRule::class);
    }
    public function images()
    {
        return $this->hasMany(UnitImage::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(UnitSubscription::class);
    }
    // public function active_subscription()
    // {
    //     return $this->hasMany(UnitSubscription::class);
    // }
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function unit_reviews($id)
    {
        $out = array();

        $rentals = $this->rentals;

        foreach ($rentals as $u_rental) {
            if ($u_rental['status'] == 1) {
                $out[] = $u_rental->reviews[0];
            }
        }
        return $out;
    }

    public function get_average_ratings()
    {
        $id = $this->attributes['id'];
        $res = $this->unit_reviews($id);

        $count = count($res);

        if ($count > 0) {

            $average = 0;
            $sum = 0;

            foreach ($res as $review) {
                $sum += floatval($review['star']);
            }

            $average = $sum / $count;
            return $average;
        }

        return 0;
    }

    public function bookmark()
    {
        return $this->hasMany(Bookmark::class, 'unit_id');
    }
}
