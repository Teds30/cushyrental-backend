<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacebookAuthController extends Controller
{

    public function register(Request $request)
    {
        // Check if the user with the provided email already exists
        $userExist = User::where('email', $request['email'])->first();

        if ($userExist) {
            return response([
                'message' => 'Email already exist.'
            ], 401);
        }

        $fields = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'string',
            'last_name' => 'required|string',
            'user_type_id' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'profile_picture_img' => 'required|string',
        ]);

        // Create a new user
        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'user_type_id' => $fields['user_type_id'],
            'email' => $fields['email'],
            'profile_picture_img' => $fields['profile_picture_img'],
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

    // namespace App\Http\Controllers\Auth;

    // use Exception;
    // use App\Models\User;
    // use Illuminate\Http\Request;
    // use App\Http\Controllers\Controller;
    // use Illuminate\Support\Facades\Auth;
    // use Illuminate\Support\Facades\Hash;
    // use Laravel\Socialite\Facades\Socialite;

    // class FacebookAuthController extends Controller
    // {

    //     const provider = 'facebook';

    //     public function registerRedirect()
    //     {
    //         return Socialite::driver('facebook')->redirect();
    //     }

    //     public function registerCallback()
    //     {
    //         $SocialUser = Socialite::driver('facebook')->stateless()->user();
    //         // dd($SocialUser);

    //         // return response($SocialUser, 201);

    //         $userExisted = User::where('email', $SocialUser->email)->first();

    //         if (!$userExisted) {
    //             $name = explode(' ', $SocialUser->name);

    //             $user = User::updateOrCreate([
    //                 'id' => $SocialUser->id,
    //             ], [
    //                 'first_name' => $name[0],
    //                 'last_name' => end($name),
    //                 'email' => $SocialUser->email,
    //                 'profile_picture_img' => $SocialUser->avatar,
    //                 'user_type_id' => '1' // temporary
    //             ]);

    //             $token = $user->createToken('myapptoken')->plainTextToken;

    //             $response = [
    //                 'user' => $user,
    //                 'token' => $token
    //             ];

    //             dd($token);

    //         } else {
    //             $response = $userExisted;

    //             dd($response);

    //         }


    //     }
}
