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
        $fields = $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'redirect_url' => 'required|string',
            'user_id' => 'required|integer',
        ]);


        $res = Notification::create($fields);

        return response($res, 200);
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
        return response()->json(['message' => 'Notification deleted'], 200);
    }


    public function user_notifications($id)
    {
        $res = Notification::where('user_id', $id)->orderBy('updated_at', 'desc')->get();

        if (!$res || !$res->count()) {
            return response()->json([]);
        }
        return $res;
    }


    public function read_notification(Request $request)
    {
        $res = Notification::get()->where('id', $request->id)->first();


        if (!$res || !$res->count()) {
            return response()->json([]);
        }

        $res->update(['is_read' => 1]);

        return $res;
    }
}
