<?php

namespace App\Http\Controllers;

use App\Models\ReportedUser;
use App\Http\Requests\StoreReportedUserRequest;
use App\Http\Requests\UpdateReportedUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReportedUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $out = array();
        $res = ReportedUser::get()->where('status', 1);

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        foreach ($res as $entry) {
            $user = $entry->user;
            $reported_by = $entry->report_by;
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
    public function store(StoreReportedUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $res = ReportedUser::get()->where('id', $id)->where('status', 1)->firstOrFail();

        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        return $res;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReportedUser $reportedUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReportedUserRequest $request, ReportedUser $reportedUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReportedUser $reportedUser)
    {
        //
    }

    public function reported_user_group()
    {
        $out = array();
        // $res = ReportedUser::get()->where('status', 1)->distinct('user_id');
        $res = ReportedUser::select('user_id')->distinct()->get();


        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }

        foreach ($res as $entry) {
            $reports = array();
            $user_reports = ReportedUser::get()->where('user_id', $entry->user_id);
            foreach ($user_reports as $ur) {
                $reports[] = $ur;
            }
            $out[] = ["user" => $entry->user, "reports" => [...$reports]];
        }
        return $out;
    }

    public function reported_user_group_show($user_id)
    {
        // $out = array();

        $res = User::get()->where('id', $user_id)->where('status', 1)->firstOrFail();
        if (!$res || !$res->count()) {
            return response()->json([], 404);
        }
        $res->reported;
        $out = $res;

        foreach ($out->reported as $reporter) {
            $reporter->report_by;
        }

        // return $test;

        return $out;
    }
}
