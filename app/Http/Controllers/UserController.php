<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
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
        $res = User::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        if ($res['user_type_id'] == 2) {
            $res['total_ratings'] = $res->get_total_ratings();
        }
        return $res;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $res = User::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $fields = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'gender' => 'required|string',
            'profile_picture_img' => 'required|string'
        ]);

        $res->update([
            'first_name' => $fields['first_name'],
            'middle_name' => $fields['middle_name'],
            'last_name' => $fields['last_name'],
            'phone_number' => $fields['phone_number'],
            'gender' => $fields['gender'],
            'profile_picture_img' => $fields['profile_picture_img']
        ]);

        return $res;
    }
    
    public function user_data(Request $request)
    {
        $res = $request->user();

        return $res;
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
            foreach ($out as $o) {
                $o['average_ratings'] = $o->get_average_ratings();
                $o->subscriptions;
                $o->images;
                $o->amenities;
                foreach ($o->amenities as $amenity) {
                    $amenity->amenity;
                }
            }
        }
        return $out;
    }
}
