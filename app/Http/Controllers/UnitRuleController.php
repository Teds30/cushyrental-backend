<?php

namespace App\Http\Controllers;

use App\Models\UnitRule;
use App\Http\Requests\StoreUnitRuleRequest;
use App\Http\Requests\UpdateUnitRuleRequest;
use Illuminate\Http\Request;

class UnitRuleController extends Controller
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
            $unit_rule = UnitRule::where('unit_id', $data['unit_id'])->where('rule_id', $data['id'])->first();

            if (!$unit_rule) {
                // $unit_amenity->delete();
                $res[] = UnitRule::create([
                    'unit_id' => $data['unit_id'],
                    'rule_id' => $data['id']
                ]);
            }
        }

        return response()->json($res, 201);
        // $fields = $request->validate([
        //     'unit_id' => 'required|integer',
        //     'rule_id' => 'required|integer',
        // ]);

        // $userExist = UnitRule::where([
        //     ['unit_id', '=', $fields['unit_id']],
        //     ['rule_id', '=', $fields['rule_id']]
        // ])->first();

        // if ($userExist) {
        //     return $userExist;
        // }

        // $res = UnitRule::create($fields);

        // return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitRule $unitRule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitRule $unitRule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRuleRequest $request, UnitRule $unitRule)
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
            $unit_rule = UnitRule::where('unit_id', $data['unit_id'])->where('rule_id', $data['id'])->first();

            if ($unit_rule) {
                $unit_rule->delete();
                $res[] = $unit_rule;
            }
        }

        return response()->json($res, 201);
    }
}
