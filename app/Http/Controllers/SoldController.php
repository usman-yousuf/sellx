<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\Bidding;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Sold;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $validator = Validator::make($request->all(), [
            'profile_uuid'         => 'exists:profiles,uuid',
            'buyer_uuid'           => 'exists:profiles,uuid',
            'auction_uuid'         => 'exists:auctions,uuid',
            'auction_product_uuid' => 'exists:auction_products,uuid',
            'bidding_uuid'         => 'exists:biddings,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $sold  = Sold::orderBy('created_at', 'DESC');

        if(isset($request->status)){

            $sold->where('status', $request->status);
        }
        
        if(isset($request->profile_uuid)){

            $profile = Profile::where('uuid',$request->profile_uuid)->first();
            if(null == $profile){
                return sendError('profile Does Not Exist',[]);
            }

            $product_ids = Product::where('profile_id',$profile->id)->where('is_sell_out',1)->pluck('id')->toArray();
            $sold = Sold::whereIn('product_id',$product_ids);

            $clone_sold = $sold;
            $clone_sold_pending = $sold;
            if(isset($request->offset) && isset($request->limit)){
                $sold->offset($request->offset)->limit($request->limit);
            }

            $sold = $sold->without(['profile','product'])->get();

            $data['sold'] = $sold;
            $data['sold_count'] = $clone_sold->count();
            $data['sold_count_pending'] = $clone_sold->where('status', 'pending')->count();

            return sendSuccess('Sold',$data);
        }
        if(isset($request->buyer_uuid)){

            $profile = Profile::where('uuid',$request->buyer_uuid)->first();
            if(null == $profile){
                return sendError('profile Does Not Exist',[]);
            }
            $sold->where('profile_id',$profile->id);

        }
        if(isset($request->auction_product_uuid)){

            $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();
            if(null == $auction_product){
                return sendError('Auction Product Does Not Exist',[]);
            }
            $sold->where('auction_product_id',$auction_product->id);

        }
        if(isset($request->bidding_uuid)){

            $bid = bidding::where('uuid',$request->bidding_uuid)->first();
            if(null == $bid){
                return sendError('bid Does Not Exist',[]);
            }
            $sold->where('bidding_id',$bid->id);

        }
        if(isset($request->auction_uuid)){

            $auction = Auction::where('uuid',$request->auction_uuid)->first();
            if(null == $auction){
                return sendError('auction Does Not Exist',[]);
            }
            $sold->where('auction_id',$auction->id);
        }

        $cloned_models = clone $sold;

        if(isset($request->offset) && isset($request->limit)){
            $sold->offset($request->offset)->limit($request->limit);
        }

        $data['sold'] = $sold->get();
        $data['total_sold'] = $cloned_models->count();
        $data['total_sold_pending'] = $cloned_models->where('status','pending')->count();

        return sendSuccess('Data',$data);
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

        //Updating Sold Status
        if(isset($request->sold_uuid)){
            
            $sold = [
                'status' => $request->status,
            ];
            $sold = Sold::where('uuid',$request->sold_uuid)->update($sold);

            return sendSuccess('Updated Status',$sold);
        }

        $bid = Bidding::where('uuid', $request->bidding_uuid)->first();

        if(NULL != $bid->deleted_at){

            return sendError('Bid Does Not Exist',[]);
        }
        if(NULL == $bid->sold_date_time){

            return sendError('Bidding Not confirmed',[]);
        }
        if(Sold::where('bidding_id', $bid->id)->first() ){

            return sendError('Bid already sold',[]);
        }

        $total = $bid->total_price;
        $sold = [
            'uuid'               => Str::uuid(),
            'bidding_id'         => $bid->id,
            'profile_id'         => $bid->profile_id,
            'auction_id'         => $bid->auction_id,
            'product_id'         => $bid->auction_product->product_id,
            'auction_product_id' => $bid->auction_product_id,
            'quantity'           => $bid->quantity,
            'price'              => $bid->total_price,
            'type'               => $bid->status,
            'status'             => $request->status,
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

        DB::beginTransaction();
        try{

            $sold['total_price'] = $total;
            $sold = Sold::create($sold);

            $available_quantity = $bid->auction_product->product->getAvailableQuantityAttribute();

            if(0 == $available_quantity){

                Product::where('id',$bid->auction_product->product_id)->update([
                    'is_sell_out' => 1
                ]);
                AuctionProduct::where('id',$bid->auction_product_id)->update([
                    'status' => 'completed',
                    'closure_time' => Carbon::now()
                ]);
                DB::commit();
                return sendSuccess('Product Sold,No Quantity Left',$sold);

            }
            DB::commit();
            $profile->deposit -=  $total;
            return sendSuccess('Sold',$sold);
        }
        catch(\Exception $e){
            DB::rollBack();
            return sendError($e->getMessage(), []);
        }
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
