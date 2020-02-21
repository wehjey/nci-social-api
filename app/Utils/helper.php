<?php

use JD\Cloudder\Facades\Cloudder;

/**
 * Returns json data after registration
 * 
 * @param string     $token user api token
 * @param collection $user user collect
 * @param int        $status_code http status code
 *
 * @return json token response
 */
function tokenResponse($token, $user, $status_code)
{
  return response()->json([
        'status' => $status_code,
        'success' => true,
        'message' => 'Account created successfully',
        'access_token' => $token,
        'data' => $user,
        'token_type'   => 'bearer',
        'expires_in'   => auth('api')->factory()->getTTL() * 60
  ]);
}

/**
 * Returns json data after registration
 *
 * @param int        $status_code http status code
 * @param string     $message error message
 *
 * @return json token response
 */
function errorResponse($status_code, $message)
{
    return response()->json([
        'status' => $status_code,
        'success' => false,
        'message' => $message
  ]);
}


/**
 * Upload profile image to cloudinary API
 *
 * @param [object] $request
 * @return string profile image url
 */
function uploadImage($request)
{
    $path = '';
    if ($request->hasFile('profile_url')) {
        if ($request->file('profile_url')->isValid()) {
            $filename = $request['lastname'].'_'.$request['profile_url']->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            $trans = array(
                ".png" => "",
                ".PNG" => "",
                ".JPG" => "",
                ".jpg" => "",
                ".jpeg" => "",
                ".JPEG" => "",
                ".bmp" => "",
            );
            $filename = strtr($filename, $trans); // Remove all extensions from file name
            Cloudder::upload($request['profile_url']->getPathname(), $filename);
            $response = Cloudder::getResult();
            $path = $response['secure_url']; // get the secure url
        }
    }
    return $path;
}

