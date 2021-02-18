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
 * Define the notification types || Update according to Sellx
 */
if( !function_exists('listNotficationTypes') ){
    function listNotficationTypes(){
        return [
            'message_receive' =>'message_receive'
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

