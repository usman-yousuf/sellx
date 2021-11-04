<?php

namespace App\Http\Controllers;

use App\Services\VesiCash\VesiCashService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaystackController extends Controller
{
    /**
     * Simply Pay without creating an account at paystack using bank/card etc
     *
     * @param Request $request
     * @return void
     */
  public function charge(Request $request)
  {
  	$url = "https://api.paystack.co/charge";
  	
  	$fields = [
    	'email' => $request->email,
    	'amount' => $request->amount,
    	"metadata" => [
      		"custom_fields" => [
        		[
          			"value" => $request->value,
          			"display_name" => $request->display_name,
          			"variable_name" => $request->variable_name
        		]
      		]
    	],
    
    	"bank" => [
        		"code" => $request->code,
        		"account_number" => $request->account_number
    		],
    	"birthday" => $request->birthday
	];

 	$fields_string = http_build_query($fields);
 
	//open connection
  	$ch = curl_init();
  
  	//set the url, number of POST vars, POST data
  	curl_setopt($ch,CURLOPT_URL, $url);
  	curl_setopt($ch,CURLOPT_POST, true);
  	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    	"Authorization: Bearer sk_test_3714f328fa46093895c771f2044bc1ea8ae6798a",
    	"Cache-Control: no-cache",
  	));
  
  	//So that curl_exec returns the contents of the cURL; rather than echoing it
  	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
  
  	//execute post
  	$result = curl_exec($ch);
  	echo $result;
  }

  public function submitOTP(Request $request){
  	$url = "https://api.paystack.co/charge/submit_otp";
		$fields = [
  		'otp' => $request->otp,
  		'reference' => $request->reference
		];
		$fields_string = http_build_query($fields);
		
		//open connection
		$ch = curl_init();

  	//set the url, number of POST vars, POST data
  	curl_setopt($ch,CURLOPT_URL, $url);
  	curl_setopt($ch,CURLOPT_POST, true);
  	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  		"Authorization: Bearer sk_test_3714f328fa46093895c771f2044bc1ea8ae6798a",
  		"Cache-Control: no-cache",
		));

		//So that curl_exec returns the contents of the cURL; rather than echoing it
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

		//execute post
		$result = curl_exec($ch);
		echo $result;
  }

  public function verifyAccNumber(Request $request){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".$request->account_number."&bank_code=".$request->bank_code."",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer sk_test_3714f328fa46093895c771f2044bc1ea8ae6798a",
        "Cache-Control: no-cache",
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
  
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
  }

  public function listOfBanks(Request $request){
    $curl = curl_init();
  
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/bank",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer sk_test_3714f328fa46093895c771f2044bc1ea8ae6798a",
        "Cache-Control: no-cache",
      ),
    ));
  
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
  }

  public function transferRecipient(Request $request){
    $url = "https://api.paystack.co/transferrecipient";
    
    $fields = [
      'type' => $request->type,
      'name' => $request->name,
      'account_number' => $request->account_number,
      'bank_code' => $request->bank_code,
      'currency' => $request->currency
    ];

    $fields_string = http_build_query($fields);
    
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer sk_test_3714f328fa46093895c771f2044bc1ea8ae6798a",
      "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    echo $result;
  }

  public function transfer(Request $request){
    $url = "https://api.paystack.co/transfer";
    
    $fields = [
      'source' => $request->source,
      'amount' => $request->amount,
      'recipient' => $request->recipient,
      'reason' => $request->reason
    ];

    $fields_string = http_build_query($fields);
    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer sk_test_3714f328fa46093895c771f2044bc1ea8ae6798a",
      "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    echo $result;
  }

}