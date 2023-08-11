<?php

namespace App\Http\Controllers;

use App\Models\Inclusion;
use App\Http\Requests\StoreInclusionRequest;
use App\Http\Requests\UpdateInclusionRequest;
use Illuminate\Http\Request;

class InclusionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Inclusion::get()->where('status', 1);

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

        $unit = Inclusion::create($fields);


        return $unit;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Inclusion::get()->where('id', $id)->where('status', 1)->firstOrFail();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inclusion $inclusion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInclusionRequest $request, Inclusion $inclusion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inclusion $inclusion)
    {
        //
    }
}
