<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Profile;
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

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required_without:phone_number|string|email',
            'phone_code' => 'required_without:email',
            'phone_number' => 'required_without:email',
            'password' => 'required_without:social_email',
            'socail_email' => 'required_without:email',
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $credentials = $request->only('email', 'password');
        $check = getUser()->where('email', $request->email)->first();
        if($check && ($check->email_verified_at == null || $check->email_verified_at == '')){
            $code = mt_rand(1000, 9999);
            Log::info($code);
            Mail::send('email_template.verification_code', ['code' => $code], function ($m) use ($check) {
                $m->from(config('mail.from.address'), config('mail.from.name'));
                $m->to($check->email)->subject('Verification');
            });
            $data['code'] = $code;
            return sendError('not_verified', $data);
        }
        if(Auth::attempt($credentials)){
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();
            Profile::where('id', $user->profile_id)->update(['is_online' => true]);

            $data['access_token'] = $tokenResult->accessToken;
            $data['token_type'] = 'Bearer';
            $data['expires_at'] = Carbon::parse($tokenResult->token->expires_at)->toDateTimeString();
            $data['user'] = getUser()->where('id', $request->user()->id)->first();
            return sendSuccess('Login successfully.', $data);
        }
        return sendError('Email or password is incorrect.', null);
    }

    public function signup(Request $request){
        $validator = Validator::make($request->all(), [
            'is_social' => 'required|in:1,0',
            'phone_number' => 'required_without:email|unique:users',
            'phone_code' => 'required_if: phone_number,!=, null',
            'email' => 'required_if: is_social,0|string|email|unique:users',
            'email' => 'required_without:phone_number',
            'password' => 'required_if:is_social,0',
            'social_id' => 'required_if:is_social,1',
            'social_type' => 'required_if:is_social,1',
            'social_email' => 'required_if:is_social,1',

        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->phone_number) && isset($request->phone_code)){
            $twilio = new TwilioController;
            if(!$twilio->validNumber($request->phone_code . $request->phone_number, $request->phone_code)) {
                return sendError('Phone is invalid', null);
            }
        }

        $code = mt_rand(1000, 9999);
        $check = User::where('email', $request->email)->orWhere('phone_number', $request->phone_number)->first();

        if($check){

            if($check->email == $request->email && $check->phone_number == $request->phone_number) {
                return sendError('User exists already', NULL);
            }
            if($check->email == $request->email) {
                return sendError('Email exists already', NULL);
            }
            if($check->phone_number == $request->phone_number){
                return sendError('Phone exists already', null);
            }
        }

        try {
            DB::beginTransaction();

            $user = new User;
            
            if($request->is_social == 1){
                $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                $user->phone_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            }

            if(isset($request->email))
                $user->email = $request->email;
            if(isset($request->phone_code))
                $user->phone_code = $request->phone_code;
            if(isset($request->phone_number))
                $user->phone_number = $request->phone_number;
            if(isset($request->password))
                $user->password = bcrypt($request->password);
            else{
                if($request->is_social == 1){
                    // ignore in case of social media login
                }
                else{
                    $user->password = bcrypt(bcrypt(mt_rand(100000, 999999)));
                }

            }

            if($request->is_social == 1){
                $user->social_id = $request->social_id;
                $user->social_email = $request->social_email;
                $user->social_type = $request->social_type;
            }

            if($user->save()) {
  
                DB::commit();

                if($request->is_social == 1){
                    return $this->socialLogin($request);

                }else{
                    if(isset($request->phone_number) && isset($request->phone_code)){
                        if(!$twilio->sendMessage($request->phone_code . $request->phone_number, 'Enter this code to verify your Sellx account ' . $code)) {
                            return sendError('Phone is invalid', NULL);
                        }
                    }
                    else{
                        Mail::send('email_template.verification_code', ['code' => $code], function ($m) use ($user) {
                            $m->from(config('mail.from.address'), config('mail.from.name'));
                            $m->to($user->email)->subject('Verification');
                        });
                    }
                    Log::info($code);

                    $data[ 'code' ] = $code;
                    return sendSuccess('Successfully created user', $data);
                }
            }
        }catch (\Exception $ex){
            DB::rollBack();
            $data['exception_error'] = $ex->getMessage();
            return sendError('There is some problem.', $data);
        }

        DB::rollBack();
        return sendError('There is some problem.', null);
    }

    public function socialLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'social_email' =>'required_unless:social_type,apple,facebook,google,twitter|string|email',
            'social_id' => 'required',
            'social_type' => 'required'
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user = null;

        if($request->social_type == 'apple'){
            $user = User::where('social_id', $request->social_id)->first();
        }else{
            $user = User::where('social_email',  $request->social_email)->where('social_id', $request->social_id)->first();
        }

        $check1 = User::where('social_email',  $request->social_email)->first();
        if(!$user && $check1){
            return sendError('Email has been registered already with another account.', null);
        }

        $check2 = User::where('social_id', $request->social_id)->first();
        if(!$user && $check2){
            return sendError('Account has been registered with another email.', null);
        }

        if(!$user){
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
        $data['user'] = getUser()->where('id', $request->user()->id)->first();
        return sendSuccess('Login successfully.', $data);

    }


}
