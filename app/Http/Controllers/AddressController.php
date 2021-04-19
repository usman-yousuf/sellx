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
        $uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
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
            'profile_uuid' => 'required|string',
            'address_name' => 'required|string|min:3',
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

            'is_default' => 'required|in:1,0',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // validate profile
        $profile = Profile::where('uuid', $request->profile_uuid)->first();
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }

        if (isset($request->phone_number) && isset($request->phone_code)) {
            if(!isPhoneValid($request->phone_code, $request->phone_number)){
                return sendError('Invalid Phone Number Provided', []);
            }
        }

        $address = Address::addUpdateAddress($request, $profile->id);
        if(!$address['status']){
            return sendError($address['message'], []);
        }
        $data['address'] = $address['data'];
        return sendSuccess('Address Saved Successfully', $data);
    }

    public function markDefault(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|string',
            'address_uuid' => 'required|string',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid', $request->profile_uuid)->first();
        if (null == $profile) {
            return sendError('Invalid or Expired information provided', []);
        }

        $address = Address::where('uuid', $request->address_uuid)->first();
        if (null == $address) {
            return sendError('Invalid or Expired information provided', []);
        }

        Address::where('profile_id', $profile->id)->update(['is_default' => false]); // make all address normal
        $address->update(['is_default' => true]);

        $data['address'] = $address;
        return sendSuccess('Marked as Default Successfully', $data);
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
            'address_uuid' => 'required|string',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $address = Address::where('uuid', $request->address_uuid)->first();
        if(null == $address){
            return sendError('Invalid or Expired information provided', []);
        }
        $address->delete();
        return sendSuccess('Address Deleted Successfully', []);
    }
}
