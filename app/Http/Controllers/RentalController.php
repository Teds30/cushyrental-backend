<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Rental::get()->where('status', 1);

        if (!$res || !$res->count()) {
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
    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'slots' => 'required|integer',
            'monthly_amount' => 'required|numeric',
            'due_date' => 'required|integer',
            'date_start' => 'required|string',
        ]);

        $rental = Rental::create($fields);

        if ($rental) {
            $unit = Unit::find($request->unit_id)->first();
            if ($unit) {
                $req_slots = $request->slots;
                $unit_slots = $unit->slots;

                $new_slots = $unit_slots - $req_slots;
                $unit->update(["slots" => $new_slots]);
            }
        }

        // $user = auth('sanctum')->user()->id;
        // $response = [
        //     // 'user' => $user,
        //     'rental' => $rental
        // ];

        return $rental;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Rental::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->user;
        $res->unit;

        return $res;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $res = Rental::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update($request->all());

        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        //
    }

    /**
     * Archive specified resource.
     */
    public function archive($id)
    {
        $res = Rental::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(['status' => 0]);

        return $res;
    }

    public function landlord_tenants($landlord_id)
    {

        $res = User::get()->where('id', $landlord_id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $units = $res->units;
        $tenants = array();
        foreach ($units as $unit) {
            foreach ($unit->rentals as $rental) {
                $tenants[] = $rental->user;
            }
        }
        return $tenants;
    }


    public function landlord_rental_show($landlord_id)
    {
        $res = User::get()->where('id', $landlord_id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $units = $res->units;
        $rentals = array();
        foreach ($units as $unit) {
            foreach ($unit->rentals as $rental) {
                $rental->user;
                $rental->unit;
                $rentals[] = $rental;
            }
        }
        return $rentals;
    }


    public function terminate($id)
    {
        $res = Rental::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(["rental_status" => 4]);

        return $res;
    }
}
