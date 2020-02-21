<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    /**
     * Undocumented function
     *
     * @param LoginRequest $request
     * @return json
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']); // get the credentials from request
        if (!$token = auth()->attempt($credentials)) {
            return errorResponse(401, 'Invalid login details');
        }

        return tokenResponse($token, auth()->user(), 200);
    }
}
