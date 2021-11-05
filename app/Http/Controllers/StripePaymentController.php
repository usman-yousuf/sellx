<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Stripe;


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
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $currency = (isset($request->currency) && ('' != $request->currency)) ? $request->currency : 'usd';

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
