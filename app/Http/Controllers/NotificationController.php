<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Notification::all();

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the post by its ID
        $notification = Notification::find($id);

        if (!$notification) {
            // Return a response indicating that the notification was not found
            return response()->json(['message' => 'Notification not found'], 404);
        }

        // Delete the notification
        $notification->delete();

        // Return a response indicating the post was deleted
        return response()->json(['message' => 'Post deleted'], 200);
    }


    public function user_notifications($id)
    {
        $res = Notification::where('user_id', $id)->get();

        if (!$res || !$res->count()) {
            return response()->json([]);
        }
        return $res;
    }
}
