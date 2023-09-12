<?php

namespace App\Http\Controllers;

use App\Models\UnitSubscription;
use App\Http\Requests\StoreUnitSubscriptionRequest;
use App\Http\Requests\UpdateUnitSubscriptionRequest;
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
        $fields = $request->validate([
            'unit_id' => 'required|integer',
            'subscription_id' => 'required|integer',
            'date_start' => 'required|string',
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
}
