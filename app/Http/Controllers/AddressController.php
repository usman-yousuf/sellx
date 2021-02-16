<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\PasswordReset;
use App\Models\Profile;
use App\Models\SignupVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Get Profile Addresses
     *
     * @param Request $request
     * @return void
     */
    public function getProfileAddresses(Request $request)
    {
        $uuid = (isset($request->profile_id) && ($request->profile_id != ''))? $request->profile_id : $request->user()->activeProfile->uuid;
        $profile = Profile::where('uuid', $uuid)->with('user')->first();
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }
        $data['addresses'] = $profile->addresses;
        return sendSuccess('Success', $data);
    }

    /**
     * Update Address
     *
     * @param Request $request
     * @return void
     */
    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_id' => 'required|string',

            'reciever_name' => 'required|string|min:3',
            'phone_code' => 'required|min:2', // basically country code
            'phone_number' => 'required|string|min:6',

            'address1' => 'required',
            'address2' => 'string',
            'zip' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',

            'default' => 'required|in:1,0',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // validate profile
        $profile = Profile::where('uuid', $request->profile_id)->first();
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }

        if (isset($request->phone_number) && isset($request->phone_code)) {
            if(!isPhoneValid($request->phone_code, $request->phone_number)){
                return sendError('Invalid Phone Number Provided', []);
            }
        }
        // dd($profile->id);
        $address = Address::addUpdateAddress($request, $profile->id);
        if(!$address['status']){
            return sendError($address['message'], []);
        }
        $data['address'] = $address['data'];
        return sendError('Address Saved Successfully', $data);
    }

    /**
     * Delete an Address
     *
     * @param Request $request
     *
     * @return void
     */
    public function deleteAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|string',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $address = Address::where('uuid', $request->address_id)->first();
        if(null == $address){
            return sendError('Invalid or Expired information provided', []);
        }
        $address->delete();
        return sendError('Address Deleted Successfully', []);
    }
}
