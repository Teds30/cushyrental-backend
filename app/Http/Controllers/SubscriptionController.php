<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Amenity;
use App\Models\Unit;
use App\Models\UnitSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Subscription::get()->where('status', 1);

        if (!$res) {
            return response()->json([], 404);
        }
        return $res;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Subscription::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        return $res;
    }

    public function gold_units()
    {
        $res = UnitSubscription::where('subscription_id', 3)->where('type', 1)->where('request_status', 1)->get();

        if (!$res || !$res->count()) {
            return response()->json([]);
        }

        foreach ($res as $subscription) {
            $subscription->unit;
            $subscription->unit->images[0]->image;
            $subscription->unit['amenities'] = $this->unit_amenities($subscription->unit->id);
            $subscription->unit['images'] = $this->unit_images($subscription->unit->id);
        }
        return $res;
    }
    public function silver_units()
    {
        $res = UnitSubscription::where('subscription_id', 2)->where('type', 1)->where('request_status', 1)->get();

        if (!$res || !$res->count()) {
            return response()->json([]);
        }

        foreach ($res as $subscription) {
            $subscription->unit;
            $subscription->unit['amenities'] = $this->unit_amenities($subscription->unit->id);
            $subscription->unit['images'] = $this->unit_images($subscription->unit->id);
        }
        return $res;
    }

    public function unit_amenities($id)
    {
        $res = Unit::find($id);
        $out = array();

        if ($res) {
            $amenities = $res->amenities;
            foreach ($amenities as $u_amenity) {
                if ($u_amenity->amenity['status'] == 1) {
                    $out[] = [
                        'id' => $u_amenity['amenity_id'],
                        'name' => $u_amenity->amenity['name'],
                        'icon' => $u_amenity->amenity['icon'],
                        'is_available' => $u_amenity->amenity['is_available'],
                    ];
                }
            }
        }
        return $out;
    }

    public function unit_images($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $images = $res->images;

            foreach ($images as $u_image) {
                if ($u_image->image['status'] == 1) {
                    $out[] = [
                        'id' => $u_image['image_id'],
                        'image' => $u_image->image['image'],
                        'is_thumbnail' => $u_image['is_thumbnail'],
                    ];
                }
            }
        }
        return $out;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $res = Subscription::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update($request->all());

        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}
