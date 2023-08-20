<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{

    const provider = 'facebook';

    public function registerRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function registerCallback()
    {
        $SocialUser = Socialite::driver('facebook')->stateless()->user();
        // dd($SocialUser);

        // return response($SocialUser, 201);
        
        $userExisted = User::where('email', $SocialUser->email)->first();

        if (!$userExisted) {
            $name = explode(' ', $SocialUser->name);

            $user = User::updateOrCreate([
                'id' => $SocialUser->id,
            ], [
                'first_name' => $name[0],
                'last_name' => end($name),
                'email' => $SocialUser->email,
                'profile_picture_img' => $SocialUser->avatar,
                'user_type_id' => '1' // temporary
            ]);

            $token = $user->createToken('myapptoken')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            dd($token);

        } else {
            $response = $userExisted;

            dd($response);

        }

        
    }
}
