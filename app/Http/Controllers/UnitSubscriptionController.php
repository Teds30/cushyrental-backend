<?php

namespace App\Http\Controllers;

use App\Models\UnitSubscription;
use App\Http\Requests\StoreUnitSubscriptionRequest;
use App\Http\Requests\UpdateUnitSubscriptionRequest;
use App\Models\Subscription;
use App\Models\Unit;
use App\Models\UnitImage;
use App\Models\User;
use Illuminate\Http\Request;

class UnitSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $subscription = UnitSubscription::where('unit_id', $request['id'])->where('date_start', $request['date_start'])->where('date_end', $request['date_end'])->first();

        if ($subscription) {
            $subscription->update(['type' => $request['type'], 'request_status' => $request['request_status']]);
            return response()->json($subscription, 201);
        }


        $fields = $request->validate([
            'unit_id' => 'required|integer',
            'subscription_id' => 'required|integer',
            'pop_image_id' => 'required|integer',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'email_address' => 'required|string',
            'date_start' => 'string',
            'date_end' => 'string',
            'type' => 'integer',
            'request_status' => 'integer',
        ]);

        $res = UnitSubscription::create($fields);

        return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitSubscription $unitSubscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitSubscription $unitSubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitSubscriptionRequest $request, UnitSubscription $unitSubscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $res = UnitSubscription::get()->where('id', $id)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->delete();

        return $res;
    }

    public function user_subscriptions($landlord_id)
    {
        $out = [];
        $user = User::find($landlord_id);
        $units = $user->units;
        foreach ($units as $unit) {
            $tmp = [];
            $subs = $unit->subscriptions;
            if (count($subs) > 0)
                $tmp = $unit->subscriptions;

            foreach ($tmp as $sub) {
                $sub->unit;
                $sub->subscription;
                $img = UnitImage::get()->where('unit_id', $sub->unit['id'])->where('is_thumbnail', 1)->first();
                if (!$img) {
                    $img = UnitImage::get()->where('unit_id', $sub->unit['id'])->first();
                }
                if ($img)
                    $sub->unit['image'] = $img->image->image;
            }


            $out = [...$out, ...$tmp];
        }
        return $out;
    }
}
