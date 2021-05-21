<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\Bidding;
use App\Models\user;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

// use GuzzleHttp\Psr7\str;


class BiddingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auction_uuid' => 'exists:auctions,uuid|required_with:max_bid_price',
            'user_uuid' => 'exists:users,uuid',
            'biddind_uuid' => 'exists:biddings,uuid',
            'auction_product_uuid' =>'exists:auction_products,uuid',
            'max_bid_price' => 'exists:auctions,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // Bid_id,user_id,Auction_id and max price filter
        //  Max Price filter only works with auction_id
        $bids  = Bidding::orderBy('created_at', 'DESC');
        if(isset($request->biddind_uuid)){

            $bids->where('uuid',$request->biddind_uuid);
        }
        else if(isset($request->user_uuid)){

            $user = user::where('uuid',$request->user_uuid)->first();
            $bids->where('user_id',$user->id);
        }
        else if(isset($request->auction_product_uuid)){

            $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();
            $bids->where('auction_product_id',$auction_product->id);
        }
        else if(isset($request->auction_uuid)){

            $auction = Auction::where('uuid',$request->auction_uuid)->first();

            if(isset($request->max_bid_price)){

                $bids->where('auction_id',$auction->id)
                    ->where('bid_price',$request->max_bid_price)
                    ->get();
            }
            else{

                $bids->where('auction_id',$request->auction_id)->get();
            }
        }
        else{

            $result = Bidding::all();
        }

        $cloned_models = clone $bids;
        if(isset($request->offset) && isset($request->limit)){
            $bids->offset($request->offset)->limit($request->limit);
        }
        $bids = $bids->get();
        $total_bids = $cloned_models->count();


        return sendSuccess('Data',$bids);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function show(Bidding $bidding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function edit(Bidding $bidding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Bidding $bidding)
    {

        $validator = Validator::make($request->all(), [
            'auction_uuid' => 'string|exists:auctions,uuid',
            'auction_product_uuid' => 'string|exists:auction_products,uuid',
            'user_uuid' => 'string|exists:users,uuid',
            'bid_price' => 'required_without_all:bidding_uuid',
            'is_fixed_price' => 'boolean|required_without_all:bid_price,bidding_uuid',
            'single_unit_price' => 'required_with_all:is_fixed_price|numeric|min:1',
            'quantity' => 'required_with_all:is_fixed_price|numeric|min:1',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $user = user::where('uuid',$request->user_uuid)->first();
        $auction = Auction::where('uuid',$request->auction_uuid)->first();
        $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();

        if(isset($request->bidding_uuid)){

            $biddings = [
                'status' => 'bid_won',
                'sold_date_time' => Carbon::now(),
            ];

            $bid = Bidding::where('uuid', $request->bidding_uuid)
                ->where('is_fixed_price',0)
                ->update($biddings);
            
            if(!$bid){

                return sendError('Data Missmatch',$bid);
            }

                return sendSuccess("Sold",$bid);
        }

        //Work if is_fixed_price is not fixed,if bid and fixed both are given it will go for purchased
        if(!$request->is_fixed_price??''){ 

            $last_max_bid = Bidding::max('bid_price');
            $min_bid_value = $last_max_bid+$auction_product->product->min_bid;
            $max_bid_value = $last_max_bid+$auction_product->product->max_bid;

            if($request->bid_price <= $auction_product->product->start_bid ){

                return sendError("Bid price Must be more than",$auction_product->product->start_bid);
            }

            if($request->bid_price >= $min_bid_value && $request->bid_price <= $max_bid_value){

                $bidding = [
                    'uuid' => Str::uuid(),
                    'user_id' => $user->id,
                    'auction_id' => $auction->id,
                    'auction_product_id' => $auction_product->id,
                    'bid_price' => $request->bid_price,
                    'total_price' => $request->bid_price,
                ];
            }
            else{

                $msg = "Value Must Be Between $min_bid_value And $max_bid_value";
                return sendError("Limit Error",$msg);
            }

        }
        else {

            $bidding = [
                'uuid' => Str::uuid(),
                'auction_id' => $request->auction_id,
                'auction_product_id' => $request->auction_product_id,
                'user_id' => $request->user_id,
                'is_fixed_price' => $request->is_fixed_price,
                'single_unit_price' => $request->single_unit_price,
                'quantity' => $request->quantity,
                'total_price' => $request->quantity * $request->single_unit_price,
                'status' => 'purchased',
                'sold_date_time' => Carbon::now(),
            ];
        }

        $bid = Bidding::create($bidding);

        return sendSuccess("Sucess",$bid);
        // $bid = Bidding::create($request->all());
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
