<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


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
