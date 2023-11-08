<?php

namespace App\Http\Controllers;

use App\Models\UnitAmenity;
use App\Http\Requests\StoreUnitAmenityRequest;
use App\Http\Requests\UpdateUnitAmenityRequest;
use Illuminate\Http\Request;

class UnitAmenityController extends Controller
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
        $res = [];

        foreach ($request->all() as $data) {
            $unit_amenity = UnitAmenity::where('unit_id', $data['unit_id'])->where('amenity_id', $data['id'])->first();

            if (!$unit_amenity) {
                // $unit_amenity->delete();
                $res[] = UnitAmenity::create([
                    'unit_id' => $data['unit_id'],
                    'amenity_id' => $data['id']
                ]);
            }
        }

        return response()->json($res, 201);
        // $fields = $request->validate([
        //     'unit_id' => 'required|integer',
        //     'amenity_id' => 'required|string',
        // ]);

        // $userExist = UnitAmenity::where([
        //     ['unit_id', '=', $fields['unit_id']],
        //     ['amenity_id', '=', $fields['amenity_id']]
        // ])->first();

        // if ($userExist) {
        //     return $userExist;
        // }

        // $res = UnitAmenity::create($fields);

        // return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitAmenity $unitAmenity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitAmenity $unitAmenity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitAmenityRequest $request, UnitAmenity $unitAmenity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $res = [];

        foreach ($request->all() as $data) {
            $unit_amenity = UnitAmenity::where('unit_id', $data['unit_id'])->where('amenity_id', $data['id'])->first();

            if ($unit_amenity) {
                $unit_amenity->delete();
                $res[] = $unit_amenity;
            }
        }

        return response()->json($res, 201);
    }
}
