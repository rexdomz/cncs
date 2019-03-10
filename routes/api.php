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

/*
// List articles
Route::get('articles', 'ArticleController@index');

// List single article
Route::get('article/{id}', 'ArticleController@show');

// Create new article
Route::post('article', 'ArticleController@store');

// Update article
Route::put('article', 'ArticleController@store');

// Delete article
Route::delete('article/{id}', 'ArticleController@destroy');
*/


// List profiles
Route::get('profiles', 'ProfilesController@index');

// List single profile
Route::get('profile/{id}', 'ProfilesController@show');

// Create new profile
Route::post('profile', 'ProfilesController@store');

// Update profile
Route::put('profile', 'ProfilesController@store');

// Delete profile
Route::delete('profile/{id}', 'ProfilesController@destroy');