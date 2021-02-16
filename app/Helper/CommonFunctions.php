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
