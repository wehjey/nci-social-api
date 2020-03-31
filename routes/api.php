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
     * Payment route
     */
    Route::get('payment/callback', 'PaymentController@gatewayCallback');

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
        Route::get('comments/topic/{topic}', 'CommentController@index');
        Route::post('comment/{topic}', 'CommentController@store');
        Route::get('comment/{comment}', 'CommentController@show');
        Route::delete('comment/{comment}', 'CommentController@destroy');

        /**
         * Market Place routes
         */
        Route::post('product', 'ProductController@create');
        Route::get('product/{product}', 'ProductController@show');
        Route::get('products', 'ProductController@index');
        Route::delete('product/{product}', 'ProductController@destroy');
        Route::post('order', 'ProductController@order');


        /**
         * Category
         */
        Route::get('categories', 'CategoryController@index');
    });

});