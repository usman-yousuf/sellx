<?php

namespace App\Http\Controllers;

use App\Models\viewer;
use App\Models\Profile;
use App\Models\Auction;
use App\Models\AuctionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ViewerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_viewer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auction_uuid' => 'required|exists:auctions,uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $auction = Auction::where('uuid',$request->auction_uuid)->first();

        $viewer = Viewer::where('auction_id',$auction->id)->get();

        return sendSuccess("Viewers",$viewer);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_viewer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'required_with:auction_uuid,auction_product_uuid|exists:profiles,uuid',
            'auction_uuid' => 'required_with:profile_uuid,auction_product_uuid|exists:auctions,uuid',
            'auction_product_uuid' =>'required_with:auction_uuid,profile_uuid|exists:auction_products,uuid',
            'viewer_uuid' =>'required_with:left_at|exists:viewers,uuid',
            'left_at' =>'required_with:viewer_uuid|required_without:auction_uuid,auction_product_uuid,profile_uuid',
        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        if(isset($request->left_at)){

            $viewer = [
                'left_at' => $request->left_at,
            ];

            $viewer = Viewer::where('uuid',$request->viewer_uuid)->update($viewer);

            return sendSuccess('Left',$viewer);
        }

        $profile = Profile::where('uuid',$request->profile_uuid)->first();
        $auction = Auction::where('uuid',$request->auction_uuid)->first();
        $auction_product = AuctionProduct::where('uuid',$request->auction_product_uuid)->first();

        $viewer = [
            'uuid' => Str::uuid(),
            'profile_id' => $profile->id,
            'auction_id' => $auction->id,
            'auction_product_id' => $auction_product->id,
        ];

        $viewer = viewer::Create($viewer);

        return sendSuccess("viewer added",$viewer);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\viewer  $viewer
     * @return \Illuminate\Http\Response
     */
    public function show(viewer $viewer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\viewer  $viewer
     * @return \Illuminate\Http\Response
     */
    public function edit(viewer $viewer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\viewer  $viewer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, viewer $viewer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\viewer  $viewer
     * @return \Illuminate\Http\Response
     */
    public function destroy(viewer $viewer)
    {
        //
    }
}
