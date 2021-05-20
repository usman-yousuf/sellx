<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\Bidding;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'auction_id' => 'required_with:max_bid_price|numeric|min:1',
            'user_id' => 'numeric|min:1',
            'biddind_id' => 'numeric|min:1',
            'biddind_id' => 'numeric|min:1',
            'max_bid_price' => 'numeric|min:1',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->biddind_id)){
            $result = Bidding::where('id',$request->biddind_id)->get();
        }
        else if(isset($request->user_id)){
            $result = Bidding::where('user_id',$request->user_id)->get();
        }
        else if(isset($request->auction_id)){
            if(isset($request->max_bid_price)){
                $result = Bidding::where('auction_id',$request->auction_id)
                    ->where('bid_price',$request->max_bid_price)
                    ->get();
            }
            else{
                $result = Bidding::where('auction_id',$request->auction_id)->get();
            }
        }
        else{
            $result = Bidding::all();
        }

        return sendSuccess('Data',$result);
        
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
        $validator = Validator::make($request->all(), [
            'bidding_id' => 'string|exists:biddings,id',
            'is_fixed_price' => 'boolean|required',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        //If Fixed price
        if($request->is_fixed_price??''){ 
            $biddings = [
                'status' => 'purchased',
                'sold_date_time' => Carbon::now(),
            ];
        }
        else{
            $biddings = [
                'status' => 'bid_won',
                'sold_date_time' => Carbon::now(),
            ];
        }
        
        $bid = Bidding::where('id', $request->bidding_id)
            ->where('is_fixed_price',$request->is_fixed_price)
            ->update($biddings);
            
        if($bid){
            return sendSuccess("Sold",$bid);
        }
        else{
            return sendError("Data Missmatch",$bid);   
        }
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
            'auction_id' => 'string|exists:auctions,id',
            'auction_product_id' => 'string|exists:auction_products,id',
            'user_id' => 'string|exists:users,id',
            'bid_price' => 'required_unless:is_fixed_price,1',
            'is_fixed_price' => 'boolean|required_without:bid_price',
            'single_unit_price' => 'required_with_all:is_fixed_price|numeric|min:1',
            'quantity' => 'required_with_all:is_fixed_price|numeric|min:1',
        ]);

        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $auction_product = AuctionProduct::where('id',$request->auction_product_id)->first();

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
                    'auction_id' => $request->auction_id,
                    'auction_product_id' => $request->auction_product_id,
                    'user_id' => $request->user_id,
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
                // 'status' => 'purchased',
                // 'sold_date_time' => Carbon::now(),
            ];
        }

        $bid = Bidding::create($bidding);

        // $bid = Bidding::create($request->all());

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
