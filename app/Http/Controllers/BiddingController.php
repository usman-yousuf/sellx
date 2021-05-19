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
    public function index()
    {
        // return sendSuccess("This","That")
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
        
        return sendSuccess("This",$request->all());
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

            if($request->bid_price <= $auction_product->product->start_bid ){
                return sendError("Bid price Must be more than",$auction_product->product->start_bid);
            }
            $bidding = [
                'uuid' => Str::uuid(),
                'auction_id' => $request->auction_id,
                'auction_product_id' => $request->auction_product_id,
                'user_id' => $request->user_id,
                'bid_price' => $request->bid_price,
            ];
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
