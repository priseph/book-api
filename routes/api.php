<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//route for register and Login
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');

//routes for our API
//apiResource() is used to generate API only routes
Route::apiResource('books', 'BookController');

//route that will be used to rate a specified book
Route::post('books/{book}/ratings', 'RatingController@store');