<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlacklistedUser;
use App\Http\Requests\StoreBlacklistedUserRequest;
use App\Http\Requests\UpdateBlacklistedUserRequest;
use App\Models\User;

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
    public function create(Request $request)
{   
    $fields = $request->validate([
        'user_id' => 'required|integer',
        'reason' => 'required|string',
        'restricted_until' => 'required|string',
        'status' => 'required|integer', // Assuming you have a 'status' field in your request
    ]);

    if ($fields['status'] === 0) {
        $res = BlacklistedUser::create([
            'user_id' => $fields['user_id'],
            'reason' => $fields['reason'],
            'restricted_until' => $fields['restricted_until'],
        ]);

        // Update the status for the user
        User::where('id', $fields['user_id'])->update(['status' => $fields['status']]);
    } else {
        $res = BlacklistedUser::create($fields);
    }

    return $res;
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
