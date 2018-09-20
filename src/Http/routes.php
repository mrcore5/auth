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

// Laravels routes come from vendor/laravel/framework/src/Illuminate/Routing/Router.php auth() method
Route::group(['prefix' => 'auth'], function () {
    // Laravel override authentication routes
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');

    // Laravel changed to POST logout...ill keep GET for now
    #Route::post('logout', 'Auth\LoginController@logout');
    Route::get('logout', 'Auth\LoginController@logout');
});

Route::group(['prefix' => 'password'], function () {
    // Laravel override password reset routes
    Route::get('reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('reset', 'Auth\ResetPasswordController@reset');
});
