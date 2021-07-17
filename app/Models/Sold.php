<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['profile','product'];

    protected $appends = [
        'product_name',
        'media_path',
        'product_uuid',
    ];

    public function getProductNameAttribute(){

        $product = Product::Where('id', $this->product_id)->first();
        return $product->title??Null;
    }

    public function getMediaPathAttribute(){ 

        $product = Product::Where('id', $this->product_id)->first();
        if(NULL != $product){
            $media_path = UploadMedia::where('ref_id', $product->id)->first();
            return $media_path->path;
        }
        return null;

    }

    public function getProductUuidAttribute(){ 

       $product = Product::Where('id', $this->product_id)->first();
        return $product->uuid??Null;
    }

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }
}
