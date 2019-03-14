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

/*** Profiles Endpoints ***/
// List profiles
Route::get('profiles', 'ProfilesController@index');

// List profiles by area
Route::get('profiles-by-area', 'ProfilesController@get_profiles_by_area');

// List single profile
Route::get('profile/{id}', 'ProfilesController@show');

// Create new profile
Route::post('profile', 'ProfilesController@store');

// Update profile
Route::put('profile', 'ProfilesController@store');

// Delete profile
Route::delete('profile/{id}', 'ProfilesController@destroy');


/***Area Endpoints ***/
Route::get('areas', 'AreaController@index');