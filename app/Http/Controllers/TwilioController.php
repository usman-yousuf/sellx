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
   //  		$apiResponse = $this->client->messages->create(
		 //  		$number, // Text this number
		 //  		[
		 //    		'from' => (int)'+17147092151', // From a valid Twilio number (babar.kodextech@gmail.com)
		 //    		'body' => $code
		 //  		]
			// );   
              $apiResponse = $this->client->messages->create(
                 $number, // Text this number
                 [
                 'from' => (int)'+19567071448', // From a valid Twilio number (aleem.kodextech@gmail.com)
                 'body' => $code
                 ]
            );
			return $apiResponse;

    	} catch (Exception $e) {
    		return sendError($e->getMessage(), []);
    	}




    }

    /**
     * Valiate Phone Number
     *
     * @param integer $number
     * @param integer $countrycode
     *
     * @return void
     */
    public function validNumber($number, $countrycode){
    	try {
    		$apiResponse = $this->client->lookups->v1->phoneNumbers($number)->fetch(["countryCode" => $countrycode]);
    		return $apiResponse;

    	} catch (\Exception $e) {
    		return sendError($e->getMessage(), []);
    	}
    }

}
