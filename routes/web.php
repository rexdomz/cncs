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

Route::get('/registration', 'HomeController@index')->name('home');

Route::get('/reports-all-accounts', 'HomeController@index')->name('home');

Route::get('/reports-weekly', 'HomeController@index')->name('home');

Route::get('/payment', 'HomeController@index')->name('home');
