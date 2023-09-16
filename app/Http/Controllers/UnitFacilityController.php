<?php

namespace App\Http\Controllers;

use App\Models\UnitFacility;
use App\Http\Requests\StoreUnitFacilityRequest;
use App\Http\Requests\UpdateUnitFacilityRequest;
use Illuminate\Http\Request;

class UnitFacilityController extends Controller
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
            'facility_id' => 'required|integer',
            'is_shared' => 'integer'
        ]);

        $facilityExist = UnitFacility::where([
            ['unit_id', '=', $fields['unit_id']],
            ['facility_id', '=', $fields['facility_id']]
        ])->first();

        if ($facilityExist) {
            $facilityExist->update($request->all());
            return $facilityExist;
        }

        $res = UnitFacility::create($fields);

        return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitFacility $unitFacility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitFacility $unitFacility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitFacilityRequest $request, UnitFacility $unitFacility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $res = UnitFacility::get()->where('id', $id)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->delete();

        return $res;
    }
}
