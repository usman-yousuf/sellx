<?php

namespace App\Models;


use App\Models\AuctionProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidding extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $with = [
        'user',
        'sold'
    ];

    protected $appends = [
        'sold_price',
        'auction_house_name',
        'product_name',
        'media_path',
        'product_uuid',
        'sold_status',
    ];
    
    public function auction_product()
    {
        return $this->belongsTo(AuctionProduct::class, 'auction_product_id', 'id')->with('solds');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id')->without(['biddings']);
    }

    public function user()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function sold()
    {
        return $this->hasOne(Sold::class, 'bidding_id', 'id');
    }

    public function getSoldPriceAttribute(){

        $check = Sold::where('auction_product_id',$this->auction_product_id)
            ->orderBy('created_at', 'DESC')->first();

        if($check)
            return $check->total_price;

        return 0;
    }

    public function getSoldStatusAttribute(){

        return Sold::where('auction_product_id',$this->auction_product_id)
            ->where('profile_id',$this->profile_id)
            ->orderBy('created_at', 'DESC')
            ->pluck('status')->first()??'Lot_lost';
    }

    public function getAuctionHouseNameAttribute(){

        // return $this->auction->auctioneer->auction_house_name;

        $auction_house_name = Auction::where('id',$this->auction_id)->first();
        if(NULL != $auction_house_name){
            $auction_house_name = Profile::where('id',$auction_house_name->auctioneer_id)->first();
            if(NULL != $auction_house_name){
                $auction_house_name = $auction_house_name->auction_house_name; 
                return $auction_house_name;
            }
        }
        return NULL;
    }

    public function getProductNameAttribute(){

        $product_name = AuctionProduct::where('id',$this->auction_product_id)->first();
            if(NULL != $product_name){
                $product_name = Product::where('id',$product_name->product_id)->first();
                if(NULL != $product_name){
                    $product_name = $product_name->title; 
                    return $product_name;
                }
            }
        return NULL;
    }

    public function getMediaPathAttribute(){ 

        $path = AuctionProduct::where('id',$this->auction_product_id)->first();

        if(NULL != $path){
            $path = Product::where('id',$path->product_id)->first();
            if(NULL != $path){
                $media_path =  UploadMedia::where('type','product')
                        ->where('ref_id',$path->id)->latest()->pluck('path');
                return $media_path;
            }
        }
    }

    public function getProductUuidAttribute(){ 

        $path = AuctionProduct::where('id',$this->auction_product_id)->first();
        
        if(NULL != $path){
            $path = Product::where('id',$path->product_id)->first();
            if(NULL != $path){
                return $path->uuid;
            }
        }
    }
}
