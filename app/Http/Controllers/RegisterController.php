<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\User;

class RegisterController extends Controller
{

    /**
     * Register new students
     * 
     * @param object $request contains http request
     * 
     * @return json
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create(
            [
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'phone_number' => $request['phone_number'],
                'email'    => $request['email'],
                'password' => bcrypt($request['password']),
                'profile_url' => uploadImage($request, 'profile_url'),
            ]
        );
        $token = auth()->login($user, true); // Get user api token
        return tokenResponse($token, $user, 201);
    }

    /**
     * Update profile
     * 
     * @param object $request contains http request
     * 
     * @return json
     */
    public function updateProfile(ProfileRequest $request)
    {
        $user = User::find(auth()->id());
        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->phone_number = $request['phone_number'];
        // Save images if user uploaded
        if (isset($request['profile_url'])) {
            $user->profile_url = uploadImage($request, 'profile_url');
        }
        $user->save();
        return resourceCreatedResponse($user, 'Profile updated successfully', 200);
    }

}
