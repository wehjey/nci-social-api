<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
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
            ]
        );
        $token = auth()->login($user); // Get user api token
        return tokenResponse($token, $user);
    }

}
