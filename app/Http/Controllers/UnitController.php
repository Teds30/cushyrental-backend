<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Unit::get()->where('status', 1);

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
    public function store(StoreUnitRequest $request)
    {
        $fields = $request->validate([
            'landlord_id' => 'required',
            'name' => 'required|string',
            'details' => 'required|string',
            'price' => 'required|string',
            'month_advance' => 'required|integer',
            'month_deposit' => 'required|integer',
            'location' => 'required|string',
            'address' => 'required|string',
            'target_gender' => 'required|integer',
            'slots' => 'required|integer',
            'is_listed' => 'required|integer',
        ]);

        $unit = Unit::create($fields);
        $user = auth('sanctum')->user()->id;

        $response = [
            'user' => $user,
            'unit' => $unit
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Unit::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->landlord;

        $out = array();

        $amenities = $this->unit_amenities($id);
        $facilities = $this->unit_facilities($id);
        $inclusions = $this->unit_inclusions($id);
        $rules = $this->unit_rules($id);
        $images = $this->unit_images($id);
        $subscriptions = $this->unit_subscriptions($id);
        $rentals = $this->unit_rentals($id);

        $res['amenities'] = $amenities;
        $res['facilities'] = $facilities;
        $res['inclusions'] = $inclusions;
        $res['rules'] = $rules;
        $res['images'] = $images;
        $res['subscriptions'] = $subscriptions;
        $res['rentals'] = $rentals;

        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $res = Unit::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update($request->all());

        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        //
    }

    /**
     * Archive specified resource.
     */
    public function archive($id)
    {
        $res = Unit::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(['status' => 0]);

        return $res;
    }



    /**
     * Unit Attributes
     */

    public function unit_facilities($id)
    {
        $res = Unit::find($id);
        $out = array();

        if ($res) {
            $facilities = $res->facilities;

            foreach ($facilities as $u_facility) {
                if ($u_facility->facility['status'] == 1) {
                    $out[] = [
                        'id' => $u_facility['facility_id'],
                        'name' => $u_facility->facility['name'],
                        'icon' => $u_facility->facility['icon'],
                        'is_shared' => $u_facility['is_shared'],
                        'is_available' => $u_facility->facility['is_available'],
                    ];
                }
            }
        }
        return $out;
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


    public function unit_inclusions($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $inclusions = $res->inclusions;

            foreach ($inclusions as $u_inclusion) {
                if ($u_inclusion->inclusion['status'] == 1) {
                    $out[] = [
                        'id' => $u_inclusion['inclusion_id'],
                        'name' => $u_inclusion->inclusion['name'],
                        'icon' => $u_inclusion->inclusion['icon'],
                        'is_available' => $u_inclusion->inclusion['is_available'],
                    ];
                }
            }
        }
        return $out;
    }


    public function unit_rules($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $rules = $res->rules;

            foreach ($rules as $u_rule) {
                if ($u_rule->rule['status'] == 1) {
                    $out[] = [
                        'id' => $u_rule['rule_id'],
                        'name' => $u_rule->rule['name'],
                        'icon' => $u_rule->rule['icon'],
                        'is_available' => $u_rule->rule['is_available'],
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


    public function unit_subscriptions($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $subscriptions = $res->subscriptions;

            foreach ($subscriptions as $u_subscription) {
                if ($u_subscription->subscription['status'] == 1) {
                    $out[] = [
                        'id' => $u_subscription['subscription_id'],
                        'name' => $u_subscription->subscription['name'],
                        'hex_color' => $u_subscription->subscription['hex_color'],
                        'date_start' => $u_subscription['date_start'],
                        'date_end' => $u_subscription['date_end'],
                        'type' => $u_subscription['type'],
                        'request_status' => $u_subscription['request_status'],
                    ];
                }
            }
        }
        return $out;
    }


    public function unit_rentals($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $rentals = $res->rentals;

            foreach ($rentals as $u_rental) {
                if ($u_rental['status'] == 1) {
                    $out[] = $u_rental;
                }
            }
        }
        return $out;
    }
}
