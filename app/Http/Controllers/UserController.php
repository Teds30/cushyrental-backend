<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = User::get()->where('status', 1);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        return $res;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = User::get()->where('id', $id)->where('status', 1)->firstOrFail();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        return $res;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function user_units($id)
    {
        $res = User::find($id);
        $out = array();


        if ($res) {
            $out = $res->units()->where('status', '1')->get();
        }
        return $out;
    }
}
