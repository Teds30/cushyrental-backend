<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $out = array();
        $res = Review::get()->where('status', 1);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        foreach ($res as $entry) {
            $user = $entry->user;
            $out[] = $entry;
        }
        return $out;
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
            'user_id' => 'required|integer',
            'rental_id' => 'required|integer',
            'environment_star' => 'required|integer',
            'unit_star' => 'required|integer',
            'landlord_star' => 'required|integer',
            'message' => 'string',
            'star' => 'required|numeric'
        ]);

        $review = Review::create($fields);


        return $review;
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }

    public function landlord_reply_store(Request $request)
    {

        $fields = $request->validate([
            'review_id' => 'required|integer',
            'landlord_reply' => 'required'
        ]);

        $res = Review::find($fields['review_id']);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(['landlord_reply' => $fields['landlord_reply']]);

        return $res;
    }
}
