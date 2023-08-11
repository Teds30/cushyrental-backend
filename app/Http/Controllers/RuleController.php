<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Rule::get()->where('status', 1);

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
    public function store(Request $request)
    {
        $fields = $request->validate([
            'icon' => 'string',
            'name' => 'required|string',
        ]);

        $unit = Rule::create($fields);


        return $unit;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Rule::get()->where('id', $id)->where('status', 1)->firstOrFail();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rule $rule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRuleRequest $request, Rule $rule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rule $rule)
    {
        //
    }
}
