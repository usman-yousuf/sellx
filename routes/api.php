<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BiddingController;
use App\Http\Controllers\BuyerRequestController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SoldController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ViewerController;
use App\Http\Controllers\BlockController;
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
    Route::post('switch_profile', 'App\Http\Controllers\UserController@switchProfile');
    Route::post('get_auction_house', 'App\Http\Controllers\UserController@getAuctionHouse');


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
    Route::post('test_product', 'App\Http\Controllers\ProductController@test');


    // Auctions
    Route::post('get_auctions', [AuctionController::class, 'getAuctions']);
    Route::post('delete_auction', [AuctionController::class, 'deleteAuction']);
    Route::post('delete_auction_product', [AuctionController::class, 'deleteAuctionProduct']);
    Route::post('update_auction', [AuctionController::class, 'updateAuction']);
    Route::post('go_online', [AuctionController::class, 'toggleLiveAuction']);
    Route::post('back_to_list', [AuctionController::class, 'backToList']);
    Route::post('get_live_auction', [AuctionController::class, 'get_live_auction']);
    Route::post('update_auction_status', [AuctionController::class, 'updateAuctionStatus']);
    Route::post('update_auction_status', [AuctionController::class, 'updateAuctionStatus']);
    Route::post('update_time', [AuctionController::class, 'update_time']);
    Route::post('update_access', [AuctionController::class, 'update_access']);
    Route::post('update_auction_setting', [AuctionController::class, 'update_auction_setting']);
    Route::post('update_auction_product_fix_price', [AuctionController::class, 'update_auction_product_fix_price']);

    // Watchlist
    Route::post('add_to_watchlist', [AuctionController::class, 'AddToWatchlist']);
    Route::post('remove_from_watchlist', [AuctionController::class, 'RemoveFromWatchlist']);
    Route::post('get_watchlist', [AuctionController::class, 'getWatchlist']);

    Route::post('get_dummy_auctions', [AuctionController::class, 'getDummyAuctions']);
    Route::post('update_dummy_auctions', [AuctionController::class, 'updateDummyAuction']);
    Route::post('delete_dummy_auction', [AuctionController::class, 'deleteDummyAuction']);

    //bidding
    Route::post('get_bidding', [BiddingController::class, 'get_bidding']);
    Route::post('bidding', [BiddingController::class, 'bidding']);
    Route::post('user_bids', [BiddingController::class, 'user_bids']);

    //complain
    Route::post('get_complain', [BuyerRequestController::class, 'get_complain']);
    Route::post('update_complain', [BuyerRequestController::class, 'update_complain']);

    //sold
    Route::post('get_sold', [SoldController::class, 'get_sold']);
    Route::post('update_sold', [SoldController::class, 'update_sold']);

    //comment
    Route::post('get_comment', [CommentController::class, 'get_comment']);
    Route::post('update_comment', [CommentController::class, 'update_comment']);
    Route::post('delete_comment', [CommentController::class, 'delete_comment']);

    //viewers
    Route::post('get_viewer', [ViewerController::class, 'get_viewer']);
    Route::post('update_viewer', [ViewerController::class, 'update_viewer']);

    //Story
    Route::post('get_story', [StoryController::class, 'get_story']);
    Route::post('update_story', [StoryController::class, 'update_story']);
    Route::post('delete_story', [StoryController::class, 'delete_story']);

    //Block
    Route::post('get_block', [BlockController::class, 'get_block']);
    Route::post('update_block', [BlockController::class, 'update_block']);
    Route::post('delete_block', [BlockController::class, 'delete_block']);

    /**
     * Chat Route
     */
    Route::post('create_chat', 'App\Http\Controllers\ChatsController@createChat');
    Route::post('get_chat_messages', 'App\Http\Controllers\ChatsController@getChatMessages');
//    Route::post('get_chat_media', 'App\Http\Controllers\ChatsController@getChatMedia');
    Route::post('send_message', 'App\Http\Controllers\ChatsController@sendMessage');
    Route::post('get_chats', 'App\Http\Controllers\ChatsController@getChats');
    Route::post('delete_chat', 'App\Http\Controllers\ChatsController@deleteChat');
    Route::post('delete_message', 'App\Http\Controllers\ChatsController@deleteMessage');
    Route::post('chat_new_users', 'App\Http\Controllers\ChatsController@getNewUsers');
    Route::post('get_existing_chat', 'App\Http\Controllers\ChatsController@getExistingChat');

});
