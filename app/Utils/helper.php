<?php

/**
 * Helper file with global functions
 */
use JD\Cloudder\Facades\Cloudder;

/**
 * Returns json data after registration
 * 
 * @param string     $token       user api token
 * @param collection $user        user collect
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
  ], $status_code);
}

/**
 * Returns resource data json
 * 
 * @param collection $data         Resource data
 * @param string     $message      Response
 * @param int        $status_code  HTTP status code
 *
 * @return json resource response
 */
function resourceResponse($data, $message, $status_code)
{
    return response()->json([
            'status' => $status_code,
            'success' => true,
            'message' => $message,
            'per_page' => $data->perPage(),
            'item_count' => $data->count(),
            'total_count' => $data->total(),
            'data' => $data,
            'prev_page' => $data->previousPageUrl(),
            'next_page' => $data->nextPageUrl()
    ], $status_code);
}

/**
 * Returns resource data json
 * 
 * @param collection $data         Resource data
 * @param string     $message      Response
 * @param int        $status_code  HTTP status code
 *
 * @return json resource response
 */
function resourceCreatedResponse($data, $message, $status_code)
{
    return response()->json([
            'status' => $status_code,
            'success' => true,
            'message' => $message,
            'data' => $data,
    ], $status_code);
}

/**
 * Returns json data after registration
 *
 * @param int    $status_code http status code
 * @param string $message     error message
 * @param array  $errors      array of validation error messages
 *
 * @return json  token        response
 */
function errorResponse($status_code, $message, $errors=[])
{
    return response()->json([
        'status' => $status_code,
        'success' => false,
        'message' => $message,
        'errors' => $errors
    ], $status_code);
}

/**
 * Upload profile image to cloudinary API
 *
 * @param object $request http request object
 * 
 * @return string profile  image url
 */
function uploadImage($request, $field)
{
    $path = '';
    if ($request->hasFile($field)) {
        if ($request->file($field)->isValid()) {
            $filename = filename().$request[$field]->getClientOriginalName();
            $filename = str_replace(' ', '_', $filename);
            $filename = strtr($filename, fileExtensions()); // Remove all extensions from file name
            Cloudder::upload($request[$field]->getPathname(), $filename);
            $response = Cloudder::getResult();
            $path = $response['secure_url']; // get the secure url
        }
    }
    return $path;
}

/**
 * Upload profile image to cloudinary API
 *
 * @param object $image Image object
 * 
 * @return string profile  Image url
 */
function uploadSingleImage($image)
{
    $path = '';
    if ($image->isValid()) {
        $filename = filename().$image->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);
        $filename = strtr($filename, fileExtensions()); // Remove all extensions from file name
        Cloudder::upload($image->getPathname(), $filename);
        $response = Cloudder::getResult();
        $path = $response['secure_url']; // get the secure url
    }
    return $path;
}

/**
 * Returns array of file extensions
 *
 * @return array
 */
function fileExtensions()
{
    return [
        ".png" => "",
        ".PNG" => "",
        ".JPG" => "",
        ".jpg" => "",
        ".jpeg" => "",
        ".JPEG" => "",
        ".bmp" => "",
    ];
}

/**
 * Generates filename prefix for uploads
 *
 * @return string
 */
function filename()
{
    return 'NCISOC_'.date('YmdHisu').'_';
}

/**
 * Number of elements per page
 *
 * @return int
 */
function perPage()
{
    $per_page = 20;

    // Check if per_page exists in query and ensure its an integer
    if (request()->exists('per_page')) {
        $per_page = (int) request('per_page');
    } 

    return $per_page;
}

