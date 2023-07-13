<?php

namespace App\Http\Controllers;

use App\Models\BlacklistedUser;
use App\Http\Requests\StoreBlacklistedUserRequest;
use App\Http\Requests\UpdateBlacklistedUserRequest;

class BlacklistedUserController extends Controller
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
    public function store(StoreBlacklistedUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BlacklistedUser $blacklistedUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlacklistedUser $blacklistedUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlacklistedUserRequest $request, BlacklistedUser $blacklistedUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlacklistedUser $blacklistedUser)
    {
        //
    }
}
