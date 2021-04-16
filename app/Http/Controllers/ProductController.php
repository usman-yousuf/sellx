<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use App\Models\Product;
use App\Models\UploadMedia;
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

        $clone_products = clone $products;
        if(isset($request->offset) && isset($request->limit)){
            $products->offset($request->offset)->limit($request->limit);
        }

        $models = $products->with('medias')->with('category')->with('subCategory')->with('subCategoryLevel3')->get();
        
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
            'cat_id' => 'required',
            'sub_cat_id' => 'required',
            'sub_cat_level_3_id' => 'required',
            'min_bid' => 'required|min:1',
            'max_bid' => 'required|gt:min_bid',
            'start_bid' => 'required|min:1',
            'target_price' => 'required|gt:start_bid'
        ]);
        if($validator->fails()){
            $data['validation_error'] = $validator->getMessageBag();
            return sendError($validator->errors()->all()[0], $data);
        }
		
		$profile_uuid = ($request->profile_uuid) ? $request->profile_uuid : $request->user()->profile->uuid;
		$profile = Profile::where('uuid', $profile_uuid)->first();

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
        //dd($request->all());

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
        if(isset($request->min_bid))
        	$product->min_bid = $request->min_bid;
        if(isset($request->max_bid))
        	$product->max_bid = $request->max_bid;
        if(isset($request->start_bid))
        	$product->start_bid = $request->start_bid;
        if(isset($request->target_price))
        	$product->target_price = $request->target_price;

        if($product->save()){

        	// UNDER CONSTRUCTION
        	// $old_media = UploadMedia::where('profile_id', $profile->id)
         //        ->where(function($q) use($product){
         //            $q->where('ref_id', $product->id)->where('type', 'product');
         //        })->pluck('id')->toArray();

         //    $remove_media = $old_media;
         //    if(isset($request->product_media) && count($request->product_media) > 0){
         //        ProductMedia::whereIn('id', $request->product_media)->update(['product_id' => $product->id]);
         //        $remove_media = array_values(array_diff($old_media, $request->product_media));
         //    }
         //    $request->request->replace(['product_media' => $remove_media]);
         //    $this->discardProductMedia($request);


        	// save mode attachments in db
        	if($request->attachments != null){
            	$attachmentResult = UploadMedia::addAttachments($request->user()->profile->id, $request->attachments, $product->id, 'product');
        	}

            if(!$attachmentResult['status']){
                return getInternalErrorResponse($attachmentResult['message'], [], $attachmentResult['responseCode']);
            }

        	DB::commit();
        	$data['product'] = Product::where('id', $product->id)->with('medias')->with('category')->with('subCategory')->with('subCategoryLevel3')->first();
        	return sendSuccess($message, $data);
        }
        
        DB::rollBack();
        return sendError('There is some problem.', null);

	}

}