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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login User
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        // setup validation Rules
        $rules = [
            'is_social' => 'required',
        ];
        if($request->is_social){
            $rules = array_merge($rules, [
                'social_email' => 'required|email',
                'social_id' => 'required',
                'social_type' => 'required',
            ]);
        }
        else{ // email or phone based verification
            $rules = array_merge($rules, [
                'password' => 'required|min:6',
            ]);
            if(isset($request->email) && ($request->email != '')){ // email
                $rules = array_merge($rules, [
                    'email' => 'required|email',
                ]);
            }
            else{ // phone
                $rules = array_merge($rules, [
                    'phone_code' => 'required|min:2',
                    'phone_number' => 'required|min:6',
                ]);
            }
        }
        // dd($request->all(), $rules);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // dd($request->all());
        if($request->is_social){
            return $this->socialLogin($request);
        }
        else {
            // get user
            if(isset($request->email) && ($request->email !='')){
                $foundUser = User::where('email', $request->email)->first();
            }
            else{
                $foundUser = User::where('phone_code', $request->phone_code)->where('phone_number', $request->phone_number)->first();
            }
            if(null == $foundUser){
                return sendError('username of Password is incorrect', []);
            }

            // verify hased password
            if (!\Hash::check($request->password, $foundUser->password)) {
                return sendError('username of Password is incorrect', []);
            }

            // determine if user if verifeid or not
            if(isset($request->email) && ($request->email !='')){
                if($foundUser->email_verified_at == null){
                    $response = $this->resendVerificationToken($request)->getData();
                    $data = $response->data;
                    return sendError('New Verification Code sent', $data);
                }
            }
            else{
                if($foundUser->phone_verified_at == null){
                    $response = $this->resendVerificationToken($request)->getData();
                    // dd($response);
                    $data = $response->data;
                    return sendError('New Verification Code sent', $data);
                }
            }

            // login user to application
            Auth::loginUsingId($foundUser->id);
            if(Auth::check()){
                $tokenResult = $foundUser->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();

                $data['access_token'] = $tokenResult->accessToken;
                $data['token_type'] = 'Bearer';
                $data['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
                $data['user'] = User::where('id', $request->user()->id)->first();
                return sendSuccess('Login successfully.', $data);
            }
            else{
                return sendError('Something went wrong while loggin in application', []);
            }
        }
        return sendError('Email or password is incorrect.', null);
    }

    /**
     * Except Social login - other scenarios are done
     *
     * @param Request $request
     * @return void
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_if: is_social,0|string|email',
            'email' => 'required_without:phone_number',
            'email' => 'unique:users',

            'phone_number' => 'required_without:email|unique:users',
            'phone_code' => 'required_without:email', // asically country code

            'password' => 'min:6|required_if:is_social,0',

            'is_social' => 'required|in:1,0',
            'social_id' => 'required_if:is_social,1',
            'social_type' => 'required_if:is_social,1',
            'social_email' => 'required_if:is_social,1',

        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // validate phone number
        if (isset($request->phone_number) && isset($request->phone_code)) {
            $twilio = new TwilioController;
            if (!$twilio->validNumber($request->phone_code . $request->phone_number, $request->phone_code)) {
                return sendError('Phone is invalid', null);
            }
        }

        $code = mt_rand(100000, 999999);

        // determine if user Already Exists of have voilated UNIQUE values
        $existingUser = User::where('email', $request->email)->orWhere('phone_number', $request->phone_number)->first();
        if (null != $existingUser) {
            if ($existingUser->email == $request->email && $existingUser->phone == $request->phone_number) {
                return sendError('User exists already', NULL);
            } else {
                if (isset($request->email) && ($existingUser->email == $request->email)) {
                    return sendError('Email exists already', NULL);
                } else if (isset($request->phone_number) && ($existingUser->phone_number == $request->phone_number)) {
                    return sendError('Phone Number exists already', null);
                }
            }
        }


        try {
            DB::beginTransaction();

            $user = new User;
            $user->uuid = \Str::uuid();

            if ($request->is_social == 1) {
                $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->phone_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            }

            if (isset($request->email))
                $user->email = $request->email;
            if (isset($request->phone_code))
                $user->phone_code = $request->phone_code;
            if (isset($request->phone_number))
                $user->phone_number = $request->phone_number;

            // password for both social media and simple case
            if (isset($request->password)) {
                $user->password = bcrypt($request->password);
            } else {
                if ($request->is_social == 1) {
                    // ignore in case of social media login
                } else {
                    $user->password = bcrypt(bcrypt(mt_rand(100000, 999999)));
                }
            }

            // if its socila media signup
            if ($request->is_social == 1) {
                $user->social_id = $request->social_id;
                $user->social_email = $request->social_email;
                $user->social_type = $request->social_type;
                $user->is_social = $request->is_social;
            }

            if ($user->save()) {
                $user->update(['code' => $code]);
                DB::commit();

                // login or send authorization token
                if ($request->is_social == 1) { // its a social media signup
                    return $this->socialLogin($request);
                } else { // send verification code
                    if(!$this->sendVerificationToken($user, $code, $request)){
                        DB::rollBack();
                        return sendError('Something went wrong while sending Activation Code.', []);
                    }

                    Log::info($code);

                    $data['code'] = $code;
                    return sendSuccess('Successfully created user', $data);
                }
            }
        } catch (\Exception $ex) {
            DB::rollBack();

            $data['exception_error'] = $ex->getMessage();
            return sendError('There is some problem.', $data);
        }

        DB::rollBack();
        return sendError('There is some problem.', null);
    }

    /**
     * Send Activation Code
     *
     * @param \App\models\User $user
     * @param integer $code
     * @param Request $request
     * @return void
     */
    public function sendVerificationToken($user, $code, $request)
    {
        $verificationModel = new SignupVerification();
        if (isset($request->phone_number) && isset($request->phone_code)) {
            $twilio = new TwilioController;
            if (!$twilio->sendMessage($request->phone_code . $request->phone_number, 'Enter this code to verify your Sellx account ' . $code)) {
                return sendError('Somthing went wrong while send Code over phone', NULL);
            }
            $verificationModel->type = 'phone';
            $verificationModel->phone = (strpos($request->phone_number, '+') > -1)? $request->phone_number : $request->phone_code . $request->phone_number;
            $verificationModel->email = null;
        } else {
            Mail::send('email_template.verification_code', ['code' => $code], function ($m) use ($user) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to($user->email)->subject('Verification');
            });
            $verificationModel->type = 'email';
            $verificationModel->email = $request->email;
            $verificationModel->phone = null;
        }
        $verificationModel->token = $code;
        $verificationModel->created_at = date('Y-m-d H:i:s');

        return ($verificationModel->save());
    }

    /**
     * Social Media Login
     *
     * @param Request $request
     * @return void
     */
    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'social_email' => 'required_unless:social_type,apple,facebook,google,twitter|string|email',
            'social_id' => 'required',
            'social_type' => 'required'
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user = null;

        if ($request->social_type == 'apple') {
            $user = User::where('social_id', $request->social_id)->first();
        } else {
            $user = User::where('social_email',  $request->social_email)->where('social_id', $request->social_id)->first();
        }

        $check1 = User::where('social_email',  $request->social_email)->first();
        if (!$user && $check1) {
            return sendError('Email has been registered already with another account.', null);
        }

        $check2 = User::where('social_id', $request->social_id)->first();
        if (!$user && $check2) {
            return sendError('Account has been registered with another email.', null);
        }

        if (!$user) {
            return sendError('not_registered.', null);
        }

        Auth::login($user);
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $data['access_token'] = $tokenResult->accessToken;
        $data['token_type'] = 'Bearer';
        $data['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
        $data['user'] = User::where('id', $request->user()->id)->first();
        return sendSuccess('Login successfully.', $data);
    }

    /**
     * Verify a user with code
     *
     * @param Request $request
     * @return void
     */
    public function verifyUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'activation_code' => 'required',

            'email' => 'required_without:phone_number|email',
            'phone_number' => 'required_without:email',
            'phone_code' => 'required_without:email', // basically country code
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }


        // get user based on email|phone
        if(isset($request->email) && $request->email != ''){
            $user = User::where('email', $request->email)->first();
        }
        else{
            $user = User::where('phone_number', $request->phone_number)->where('phone_code', $request->phone_code)->first();
        }
        if(null == $user){
            return sendError('Invalid or Expired Information Provided', null);
        }

        // get verification code based on email|phone
        if(isset($request->email) && $request->email != ''){
            $veridicationModel = SignupVerification::where('email', $request->email)->where('token', $request->activation_code)->first();
        }
        else{
            $veridicationModel = SignupVerification::where('phone', $request->phone_code . $request->phone_number)->where('token',$request->activation_code)->first();
        }
        if(null == $veridicationModel){
            return sendError('Invalid or Expired Information Provided', null);
        }

        // update user verification fields in db
        $veridicationModel->delete(); // delete verification token
        if(isset($request->email) && $request->email != ''){
            $user->email_verified_at = date('Y-m-d H:i:s');
        }
        else{
            $user->phone_verified_at = date('Y-m-d H:i:s');
        }
        $user->save();
        $data['user'] = $user;
        return sendSuccess('Verified successfully.', $data);
    }

    /**
     * Resend Verification Token
     *
     * @param Request $request
     * @return void
     */
    public function resendVerificationToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone_number|email',
            'phone_number' => 'required_without:email',
            'phone_code' => 'required_without:email', // basically country code
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }


        // get user based on email|phone
        if(isset($request->email) && $request->email != ''){
            $user = User::where('email', $request->email)->first();
        }
        else{
            $user = User::where('phone_number', $request->phone_number)->where('phone_code', $request->phone_code)->first();
        }
        if(null == $user){
            return sendError('Invalid or Expired Information Provided', null);
        }

        // get verification code based on email|phone
        if(isset($request->email) && $request->email != ''){
            $veridicationModel = SignupVerification::where('email', $request->email)->first();
        }
        else{
            $veridicationModel = SignupVerification::where('phone', $request->phone_code . $request->phone_number)->first();
        }

        // create existing verification code and delete old one
        if(null != $veridicationModel){
            $veridicationModel->delete();
        }
        $code = mt_rand(100000, 999999);

        if(!$this->sendVerificationToken($user, $code, $request)){
            return sendError('Something went wrong while sending Activation Code.', []);
        }

        $data['user'] = $user;
        return sendSuccess('Verification Token sent Successfully.', $data);
    }

    /**
     * Send an Email when Password is Forgotton
     *
     * @param Request $request
     * @return void
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone_number|email',
            'phone_number' => 'required_without:email',
            'phone_code' => 'required_without:email', // basically country code
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->email) && $request->email != ''){
            $user = User::where('email', $request->email)->first();
        }
        else{
            $user = User::where('phone_number', $request->phone_number)->where('phone_code', $request->phone_code)->first();
        }

        if(null == $user){
            return sendError('Invalid or Expired Information Provided', null);
        }

        if($user->is_social){
            return sendError('Please update your password at your Social media', null);
        }

        // set password reset token
        $code = mt_rand(100000, 999999);
        $resetCode = PasswordReset::generatePasswordResetToken($request, $code);
        if(!$resetCode){
            return sendError('Somthing went wrong while Creating Reset Password Code', NULL);
        }

        // send token at email|phone number
        if(isset($request->email) && $request->email != ''){
            Mail::send('email_template.forgot_password', ['code' => $code], function ($m) use ($user) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to($user->email)->subject('Verification');
            });
        }
        else{
            $twilio = new TwilioController;
            if (!$twilio->sendMessage($request->phone_code . $request->phone_number, 'Enter this code to verify your Sellx account ' . $code)) {
                return sendError('Somthing went wrong while send Code over phone', NULL);
            }
        }

        return sendSuccess('Reset Token Sent Successfully.', []);
    }

    /**
     * Reset Password
     *
     * @param Request $request
     * @return void
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone_number|email',
            'new_password' => 'required|min:6',
            'code' => 'required',
            'phone_number' => 'required_without:email',
            'phone_code' => 'required_without:email', // basically country code
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->email) && $request->email != ''){
            $user = User::where('email', $request->email)->first();
        }
        else{
            $user = User::where('phone_number', $request->phone_number)->where('phone_code', $request->phone_code)->first();
        }
        if(null == $user){
            return sendError('Invalid or Expired Information Provided', null);
        }
        // dd($request->all());
        // delete password reset toke
        $status = PasswordReset::deleteResetToken($request);
        if($status < 0){
            return sendError('Something went wrong...', []);
        }

        if($status){ // token deleted successfully
            // update user password
            $user->password = bcrypt($request->password);
            if($user->save()){
                return sendSuccess('Password Reset Successfully', []);
            }
            else{
                return sendError('Inetranl Server Error', []);
            }
        }
        else{
            return sendError('Invalid or Expired Token Provided.', []);
        }



    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        // verify hased password
        // dd($request->user());
        $model = User::where('id', $request->user()->id)->first();
        if(null == $model){
            return sendError('Invalid or Expired information provided', []);
        }

        if (!\Hash::check($request->old_password, $model->password)) {
            return sendError('Password is incorrect', []);
        }


        $model->password = bcrypt($request->new_password);
        $data['user'] = $model->save();

        return sendSuccess('Password Reset Successfully', $data);
    }

}
