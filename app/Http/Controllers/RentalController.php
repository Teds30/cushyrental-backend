<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
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
            'user_id' => 'required',
            'unit_id' => 'required',
            'monthly_amount' => 'required|string',
            'due_date' => 'required|string',
            'date_start' => 'required|string',
            'date_end' => 'required|string',
        ]);

        $rental = Rental::create($fields);
        $user = auth('sanctum')->user()->id;

        $response = [
            'user' => $user,
            'rental' => $rental
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Rental::get()->where('id', $id)->where('status', 1);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

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
}
