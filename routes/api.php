<?php

use App\Http\Controllers\AuctionController;
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

Route::post('get_cities', 'App\Http\Controllers\NoAuthController@getCities');
Route::post('get_countries', 'App\Http\Controllers\NoAuthController@getCountries');
Route::post('get_languages', 'App\Http\Controllers\NoAuthController@getLanguages');
Route::post('get_constants', 'App\Http\Controllers\NoAuthController@getConstants');
Route::post('get_categories', 'App\Http\Controllers\NoAuthController@getCategories');
Route::post('get_currencies', 'App\Http\Controllers\NoAuthController@getCurrencies');
Route::post('get_initial_data', 'App\Http\Controllers\NoAuthController@getInitialData');


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
    Route::post('become_auctioneer', 'App\Http\Controllers\UserController@becomeAuctioneer');

    // ADDRESS
    Route::post('get_profile_addresses', 'App\Http\Controllers\AddressController@getProfileAddresses');
    Route::post('update_address', 'App\Http\Controllers\AddressController@updateAddress');
    Route::post('mark_address_default', 'App\Http\Controllers\AddressController@markDefault');
    Route::post('delete_address', 'App\Http\Controllers\AddressController@deleteAddress');

    // Feedbacks
    Route::post('send_feedback', 'App\Http\Controllers\UserController@sendFeedback');

    // Reviews
    Route::post('send_review', 'App\Http\Controllers\UserController@sendReviews');
    Route::post('get_reviews', 'App\Http\Controllers\UserController@getReviews');

    //FOLLOW-UNFOLLOW

    Route::post('follow_unfollow', 'App\Http\Controllers\UserController@followUnfollow');
    Route::post('followings', 'App\Http\Controllers\UserController@getUserFollowings');
    Route::post('followers', 'App\Http\Controllers\UserController@getUserFollowers');

    // Notification
    Route::post('update_notification_setting', 'App\Http\Controllers\NotificationController@updateNotificationSetting');
    Route::post('get_notifications', 'App\Http\Controllers\NotificationController@getNotifications');
    Route::post('get_notification_permissions', 'App\Http\Controllers\NotificationController@getNotificationsPermission');
    Route::post('get_unread_notification_counts', 'App\Http\Controllers\NotificationController@getUnreadNotificationsCount');

    // Localisation
    Route::post('update_localisation_setting', 'App\Http\Controllers\LocalisationController@updateLocalisationSetting');
    Route::post('get_localisation_setting', 'App\Http\Controllers\LocalisationController@getLocalisationSetting');

    Route::post('validate_bank', 'App\Http\Controllers\RefundController@validateIBAN');
    Route::post('refund_request', 'App\Http\Controllers\RefundController@refundRequest');
    Route::post('get_refund_history', 'App\Http\Controllers\RefundController@getRefundHistory');

    //PRODUCTS
    Route::post('get_products', 'App\Http\Controllers\ProductController@getProducts');
    Route::post('update_product', 'App\Http\Controllers\ProductController@updateProduct');
    Route::post('delete_product', 'App\Http\Controllers\ProductController@deleteProduct');


    // Auctions
    Route::post('get_auctions', [AuctionController::class, 'getAuctions']);
    Route::post('delete_auction', [AuctionController::class, 'deleteAuction']);
    Route::post('update_auction', [AuctionController::class, 'updateAuction']);



});
