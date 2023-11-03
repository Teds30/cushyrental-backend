<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Unit;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function create(Request $request)
    {
        $bookmarksWithUnits = [];

        $fields = $request->validate([
            'user_id' => 'required|integer',
            'unit_id' => 'required|integer',
        ]);

        $isBookmark = Bookmark::where('user_id', $fields['user_id'])
            ->where('unit_id', $fields['unit_id'])
            ->first();

        if ($isBookmark) {
            $isBookmark->delete();
            
            $bookmarks = Bookmark::where('user_id', $fields['user_id'])->get();
            foreach ($bookmarks as $bookmark) {
                $unit = Unit::where('id', $bookmark->unit_id)->first();
                if ($unit) {
                    $unit->load('landlord');
                    $amenities = $this->unit_amenities($unit->id);
                    $facilities = $this->unit_facilities($unit->id);
                    $inclusions = $this->unit_inclusions($unit->id);
                    $rules = $this->unit_rules($unit->id);
                    $images = $this->unit_images($unit->id);
                    $subscriptions = $this->unit_active_subscriptions($unit->id);
                    $ratings = $unit->get_average_ratings();
    
                    // Add average ratings to the unit details
                    $unit['amenities'] = $amenities;
                    $unit['facilities'] = $facilities;
                    $unit['inclusions'] = $inclusions;
                    $unit['rules'] = $rules;
                    $unit['images'] = $images;
                    $unit['active_subscription'] = $subscriptions;
                    $unit['average_ratings'] = $ratings;
    
                    $bookmarksWithUnits[] = $unit;
                }
            }
            return response()->json($bookmarksWithUnits, 201);
        }

        $res = Bookmark::create($fields);
        return response()->json($res, 201);
    }

    public function show($id)
    {
        $res = Bookmark::where('user_id', $id)->get();
        foreach ($res as $unit) {
            $unit->unit;
        }
        return response()->json($res, 201);
    }

    public function bookmark_units($id)
    {
        $bookmarks = Bookmark::where('user_id', $id)->get();
        $bookmarksWithUnits = [];

        foreach ($bookmarks as $bookmark) {
            $unit = Unit::find($bookmark->unit_id);

            if ($unit) {
                $unit->load('landlord');
                $amenities = $this->unit_amenities($unit->id);
                $facilities = $this->unit_facilities($unit->id);
                $inclusions = $this->unit_inclusions($unit->id);
                $rules = $this->unit_rules($unit->id);
                $images = $this->unit_images($unit->id);
                $subscriptions = $this->unit_active_subscriptions($unit->id);
                $ratings = $unit->get_average_ratings();

                // Add average ratings to the unit details
                $unit['amenities'] = $amenities;
                $unit['facilities'] = $facilities;
                $unit['inclusions'] = $inclusions;
                $unit['rules'] = $rules;
                $unit['images'] = $images;
                $unit['active_subscription'] = $subscriptions;
                $unit['average_ratings'] = $ratings;

                $bookmarksWithUnits[] = $unit;
            }
        }

        // Returning the JSON response with the modified bookmarks
        return response()->json($bookmarksWithUnits, 201);
    }

    public function unit_amenities($id)
    {
        $res = Unit::find($id);
        $out = array();

        if ($res) {
            $amenities = $res->amenities;

            foreach ($amenities as $u_amenity) {
                if ($u_amenity->amenity['status'] == 1) {
                    $out[] = [
                        'id' => $u_amenity['amenity_id'],
                        'name' => $u_amenity->amenity['name'],
                        'icon' => $u_amenity->amenity['icon'],
                        'is_available' => $u_amenity->amenity['is_available'],
                    ];
                }
            }
        }
        return $out;
    }

    public function unit_facilities($id)
    {
        $res = Unit::find($id);
        $out = array();

        if ($res) {
            $facilities = $res->facilities;

            foreach ($facilities as $u_facility) {
                if ($u_facility->facility['status'] == 1) {
                    $out[] = [
                        'id' => $u_facility['facility_id'],
                        'name' => $u_facility->facility['name'],
                        'icon' => $u_facility->facility['icon'],
                        'is_shared' => $u_facility['is_shared'],
                        'is_available' => $u_facility->facility['is_available'],
                    ];
                }
            }
        }
        return $out;
    }

    public function unit_inclusions($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $inclusions = $res->inclusions;

            foreach ($inclusions as $u_inclusion) {
                if ($u_inclusion->inclusion['status'] == 1) {
                    $out[] = [
                        'id' => $u_inclusion['inclusion_id'],
                        'name' => $u_inclusion->inclusion['name'],
                        'icon' => $u_inclusion->inclusion['icon'],
                        'is_available' => $u_inclusion->inclusion['is_available'],
                    ];
                }
            }
        }
        return $out;
    }

    public function unit_rules($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $rules = $res->rules;

            foreach ($rules as $u_rule) {
                if ($u_rule->rule['status'] == 1) {
                    $out[] = [
                        'id' => $u_rule['rule_id'],
                        'name' => $u_rule->rule['name'],
                        'icon' => $u_rule->rule['icon'],
                        'is_available' => $u_rule->rule['is_available'],
                    ];
                }
            }
        }
        return $out;
    }

    public function unit_images($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $images = $res->images;

            foreach ($images as $u_image) {
                if ($u_image->image['status'] == 1) {
                    $out[] = [
                        'id' => $u_image['image_id'],
                        'image' => $u_image->image['image'],
                        'is_thumbnail' => $u_image['is_thumbnail'],
                    ];
                }
            }
        }
        return $out;
    }

    public function unit_active_subscriptions($id)
    {
        $res = Unit::find($id);
        $out = null;


        if ($res) {
            $subscriptions = $res->subscriptions;

            foreach ($subscriptions as $u_subscription) {
                if ($u_subscription->subscription['status'] == 1 && $u_subscription['request_status'] == 1) {
                    $out = [
                        'id' => $u_subscription['subscription_id'],
                        'name' => $u_subscription->subscription['name'],
                        'hex_color' => $u_subscription->subscription['hex_color'],
                        'date_start' => $u_subscription['date_start'],
                        'date_end' => $u_subscription['date_end'],
                        'type' => $u_subscription['type'],
                        'request_status' => $u_subscription['request_status'],
                    ];
                }
            }
        }
        return $out;
    }
}
