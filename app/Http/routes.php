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

    Route::get('user' , 'UserProfileController@resume')->name('user_profile.resume');
    Route::get('userImage', 'UserProfileController@getProfileImage')->name('user_profile.image');
    Route::post('user', 'UserProfileController@update')->name('user_profile.update');

	Route::post('changePassword', 'UserProfileController@changePassword')->name('user_profile.changePassword');

	Route::get ('centerEmptySpace', 'CenterController@seeEmptySpace')->name('center.emptySpace');
    
});

// Ajax
Route::group(['middleware' => 'auth'], function() {
    Route::get ('ajax/centers',  'CenterController@ajaxResume')->name('center.ajaxResume');
    Route::get ('ajax/stores',   'StoreController@ajaxResume')->name('store.ajaxResume');
	Route::get ('ajax/articles', 'PalletArticleController@ajaxResume')->name('palletArticle.ajaxResume');
	Route::get ('ajax/users',    'UserController@ajaxResume')->name('user.ajaxResume');
});

// Users
Route::group(['middleware' => 'auth', 'admin'], function() {

	Route::get('users', 'UserController@resume')->name('users.resume');

	Route::get ('newUser', 'UserController@create')->name('user.create');
	Route::post('newUser', 'UserController@store')->name('user.store');

	Route::get ('users/{id}', 'UserController@details')->name('user.details');
	Route::post('users/{id}', 'UserController@update')->name('user.update');

	Route::get ('userDelete/{id}', 'UserController@delete')->name('user.delete');
	Route::delete('userDelete/{id}', 'UserController@delete')->name('user.delete');

});

// Centers
Route::group( [ 'middleware' => 'auth', 'superAdmin' ], function () {

	Route::get( 'centers', 'CenterController@resume' )->name( 'center.resume' );

	Route::get( 'newCenter', 'CenterController@create' )->name( 'center.create' );
	Route::post( 'newCenter', 'CenterController@store' )->name( 'center.store' );

	Route::post( 'centerChange', 'CenterController@change' )->name( 'center.change' );

	Route::get( 'center/{id}', 'CenterController@details' )->name( 'center.details' );
	Route::post( 'center/{id}', 'CenterController@update' )->name( 'center.update' );

	Route::get( 'centerDelete/{id}', 'CenterController@delete' )->name( 'center.delete' );
	Route::delete( 'centerDelete/{id}', 'CenterController@delete' )->name( 'center.delete' );

} );

// Stores
Route::group(['middleware' => 'auth'], function() {

	Route::group(['middleware' => 'auth', 'admin'], function() {

		Route::get ('newStore', 'StoreController@create')->name('store.create');
		Route::post('newStore', 'StoreController@store')->name('store.store');

		Route::get ('store/{id}', 'StoreController@details')->name('store.details');
		Route::post('store/{id}', 'StoreController@update')->name('store.update');

		Route::get ('storeDelete/{id}', 'StoreController@delete')->name('store.delete');
		Route::delete('storeDelete/{id}', 'StoreController@delete')->name('store.delete');

	});

    Route::get('stores', 'StoreController@resume')->name('store.resume');

    Route::get ('store/{id}/usedSpace', 'StoreController@seeUsedSpace')->name('store.usedSpace');
    Route::get ('store/{id}/emptySpace', 'StoreController@seeEmptySpace')->name('store.emptySpace');

});

// StorePallets
Route::group(['middleware' => 'auth'], function() {

	Route::get( 'storePallets/{id}/{location}', 'PalletController@resume' )->name( 'storePallets.resume' );

	Route::group(['middleware' => ['auth', 'advancedUser']], function() {

		Route::post('palletTransfer/{id}', 'PalletController@transfer')->name('storePallets.transfer');

		Route::get('palletLocations/{id}', 'PalletController@getPalletLocationsByStore')->name('storePallet.palletLocations');
		Route::post('palletLocations/{id}', 'PalletController@getPalletLocationsByStore')->name('storePallet.palletLocations');
	});

});

// PalletArticles
Route::group(['middleware' => 'auth'], function() {

	Route::get('articles', 'PalletArticleController@resume')->name('palletArticle.resume');

	Route::get ('article/{id}', 'PalletArticleController@details')->name('palletArticle.details');

	Route::group(['middleware' => 'auth', 'advancedUser'], function() {

		Route::post( 'articleTransfer/{id}', 'PalletArticleController@articleTransfer' )->name( 'palletArticle.transfer' );

		Route::get( 'articleDelete/{id}', 'PalletArticleController@delete' )->name( 'palletArticle.delete' );
		Route::delete( 'articleDelete/{id}', 'PalletArticleController@delete' )->name( 'palletArticle.delete' );

	});

	//AJAX
	Route::post('articleLocations/{id}', 'PalletArticleController@getArticleLocationsByStore')->name('palletArticle.articleLocations');
});

// NewArticles
Route::group(['middleware' => 'auth', 'advancedUser'], function() {

	Route::get ('articlesNew/addPallet', 'ArticlesNewController@newPallet')->name('articlesNew.addPallet');
	Route::post('articlesNew/addPallet', 'ArticlesNewController@storeNewPallet')->name('articlesNew.storeNewPallet');

	Route::get('articlesNew/pallet/{id}/addArticles', 'ArticlesNewController@toAddArticlesView')->name('articlesNew.addArticlesToPallet');
	Route::post('articlesNew/pallet/{id}/addArticles', 'ArticlesNewController@addArticlesToPallet')->name('articlesNew.storeArticlesToPallet');

	Route::get('articlesNew/palletArticle/delete/{id}', 'ArticlesNewController@deletePalletArticle')->name('articlesNew.deletePalletArticle');

	//AJAX
	Route::post('articlesNew/ajax/{lot}', 'ArticlesNewController@getNewArticlesByLot')->name('articlesNew.newArticles');

});