<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Bidding;

class AuctionProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auction_products';
    public $timestamps = true;

    protected $with = [
        'product', 
        'viewers',
        'biddings',
        'comments',
    ];

    protected $withCount = [
        'biddings',
        'viewers',
        'comments'];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $appends = [
        'is_reviwed',
        'put_up_for_auction'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->with('medias');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function biddings()
    { 
        return $this->hasMany(Bidding::class,'auction_product_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function viewers()
    { 
        return $this->hasMany(Viewer::class, 'auction_product_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function comments()
    { 
        return $this->hasMany(Comment::class,'auction_product_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function complains()
    { 
        return $this->hasMany(Complain::class, 'auction_product_id', 'id');
    }

    //Instance methods

    public function getIsReviwedAttribute(){
        // dd();
        return Reviews::where('auction_product_id',$this->id)->where('sender_profile_id',Auth()->User()->profile->id)->first()?1:0;
    }

    public function getPutUpForAuctionAttribute(){

        if((isset($this->auction->id)) && (Auction::where('id',$this->auction->id)->where('is_live',1)->first()))
            return $this->sort_order>=AuctionProduct::where('auction_id',$this->auction->id)->where('status','!=','completed')->max('sort_order')? 1 : 0;

        return 0;
    }  

    /**
     * Boot Method of Modal
     */
    protected static function boot()
    {
        parent::boot();

        // delete an Auction
    }

}
