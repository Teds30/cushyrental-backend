<?php

namespace App\Http\Controllers;

use App\Models\UserTypes;
use App\Http\Requests\StoreUserTypesRequest;
use App\Http\Requests\UpdateUserTypesRequest;

class UserTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = UserTypes::get()->where('status', 1);

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
    public function store(StoreUserTypesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = UserTypes::get()->where('id', $id)->where('status', 1);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserTypes $userTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserTypesRequest $request, UserTypes $userTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTypes $userTypes)
    {
        //
    }
}
