<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\AuctionProduct;
use App\Models\Product;
use App\Models\Profile;
use App\Models\UploadMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function deleteAuctionProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_uuid' => 'required|string|exists:products,uuid',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $product = Product::where('uuid', $request->product_uuid)->first();
        if (null == $product) {
            return sendError('No Record Found', []);
        }

        try {
            AuctionProduct::where('product_id', $product->id)->delete();
            return sendSuccess('Record(s) Deleted Successfully', []);
        } catch (\Exception $ex) {
            return sendError('Something went wrong while deleting Auction Products', []);
        }
    }

    public function updateAuction(Request $request)
    {
        // $auction = Auction::where('id', 9)->with(['auction_products', 'auctioneer', 'medias'])->first();
        // return sendSuccess('success', $auction);
        $validator = Validator::make($request->all(), [
            'auction_uuid' => 'string|exists:auctions,uuid',
            'title' => 'required|min:3',
            'status' => 'in:pending,in-progress,pending,cancelled,aborted',
            'is_scheduled' => 'required|in:0,1',
            'scheduled_date_time' => 'required_if:is_scheduled,1',
            'is_live' => 'required|in:0,1',
            'cover_image' => 'required',
            'product_uuids.*' => 'exists:products,uuid',
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
            $model = Auction::where('uuid', $request->auction_uuid)->first();
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

        try{
    		DB::beginTransaction();
            $model->save();

            // add|update Media related to this auction
            $uploadMedia = UploadMedia::where('profile_id', $request->user()->profile->id)->where('ref_id', $model->id)->where('type', 'auction')->first();
            if(null == $uploadMedia){
                $attachmentResult = UploadMedia::addAttachments($request->user()->profile->id, $request->cover_image, $model->id, 'auction');
                if(!$attachmentResult['status']){
                    DB::rollBack();
                    return sendError('Something went wrong while saving file', $attachmentResult['data']);
                }
                $uploadMediaPath = $attachmentResult['data'][0];
            }
            else{
                $uploadMedia->path = $request->cover_image;
                $uploadMedia->updated_at = date('Y-m-d H:i:s');
                $uploadMedia->save();
                $uploadMediaPath  = $uploadMedia->path;
            }

            // add|update Auction lots
            if(isset($request->product_uuids) && ('' != $request->product_uuids)){

                // get requested Product Ids from produtcs table
                $uuids = "('". implode("','", $request->product_uuids) . "')";
                $product_ids = DB::select("SELECT id FROM products WHERE uuid IN {$uuids}");
                if(empty($product_ids)){
                    DB::rollBack();
                    return sendError('No Products Found', []);
                }
                $requestedProductIds = [];
                foreach($product_ids as $item){
                    $requestedProductIds[] = $item->id;
                }

                // get Existing Product Ids from db
                $product_ids = DB::select("SELECT id FROM products WHERE profile_id = {$request->user()->profile->id}");
                if (empty($product_ids)) {
                    DB::rollBack();
                    return sendError('No Products Found', []);
                }
                $productIds = [];
                foreach ($product_ids as $item) {
                    $productIds[] = $item->id;
                }

                $product_ids = "('" . implode("','", $productIds) . "')";
                $auction_product_ids = DB::select("SELECT product_id FROM auction_products WHERE isNull(deleted_at) AND product_id IN {$product_ids}");

                $existingProductIds = [];
                foreach ($auction_product_ids as $item) {
                    $existingProductIds[] = $item->product_id;
                }
                // dd($existingProductIds);
                // dd($requestedProductIds, $existingProductIds);
                $productIdsToAdd = array_diff($requestedProductIds, $existingProductIds);
                foreach($productIdsToAdd as $id){
                    $temp = new AuctionProduct();
                    $temp->uuid = \Str::uuid();
                    $temp->auction_id = $model->id;
                    $temp->product_id = $id;
                    $temp->sort_order = (boolean)true;
                    $temp->created_at = date('Y-m-d H:i:s');
                    $temp->save();
                }
            }
        	DB::commit();
        }
        catch(\Exception $ex)
        {
            return sendError($ex->getMessage(), $ex->getTrace());
        }
        $auction = Auction::where('id', $model->id)->with(['auction_products','auctioneer', 'medias'])->first();
        return sendSuccess('Record Saved Successfully', $auction);
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
