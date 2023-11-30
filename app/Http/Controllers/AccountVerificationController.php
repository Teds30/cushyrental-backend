<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AccountVerification;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreAccountVerificationRequest;
use App\Http\Requests\UpdateAccountVerificationRequest;
use Illuminate\Support\Facades\Storage;

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

        foreach ($res as $e) {
            $e->user;
            $e->checked_by;
            $e->identification_card_type;
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
        $out = [];

        $fields = $request->validate([
            'user_id' => 'required',
            'checked_by' => 'integer',
            'verdict' => 'string',
            'denied_reason' => 'string',
            'submitted_id_image_url' => 'required|string',
            'identification_card_type_id' => 'required|integer',
            'address' => 'required|string',
            'contact_number' => 'required|string',
        ]);

        $isVerified = AccountVerification::where('user_id', $fields['user_id'])->first();

        if ($isVerified) {
            $isVerified->update([
                'submitted_id_image_url' => $fields['submitted_id_image_url'],
                'identification_card_type_id' => $fields['identification_card_type_id'],
                'address' => $fields['address'],
                'contact_number' => $fields['contact_number'],
                'verdict' => null,
                'denied_reason' => null,
            ]);

            $out['acc_ver'] = $isVerified;
            $out['user'] = User::where('id', $fields['user_id'])->first();
        } else {
            $out['acc_ver'] = AccountVerification::create($fields);
            $out['user'] = User::where('id', $fields['user_id'])->first();
        }

        return response($out, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = AccountVerification::get()->where('id', $id)->where('status', 1)->first();

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

    public function landlord_verification($id)
    {

        $res = AccountVerification::with('identification_card_type')
            ->where('user_id', $id)
            ->where('status', 1)
            ->first();

        return ['data' => $res];
    }

    public function update_landlord_verification(Request $request)
    {
        $res = AccountVerification::get()->where('id', $request['id'])->first();

        if ($request['verdict'] === 0) {
            $this->delete_dentification_card($res->submitted_id_image_url);

            $res->update([
                'checked_by_id' => $request['checked_by_id'],
                'verdict' => $request['verdict'],
                'denied_reason' => $request['denied_reason'],
            ]);
        } else {
            $pathToFile = public_path("uploads/identification_card/" . $res->submitted_id_image_url);
            
            $res->update([
                'checked_by_id' => $request['checked_by_id'],
                'verdict' => $request['verdict'],
            ]);

            $res->User->update(['is_verified' => $request['verdict']]);
            // if (file_exists($pathToFile)) {
            //     File::delete($image_path);
            //     unlink($pathToFile);
            // }
        }

        return $res;
    }

    public function delete_dentification_card($fileName)
    {
        // $res = Storage::delete($fileName);
        $res = unlink(storage_path('app/uploads/identification_card/' . $fileName));

        // return response()->json($res);
    }
}
