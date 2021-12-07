<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Card;
use App\Models\User;
use App\Models\Address;
use App\Models\Profile;
use App\Models\Reviews;
use App\Models\Defaulter;
use App\Models\Followers;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\AuctionProduct;
use Illuminate\Support\Carbon;
use App\Models\SignupVerification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\StripePaymentController;

class UserController extends Controller
{

    /**
     * Swicth Active Profile
     *
     * @param Request $request
     * @return void
     */

    private $stripe;
    private $transfer_obj;

    function __construct(StripePaymentController $StripePaymentController){
        $this->stripe = new \Stripe\StripeClient(
            config('app.stripe_secret_key')
        );

        \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));

        $this->transfer = new \Stripe\Transfer();

        $this->StripePaymentController = $StripePaymentController;
    }

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
            'user_uuid'    => 'required',
            'first_name'   => 'string|min:3',
            'last_name'    => 'string',
            'username'     => 'string',
            'country'      => 'string',
            'dob'          => 'date',
            'gender'       => 'in:male,female',
            'profile_type' => 'in:buyer,auctioneer',
            'bio'          => 'string',
            'description'  => 'string',
            'profile_image' => 'string',
            'auction_house_logo' => 'string',
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
        if(isset($request->username)){
            $foundModel = Profile::where('username', $request->username)->where('id', '!=', $user->active_profile_id)->first();
            if(null != $foundModel){
                if($foundModel->id != $user->active_profile_id){ // email belongs to some another user
                    return sendError('Username Already Exists', NULL);
                }
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
        $model_auction = Profile::where('uuid', $request->following_uuid)->first();
        if(NULL != $model_auction)
            if($model_auction->user_id == $model->user_id)
                return sendError('Cant Follow Your own Auction House',[]);

        if($profile_uuid == $request->following_uuid)
           return sendError('Cant Follow Your own profile',[]);

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

    /**
     * Get All Users
     *
     * @param Request $request
     * @return void
     */
    public function getAllUsers(Request $request)
    {
        $users = User::latest()->with('profiles')->get();

        return sendSuccess('Success', $users);
    }

    public function updateCard(Request $request){


        {



            // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // $stripe_card = $this->stripe->paymentMethods->create([
            //         'type' => 'card',
            //         'card' => [
            //             'number' => $request->card_no,
            //             'exp_month' => $request->exp_month,
            //             'exp_year' => $request->exp_year,
            //             'cvc' => $request->cvc,
            //         ],
            //     ]);


            // // $data['PaymentIntent'] = \Stripe\PaymentIntent::create([
            // //     'amount' => 1099,
            // //     'currency' => 'usd',
            // //     'payment_method_types' => ['card'],
            // // ]);

            //     // return $stripe_card->id;

            // $data['charge']  = \Stripe\Charge::create ([
            //         "amount" => 100,
            //         "currency" => "usd",
            //         "source" => $stripe_card->id,
            //         "description" => "Test payment from itsolutionstuff.com."
            // ]);

            // return $data;

            // $stripe = new \Stripe\StripeClient(
            //     env('STRIPE_SECRET')
            //   );
            //   $data['account'] = $stripe->accounts->create([
            //     'country' => 'US',
            //     'type' => 'express',
            //   ]);

            //   $data['account_links'] = \Stripe\AccountLink::create([
            //     'account'     => $data['account']->id,
            //     'refresh_url' => 'https://example.com/reauth',
            //     'return_url'  => 'https://example.com/return',
            //     'type'        => 'account_onboarding',
            //   ]);

            //   $data['payment_intent'] = \Stripe\PaymentIntent::create([
            //     'payment_method_types' => ['card'],
            //     'amount' => 1000,
            //     'currency' => 'eur',
            //     'application_fee_amount' => 123,
            //   ], ['stripe_account' => $data['account']->id]);

            //   return $data;

            // \Stripe\Stripe::setApiKey('sk_test_51HycB2C7XjW69rGhuL6bXwL5flAeCpJ0JTaINUmAtg0rkaz2YvWK7neYeLZXr3QGujYCokGVhckGs5rCcb8OboEj00AXGxqdpm');


            // \Stripe\Stripe::setApiKey('sk_test_51HycB2C7XjW69rGhuL6bXwL5flAeCpJ0JTaINUmAtg0rkaz2YvWK7neYeLZXr3QGujYCokGVhckGs5rCcb8OboEj00AXGxqdpm');

            // $account = \Stripe\Account::create([
            //     'type' => 'standard',
            // ]);
            // return $account;
            // Create a PaymentIntent:
            // $data['paymentIntent'] = \Stripe\PaymentIntent::create([
            //     'amount' => 100,
            //     'currency' => 'usd',
            //     'payment_method_types' => ['card'],
            //     'transfer_group' => '{ORDER10}',
            // ]);

            // $data['account'] = \Stripe\Account::create([
            //     'type' => 'custom',
            //     'country' => 'US',
            // ]);

            // $data['account_links'] = \Stripe\AccountLink::create([
            //     'account' => 'acct_1032D82eZvKYlo2C',
            //     'refresh_url' => 'https://example.com/reauth',
            //     'return_url' => 'https://example.com/return',
            //     'type' => 'account_onboarding',
            //   ]);

            // return $data;
            // // Create a Transfer to a connected account (later):
            // $data['transfer'] = \Stripe\Transfer::create([
            //     'amount'         => 7000,
            //     'currency'       => 'eur',
            //     'destination'    => '{{CONNECTED_STRIPE_ACCOUNT_ID}}',
            //     'transfer_group' => '{ORDER10}',
            // ]);


            // // Create a second Transfer to another connected account (later):
            // $data['transfer'] = \Stripe\Transfer::create([
            // 'amount' => 2000,
            // 'currency' => 'eur',
            // 'destination' => '{{OTHER_CONNECTED_STRIPE_ACCOUNT_ID}}',
            // 'transfer_group' => '{ORDER10}',
            // ]);


            // return $data;




            // $card = Card::where('profile_id',Auth::User()->profile->id)->first();

            // // if(null == $card){
            //     $card = new Card();
            //     $card->uuid = \Str::uuid();
            //     $card->profile_id = $request->User()->profile->id;

            //     try {
                    // $stripe_card = $this->stripe->paymentMethods->create([
                    //     'type' => 'card',
                    //     'card' => [
                    //         'number' => $request->card_no,
                    //         'exp_month' => $request->exp_month,
                    //         'exp_year' => $request->exp_year,
                    //         'cvc' => $request->cvc,
                    //     ],
                    // ]);

            //     }catch (\Exception $e){
            //         Log::info($e->getMessage());
            //         return sendError($e->getMessage(), null);
            //     }

            //     if(isset($stripe_card->id));
            //         $card->card_stripe_id = $stripe_card->id;
            // // }

            // if(isset($request->card_holder_name))
            //     $card->card_holder_name = $request->card_holder_name;

            // if(isset($request->card_no))
            //     $card->card_no = $request->card_no;

            // if(isset($request->exp_month))
            //     $card->exp_month = $request->exp_month;

            // if(isset($request->exp_year))
            //     $card->exp_year = $request->exp_year;

            // if(isset($request->cvc))
            //     $card->cvc = $request->cvc;

            // $card->is_default = true;

            // $card->save();


            // return sendSuccess('Card Added',$card);
        }
    }

    public function updateBank(Request $request){

        $bank = Bank::where('profile_id',Auth::User()->profile->id)->first();
        if(null == $bank){
            $bank = new Bank();
            $bank->uuid = \Str::uuid();
        }

        $bank->profile_id = Auth::User()->profile->id;

        if(isset($request->account_title))
            $bank->title = $request->account_title;

        if(isset($request->bank_name))
            $bank->bank_name = $request->bank_name;

        if(isset($request->account_no))
            $bank->iban = $request->account_no;

        if(isset($request->swift_code))
            $bank->swift_code = $request->swift_code;

        if(isset($request->branch_code))
            $bank->branch_code = $request->branch_code;

        $bank->save();

        return sendSuccess('Bank Added',$bank);
    }

    public function addDeposit(Request $request){

        $validator = Validator::make($request->all(), [
            'deposit_cash' => 'required|numeric|min:0',
            'profile_uuid' => 'exists:profiles,uuid',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid',$request->profile_uuid)->first() ?? Auth::User()->profile;



        $request->merge([
            'charges' => $request->deposit_cash,
        ]);

        $charge  = $this->StripePaymentController->stripeCharge($request)->getData();
        if(!$charge->status){
            return sendError('internal server Error',$charge->data);
        }

        $defaulter = Defaulter::where('profile_id',$profile->id)->first();

        $profile->deposit += $request->deposit_cash;
        if($profile->deposit > 15000)
            $profile->max_bid_limit = $profile->deposit*(($defaulter->penalty_percentage ?? 2)/100);
        else
            $profile->max_bid_limit = 15000;


        $profile->save();

        return sendSuccess('Deposit Added',$profile);
    }

    public function isDefault(Request $request){
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'exists:profiles,uuid|required',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid',$request->profile_uuid)->first();

        $defaulter = Defaulter::where('profile_id',$profile->id)->first();

        if(null == $defaulter)
            return sendSuccess('not defaulter',[]);

        return sendSuccess('Defaulter',$defaulter);
    }
}
