<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PasswordReset;
use App\Models\Profile;
use App\Models\SignupVerification;
use App\Models\User;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RefundController extends Controller
{
	public function validateIBAN(Request $request)
    {
    	$validator = Validator::make($request->all(), [
            'iban' => 'required',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $curl = curl_init();
 
		$post = [
		    'format'  => 'json',
		    'api_key' => '[YOUR_API_KEY]',
		    'iban'    => $request->iban,
		];
		 
		curl_setopt_array($curl, array(
		    CURLOPT_URL            => 'https://api.iban.com/clients/api/v4/iban/',
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_POSTFIELDS     => $post
		));
		 
		$output = curl_exec($curl);
		$result = json_decode($output);
		 
		$data['response'] = $result;
		 
		curl_close($curl);

		return $data;
	}

	public function getRefundHistory(Request $request){
		$uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
        $profile = Profile::where('uuid', $uuid)->first();
        
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }
        
        $data['refunds'] = Refund::where('profile_id', $profile->id)->orderBy('created_at', 'desc')->get();
        
        return sendSuccess('Success', $data);
	}

	public function refundRequest(Request $request){
		$validator = Validator::make($request->all(), [
            'refund_amount'  => 'required',
            'name'           => 'required',
            'iban'           => 'required',
            'swift_code'     => 'required',
            'branch_code'    => 'required',
            'branch_address' => 'required',
            'city'           => 'required',
            'country'        => 'required',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

		$uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
        $profile = Profile::where('uuid', $uuid)->first();
        
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }
        
        $refund                 = new Refund();
        $refund->uuid           = \Str::uuid();
        $refund->profile_id     = $profile->id;
        $refund->refund_amount  = $request->refund_amount;
        $refund->name           = $request->name;
        $refund->iban           = $request->iban;
        $refund->swift_code     = $request->swift_code;
        $refund->branch_code    = $request->branch_code;
        $refund->branch_address = $request->branch_address;
        $refund->country        = $request->country;
        $refund->city           = $request->city;

        if($refund->save()){
        	$data['refund'] = Refund::where('id', $refund->id)->first();

        	return sendSuccess('Refund Successfully Requested.', $data);
        }
        return sendError('There is something wrong, please try again.', null);
        
	}

    // for admin controller
    public function getAdminRefundHistory( Request $request){
		$uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
        $profile = Profile::where('uuid', $uuid)->first();
        
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }
        
        // $data = Refund::where('profile_id', $profile->id)->orderBy('created_at', 'desc')->get();
        $data = Refund::orderBy('created_at', 'desc')->get();


        return view('admin.refund_cancelation.refund.index', ['data'=>$data]);
        // return sendSuccess('Success', $data);
	}

    public function refundEdit(Request $request, $uuid){
        $refund_data = Refund::where('uuid', $uuid)->first();
        $profile = Profile::where('id',$refund_data->profile_id)->first();
        
        return view('admin.refund_cancelation.refund.edit_refund', ['refund_data'=> $refund_data, 'profile' => $profile]);
	}

    public function refundUpdate(Request $request, $uuid){
        $update_refund = Refund::where('uuid', $uuid)->first();
        
        $profile = Profile::where('id',$update_refund->profile_id)->first();
        
        if(isset($request->refund_user_name))
            $profile->username = $request->refund_user_name;
            $profile->save();

        if(isset($request->refund_date))
            $update_refund->created_at = $request->refund_date;

        if(isset($request->refund_amount))
            $update_refund->refund_amount = $request->refund_amount;

        if(isset($request->account_holder))
            $update_refund->name = $request->account_holder;

        if(isset($request->iban_number))
            $update_refund->iban = $request->iban_number;

        if(isset($request->branch_address))
            $update_refund->branch_address = $request->branch_address;

        if(isset($request->branch_code))
            $update_refund->branch_code = $request->branch_code;

        $update_refund->save();
        return redirect()->route('admin.refund.list');
            
    }
    // All refund detail
    public function refundDetail(Request $request, $uuid){

        $refund_data = Refund::where('uuid', $uuid)->first();
        $profile = Profile::where('id',$refund_data->profile_id)->first();

		return view('admin.refund_cancelation.refund.view_refund_details', ['refund_data'=> $refund_data, 'profile'=> $profile]);
	}

    public function refundDelete(Request $request, $uuid){

        $refund_data = Refund::where('uuid', $uuid)->first();
        $profile = Profile::where('id',$refund_data->profile_id)->first();

        if($refund_data->delete() && $profile->delete()){

            return redirect()->route('admin.refund.list');
        }
    }

}