<?php

/**
 * Returns json data after registration
 * 
 * @param string $token user api token
 * @param collection  $user user collect
 *
 * @return json token response
 */
function tokenResponse($token,$user)
{
  return response()->json([
        'status' => 201,
        'success' => true,
        'message' => 'Account created successfully',
        'access_token' => $token,
        'data' => $user,
        'token_type'   => 'bearer',
        'expires_in'   => auth('api')->factory()->getTTL() * 60
  ]);
}