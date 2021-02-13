<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

function sendSuccess($message, $data) {
    return Response::json(['status' => true, 'message' => $message, 'data' => $data], 200);
}

function sendError($message, $data) {
    return Response::json(['status' => false, 'message' => $message, 'data' => $data], 200);
}