<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\Bidding;
use App\Models\Profile;
use App\Models\Sold;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SoldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_sold(Request $request)
    {

        $sold  = Sold::orderBy('created_at', 'DESC');
        
        if(isset($request->bidding_uuid)){

            $bid = bidding::where('uuid',$request->bidding_uuid)->first();
            $sold->where('bidding_id',$bid->id);

        }
        if(isset($request->profile_uuid)){

            $profile = Profile::where('uuid',$request->profile_uuid)->first();
            $sold->where('profile_id',$profile->id);
        }
        if(isset($request->auction_uuid)){

            $auction = Auction::where('uuid',$request->auction_uuid)->first();
            $sold->where('auction_id',$request->auction_id)->get();
        }
        else{

            $result = sold::all();
        }

        $cloned_models = clone $sold;

        if(isset($request->offset) && isset($request->limit)){
            $sold->offset($request->offset)->limit($request->limit);
        }

        $sold = $sold->get();
        $total_sold = $cloned_models->count();

        return sendSuccess('Data',$sold);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_sold(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bidding_uuid' => 'required_without:sold_uuid|exists:biddings,uuid',        
            'sold_uuid' => 'required_without:bidding_uuid|exists:solds,uuid',
            'status' => 'string|required',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->sold_uuid)){
            
            $sold = [
                'status' => $request->status,
            ];

            $sold = Sold::where('uuid',$request->sold_uuid)->update($sold);

            return sendSuccess('Updated Status',$sold);
        }

        $bid = Bidding::where('uuid', $request->bidding_uuid)->first();

        if(Sold::where('bidding_id', $bid->id)->first() ){
            return sendError('Bid already sold',[]);
        }

        $total = $bid->total_price;

        $sold = [
            'uuid' => Str::uuid(),
            'bidding_id' => $bid->id,
            'profile_id' => $bid->profile_id,
            'auction_id' => $bid->auction_id,
            'product_id' => $bid->auction_product->product_id,
            'auction_product_id' => $bid->auction_product_id,
            'quantity' => $bid->quantity,
            'price' => $bid->total_price,
            'type' => $bid->status,
            'status' => $request->status,
        ];

        if(isset($request->discount)){

            $total = $total - ($bid->total_price * ($request->discount/100));
            $sold += [
                'discount' => $request->discount, 
            ];
        } 

        if(isset($request->tax_fee)){

            $total = $total + $request->tax_fee;
            $sold += [
                'tax_fee' => $request->tax_fee, 
            ];
        }

        if(isset($request->shipping_fee)){

            $total = $total + $request->shipping_fee;
            $sold += [
                'shipping_fee' => $request->shipping_fee, 
            ];
        }

        $sold['total_price'] = $total;

        $sold = Sold::create($sold);

        return sendSuccess('Sold',$sold);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function show(Sold $sold)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function edit(Sold $sold)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sold $sold)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sold  $sold
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sold $sold)
    {
        //
    }
}
