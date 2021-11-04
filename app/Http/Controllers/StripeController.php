<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Card;
use Illuminate\Support\Carbon;
use Stripe\Account;

class StripeController extends Controller
{
    /**
     * @var \Stripe\StripeClient
     */
    private $stripe;
    private $transfer_obj;

    function __construct(){
        $this->stripe = new \Stripe\StripeClient(
            config('app.stripe_secret_key')
        );

        \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));

        $this->transfer = new \Stripe\Transfer();
    }

    public function createCutomerCard(Request $request){

        try {
            $stripe_card = $this->stripe->paymentMethods->create([
                'type' => 'card',
                'card' => [
                    'number' => $request->number,
                    'exp_month' => $request->exp_month,
                    'exp_year' => $request->exp_year,
                    'cvc' => $request->cvc,
                ],
            ]);

        }catch (\Exception $e){
            Log::info($e->getMessage());
            return sendError($e->getMessage(), null);
        }

        $_bool = filter_var($request->is_default, FILTER_VALIDATE_BOOLEAN);
        $request->merge([ 'is_default' => $_bool ]);
        $request->merge([ 'card_stripe_id' => $stripe_card->id ]);
        $validator = Validator::make($request->all(), [
            'card_holder_name' => 'required',
            'card_stripe_id' => 'required',
            'is_default' => 'required',
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        $user_id = ($request->user_id) ? $request->user_id : Auth::id();
        $user = User::find($user_id);

        try{
            // $user->addPaymentMethod($request->card_stripe_id);

        }catch (\Exception $e){
            Log::info($e->getMessage());
            return sendError($e->getMessage(), null);
        }

        // $saved_cards = $user->paymentMethods();
        $check_duplicate = false;
        $current_card = null;
        // foreach($saved_cards as $index=>$c){
        //     if($current_card == null){
        //         if($c->id == $request->card_stripe_id){
        //             $current_card = $c;
        //         }
        //     }else{
        //         if($c->card->fingerprint == $current_card->card->fingerprint){
        //             $check_duplicate = true;
        //             $current_card = $c;
        //             break;
        //         }
        //     }
        // }
        $is_default = $request->is_default;
        if($is_default){
            Card::where('user_id', $user_id)->update(['is_default'=> false]);
        }else{
            $check = Card::where('user_id', $user_id)->where('is_default', true)->first();
            if(!$check){
                $is_default = true;
            }
        }
        if($check_duplicate){
            $paymentMethod = $user->findPaymentMethod($request->card_stripe_id);
            $paymentMethod->delete();
            return sendError('Card already exists.', null);
        }else{
            $card = new Card;
            $card->user_id = $user_id;
            $card->card_holder_name = $request->card_holder_name;
            $card->stripe_id = $current_card->id;
            $card->brand = $current_card->card->brand;
            $card->last4 = $current_card->card->last4;
            $card->exp_month = $current_card->card->exp_month;
            $card->exp_year = $current_card->card->exp_year;
            $card->country = $current_card->card->country;
            $card->is_default = $is_default;
            $card->save();
            $data = ['card' => $card];
            return sendSuccess('Card added successfully.', $data);
        }


    }

    function refund($user_id, $payment_id, $amount){
        $refund = $this->stripe->refunds->create([
            'payment_intent' => $payment_id,
            'amount' => $amount * 100,
        ]);
        if($refund->status == 'succeeded')
            return true;
        return false;

    }


    function transfer($amount, $destination, $chargeID){
        try {
            $transfer = $this->transfer->create([
                "amount" => $amount,
                "currency" => "usd",
                "source_transaction" => $chargeID,
                "destination" => $destination
            ]);
            Log::info($transfer);
            return true;
        }catch (\Exception $e){
            Log::info($e->getMessage());
            return false;
        }
    }

    /**
     * Transfer money from my(api) account to someone else
     *
     * @param Integer $amount
     * @param String $destination
     *
     * @return void
     */
    function payout($amount, $destination)
    {
        try {
            $transfer = $this->transfer->create([
                "amount" => $amount,
                "currency" => "usd",
                "destination" => $destination
            ]);
            // dd($transfer->id);
            Log::info($transfer);
            return $transfer->id;
        } catch (\Exception $e) {
            // dd($e);
            Log::info($e->getMessage());
            return false;
        }
    }

    function getBalance($acc_id){
        try {
            \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));

            $balance = \Stripe\Balance::retrieve(
                ['stripe_account' => $acc_id]
            );
            Log::info($balance);

            return ['status'=>true, 'data' => $balance];
        }catch (\Exception $e){
            Log::info($e->getMessage());
            return ['status'=>false, 'data' => null];
        }
    }

    function stripeConnectUrl(Request $request){
        $data['redirect_url'] = route('stripe.url');
        $data['connect_url'] = "https://connect.stripe.com/express/oauth/authorize?redirect_uri=".route('stripe.url')."&client_id=".config('app.stripe_client_id')."&scope=read_write&state=".bcrypt('123456');
        return sendSuccess('Url generated successfully.', $data);
    }

    function stripeRedirect(Request $request) {
        return sendSuccess('Success', null);
        /*Log::info($request->all());
        $code = $request->code;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://connect.stripe.com/oauth/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
            'client_secret' => config('app.stripe_secret_key'),
            'code' => $code,
            'grant_type' => 'authorization_code',
        )));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = json_decode(curl_exec($ch));
        curl_close($ch);
        //$account = Account::retrieve($server_output->stripe_user_id);
        //$url = $account->login_links->create();
        Log::info($server_output);*/

        /*$user = Auth::user();
        $user->stripe_payout_account_id = $server_output->stripe_user_id;
        $user->stripe_express_dashboard_url = $url->url;
        $user->is_bank_account_verified = 1;
        $user->save();*/
        /*Session::flash('success', 'Connected Successfully');
        return Redirect::to('edit_profile#paymentdetail');*/
    }



    function stripeRedirectUri(Request $request) {

        // dd( Session::has('redirect_page'));
        try {
            $code = $request->code;
            $response = $this->stripe->oauth->token([
                'grant_type' => 'authorization_code',
                'code' => $code,
            ]);
            $account = $this->stripe->accounts->retrieve($response->stripe_user_id);
            $url = $account->login_links->create();

            if(Auth::check()) {
                $user = Auth::user();
                $user->stripe_payout_account_id = $response->stripe_user_id;
                $user->stripe_express_dashboard_url = $url->url;
                $user->save();
                Session::put('stripe_connect_success', 'Stripe Connected Successfully');
                // dd( Session::has('redirect_page'));
                // check if redirect URL exists set it and clear session variables
                if(Session::has('redirect_page')){
                    $redirect_url = Session::get('redirect_page');
                    if(Session::has('redirect_tab')){
                        $redirect_tab = Session::get('redirect_tab');
                        $redirect_url .= "?tab={$redirect_tab}";
                        session()->forget('redirect_tab');
                    }
                    if(Session::has('model_id')){
                        $model_id = Session::get('model_id');
                        $redirect_url .= "?modal_id={$model_id}";
                        session()->forget('model_id');
                    }
                    Session::put('stripe_account_id', $response->stripe_user_id);
                    session()->forget('redirect_page');
                    // dd($redirect_url);
                    return redirect()->to($redirect_url);
                }
                return redirect()->route('login');
            }
        }catch (\Exception $ex){
            Log::info($ex->getMessage());
        }
        Session::put('stripe_connect_error', 'There is some problem to connect to stripe');
        return redirect()->route('login');
    }


    function makeProduct($name, $currency, $price, $is_recurring = false){
        $product = $this->stripe->products->create([
            'name' => $name,
        ]);

        $price_arr = [
            'product' => $product->id,
            'unit_amount' => $price*100,
            'currency' => $currency,
        ];
        if($is_recurring){
            $price_arr = array_merge($price_arr, ['recurring' => ['interval' => 'month']]);
        }

        $price = $this->stripe->prices->create($price_arr);
        return ['status' => true, 'message' => 'Success', 'data' => $price];
    }

}
