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

class UserController extends Controller
{
    /**
     * Get User Details
     *
     * @param Request $request
     * @return void
     */
    public function getUser(Request $request)
    {
        // dd($request->user()->uuid);
        $uuid = (isset($request->user_uuid) && ($request->user_uuid != ''))? $request->user_uuid : $request->user()->uuid;
        $user = User::where('uuid', $uuid)->with('activeProfile', 'profiles')->first();
        if(null == $user){
            return sendError('Invalid or Expired information provided', []);
        }
        $data['user'] = $user;
        return sendSuccess('Success', $data);
    }

    /**
     * Get Profile Details
     *
     * @param Request $request
     * @return void
     */
    public function getProfile(Request $request)
    {
        $uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->activeProfile->uuid;
        $profile = Profile::where('uuid', $uuid)->with('user', 'defaultAddress')->first();
        if(null == $profile){
            return sendError('Invalid or Expired information provided', []);
        }
        $data['profile'] = $profile;
        return sendSuccess('Success', $data);
    }

    /**
     * Update Profile Chunks
     *
     * @param Request $request
     * @return void
     */
    public function updateProfileChunks(Request $request)
    {
        $rules = [
            'screen_type' => 'required|in:phone,email,username,names,image',
            'profile_uuid' => 'required',
        ];

        if($request->screen_type == 'phone'){
            $rules = array_merge($rules, [
                'phone_number' => 'required',
                'phone_code' => 'required',
            ]);
        }
        else if($request->screen_type == 'email'){
            $rules = array_merge($rules, [
                'email' => 'required|email',
            ]);
        }
        else if($request->screen_type == 'username'){
            $rules = array_merge($rules, [
                'username' => 'required|unique:profiles,username,' . $request->id,
            ]);
        }
        else if($request->screen_type == 'names'){
            $rules = array_merge($rules, [
                'first_name' => 'required|min:3',
                'last_name' => 'string',
            ]);
        }
        else if($request->screen_type == 'image'){
            $rules = array_merge($rules, [
                'profile_image' => 'required|string',
            ]);
        }

        // validate given chunk
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        $profile_uuid = $request->profile_uuid;

        // determine if profile exists
        $profile = Profile::where('uuid', $profile_uuid)->first();
        if(null == $profile){
            return sendError('Invalid or Expired Information Provided', []);
        }

        if( ($request->screen_type == 'phone') || ($request->screen_type == 'email') ){
            if($request->screen_type == 'phone'){
                $foundUser = User::where('phone_number', $request->phone_number)->where('phone_code', $request->phone_code)->first();
                if(null != $foundUser){
                    if($foundUser->active_profile_id != $profile->id){ // phone belongs to some another user
                        return sendError('Phone Already Exists', NULL);
                    }
                }
                // // validate given phone number
                $code = mt_rand(100000, 999999);
                $twilio = new TwilioController;
                    if (!$twilio->sendMessage($request->phone_code . $request->phone_number, 'Enter this code to verify your Sellx account ' . $code)) {
                    return sendError('Somthing went wrong while send Code over phone', NULL);
                }
            }
            else if($request->screen_type == 'email'){
                $foundUser = User::where('email', $request->email)->first();
                if(null != $foundUser){
                    if($foundUser->active_profile_id != $profile->id){ // email belongs to some another user
                        return sendError('Email Already Exists', NULL);
                    }
                }
            }

            // update user chunk
            $chunkUpdateResult = User::updateUserChunks($request, $profile->user->uuid);
            if(!$chunkUpdateResult){
                return sendError('Something went wrong while updating Profile', []);
            }
            // resemd verification token
            $authCtrlObj = new AuthController();
            $code = mt_rand(100000, 999999);
            $authCtrlObj->sendVerificationToken($profile->user, $code, $request); // send verification email
            $profile = Profile::where('id', $chunkUpdateResult->active_profile_id)->with('user', 'defaultAddress')->first();
            $data['profile'] = $profile;
            return sendSuccess('Profile Updated Successfully.', $data);
        }
        else{
            if($request->screen_type == 'username'){
                $foundUser = Profile::where('username', $request->username)->first();
                if(null != $foundUser){
                    if($foundUser->profile_id != $profile->id){ // email belongs to some another user
                        return sendError('Username Already Exists', NULL);
                    }
                }
            }

            // update user chunk
            $chunkUpdateResult = Profile::updateProfileChunks($request, $profile->uuid);
            if(!$chunkUpdateResult){
                return sendError('Something went wrong while updating Profile', []);
            }
            $data['profile'] = $chunkUpdateResult;
            return sendSuccess('Profile Updated Successfully.', $data);
        }
    }

    /**
     * Create|update a Profile
     *
     * @param Request $request
     * @return void
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_uuid' => 'required',
            'first_name' => 'required|min:3',
            'last_name' => 'string',
            'username' => 'required',
            'country' => 'required',
            'dob' => 'required',
            'gender' => 'required|in:male,female',
            'profile_type' => 'required|in:buyer,auctionar',
            'profile_image' => 'required',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        $user_uuid = (isset($request->user_uuid) && ($request->user_uuid != ''))? $request->user_uuid : $request->user()->uuid;

        // determine if user exists
        $user = User::where('uuid', $user_uuid)->first();
        if(null == $user){
            return sendError('Invalid or Expired Information Provided', []);
        }

        $foundModel = Profile::where('username', $request->username)->first();
        if(null != $foundModel){
            if($foundModel->user_id != $user->id){ // email belongs to some another user
                return sendError('Username Already Exists', NULL);
            }
        }

        // validate profile if given
        $updateResult = Profile::addUpdateModel($request, $user->id);
        if(!$updateResult){
            return sendError('Something went wrong while updating Profile', []);
        }
        $data['profile'] = $updateResult;
        return sendSuccess('Profile Updated Successfully.', $data);
    }

    public function sendFeedback(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'message' => 'required|min:20',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        $profile_uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->activeProfile->uuid;

        $profile = Profile::where('uuid', $profile_uuid)->first();

        try {
            Mail::send('email_template.feedback', ['email' => $request->email, 'name' => $profile->first_name, 'message_body' => $request->message], function ($m) use ($profile) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to(config('mail.from.address'))->subject('Feedback');
            });

            // Live server - For later use
            // Mail::send('email_template.feedback', ['email' => $request->email, 'name' => $profile->first_name, 'message_body' => $request->message], function ($m) use ($request, $profile) {
            //     $m->from($request->email, $profile->first_name.$profile->last_name);
            //     $m->to(config('mail.from.address'))->subject('Feedback');
            // });

            return sendSuccess('Feedback Sent Successfully.', null);
        } catch (Exception $e) {

                $data['exception_error'] = $e->getMessage();
                return sendError('There is some problem.', $data);
            }
    }

    public function becomeAuctioneer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required',
            'name' => 'required',
            'attachments' => 'required|string|min:5', // comma seperated attachments URLs
            'product_categories' => 'required', // categories
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        $profile_uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;

        $foundModel = Profile::where('uuid', $profile_uuid)->first();
        if(null == $foundModel){
            return sendError('Invalid Information Provided', []);
        }

        $result = profile::addUpdateAuctioneer($request);
        if(!$result['status']){
            return sendError('Something went wrong while becoming Auctioneer', []);
        }
        $data['profile'] = $result['data'];
        return sendSuccess('Auctioneer Created Successfully', $data);
    }
}
