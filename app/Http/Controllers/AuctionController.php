<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Product;
use App\Models\Profile;
use App\Models\UploadMedia;
use App\Models\DummyAuction;
use Illuminate\Http\Request;
use App\Models\AuctionProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuctionController extends Controller
{
    #region - DUMMY - START
        public function updateDummyAuction(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'auction_id' => 'string|exists:auctions,id',
                'is_live' => 'required|in:0,1',
                'online_url' => 'required_if:is_live,1',
                'name' => 'required'
            ]);
            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            if(isset($request->auction_id) && ('' != $request->auction_id) ){ // update Auction
                $model = DummyAuction::where('id', $request->auction_id)->first();
            }
            else{ // new Auction
                $model = new DummyAuction();
            }

            $model->is_live = $request->is_live;
            if($request->is_live){
                $model->online_url = $request->online_url;
            }
            $model->name = $request->name;

            try{
                $model->save();
                return sendSuccess('Auction Added Successfully', $model);
            }
            catch(\Exception $ex){
                return sendError($ex->getMessage(), $ex->getTrace());
            }
        }

        public function deleteDummyAuction(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'auction_id' => 'string|exists:auctions,id',
            ]);
            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            $model = DummyAuction::where('id', $request->auction_id)->first();
            if(null == $model){
                return sendError('Record not Found', []);
            }

            try{
                $model->delete();
                return sendSuccess('Auction Deleted Successfully', []);
            }
            catch(\Exception $ex){
                return sendError($ex->getMessage(), $ex->getTrace());
            }
        }

        public function getDummyAuctions(Request $request)
        {
            $models = DummyAuction::orderBy('id', 'DESC')->get();

            return sendSuccess('list', $models);
        }
    #endregion - DUMMY - END

    #region - API end points - START
        /**
         * Get Auctions based on given filters
         *
         * @param Request $request
         * @return void
         */
        public function getAuctions(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'profile_uuid' => 'string|exists:profiles,uuid',
            ]);
            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            $models = Auction::
                    orderBy('created_at', 'DESC')
                    ->with(['auction_products', 'auctioneer', 'medias']);

            // set logged in user profile if not given
            if( isset($profile_uuid) && ('' != $request->profile_uuid)){
                // validate if profile is an auctioneer
                $auctioneer = Profile::where('uuid', $request->profile_uuid)->where('profile_type', 'auctioneer')->first();
                if(null == $auctioneer){
                    return sendError('Invalid User Provided', []);
                }
                // $request->profile_uuid = $request->user()->profile->uuid;
                $models->where('auctioneer_id', $auctioneer->id);
            }

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

        /**
         * Delete an Auction
         *
         * @param Request $request
         * @return void
         */
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

        /**
         * Delete a product against an Auction
         *
         * @param Request $request
         * @return void
         */
        public function deleteAuctionProduct(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'auction_uuid' => 'required|string|exists:auctions,uuid',
                'product_uuid' => 'required|string|exists:products,uuid',
            ]);
            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            $auction = Auction::where('uuid', $request->auction_uuid)->first();
            if (null == $auction) {
                return sendError('No Record Found', []);
            }

            $product = Product::where('uuid', $request->product_uuid)->first();
            if (null == $product) {
                return sendError('No Record Found', []);
            }

            try {
                AuctionProduct::where('product_id', $product->id)->where('auction_id', $auction->id)->delete();
                Product::where('id', $product->id)->update(['is_added_in_auction' => (bool)false]);
                return sendSuccess('Record(s) Deleted Successfully', []);
            } catch (\Exception $ex) {
                return sendError('Something went wrong while deleting Auction Products', []);
            }
        }

        /**
         * Update an Auction
         *
         * @param Request $request
         * @return void
         */
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
                    // dd($productIdsToAdd);
                    foreach($productIdsToAdd as $id){
                        $temp = new AuctionProduct();
                        $temp->uuid = \Str::uuid();
                        $temp->auction_id = $model->id;
                        $temp->product_id = $id;
                        $temp->sort_order = 1;
                        $temp->created_at = date('Y-m-d H:i:s');
                        $temp->save();

                        $status = Product::where('id', $id)->update([
                            'is_added_in_auction' => (bool)true
                        ]);
                        // dd($status);
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
         * Toggle Auction Live Status
         *
         * @param Request $request
         * @return void
         */
        public function toggleLiveAuction(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'auction_uuid' => 'required|string|exists:auctions,uuid',
                'is_live' => 'required|in:0,1',
                'online_url' => 'required_if:is_live,1',
            ]);
            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            $model = Auction::where('uuid', $request->auction_uuid)->first();
            if (null == $model) {
                return sendError('No Record Found', []);
            }

            $model->is_live = $request->is_live;
            if($request->is_live && isset($request->online_url)){
                $model->online_url = $request->online_url;
            }

            DB::beginTransaction();
            try {
                $model->save();
                DB::commit();
                return sendSuccess('Auction Live Status Updated Successfully', $model);
            } catch (\Exception $ex) {
                DB::rollBack();
                return sendError('Something Went wrong while updating Auction Live Status', []);
            }
        }

    #endregion - API end points - END
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
