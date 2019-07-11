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

Route::get('/', function () {
    return view('home');
}); 

Auth::routes();

Route::prefix('admin')->group(function() {

    //Route::get('/', 'AdminController@index');

    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/dashboard', 'AdminController@index');

    Route::get('/', 'AdminController@index')->name('admin.home');
    Route::get('/registration', 'AdminController@register')->name('admin.registration');
    Route::get('/registered-users', 'AdminController@registered_users')->name('admin.registered-users');
    Route::get('/user-payment', 'AdminController@payment')->name('admin.user-payment');
    Route::get('/quota', 'AdminController@collector')->name('admin.quota');
    Route::get('/area', 'AdminController@area')->name('admin.area');

    /* Release */
    Route::get('/release', 'AdminController@release')->name('release');

    //Print
    Route::get('/payment-view/{id}', 'PrintController@printPreview');
    Route::get('/qouta-view/{id}/{collector}', 'PrintController@printQouta');

});

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user-payment', 'HomeController@collection_sales')->name('collection-sales');
Route::get('/quota', 'HomeController@collector')->name('quota');

//Print
Route::get('/payment-view/{id}', 'PrintController@printPreview');
Route::get('/qouta-view/{id}/{collector}', 'PrintController@printQouta');