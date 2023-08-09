<?php

namespace App\Http\Controllers;

use App\Models\AccountVerification;
use App\Http\Requests\StoreAccountVerificationRequest;
use App\Http\Requests\UpdateAccountVerificationRequest;
use Illuminate\Http\Request;

class AccountVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = AccountVerification::get()->where('status', 1);

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
            'user_id' => 'required',
            'checked_by' => 'required',
            'verdict' => 'string',
            'denied_reason' => 'string',
            'submitted_id_image_url' => 'required|string',
            'identification_card_type' => 'required|integer',
            'address' => 'required|string',
            'contact_number' => 'required|string',
        ]);

        $acc_ver = AccountVerification::create($fields);
        $user = auth('sanctum')->user()->id;

        $response = [
            'user' => $user,
            'res' => $acc_ver
        ];

        return response($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $res = AccountVerification::get()->where('id', $id)->where('status', 1)->firstOrFail();;

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        $res->user;
        $res->checked_by;
        $res->identification_card_type;
        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountVerification $accountVerification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $res = AccountVerification::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update($request->all());

        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountVerification $accountVerification)
    {
        //
    }

    /**
     * Archive specified resource.
     */
    public function archive($id)
    {
        $res = AccountVerification::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(['status' => 0]);

        return $res;
    }
}
