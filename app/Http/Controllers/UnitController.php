<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Amenity;
use Illuminate\Http\Request;
use App\Models\UnitAmenity;
use App\Models\UnitFacility;
use App\Models\UnitImage;
use App\Models\UnitInclusion;
use App\Models\UnitRule;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Unit::get()->where('status', 1);

        if (!$res) {
            return response()->json([], 404);
        }

        foreach ($res as $entry) {
            $entry->landlord;

            $amenities = $this->unit_amenities($entry->id);
            $facilities = $this->unit_facilities($entry->id);
            $inclusions = $this->unit_inclusions($entry->id);
            $rules = $this->unit_rules($entry->id);
            $images = $this->unit_images($entry->id);
            $subscriptions = $this->unit_active_subscriptions($entry->id);
            $ratings = $entry->get_average_ratings();

            $entry['amenities'] = $amenities;
            $entry['facilities'] = $facilities;
            $entry['inclusions'] = $inclusions;
            $entry['rules'] = $rules;
            $entry['images'] = $images;
            $entry['active_subscription'] = $subscriptions;
            $entry['average_ratings'] = $ratings;
        }

        return $res;
    }

    public function similar_units($id)
    {

        $toCompare = Unit::where('id', $id)->where('status', 1)->first();

        $amenityIds = collect($toCompare->amenities)->pluck('amenity_id')->toArray() ?? [];
        $facilityIds = collect($toCompare->facilities)->pluck('facility_id')->toArray() ?? [];
        $inclusionIds = collect($toCompare->inclusions)->pluck('inclusion_id')->toArray() ?? [];

        $similarUnits = Unit::select('units.*')
            ->leftJoin('unit_amenities', 'units.id', '=', 'unit_amenities.unit_id')
            ->leftJoin('unit_facilities', 'units.id', '=', 'unit_facilities.unit_id')
            ->leftJoin('unit_inclusions', 'units.id', '=', 'unit_inclusions.unit_id')
            ->where(function ($query) use ($amenityIds, $facilityIds, $inclusionIds) {
                if (!empty($amenityIds)) {
                    $query->whereIn('unit_amenities.amenity_id', $amenityIds);
                }

                if (!empty($facilityIds)) {
                    $query->orWhereIn('unit_facilities.facility_id', $facilityIds);
                }

                if (!empty($inclusionIds)) {
                    $query->orWhereIn('unit_inclusions.inclusion_id', $inclusionIds);
                }
            })
            ->where('units.id', '!=', $id) // Exclude the unit being compared
            ->groupBy(
                'units.id',
                'units.landlord_id',
                'units.name',
                'units.details',
                'units.price',
                'units.month_advance',
                'units.month_deposit',
                'units.location',
                'units.address',
                'units.target_gender',
                'units.slots',
                'units.is_listed',
                'units.request_status',
                'units.verdict',
                'units.status',
                'units.created_at',
                'units.updated_at',
            )
            ->orderByRaw('COUNT(*) DESC')
            ->take(3)
            ->distinct()
            ->get();

        foreach ($similarUnits as $entry) {
            $entry->landlord;

            $amenities = $this->unit_amenities($entry->id);
            $facilities = $this->unit_facilities($entry->id);
            $inclusions = $this->unit_inclusions($entry->id);
            $rules = $this->unit_rules($entry->id);
            $images = $this->unit_images($entry->id);
            $subscriptions = $this->unit_active_subscriptions($entry->id);
            $ratings = $entry->get_average_ratings();

            $entry['amenities'] = $amenities;
            $entry['facilities'] = $facilities;
            $entry['inclusions'] = $inclusions;
            $entry['rules'] = $rules;
            $entry['images'] = $images;
            $entry['active_subscription'] = $subscriptions;
            $entry['average_ratings'] = $ratings;
        }

        return $similarUnits;
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
        $out = array();

        $fields = $request->validate([
            'landlord_id' => 'required',
            'name' => 'required|string',
            'details' => 'required|string',
            'price' => 'required|string',
            'month_advance' => 'required|integer',
            'month_deposit' => 'required|integer',
            'location' => 'required|string',
            'address' => 'required|string',
            'target_gender' => 'required|integer',
            'slots' => 'required|integer',
            'is_listed' => 'integer',
        ]);

        $out['unit'] = Unit::create($fields);

        // $user = auth('sanctum')->user()->id;

        // $response = [
        //     'user' => $user,
        //     'unit' => $unit
        // ];

        // return response($response, 201);

        $out['amenities'] = $this->save_amenity($request->amenities, $out['unit']->id);
        $out['inclusions'] = $this->save_inclusion($request->inclusions, $out['unit']->id);
        $out['rules'] = $this->save_rule($request->rules, $out['unit']->id);
        $out['facilities'] = $this->save_facility($request->facilities, $out['unit']->id);
        $out['images'] = $this->save_unit_image($request->images, $out['unit']->id);

        return response($out, 200);
        // return response($request, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Unit::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->landlord;
        $res->get_average_ratings();

        $out = array();

        $amenities = $this->unit_amenities($id);
        $facilities = $this->unit_facilities($id);
        $inclusions = $this->unit_inclusions($id);
        $rules = $this->unit_rules($id);
        $images = $this->unit_images($id);
        $subscriptions = $this->unit_subscriptions($id);
        $rentals = $this->unit_rentals($id);

        $res['amenities'] = $amenities;
        $res['facilities'] = $facilities;
        $res['inclusions'] = $inclusions;
        $res['rules'] = $rules;
        $res['images'] = $images;
        $res['subscriptions'] = $subscriptions;
        $res['rentals'] = $rentals;
        $res['average_ratings'] = $res->get_average_ratings();

        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $res = Unit::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update($request->all());

        return $res;
    }

    public function verify(Request $request)
    {

        $res = Unit::find($request["id"]);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update([
            'is_listed' => $request["is_listed"],
            'verdict' => $request['verdict'],
            'request_status' => $request["request_status"]
        ]);
        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $res = Unit::get()->where('id', $id)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->delete();

        return $res;
    }

    /**
     * Archive specified resource.
     */
    public function archive($id)
    {
        $res = Unit::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(['status' => 0]);

        return $res;
    }



    /**
     * Unit Attributes
     */

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

    public function unit_subscriptions($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $subscriptions = $res->subscriptions;

            foreach ($subscriptions as $u_subscription) {
                if ($u_subscription->subscription['status'] == 1) {
                    $out[] = [
                        'id' => $u_subscription['subscription_id'],
                        'name' => $u_subscription->subscription['name'],
                        'hex_color' => $u_subscription->subscription['hex_color'],
                        'date_start' => $u_subscription['date_start'],
                        'date_end' => $u_subscription['date_end'],
                        'type' => $u_subscription['type'],
                        'request_status' => $u_subscription['request_status'],
                        'pop_image_id' => $u_subscription['pop_image_id'],
                        'account_name' => $u_subscription['account_name'],
                        'account_number' => $u_subscription['account_number'],
                        'email_address' => $u_subscription['email_address'],
                        'subscription_id' => $u_subscription['id'],
                    ];
                }
            }
        }
        return $out;
    }


    public function unit_rentals($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $rentals = $res->rentals;

            foreach ($rentals as $u_rental) {
                if ($u_rental['status'] == 1) {
                    $out[] = $u_rental;
                }
            }
        }
        return $out;
    }

    public function unit_reviews($id)
    {
        $res = Unit::find($id);
        $out = array();


        if ($res) {
            $rentals = $res->rentals;

            foreach ($rentals as $u_rental) {
                if ($u_rental['status'] == 1) {
                    $out = $u_rental->reviews;
                    foreach ($u_rental->reviews as $review) {
                        $review->user;
                        $review->rental->unit->landlord;
                    }
                }
            }
        }
        return $out;
    }

    public function unit_reviews_total($id)
    {
        $res = $this->unit_reviews($id);

        if (!$res) return ["unit_id" => intval($id), "average" => 0, "reviews" => 0];

        $average = 0;
        $sum = 0;
        $count = count($res);

        foreach ($res as $review) {
            $sum += intval($review['star']);
        }

        $average = $sum / $count;
        return ["unit_id" => intval($id), "average" => $average, "reviews" => $count];
    }

    // Saving attributes and unit images

    public function save_amenity($amenities, $id)
    {
        $saveAmenity = array();
        foreach ($amenities as $amenity) {
            $saveAmenity[] = [UnitAmenity::create([
                'unit_id' => $id,
                'amenity_id' => $amenity
            ])];
        }

        return $saveAmenity;
    }

    public function save_facility($facilities, $id)
    {
        $saveFacilities = array();

        foreach ($facilities as $facility) {
            $facility_id = intval($facility['id']);
            $isShared = intval($facility['is_shared']);

            $saveFacilities[] = UnitFacility::create([
                'unit_id' => $id,
                'facility_id' => $facility_id,
                'is_shared' => $isShared,
            ]);
        }

        return $saveFacilities;
    }

    public function save_inclusion($inclusions, $id)
    {
        $saveInclusions = array();
        foreach ($inclusions as $inclusion) {
            $saveInclusions[] = [UnitInclusion::create([
                'unit_id' => $id,
                'inclusion_id' => $inclusion
            ])];
        }

        return $saveInclusions;
    }

    public function save_rule($rules, $id)
    {
        $saveRules = array();
        foreach ($rules as $rule) {
            $saveRules[] = [UnitRule::create([
                'unit_id' => $id,
                'rule_id' => $rule
            ])];
        }

        return $saveRules;
    }

    public function save_unit_image($unitImages, $id)
    {
        $saveUnitImages = array();

        foreach ($unitImages as $unitImage) {
            $image_id = intval($unitImage['image_id']);
            $is_thumbnail = intval($unitImage['is_thumbnail']);

            $saveUnitImages[] = UnitImage::create([
                'unit_id' => $id,
                'image_id' => $image_id,
                'is_thumbnail' => $is_thumbnail,
            ]);
        }

        return $saveUnitImages;
    }


    public function unit_search(Request $request)
    {

        $filters = $request->filters;
        $radius_km = $request->radius;

        $latitude = $request->location['lat'];
        $longitude = $request->location['lng'];


        $units = Unit::select('*')
            ->selectRaw(
                '(6371 * ACOS(
            COS(RADIANS(?)) * COS(RADIANS(SUBSTRING_INDEX(location, \',\', 1)))*
            COS(RADIANS(? - SUBSTRING_INDEX(location, \',\', -1))) +
            SIN(RADIANS(?)) * SIN(RADIANS(SUBSTRING_INDEX(location, \',\', 1)))
        )) as distance',
                [$latitude, $longitude, $latitude]
            )
            ->having('distance', '<=', $radius_km);

        $units->where('status', 1);
        $units->where('is_listed', 1);

        if ($request->has('filters') && isset($request->filters['price_range'])) {
            $price_range = $request->filters['price_range'];
            $units->whereBetween('price', $price_range);
        }

        if ($request->has('filters') && isset($request->filters['gender'])) {
            $gender = $request->filters['gender'];
            $units->where('target_gender', $gender);
        }

        if ($request->has('filters') && isset($request->filters['quantity'])) {
            $quantity = $request->filters['quantity'];
            $units->where('slots', '>=', $quantity);
        }

        if ($request->has('filters') && isset($request->filters['amenity']) && count($request->filters['amenity']) > 0) {
            $amenities = $request->filters['amenity'];
            $units->where(function ($query) use ($amenities) {
                $query->whereHas('amenities', function ($query) use ($amenities) {
                    $query->whereIn('amenity_id', $amenities);
                });
            });
        }

        if ($request->has('filters') && isset($request->filters['facility']) && count($request->filters['facility']) > 0) {
            $facilities = $request->filters['facility'];
            $units->where(function ($query) use ($facilities) {
                $query->whereHas('facilities', function ($query) use ($facilities) {
                    $query->whereIn('facility_id', $facilities);
                });
            });
        }

        if ($request->has('filters') && isset($request->filters['inclusion']) && count($request->filters['inclusion']) > 0) {
            $inclusions = $request->filters['inclusion'];
            $units->where(function ($query) use ($inclusions) {
                $query->whereHas('inclusions', function ($query) use ($inclusions) {
                    $query->whereIn('inclusion_id', $inclusions);
                });
            });
        }

        if ($request->has('filters') && isset($request->filters['rule']) && count($request->filters['rule']) > 0) {
            $rules = $request->filters['rule'];
            $units->where(function ($query) use ($rules) {
                $query->whereHas('rules', function ($query) use ($rules) {
                    $query->whereIn('rule_id', $rules);
                });
            });
        }

        $units = $units->get();



        foreach ($units as $unit) {

            $images = $this->unit_images($unit->id);
            $unit["images"] = $images;
            $unit->landlord;
            $unit->amenities;
            $unit->facilities;
            $unit->inclusions;
            $unit->rules;
        }


        return ['units' => $units];
    }

    public function update_location(Request $request)
    {
        $res = Unit::find($request->id);
        $res->update([
            'location' => $request->location,
            'address' => $request->address
        ]);

        return $res;
    }
}
