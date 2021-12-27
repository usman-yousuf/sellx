<?php

namespace App\Http\Controllers;

use Stripe;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StripePaymentController extends Controller
{

    /**
     * Charge a bank account via Stripe
     *
     * @param Request $request
     *
     * @return void
     */
    public function stripeCharge(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'currency'        => 'required|in:aed',
            'card_number'     => 'required',
            'expiry_month'    => 'required',
            'expiry_year'     => 'required',
            'cvc'             => 'required',
            'charges'         => 'required',
            'payment_message' => 'string'
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }



        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $currency = (isset($request->currency) && ('' != $request->currency)) ? $request->currency : 'aed';

        try{
            $token = Stripe\Token::create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->expiry_month,
                    'exp_year' => $request->expiry_year,
                    'cvc' => $request->cvc,
                ],
            ]);

            $charge = Stripe\Charge::create([
                "amount" => 100 * $request->charges,
                "currency" => $currency,
                "source" => $token->id,
                "description" => $request->payment_message ?? 'sending Payment'
            ]);
            return sendSuccess('Payment Charged Successfully', $charge);
        }
        catch(Exception $ex){
            return sendError($ex->getMessage(), $ex->getTrace());
        }
    }
}
