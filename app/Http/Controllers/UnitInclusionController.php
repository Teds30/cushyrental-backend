<?php

namespace App\Http\Controllers;

use App\Models\UnitInclusion;
use App\Http\Requests\StoreUnitInclusionRequest;
use App\Http\Requests\UpdateUnitInclusionRequest;
use Illuminate\Http\Request;

class UnitInclusionController extends Controller
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
            $unit_inclusion = UnitInclusion::where('unit_id', $data['unit_id'])->where('inclusion_id', $data['id'])->first();

            if (!$unit_inclusion) {
                // $unit_amenity->delete();
                $res[] = UnitInclusion::create([
                    'unit_id' => $data['unit_id'],
                    'inclusion_id' => $data['id']
                ]);
            }
        }

        return response()->json($res, 201);
        // $fields = $request->validate([
        //     'unit_id' => 'required|integer',
        //     'inclusion_id' => 'required|integer',
        // ]);

        // $userExist = UnitInclusion::where([
        //     ['unit_id', '=', $fields['unit_id']],
        //     ['inclusion_id', '=', $fields['inclusion_id']]
        // ])->first();

        // if ($userExist) {
        //     return $userExist;
        // }

        // $res = UnitInclusion::create($fields);

        // return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitInclusion $unitInclusion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitInclusion $unitInclusion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitInclusionRequest $request, UnitInclusion $unitInclusion)
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
            $unit_inclusion = UnitInclusion::where('unit_id', $data['unit_id'])->where('inclusion_id', $data['id'])->first();

            if ($unit_inclusion) {
                $unit_inclusion->delete();
                $res[] = $unit_inclusion;
            }
        }

        return response()->json($res, 201);
    }
}
