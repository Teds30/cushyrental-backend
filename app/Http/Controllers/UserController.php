<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Twilio\Rest\Client;

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

        $res->update([
            'first_name' => $request['first_name'],
            'middle_name' => $request['middle_name'],
            'last_name' => $request['last_name'],
            'phone_number' => $request['phone_number'],
            'gender' => $request['gender'],
            'profile_picture_img' => $request['profile_picture_img'],
            'phone_number' => $request['phone_number'],
        ]);

        return $res;
    }

    public function user_data(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['user' => $user], 200);
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
                foreach ($o->images as $image) {
                    $image->image;
                }
            }
        }
        return $out;
    }

    public function get_email($email)
    {
        $res = User::where('email', $email)->first();

        if (!$res || !$res->count()) {
            return response()->json([], 200);
        }

        return $res;
    }

    public function request_otp(Request $request)
    {
        $fields = $request->validate([
            'number' => 'required|string',
        ]);

        $number = $fields['number'];

        $isLengthValid = strlen($number) === 11;
        $startsWith09 = substr($number, 0, 2) === '09';
        $isAllDigits = ctype_digit($number);

        // Combine the conditions
        if ($isLengthValid && $startsWith09 && $isAllDigits) {
            $transformedNumber = '+63' . substr($number, 1);
            $sid = getenv("TWILIO_SID");
            $otp_sid = getenv("TWILIO_OTP_SID");
            $token = getenv("TWILIO_TOKEN");
            $twilio = new Client($sid, $token);

            $verification = $twilio->verify->v2->services($otp_sid)
                ->verifications
                ->create($transformedNumber, "sms");

            return (["status" => $verification->status]);
        }
    }

    public function validate_otp(Request $request)
    {

        $fields = $request->validate([
            'number' => 'required|string',
            'otp' => 'required|string',
        ]);

        $number = $fields['number'];
        $otp = $fields['otp'];

        $isLengthValid = strlen($number) === 11;
        $startsWith09 = substr($number, 0, 2) === '09';
        $isAllDigits = ctype_digit($number);

        // Combine the conditions
        if ($isLengthValid && $startsWith09 && $isAllDigits) {
            $transformedNumber = '+63' . substr($number, 1);
            $sid = getenv("TWILIO_SID");
            $otp_sid = getenv("TWILIO_OTP_SID");
            $token = getenv("TWILIO_TOKEN");
            $twilio = new Client($sid, $token);
            $verification_check = $twilio->verify->v2->services($otp_sid)
                ->verificationChecks
                ->create(
                    [
                        "to" => $transformedNumber,
                        "code" => $otp
                    ]
                );

            return (["status" => $verification_check->status]);
        }
        return false;
    }
}
