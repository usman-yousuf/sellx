<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    public function getAuctions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_uuid' => 'string|exists:profiles,uuid',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // set logged in user profile if not given
        if( !isset($profile_uuid) || ('' == $request->profile_uuid)){
            $request->profile_uuid = $request->user()->profile->uuid;
        }

        // validate if profile is an auctioneer
        $auctioneer = Profile::where('uuid', $request->profile_uuid)->where('profile_type', 'auctioneer')->first();
        if(null == $auctioneer){
            return sendError('Invalid User Provided', []);
        }

        $models = Auction::
                where('auctioneer_id', $auctioneer->id)
                ->orderBy('created_at', 'DESC')
                ->with(['auction_products', 'auctioneer', 'medias']);

        if(isset($request->status) && ('' != $request->status)){
            $models->whereIn('status', [$request->status]);
        }

        $cloned_models = clone $models;
        if( isset($request->offset) && isset($request->limit) ){
            $models->offset($request->offset)->limit($request->limit);
        }
        $data['auctions'] = $models->get();
        $data['total_auctions_count'] = $cloned_models->count();

        return sendSuccess('Success', $data);
    }

    public function deleteAuction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auction_uuid' => 'required|string|exists:auctions,uuid',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $model = Auction::where('uuid', $request->auction_uuid)->first();
        if(null == $model){
            return sendError('No Record Found', []);
        }

        try{
            $model->delete();
            return sendSuccess('Record Deleted Successfully', []);
        }
        catch(\Exception $ex)
        {
            return sendError('Something went wrong while deleting Auction', []);
        }
    }

    public function updateAuction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'auction_uuid' => 'string|exists:auctions,uuid',
            'title' => 'required|min:3',
            'status' => 'in:pending,in-progress,pending,cancelled,aborted',
            'is_scheduled' => 'required|in:0,1',
            'scheduled_date_time' => 'required_if:is_scheduled,1',
            'is_live' => 'required|in:0,1',
            'cover_image' => 'required'
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        // profile uuid
        $profile_uuid = ($request->profile_uuid) ? $request->profile_uuid : $request->user()->profile->uuid;
        $profile = Profile::where('uuid', $profile_uuid)->first();
        if(null == $profile){
            return sendError('User Not Found', []);
        }

        // auction uuid
        if(isset($request->auction_uuid) && ('' != $request->auction_uuid) ){ // update Auction
            $model = Auction::where('uuid', $request->uuid)->first();
            if(isset($request->status) && ('' != $request->status)){
                $model->status = $request->status;
            }
        }
        else{ // new Auction
            $model = new Auction();
            $model->uuid = \Str::uuid();
            $model->auctioneer_id = $profile->id;
            $model->status = (isset($request->status) && ('' != $request->status))? $request->status : 'pending';
        }

        $model->title = $request->title;
        $model->is_scheduled = $request->is_scheduled;
        $model->scheduled_date_time = $request->scheduled_date_time;
        $model->is_live = $request->is_live;
        dd($request->all(), $model->getAttributes());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function show(Auction $auction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction $auction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        //
    }
}
