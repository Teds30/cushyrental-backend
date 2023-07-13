<?php

namespace App\Http\Controllers;

use App\Models\IdentificationCardType;
use App\Http\Requests\StoreIdentificationCardTypeRequest;
use App\Http\Requests\UpdateIdentificationCardTypeRequest;

class IdentificationCardTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return IdentificationCardType::all();
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
    public function store(StoreIdentificationCardTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(IdentificationCardType $identificationCardType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IdentificationCardType $identificationCardType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdentificationCardTypeRequest $request, IdentificationCardType $identificationCardType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IdentificationCardType $identificationCardType)
    {
        //
    }
}
