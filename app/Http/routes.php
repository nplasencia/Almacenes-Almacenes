<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication routes...

Route::get ('login', 'Auth\AuthController@getLogin')->name('login');
Route::post('login', 'Auth\AuthController@postLogin');

Route::get ('logout', 'Auth\AuthController@getLogout')->name('logout');

Route::post ('password/email', 'Auth\PasswordController@postEmail')->name('passwordEmail');

Route::get ('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset')->name('passwordReset');

Route::group(['middleware' => 'auth'], function() {

    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('user' , 'UserController@resume')->name('user_profile.resume');
    Route::get('userImage', 'UserController@getProfileImage')->name('user_profile.image');
    Route::post('user', 'UserController@update')->name('user_profile.update');
    
});
