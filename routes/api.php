<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('send_message', 'App\Http\Controllers\TwilioController@sendMessage');
Route::post('valid_number', 'App\Http\Controllers\TwilioController@validNumber');
Route::get('no-auth', 'App\Http\Controllers\AuthController@noAuth')->name('noAuth');

Route::group([ 'prefix' => 'auth'], function () {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('signup', 'App\Http\Controllers\AuthController@signup');
    Route::post('social_login', 'App\Http\Controllers\AuthController@socialLogin');

    Route::post('verify_user', 'App\Http\Controllers\AuthController@verifyUser');
    Route::post('resend_activation_token', 'App\Http\Controllers\AuthController@resendVerificationToken');
    Route::post('forgot_password', 'App\Http\Controllers\AuthController@forgotPassword');
    Route::post('reset_password', 'App\Http\Controllers\AuthController@resetPassword');

    Route::group([ 'middleware' => 'auth:api'], function() {
        Route::post('logout', 'App\Http\Controllers\AuthController@logout');
        // Route::post('change_social_password', 'App\Http\Controllers\AuthController@changeSocialLoginPassword');

        Route::post('update_password', 'App\Http\Controllers\AuthController@updatePassword');
    });

});


Route::group(['middleware' => 'auth:api'], function() {
    Route::post('get_user', 'App\Http\Controllers\UserController@getUser');
    Route::post('get_profile', 'App\Http\Controllers\UserController@getProfile');
    Route::post('update_profile', 'App\Http\Controllers\UserController@updateProfile');
    Route::post('update_profile_chunks', 'App\Http\Controllers\UserController@updateProfileChunks');
});
