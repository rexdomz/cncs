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
Route::get('profilesbyarea/{id}/{perpage?}', 'ProfilesController@get_profiles_by_area');

// List single profile
Route::get('profile/{id}', 'ProfilesController@show');

// Create new profile
Route::post('profile', 'ProfilesController@store');

// Update profile
Route::put('profiler', 'ProfilesController@store');

// Delete profile
Route::delete('profile/{id}', 'ProfilesController@destroy');


/***Area Endpoints ***/
//List areas
Route::get('areas', 'AreaController@index');

// List single area
Route::get('area/{id}', 'AreaController@show');

// Create new area
Route::post('area', 'AreaController@store');

// Update area
Route::put('area', 'AreaController@store');

// Delete area
Route::delete('area/{id}', 'AreaController@destroy');


Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact RexDomz'], 404);
});