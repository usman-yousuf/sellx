<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductWatchlist;
use App\Models\Profile;
use App\Models\UploadMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
	/**
     * Get Products w.r.t given request data filters
     *
     * @param Request $request
     * @return void
     */
    public function getProducts(Request $request)
    {
        $products = Product::orderBy('created_at', 'desc');

        if(isset($request->profile_uuid) && ($request->profile_uuid != '') ){
            $profile = Profile::where('uuid', $request->profile_uuid)->first();

            if($profile != null){
            	$products->where('profile_id', $profile->id);
            }
        }

        // $products = Product::where('profile_id', $request->profile_uuid)->orderBy('created_at', 'desc');

        if(isset($request->categories) && ('' != $request->categories)){
            $categories = explode(',', $request->categories);
            if(!empty($categories)){
                $products->whereIn('cat_id', $categories);
            }
        }

        $clone_products = clone $products;
        if(isset($request->offset) && isset($request->limit)){
            $products->offset($request->offset)->limit($request->limit);
        }

        $models = $products->with('medias')->with('auction_products')->with('category')->with('subCategory')->with('subCategoryLevel3')->get();

        $data['products'] = $models;
        $data['total'] = $clone_products->count();

        return sendSuccess('Success', $data);
    }

	/**
     * Update & Create Products
     *
     * @param Request $request
     * @return void
     */
	public function updateProduct(Request $request){
		$validator = Validator::make($request->all(),[
            'product_uuid' => 'nullable|exists:products,uuid',
            'title' => 'required|string',
            'description' => 'required|string',
            'available_quantity' => 'required|integer',
            'cat_id' => 'required',
            'sub_cat_id' => 'required',
            'sub_cat_level_3_id' => 'required',
            'min_bid' => 'required|min:1',
            'max_bid' => 'required|gt:min_bid',
            'start_bid' => 'required|min:1',
            'target_price' => 'required|gt:start_bid',
            'auction_type' => 'required|in:not_preselected,ticker_price,fixed_price,from_zero',
            'set_timer' => 'required',

            'category' => 'required|string',
            
            'brand' => 'required_if:category,watches|
                        required_if:category,leatherette|
                        required_if:category,bags|
                        required_if:category,wallet|
                        required_if:category,pens|
                        required_if:category,perfume|
                        required_if:category,oud|
                        required_if:category,3|
                        required_if:category,jewellery',
            
            'make' => 'required_if:category,cars|
                        required_if:category,bike|
                        required_if:category,big_vehicle',
            'inspection_report_document' => 'required_if:category,cars|
                                            required_if:category,bike|
                                            required_if:category,big_vehicle',
            
            'city' => 'required_if:category,plate_number',
            'code' => 'required_if:category,plate_number',
            'number' => 'required_if:category,plate_number',

            'location' => 'required_if:category,properties',
            'type' => 'required_if:category,properties',
            'total_area' => 'required_if:category,properties',
            'affection_plan_document' => 'required_if:category,properties',

        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

		$profile_uuid = ($request->profile_uuid) ? $request->profile_uuid : $request->user()->profile->uuid;
		$profile = Profile::where('uuid', $profile_uuid)->first();

        $category = Category::where('id', $request->cat_id)->first();

		DB::beginTransaction();

		if($request->product_uuid != null){
			$product = Product::where('uuid', $request->product_uuid)->first();

            $message = 'Updated Successfully';
            $is_updated = true;

            if($product == null){
                return sendError('Product not found.', null);
            }
        }else{
            $product = new Product;
            $product->uuid = \Str::uuid();
            $message = 'Created Successfully';
            $is_updated = false;
        }

        if(isset($profile->id))
        	$product->profile_id = $profile->id;
    	if(isset($request->cat_id))
        	$product->cat_id = $request->cat_id;
    	if(isset($request->sub_cat_id))
        	$product->sub_cat_id = $request->sub_cat_id;
        if(isset($request->sub_cat_level_3_id))
        	$product->sub_cat_level_3_id = $request->sub_cat_level_3_id;
        if(isset($request->title))
        	$product->title = $request->title;
    	if(isset($request->description))
        	$product->description = $request->description;
        if(isset($request->available_quantity))
            $product->available_quantity = (int)$request->available_quantity;
        if(isset($request->min_bid))
        	$product->min_bid = $request->min_bid;
        if(isset($request->max_bid))
        	$product->max_bid = $request->max_bid;
        if(isset($request->start_bid))
        	$product->start_bid = $request->start_bid;
        if(isset($request->target_price))
        	$product->target_price = $request->target_price;
        if(isset($request->auction_type))
            $product->auction_type = $request->auction_type;
        if(isset($request->set_timer))
            $product->set_timer = $request->set_timer;

        if($category->slug =='watches'){
            $product->brand = $request->brand;
            $product->model = $request->model;
            $product->material = $request->material;
            $product->year_of_production = $request->year_of_production;
            $product->condition = $request->condition;
            $product->scope_of_delivery = $request->scope_of_delivery;
            $product->reference_number = $request->reference_number;
            $product->size = $request->size;
            $product->dial = $request->dial;
        }
        if($category->slug =='cars' || $category->slug =='bike' || $category->slug =='big_vehicle'){
            $product->make = $request->make;
            $product->model = $request->model;
            $product->year = $request->year;
            $product->vin = $request->vin;
            $product->exterior = $request->exterior;
            $product->transmission = $request->transmission;
            $product->fuel = $request->fuel;
            $product->keys = $request->keys;
            $product->doors = $request->doors;
            $product->seats = $request->seats;
            $product->odometer = $request->odometer;
            $product->body_type = $request->body_type;
            $product->country_of_made = $request->country_of_made;
        }
        if($category->slug =='plate_number'){
            $product->city = $request->city;
            $product->code = $request->code;
            $product->number = $request->number;
        }
        if($category->slug =='bags' || $category->slug =='wallet' || $category->slug =='leatherette'){
            $product->brand = $request->brand;
            $product->color = $request->color;
            $product->size = $request->size;
            $product->material = $request->material;
            $product->scope_of_delivery = $request->scope_of_delivery;
        }
        if($category->slug == 'pens'){
            $product->brand = $request->brand;
            $product->material = $request->material;
            $product->size = $request->size;
            $product->scope_of_delivery = $request->scope_of_delivery;
        }
        if($category->slug == 'perfume' || $category->slug == 'oud'){
            $product->brand = $request->brand;
            $product->size = $request->size;
            $product->weight = $request->weight;
        }
        if($category->slug == 'animals'){
            $product->age = $request->age;
            $product->type = $request->type;
            $product->color = $request->color;
        }

        if($category->slug == 'properties'){
            $product->location = $request->location;
            $product->type = $request->type;
            $product->total_area = $request->total_area; 
        }
        if($category->slug == 'jewellery'){
            $product->brand = $request->brand;
            $product->model = $request->model;
            $product->material = $request->material;
            $product->year_of_production = $request->year_of_production;
            $product->condition = $request->condition;
            $product->scope_of_delivery = $request->scope_of_delivery;
            $product->reference_number = $request->reference_number;
            $product->size = $request->size;
            $product->weight = $request->weight;
        }
        
        if($product->save()){

        	// Save Mode Attachments in DB
        	if($request->attachments != null){
                $uploadMedias = UploadMedia::select('path')
                    ->where('profile_id', $request->user()->profile->id)
                    ->where('type', 'product')
                    ->where('ref_id', $product->id)
                    ->get();

                $dbPaths = [];
                if($uploadMedias->count()){
                    foreach ($uploadMedias as $media) {
                        $dbPaths[] = $media->path;
                    }
                }
                
                $request_files = json_decode($request->attachments);
                
                $requested_paths = [];
                if($request_files){
                    foreach ($request_files as $file) {
                        $requested_paths[] = $file->path;
                    }
                }
                
                $filesToAdd = array_diff($requested_paths, $dbPaths);

                $AddFileToDB = [];
                if($request_files){
                    foreach ($request_files as $file) {
                        foreach ($filesToAdd as $filetocheck) {
                            if($filetocheck == $file->path){
                                $AddFileToDB[] = $file;
                            }   
                        }
                    }
                }
                if($AddFileToDB){
                    foreach($AddFileToDB as $media) {
                        $attachmentResult = UploadMedia::addAttachments($request->user()->profile->id, $media->path, $product->id, 'product', $media->media_type, $media->media_format, $media->media_size, $media->media_ratio, $media->media_thumbnail);

                        if(!$attachmentResult['status']){
                            return getInternalErrorResponse($attachmentResult['message'], [], $attachmentResult['responseCode']);
                        }
                    }
                }
            }


            if($request->inspection_report_document != null){
                $uploadMedias = UploadMedia::select('path')
                    ->where('profile_id', $request->user()->profile->id)
                    ->where('type', 'product')
                    ->where('ref_id', $product->id)
                    ->get();

                $dbPaths = [];
                if($uploadMedias->count()){
                    foreach ($uploadMedias as $media) {
                        $dbPaths[] = $media->path;
                    }
                }
                
                $request_files = json_decode($request->inspection_report_document);
                
                $requested_paths = [];
                if($request_files){
                    foreach ($request_files as $file) {
                        $requested_paths[] = $file->path;
                    }
                }
                
                $filesToAdd = array_diff($requested_paths, $dbPaths);

                $AddFileToDB = [];
                if($request_files){
                    foreach ($request_files as $file) {
                        foreach ($filesToAdd as $filetocheck) {
                            if($filetocheck == $file->path){
                                $AddFileToDB[] = $file;
                            }   
                        }
                    }
                }
                if($AddFileToDB){
                    foreach($AddFileToDB as $media) {
                        $attachmentResult = UploadMedia::addAttachments($request->user()->profile->id, $media->path, $product->id, 'product', $media->media_type, $media->media_format, $media->media_size, $media->media_ratio, $media->media_thumbnail);

                        if(!$attachmentResult['status']){
                            return getInternalErrorResponse($attachmentResult['message'], [], $attachmentResult['responseCode']);
                        }
                    }
                }
            }


            if($request->affection_plan_document != null){
                $uploadMedias = UploadMedia::select('path')
                    ->where('profile_id', $request->user()->profile->id)
                    ->where('type', 'product')
                    ->where('ref_id', $product->id)
                    ->get();

                $dbPaths = [];
                if($uploadMedias->count()){
                    foreach ($uploadMedias as $media) {
                        $dbPaths[] = $media->path;
                    }
                }
                
                $request_files = json_decode($request->affection_plan_document);
                
                $requested_paths = [];
                if($request_files){
                    foreach ($request_files as $file) {
                        $requested_paths[] = $file->path;
                    }
                }
                
                $filesToAdd = array_diff($requested_paths, $dbPaths);

                $AddFileToDB = [];
                if($request_files){
                    foreach ($request_files as $file) {
                        foreach ($filesToAdd as $filetocheck) {
                            if($filetocheck == $file->path){
                                $AddFileToDB[] = $file;
                            }   
                        }
                    }
                }
                if($AddFileToDB){
                    foreach($AddFileToDB as $media) {
                        $attachmentResult = UploadMedia::addAttachments($request->user()->profile->id, $media->path, $product->id, 'product', $media->media_type, $media->media_format, $media->media_size, $media->media_ratio, $media->media_thumbnail);

                        if(!$attachmentResult['status']){
                            return getInternalErrorResponse($attachmentResult['message'], [], $attachmentResult['responseCode']);
                        }
                    }
                }
            }


        	DB::commit();
        	$data['product'] = Product::where('id', $product->id)->with('medias')->with('category')->with('subCategory')->with('subCategoryLevel3')->first();
            // dd(utf8_enc($odedata['product']['description']));
            // dd($data['product']['description']);
        	return sendSuccess($message, $data);
        }

        DB::rollBack();
        return sendError('There is some problem.', null);

	}

    /**
     * Delete a Product
     *
     * @param Request $request
     * @return void
     */
    public function deleteProduct(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_uuid' => 'nullable|exists:products,uuid',
        ]);
        if ($validator->fails()) {
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $model = Product::where('uuid', $request->product_uuid)->first();
        if(null == $model){
            return sendError('Product Not Found', null);
        }
        if($model->profile_id != $request->user()->active_profile_id){
            return sendError('You are Not Authorized to delete this product', null);
        }
        if($model->is_added_in_auction == true){
            return sendError('Cannot delete the product, already in Auction.', null);
        }

        try{
            UploadMedia::where('profile_id', $request->user()->profile->id)
                ->where('type', 'product')
                ->where('ref_id', $model->id)
                ->delete();

            $model->delete();
            return sendSuccess('Product Deleted Successfully', []);
        }
        catch(\Exception $ex){
            return sendError($ex->getMessage(), []);
        }

    }

    public function test(Request $request){
        return sendSuccess('success', $request->all() ?? "ABC");
    }

    public function update_product_auction_type(Request $request){

        $validator = Validator::make($request->all() ,[
            'product_uuid' => 'required|exists:products,uuid',
            'auction_type' => 'required|in:not_preselected,ticker_price,fixed_price,from_zero',

        ]);

        if ($validator->fails()) {

            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
        
        $product = Product::where('uuid',$request->product_uuid)->update(['auction_type' => $request->auction_type]);

        return sendSuccess('Updated',$product);
    }

    public function get_products_details(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'product_uuid' => 'required|exists:products,uuid',
        ]);

        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }

        $product = Product::where('uuid', $request->product_uuid)->with(['medias', 'auction_products'])->first();

        return sendSuccess('Data',$product); 
    }

    public function getWatchlist(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'profile_uuid' => 'required|string|exists:profiles,uuid'
            ]);
            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            $profile = Profile::where('uuid', $request->profile_uuid)->first();
            if (null == $profile) {
                return sendError('Profile not Found', []);
            }

            $models = ProductWatchlist::where('profile_id', $profile->id);

            $cloned_models = clone $models;
            
            if(isset($request->offset) && isset($request->limit) ){
                $models->offset($request->offset)->limit($request->limit);
            }

            $data['watchlist'] = $models->get();
            $data['total_watchlist_items'] = $cloned_models->count();
            
            return sendSuccess('Success', $data);
        }

        public function AddToWatchlist(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'product_uuid' => 'required|string|exists:products,uuid',
                'profile_uuid' => 'required|string|exists:profiles,uuid'
            ]);

            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            $profile = Profile::where('uuid', $request->profile_uuid)->first();
            if (null == $profile) {
                return sendError('Profile not Found', []);
            }

            $product = Product::where('uuid', $request->product_uuid)->first();
            if (null == $product) {
                return sendError('product not Found', []);
            }

            $check = ProductWatchlist::where('profile_id', $profile->id)->where('product_id', $product->id)->first();
            if($check != null){
                return sendError('product already added in watchlist', null);
            }

            $model = new ProductWatchlist();

            $model->uuid = \Str::uuid();
            $model->profile_id = $profile->id;
            $model->product_id = $product->id;

            if($model->save()){
                $data['watchlist'] = ProductWatchlist::find($model->id);
                return sendSuccess('product added to watchlist successfully', $data);
            }
        }

        public function RemoveFromWatchlist(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'watchlist_uuid' => 'required|string|exists:product_watchlists,uuid'
            ]);
            if ($validator->fails()) {
                $data['validation_error'] = $validator->getMessageBag();
                return sendError($validator->errors()->all()[0], $data);
            }

            $model = ProductWatchlist::where('uuid', $request->watchlist_uuid)->first();
            
            if (null == $model) {
                return sendError('Watchlist item not Found', null);
            }

            if($model->delete()){
                return sendSuccess('product removed from watchlist successfully.', null);
            }

            return sendError('Something went wrong, please try again.', null);
        }

}
