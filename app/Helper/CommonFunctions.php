<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


if(!function_exists('getInternalSuccessResponse')){
    function getInternalSuccessResponse($data = [], $message = 'Success', $code = 200) {
        return ['status' => true, 'message' => $message, 'data' => $data, 'responseCode' => $code];
    }
}

if(!function_exists('getInternalErrorResponse')){
    function getInternalErrorResponse($message = 'error', $data = [], $code = 500) {
        return ['status' => false, 'message' => $message, 'data' => $data, 'responseCode' => $code];
    }
}

if(!function_exists('sendSuccess')){
    function sendSuccess($message, $data) {
    return Response::json(['status' => true, 'message' => $message, 'data' => $data], 200);
    }
}

if(!function_exists('sendError')){
    function sendError($message, $data) {
        return Response::json(['status' => false, 'message' => $message, 'data' => $data], 200);
    }
}

if(!function_exists('print_array')){
    function print_array($arr, $exit = false)
    {
        echo '<pre>';
            print_r($arr);
        echo '</pre>';

        if($exit){
            exit;
        }
    }
}

/**
 * check if phone number is valid or not
 */
if(!function_exists('isPhoneValid')){
    function isPhoneValid($phone_code, $phone_number)
    {
        $twilio = new \App\Http\Controllers\TwilioController();
        if (!$twilio->validNumber($phone_code . $phone_number, $phone_code)) {
            return false;
        }
        return true;
    }
}

/**
 * Define the notification types || Needs to Update according to Sellx
 */
if( !function_exists('listNotficationTypes') ){
    function listNotficationTypes(){
        return [
            'feedback_sent' => 'feedback_sent' // feedback and support send by user.
            , 'went_live' => 'went_live' // Auctioneer Started Live Auction it’ll send notification to all users.
            , 'created_lot' => 'created_lot' // If Lot is created it’ll send notification to all users.
            , 'won_a_lot' => 'won_a_lot' // If user won a lot it’ll send notification to that specific user.
            , 'posted_a_status_update' => 'posted_a_status_update' // If auctioneer or user go live or post the status.
            , 'refund_requested' => 'refund_requested' // If user request for refund it will send notification to admin
            , 'followed_an_auctioneer' => 'followed_an_auctioneer' // if user follow to any auctioneer. the notification send to the auctioneer that this user started following you.
            , 'rated_an_auctioneer' => 'rated_an_auctioneer' // if user send review/rating to the auctioneer. notification will send to that auctioneer that you have received ratings/review.
            , 'updated_access_rights_setting' => 'updated_access_rights_setting' // If auctioneer change access settings of user to “auction support” or “Auctioneer”. it will send notification to that user.
            , 'added_scheduled_auction' => 'added_scheduled_auction' // if auctioneer added schedule auction.
            , 'removed_scheduled_auction' => 'removed_scheduled_auction' // if auctioneer remove any schedule auction from the auction list
            , 'bought_product' => 'bought_product' // when user buy the product a notification should send to auction House that this user has bought this product.
            , 'completed_payment' => 'completed_payment' // Notification for payment completed
            , 'shipped_product' => 'shipped_product' // Notification for if product is shipped.
            , 'request_aution_house_approval' => 'request_aution_house_approval' // If auction House is approved from the Admin a notification should be get to auctioneer so auctioneer profile must be updated.
            , 'approved_aution_house' => 'approved_aution_house' // If auction House is approved from the Admin a notification should be get to auctioneer so auctioneer profile must be updated.

            , 'message_receive' =>'message_receive'
            , 'post_like' => 'post_like'
            , 'post_comment' => 'post_comment'
            , 'post' => 'post'
            , 'new_item_in_category' => 'new_item_in_category'
            , 'product' => 'product'
            , 'saved_item_price_decreased' => 'saved_item_price_decreased'
            , 'saved_item_price_increased' => 'saved_item_price_increased'
            , 'referral_request' => 'referral_request'
            , 'event_online' => 'purchased_ticket_event_online'
            , 'is_order_pending' => 'order_pending'
            , 'is_order_accepted' => 'order_accepted'
            , 'is_order_rejected' => 'order_rejected'
            , 'is_order_delivered' => 'order_delivered'
            , 'is_order_shipped' => 'order_shipped'
            , 'is_purchased_ticket' => 'buy_ticket'
            , 'is_make_donation' => 'make_donation'
            , 'product_like' => 'product_like'
            , 'is_account_connect' => 'account_connect'
            , 'is_follow' => 'follow'
        ];
    }
}

if( !function_exists('get_locale_datetime') ){
    /**
     * Get dateTime Timezone of Guest User hitting the application
     *
     * @param String $utc_datetime
     * @param String $targetFormat
     *
     * @return void
     */
    function get_locale_datetime($utc_datetime, $givenIp, $targetFormat = 'Y-m-d H:i:s')
    {
        $tz = get_local_timezone($givenIp);
        $dateString = Carbon::create($utc_datetime)->timezone($tz)->format($targetFormat);

        return $dateString;
    }
}


if( !function_exists('get_local_timezone') ){
    function get_local_timezone($givenIp)
    {
        if($givenIp == '127.0.0.1' || $givenIp == '::1'){
            $ip = "119.73.121.52";
        }else{
            $ip = $givenIp;
        }

        $tz = \Session::get('timezone') ?? '';
        if($tz == ''){
            $url = 'http://ip-api.com/json/'.$ip;
            $tz = file_get_contents($url);
            $tz = json_decode($tz,true)['timezone'];

            \Session::put('timezone', $tz);
        }
        return $tz;
    }
}

if( !function_exists('get_utc_datetime')){
    /**
     * Get DateTime in UTC against given user locale
     *
     * @param String $local_datetime
     * @param ip $givenIp
     * @param String $targetFormat
     *
     * @return String Converted DateTime in UTC
     */
    function get_utc_datetime($local_datetime, $givenIp, $targetFormat = 'Y-m-d H:i:s'){
        $locale_tz = get_local_timezone($givenIp);
        $tz_to = 'UTC';

        $dt = new \DateTime($local_datetime, new \DateTimeZone($locale_tz));
        $dt->setTimeZone(new \DateTimeZone($tz_to));
        $utc_datetime = $dt->format($targetFormat);

        return $utc_datetime;
    }

    
}
