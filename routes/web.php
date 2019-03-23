<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('home');
}); */

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/registration', 'HomeController@register')->name('registration');

Route::get('/registered-users', 'HomeController@registered_users')->name('regusers');

Route::get('/payment', 'HomeController@payment')->name('payment');

Route::get('/quota', 'HomeController@collector')->name('collector');

Route::get('/area', 'HomeController@area')->name('areas');
