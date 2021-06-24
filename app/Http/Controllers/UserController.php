<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\AuctionProduct;
use App\Models\Followers;
use App\Models\PasswordReset;
use App\Models\Profile;
use App\Models\Reviews;
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
     * Swicth Active Profile
     *
     * @param Request $request
     * @return void
     */
    public function switchProfile(Request $request)
    {
        $user = $request->user();
        $current_profile_id = $request->user()->active_profile_id;

        $switch_profile = Profile::where('user_id', $user->id)->where('id', '<>', $current_profile_id)->get();
        // dd($switch_profile->count());
        if ($switch_profile->count()) {
            $switch_profile_id = $switch_profile[0]->id;
            $user->active_profile_id = $switch_profile_id;

            if ($user->save()) {

                $current_user = User::where('id', $user->id)->with('profile')->first();
                $request->user()->active_profile_id = $switch_profile_id;
                $request->user()->save();

                $data['profile'] = Profile::where('id', $switch_profile_id)->with('user')->first();

                return sendSuccess('Profile Switched successfully.', $data);
            }

            return sendError('There is some problem, Please Try Again.', null);
        }
        return sendError('User Profile to switch does not exist.', null);
    }

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
        $user = User::where('uuid', $uuid)->with('profile', 'profiles')->first();
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
        $uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : null;
        if(null == $uuid){

            $uuid = (null != $request->user()->profile)? $request->user()->profile->uuid : null;

            if(null == $uuid){
                return sendError('No Profile Found Against this user', []);
            }
        }
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
            'screen_type' => 'required|in:phone,email,username,names,image,bid_limit',
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
        else if($request->screen_type == 'bid_limit'){
            $rules = array_merge($rules, [
                'max_bid_limit' => 'required',
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

        // valdate user model info
        if( ($request->screen_type == 'phone') || ($request->screen_type == 'email') ){
            // determine if phone|email does not belong to anothr user
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

            // send verification token
            $authCtrlObj = new AuthController();
            $code = mt_rand(100000, 999999);
            $authCtrlObj->sendVerificationToken($profile->user, $code, $request); // send verification email
            $profile = Profile::where('id', $profile->id)->with('user', 'defaultAddress')->first();
            $data['code'] = $code;
            $data['profile'] = $profile;
            return sendSuccess('Profile Updated Successfully.', $data);
        }
        else{
            // validate profile modal info
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
            // 'profile_image' => 'required',
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
            if($foundModel->id != $user->active_profile_id){ // email belongs to some another user
                return sendError('Username Already Exists', NULL);
            }
        }

        // validate profile if given
        $updateResult = Profile::addUpdateModel($request, $user->id);
        if(!$updateResult){
            return sendError('Something went wrong while updating Profile', []);
        }
        $data['access_token'] = (str_replace('Bearer ', '', $request->header('Authorization')));
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
        $profile_uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;

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

    /**
     * Create|update an Auctioneer
     *
     * @param Request $request
     * @return void
     */
    public function becomeAuctioneer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required',
            'auction_house_name' => 'required',
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

        DB::beginTransaction();
        $result = profile::addUpdateAuctioneer($request);
        if(!$result['status']){
            dd($result);
            DB::rollBack();
            return sendError('Something went wrong while becoming Auctioneer', []);
        }
        DB::commit();
        $data['access_token'] = (str_replace('Bearer ', '', $request->header('Authorization')));
        $data['profile'] = $result['data'];
        return sendSuccess('Auctioneer Created Successfully', $data);
    }

    public function sendReviews(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'sender_profile_uuid' => 'required|exists:profiles,uuid',
            'receiver_profile_uuid' => 'required|exists:profiles,uuid',
            'auction_product_uuid' => 'required|exists:auction_products,uuid',
            'message' => 'required',
            'rating' => 'required'
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $sender_profile_uuid = (isset($request->sender_profile_uuid) && ($request->sender_profile_uuid != ''))? $request->sender_profile_uuid : $request->user()->profile->uuid;

        $senderModel = Profile::where('uuid', $sender_profile_uuid)->first();
        $receiverModel = Profile::where('uuid', $request->receiver_profile_uuid)->first();
        $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();

        if($senderModel == null || $receiverModel == null){
            return sendError('Invalid Information Provided', []);
        }

        DB::beginTransaction();

        $model = new Reviews();

        $model->uuid = \Str::uuid();
        $model->sender_profile_id =  $senderModel->id;
        $model->receiver_profile_id = $receiverModel->id;
        $model->auction_product_id = $auction_product->id;
        $model->message = $request->message;
        $model->rating = $request->rating;

        if($model->save()){
            DB::commit();

            $data['review'] = $model;
            return sendSuccess('Review Send Successfully', $data);
        }

        DB::rollBack();
        return sendError('There is something wrong.', []);

    }

    public function getAuctionHouse(Request $request){
        $validator = Validator::make($request->all(), [
            'keywords' => 'string'
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $AuctionHouse = Profile::where('auction_house_name', '<>', '')->where('profile_type', 'auctioneer');
        if(isset($request->keywords))
            $AuctionHouse->where('auction_house_name', 'LIKE', "%{$request->keywords}%");
        

        $cloned_auction_houses = clone $AuctionHouse;
        $data['AuctionHouse'] = $AuctionHouse;
        $data['AuctionHouse'] = $data['AuctionHouse']->get();
        $data['Total_AuctionHouse'] = $cloned_auction_houses->count();
        
        if($data['Total_AuctionHouse'] > 0){
            return sendSuccess('Search found.', $data);
        }
        return sendError('Search not found.', null);

    }

    public function getReviews(Request $request){
        $validator = Validator::make($request->all(), [
            // 'profile_uuid' => 'required|exists:profiles,uuid'
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile_uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;

        $model = Profile::where('uuid', $profile_uuid)->first();

        $reviews = Reviews::where('receiver_profile_id', $model->id)->get();

        if($reviews == null){
            return sendSuccess('No reviews found.', null);
        }

        $data['reviews'] = $reviews;
        return sendSuccess('Reviews Found.', $data);

    }

    public function followUnfollow(Request $request){
        $validator = Validator::make($request->all(),[
            'following_uuid' => 'required|exists:profiles,uuid'
        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile_uuid = (isset($request->profile_uuid) && ($request->profile_uuid != ''))? $request->profile_uuid : $request->user()->profile->uuid;
        $model = Profile::where('uuid', $profile_uuid)->first();

        $following_model = Profile::where('uuid', $request->following_uuid)->first();

        $check = Followers::where('following_id', $following_model->id)->where('profile_id', $model->id)->first();

        if($check){

            $check->forceDelete();

            return sendSuccess('Unfollow successfully.', 0);
        }

        DB::beginTransaction();

        $follow = new Followers;
        $follow->uuid = \Str::uuid();
        $follow->profile_id = $model->id;
        $follow->following_id = $following_model->id;
        $follow->status = true;

        if($follow->save()) {

            DB::commit();

            return sendSuccess('Follow successfully.', 1);
        }
        DB::rollBack();
        return sendError('There is some problem.', null);
    }

    /**
     * Get User Followings
     *
     * @param Request $request
     * @return void
     */
    public function getUserFollowings(Request $request)
    {
        $profile_uuid = ($request->profile_uuid) ? $request->profile_uuid : $request->user()->profile->uuid;

        $profile = Profile::where('uuid', $profile_uuid)->first();

        $models = Followers::where('following_id', $profile->id)->with('following');

        $cloned_models = clone $models;

        if(isset($request->offset) && isset($request->limit)){
            $models = $models->offset($request->offset)->limit($request->limit);
        }
        $data['followings'] = $models->get();
        $data['total'] = $cloned_models->count();

        return sendSuccess('Success', $data);
    }

    /**
     * Get User Followings
     *
     * @param Request $request
     * @return void
     */
    public function getUserFollowers(Request $request)
    {
        $profile_uuid = ($request->profile_uuid) ? $request->profile_uuid : $request->user()->profile->uuid;

        $profile = Profile::where('uuid', $profile_uuid)->first();

        $models = Followers::where('profile_id', $profile->id)->with('follower');

        $cloned_models = clone $models;
        if(isset($request->offset) && isset($request->limit)){
            $models->offset($request->offset)->limit($request->limit);
        }

        $data['followers'] = $models->get();
        $data['total'] = $cloned_models->count();

        return sendSuccess('Success', $data);
    }

}
