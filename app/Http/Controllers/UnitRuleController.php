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
        $fields = $request->validate([
            'unit_id' => 'required|integer',
            'rule_id' => 'required|integer',
        ]);

        $userExist = UnitRule::where([
            ['unit_id', '=', $fields['unit_id']],
            ['rule_id', '=', $fields['rule_id']]
        ])->first();

        if ($userExist) {
            return $userExist;
        }

        $res = UnitRule::create($fields);

        return $res;
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
    public function destroy($id)
    {
        $res = UnitRule::get()->where('id', $id)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->delete();

        return $res;
    }
}
