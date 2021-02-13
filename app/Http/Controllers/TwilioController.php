<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Twilio\Rest\Client;


class TwilioController extends Controller
{
	private $client;

	function __construct(){
       	
       	$this->client = new Client(config('app.TWILIO_ACCOUNT_SID'), config('app.TWILIO_AUTH_TOKEN'));
    }

    public function sendMessage($number, $code){

    	try {
    		$apiResponse = $this->client->messages->create(
		  		$number, // Text this number
		  		[
		    		'from' => (int)'+17147092151', // From a valid Twilio number (babar.kodextech@gmail.com)
		    		'body' => $code
		  		]
			);
			return $apiResponse;

    	} catch (Exception $e) {
    		return sendError($e->getMessage(), []);
    	}




    }

    public function validNumber($number, $countrycode){

    	try {
    		$apiResponse = $this->client->lookups->v1->phoneNumbers($request->number)->fetch(["countryCode" => $request->countrycode]);
    		return $apiResponse;
    	
    	} catch (Exception $e) {
    		return sendError($e->getMessage(), []);
    	}
    }

}