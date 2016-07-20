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

// Ajax
Route::group(['middleware' => 'auth'], function() {
    Route::get ('ajax/centers', 'CenterController@ajaxResume')->name('center.ajaxResume');
    Route::get ('ajax/stores', 'StoreController@ajaxResume')->name('store.ajaxResume');
	Route::get ('ajax/articles', 'PalletArticleController@ajaxResume')->name('palletArticle.ajaxResume');
});

// Centers
Route::group(['middleware' => 'auth'], function() {

    Route::get('centers', 'CenterController@resume')->name('center.resume');

    Route::get ('newCenter', 'CenterController@create')->name('center.create');
    Route::post('newCenter', 'CenterController@store')->name('center.store');

    Route::post('centerChange', 'CenterController@change')->name('center.change');

    Route::get ('center/{id}', 'CenterController@details')->name('center.details');
    Route::post('center/{id}', 'CenterController@update')->name('center.update');

    Route::get ('centerDelete/{id}', 'CenterController@delete')->name('center.delete');
    Route::delete('centerDelete/{id}', 'CenterController@delete')->name('center.delete');

	Route::get ('centerEmptySpace', 'CenterController@seeEmptySpace')->name('center.emptySpace');

});

// Stores
Route::group(['middleware' => 'auth'], function() {

    Route::get('stores', 'StoreController@resume')->name('store.resume');

    Route::get ('newStore', 'StoreController@create')->name('store.create');
    Route::post('newStore', 'StoreController@store')->name('store.store');

    Route::get ('store/{id}', 'StoreController@details')->name('store.details');
    Route::post('store/{id}', 'StoreController@update')->name('store.update');

    Route::get ('storeDelete/{id}', 'StoreController@delete')->name('store.delete');
    Route::delete('storeDelete/{id}', 'StoreController@delete')->name('store.delete');

    Route::get ('store/{id}/usedSpace', 'StoreController@seeUsedSpace')->name('store.usedSpace');
    Route::get ('store/{id}/emptySpace', 'StoreController@seeEmptySpace')->name('store.emptySpace');

});

// PalletArticles
Route::group(['middleware' => 'auth'], function() {

	Route::get('articles', 'PalletArticleController@resume')->name('palletArticle.resume');
});