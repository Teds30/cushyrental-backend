<?php

namespace App\Http\Controllers;

use App\Models\UnitImage;
use App\Http\Requests\StoreUnitImageRequest;
use App\Http\Requests\UpdateUnitImageRequest;
use Illuminate\Http\Request;

class UnitImageController extends Controller
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
            'image_id' => 'required|integer',
            'is_thumbnail' => 'integer',
        ]);

        $imageExist = UnitImage::where([
            ['unit_id', '=', $fields['unit_id']],
            ['image_id', '=', $fields['image_id']]
        ])->first();

        if ($imageExist) {
            $imageExist->update($request->all());
            return $imageExist;
        }

        $res = UnitImage::create($fields);

        return $res;
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitImage $unitImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnitImage $unitImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitImageRequest $request, UnitImage $unitImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $fields = $request->validate([
            'unit_id' => 'required|integer',
            'image_id' => 'required|integer',
        ]);

        $imageExist = UnitImage::where([
            ['unit_id', '=', $fields['unit_id']],
            ['image_id', '=', $fields['image_id']]
        ])->first();

        if ($imageExist) {
            $imageExist->delete();
            return $imageExist;
        }
        // $res = UnitImage::get()->where('id', $id)->first();

        // if (!$res || !$res->count()) {
        //     return response()->json([], 404);
        // }

        // $res->delete();

        // return $res;
    }
}
