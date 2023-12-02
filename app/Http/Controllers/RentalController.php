<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Http\Requests\StoreRentalRequest;
use App\Http\Requests\UpdateRentalRequest;
use App\Models\Unit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = Rental::get()->where('status', 1);

        if (!$res || !$res->count()) {
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
            'user_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'slots' => 'required|integer',
            'monthly_amount' => 'required|numeric',
            'due_date' => 'required|integer',
            'date_start' => 'required|string',
        ]);

        $rental = Rental::create($fields);

        if ($rental) {
            $unit = Unit::get()->where('id', $request->unit_id)->first();
            if ($unit) {
                $req_slots = $request->slots;
                $unit_slots = $unit->slots;
                $new_slots = $unit_slots - $req_slots;
                $unit->update(["slots" => $new_slots]);
            }
        }

        // $user = auth('sanctum')->user()->id;
        // $response = [
        //     // 'user' => $user,
        //     'rental' => $rental
        // ];

        return response($rental, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = Rental::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->user;
        $res->unit;

        return $res;
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rental $rental)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $res = Rental::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update($request->all());

        return $res;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rental $rental)
    {
        //
    }

    /**
     * Archive specified resource.
     */
    public function archive($id)
    {
        $res = Rental::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(['status' => 0]);

        return $res;
    }

    public function landlord_tenants($landlord_id)
    {

        $res = User::get()->where('id', $landlord_id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $units = $res->units;
        $tenants = array();
        foreach ($units as $unit) {
            foreach ($unit->rentals as $rental) {
                $tenants[] = $rental->user;
            }
        }
        return $tenants;
    }


    public function landlord_rental_show($landlord_id)
    {
        $res = User::get()->where('id', $landlord_id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $units = $res->units;
        $rentals = array();
        foreach ($units as $unit) {
            foreach ($unit->rentals as $rental) {
                $rental->user;
                $rental->unit;
                $rentals[] = $rental;
            }
        }
        return $rentals;
    }

    public function landlord_upcoming_events($landlord_id)
    {
        $res = User::get()->where('id', $landlord_id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        $mytime = Carbon::now('Asia/Manila');
        $day = $mytime->format('d');
        $month = $mytime->month;
        $year = $mytime->year;



        $units = $res->units;
        $events = array();

        foreach ($units as $unit) {
            foreach ($unit->rentals as $rental) {
                $rental->user;
                $rental->unit;
                if ($rental['due_date'] >= $day) {


                    $ed = $year . '-' . $month . '-' . $rental['due_date'];
                    $event_date = Carbon::createFromFormat('Y-m-d', $ed);
                    $dayOfWeek = $event_date->dayOfWeek;
                    $weekMap = [
                        0 => 'SUN',
                        1 => 'MON',
                        2 => 'TUE',
                        3 => 'WED',
                        4 => 'THU',
                        5 => 'FRI',
                        6 => 'SAT',
                    ];
                    $weekday = $weekMap[$dayOfWeek];
                    $rental['dayOfWeek'] = $weekday;

                    $events[] = $rental;
                }
            }
        }
        return $events;
    }

    public function landlord_units_stats($landlord_id)
    {
        $res = User::get()->where('id', $landlord_id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $units_count = count($res->units);

        $listed_count = 0;
        $unlisted_count = 0;
        $occupied_count = 0;
        $pending_count = 0;
        $tenants = array();

        foreach ($res->units as $unit) {
            if ($unit['is_listed'] == 1) {
                $listed_count++;
            } else {
                $unlisted_count++;
            }

            if ($unit['request_status'] == 0) {
                $pending_count++;
            }
            if ($unit['slots'] == 0) {
                $occupied_count++;
            }

            foreach ($unit->rentals as $rental) {
                $tenants[] = $rental->user['id'];
            }
        }

        return [
            "units_count" => $units_count,
            "listed_count" => $listed_count,
            "unlisted_count" => $unlisted_count,
            "pending_count" => $pending_count,
            "occupied_count" => $occupied_count,
            "tenants_count" => count(array_unique($tenants))
        ];
    }


    public function terminate($id)
    {
        $res = Rental::find($id);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $res->update(["rental_status" => 4]);

        return $res;
    }

    public function tenant_rental_show($id)
    {
        $res = User::get()->where('id', $id)->where('status', 1)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        $rentals = $res->rentals ?? [];
        foreach ($rentals as $rental) {
            $rental->unit;
            $rental->unit->images;
            $rental->unit['average_ratings'] = $rental->unit->get_average_ratings();
        }
        return $rentals;
    }
}
