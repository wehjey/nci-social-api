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
        Route::post('product/edit/{product}', 'ProductController@update');
        Route::get('product/{product}', 'ProductController@show');
        Route::get('products', 'ProductController@index');
        Route::get('products/category/{category_id}', 'ProductController@getCategoryProducts');
        Route::delete('product/{product}', 'ProductController@destroy');
        Route::post('order', 'ProductController@order');
        Route::get('orders', 'ProductController@myOrders');
        Route::get('sales', 'ProductController@mySales');


        /**
         * Category
         */
        Route::get('categories', 'CategoryController@index');

        //Profile
        Route::post('profile', 'RegisterController@updateProfile');

        /**
         * Book API
         */
        Route::get('books/new', 'BookController@newBooks');
        Route::post('books/search', 'BookController@searchBooks');
    });

});