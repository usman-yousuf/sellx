<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sold;
use App\Models\Address;
use App\Models\Auction;
use App\Models\Bidding;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Delivery;
use App\Models\Defaulter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PaymentOption;
use App\Models\ShippingPrice;
use App\Models\AuctionProduct;
use App\Models\DeliveryOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    public function delivery(Request $request){

        $validator = Validator::make($request->all(), [

            'sold_uuid'          => 'required|exists:solds,uuid',
            'price'              => 'required|numeric',
            'shipping_fee'       => 'required|numeric',
            'total_price'        => 'required|numeric',
            'currency'           => 'required',
            'payment_type_uuid'  => 'required|exists:payment_options,uuid',
            'delivery_type_uuid' => 'required|exists:delivery_options,uuid',
            'string_charge_id'   => 'string',
            'status'             => 'in:delivered,pickeup,pending,shipped',
            'address_uuid'            => 'string|exists:uuid,address',
    
        ]);
    
        if ($validator->fails()) {
    
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
    
        
        $sold = Sold::where('uuid',$request->sold_uuid)->first();
        if(null === $sold)
            return sendError('invalid sold id',[]);
        $delivery = Delivery::where('sold_id',$sold->id)->first();
        if(null == $delivery){
            
            $delivery  = new Delivery();
            
            $payment_options = PaymentOption::where('uuid',$request->payment_type_uuid)->first();
            $delivery_options = DeliveryOption::where('uuid',$request->delivery_type_uuid)->first();
            $address = Address::where('uuid',$request->address_uuid)->first();
            
            $delivery->uuid = Str::uuid();
            $delivery->sold_id            = $sold->id;
            $delivery->auction_id         = $sold->auction_id;
            $delivery->product_id         = $sold->product_id;
            $delivery->auction_product_id = $sold->auction_product_id;
            $delivery->profile_id         = $sold->profile_id;
            $delivery->auctioneer_id      = $sold->auction->auctioneer_id;
            $delivery->price              = $request->price;
            $delivery->shipping_fee       = $request->shipping_fee;
            $delivery->total_price        = $request->total_price;
            $delivery->currency           = $request->currency;
            $delivery->payment_type_id    = $payment_options->id;
            $delivery->payment_type       = $payment_options->name;
            $delivery->delivery_type_id   = $delivery_options->id;
            $delivery->delivery_type      = $delivery_options->name;
            $delivery->string_charge_id   = $request->string_charge_id;
            $delivery->address_id         = $address->id ?? NULL;

        }
        else {
            $delivery->status             = $request->status ?? 'pending';
        }
    
        $delivery->save();

        $delivery = Delivery::find($delivery->id);        

        return sendSuccess('Delivery Saved',$delivery);
    }

}
