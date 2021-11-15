<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\AuctionSetting;
use App\Models\Bidding;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Sold;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BiddingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_bidding(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid'         => 'exists:profiles,uuid',
            'auction_uuid'         => 'exists:auctions,uuid|required_with:max_bid_price',
            'auction_product_uuid' => 'exists:auction_products,uuid',
            'bidding_uuid'         => 'exists:biddings,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // Bid_id,profile_id,Auction_id and max price filter
        //  Max Price filter only works with auction_id
        $bids  = Bidding::orderBy('created_at', 'DESC');

        if(isset($request->bidding_uuid)){

            $bids->where('uuid',$request->bidding_uuid);
        }

        if(isset($request->profile_uuid)){

            $profile = Profile::where('uuid',$request->profile_uuid)->first();
            $bids->where('profile_id',$profile->id);
        }

        if(isset($request->auction_uuid)){

            $auction = Auction::where('uuid',$request->auction_uuid)->first();

            if(isset($request->max_bid_price)){

                $bids->where('auction_id',$auction->id)
                    ->where('bid_price',$request->max_bid_price);
            }
            else{

                $bids->where('auction_id',$auction->id);
            }
        }

        $cloned_models = clone $bids;

        if(isset($request->offset) && isset($request->limit)){
            $bids->offset($request->offset)->limit($request->limit);
        }

        $bids = $bids->with(['auction'])->get();
        $total_bids = $cloned_models->count();

        return sendSuccess('Data',$bids);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_bids(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid', $request->profile_uuid)->first();

        if(null == $profile){

            return sendError('User Not Found', []);
        }

        $bids  = Bidding::orderBy('bid_price', 'DESC')
            ->where('profile_id', $profile->id)
            ->groupby('auction_product_id')
            ->whereHas('auction_product.solds')
            ->with('auction_product');
            
        $won = clone $bids;
        // return    $bids->get();
        if(isset($request->offset) && isset($request->limit)){
            $won->offset($request->offset)->limit($request->limit);
            $bids->offset($request->offset)->limit($request->limit);
        }
        $won = $won->where('status','<>',NULL)->get();
        $bids = $bids->get();

        $data = [
            "all_bids" => $bids,
            "won_bids" => $won,
        ];

        return sendSuccess("Data Found", $data);
    }

    public function auction_user_bids(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required|exists:profiles,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $profile = Profile::where('uuid', $request->profile_uuid)->first();

        if(null == $profile){

            return sendError('User Not Found', []);
        }

        $bids  = Bidding::orderBy('bid_price', 'DESC')
            ->where('profile_id', $profile->id)
            ->groupby('auction_product_id')
            ->without(['user','sold']);
            
        $won = clone $bids;
        if(isset($request->offset) && isset($request->limit)){
            $won->offset($request->offset)->limit($request->limit);
            $bids->offset($request->offset)->limit($request->limit);
        }
        $won = $won->where('status','<>',NULL)->get();
        $bids = $bids->get();

        $data = [
            "all_bids" => $bids,
            "won_bids" => $won,
        ];

        return sendSuccess("Data Found", $data);
    }

    /**
     * Update/Create the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function bidding(Request $request, Bidding $bidding)
    {

        $validator = Validator::make($request->all(), [
            'auction_uuid'         => 'string|exists:auctions,uuid|required_with:auction_product_uuid,profile_uuid,bid_price',
            'auction_product_uuid' => 'string|exists:auction_products,uuid|required_with:auction_uuid,profile_uuid,bid_price',
            'profile_uuid'         => 'string|exists:profiles,uuid|required_with:auction_product_uuid,auction_uuid,bid_price',
            'bid_price'            => 'required_without_all:bidding_uuid,is_fixed_price',
            'is_fixed_price'       => 'boolean|required_without_all:bid_price,bidding_uuid',
            'quantity'             => 'required_with_all:is_fixed_price|numeric|min:1',
            'bidding_uuid'         => 'string|exists:biddings,uuid|required_without_all:auction_uuid,auction_product_uuid,profile_uuid,bid_price,is_fixed_price'
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->bid_price) && isset($request->is_fixed_price)){

            return sendError('Cant Send Both fixed price and is fixed',[]);
        }

        //For Update bid Sold This BLock
        if(isset($request->bidding_uuid)){

            $biddings = [
                'status' => 'bid_won',
                'sold_date_time' => Carbon::now(),
            ];

            $bid = Bidding::where('uuid', $request->bidding_uuid)->where('is_fixed_price',0)->where('deleted_at',NULL)->update($biddings);

            if(!$bid)
                return sendError('Internal Server Error',$bid);

            return sendSuccess("Sold",$bid);
        }
        //End Update

        $profile = Profile::where('uuid',$request->profile_uuid)->first();
        

        $auction         = Auction::where('uuid',$request->auction_uuid)->first();
        $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();
        $product         = Product::where('id',$auction_product->product_id)->first();

        //Null Check as exist check even if model is soft deleted
        if(NULL == $profile || NULL == $auction || NULL == $product || NULL == $auction_product)
            return sendError('Data Missmatch',[]);

        //Get Product Avalible Quantity
        $available = clone $product;
        $available = $available->getAvailableQuantityAttribute();
        
        if(NULL == $product->auction_type){
            return sendError('Aution type not set of product',[]);

        }

        //Work if is_fixed_price is not fixed
        if(!isset($request->is_fixed_price)){

            if($product->auction_type == 'fixed_price')
                return sendError('Fixed Price selected, Cant Bid',[]);

            if($request->bid_price > (int)$profile->max_bid_limit)
                return sendError("You have Exceeded Your Max Bid Limit",[]);

            if($request->bid_price > $profile->deposit)
                return sendError("Not enough deposit",[]);

            $last_max_bid = Bidding::where('auction_id',$auction->id)->where('auction_product_id',$auction_product->id)->max('bid_price');

            if($last_max_bid == 0 && $product->auction_type != 'from_zero')
            	$last_max_bid = $auction_product->product->start_bid; 

            $min_bid_value = $last_max_bid+$auction_product->product->min_bid;
            $max_bid_value = $last_max_bid+$auction_product->product->max_bid;

            if($available < 1){
                return sendError('Quantity Over Reached',[]);
            }
            else if( $request->bid_price >= $min_bid_value && $request->bid_price <= $max_bid_value ){

                $bidding = [
                    'uuid' => Str::uuid(),
                    'profile_id' => $profile->id,
                    'auction_id' => $auction->id,
                    'auction_product_id' => $auction_product->id,
                    'bid_price' => (int)$request->bid_price,
                    'total_price' => (int)$request->bid_price,
                ];
            }
            else{

                $msg = "Value Must Be Between $min_bid_value And $max_bid_value";
                return sendError("Limit Error",$msg);
            }

        }
        else {

            if($product->auction_type == 'ticker_price'){

                return sendError('Ticker Price selected, Cant Fix Price',[]);
            }
            // if($product->auction_type == 'fixed_price'){

            //     $price = $product->start_bid;
            // }
            if($auction_product->is_fixed_price == 1 || $product->auction_type == 'fixed_price' || $product->auction_type == 'not_preselected'){

                $price = $auction_product->fixed_price;
                if(NULL == $price){
                    return sendError('Fix Price Not Set',[]);
                }
                if($request->$price < (int)$profile->max_bid_limit)
                    return sendError("Not enough deposit to buy this product",[]);
            }
            else{

                return sendError('Price Not Fixed, Data Missmatch',[]);
            }

            if($request->quantity <= $available){

    	            $bidding = [
    	                'uuid' => Str::uuid(),
    	                'auction_id' => $auction->id,
    	                'auction_product_id' => $auction_product->id,
    	                'profile_id' => $profile->id,
    	                'is_fixed_price' => (int)$request->is_fixed_price,
    	                'single_unit_price' => (int)$price,
    	                'quantity' => (int)$request->quantity,
    	                'total_price' => $request->quantity * $price,
    	                'status' => 'purchased',
    	                'sold_date_time' => Carbon::now(),
    	            ];
            }
            else{

                return sendError('Quantity Over Reached',[]);
            }
        }

        $bid = Bidding::create($bidding);
        $bid = $bid->where('id',$bid->id)->with(['auction','user'])->first();

        return sendSuccess("Sucess",$bid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bidding $bidding)
    {
        //
    }
}
