<?php

/**
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {

    /**
     * API authentication routes
     */
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');

    /**
     * Authenticated routes
     */
    Route::middleware('auth:api')->group(function () {

        /**
         * Topic routes
         */
        Route::get('topics', 'TopicController@index');
        Route::post('topic', 'TopicController@store');
        Route::get('topic/{topic}', 'TopicController@show');
        Route::delete('topic/{topic}', 'TopicController@destroy');

        /**
         * Comment routes
         */
        Route::get('comments/{topic}', 'CommentController@index');
        Route::post('comment/{topic}', 'CommentController@store');
        Route::get('comment/{comment}', 'CommentController@show');
        Route::delete('comment/{comment}', 'CommentController@destroy');

    });

});