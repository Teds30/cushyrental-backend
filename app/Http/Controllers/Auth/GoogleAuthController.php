<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Ramsey\Uuid\Guid\Fields;

class GoogleAuthController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('email', $request['email'])->first();

        if ($user) {

            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, 201);
        } else {


            $response = [
                'user' => null,
                'token' => null,
                'error' => 'The email provided is not yet registered.'
            ];

            return response($response);
        }
    }
    public function register(Request $request)
    {
        // Check if the user with the provided email already exists
        $userExist = User::where('email', $request['email'])->first();

        if ($userExist) {

            // Generate a token for the user
            $token = $userExist->createToken('myapptoken')->plainTextToken;

            // Prepare a success response
            $response = [
                'user' => $userExist,
                'token' => $token
            ];

            return response($response, 201);

            // return response([
            //     'message' => 'Email already exist.'
            // ], 401);
        }

        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'string|nullable',
            'user_type_id' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'profile_picture_img' => 'required|string',
        ]);

        // Create a new user
        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'] ?? '',
            'user_type_id' => $fields['user_type_id'],
            'email' => $fields['email'],
            'profile_picture_img' => $fields['profile_picture_img'],
            'is_social' => 1,
        ]);

        // Generate a token for the user
        $token = $user->createToken('myapptoken')->plainTextToken;

        // Prepare a success response
        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
}
