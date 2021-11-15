<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $timestamps = true;
    protected $with = ['medias','category','profile'];

    protected $fillable = [
        'uuid',
        'profile_id',
        'cat_id',
        'sub_cat_id',
        'sub_cat_id_level_3',
        'title',
        'description',
        'available_quantity',
        'max_bid',
        'min_bid',
        'start_bid',
        'target_price',
        'auction_type',
        'set_timer',
        'is_sell_out',
        'is_added_in_auction'
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $appends = [
        'available_quantity',
        'is_added_in_watchlist',
        'is_won_by_me',
        'my_product_status',
        'auction_house_name',
        'is_delivered'
    ];

    use SoftDeletes;

    public function category(){
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function subCategory(){
        return $this->belongsTo(SubCategories::class, 'sub_cat_id', 'id');
    }

    public function subCategoryLevel3(){
        return $this->belongsTo(SubCategoriesLevel3::class, 'sub_cat_level_3_id', 'id');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'ref_id', 'id')->where('ref_type', 'product');
    }
    public function watchlist()
    {
        return $this->hasMany(ProductWatchlist::class, 'product_id', 'id');
    }

    public function medias(){
        return $this->hasMany(UploadMedia::class, 'ref_id', 'id')->where('type', 'product');
    }

    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'profile_id', 'id');
    }

    public function auction_products()
    {
        return $this->hasMany(AuctionProduct::class, 'product_id', 'id')->without('product');
    }

    public function sold()
    {
        return $this->hasMany(Sold::class, 'product_id', 'id');
    }

    /**
     * Boot Method of Modal
     */
    protected static function boot()
    {
        parent::boot();

        // delete an Auction
        static::deleting(function ($model) {
            $model->auction_products()->delete(); // auction_products
            $model->medias()->delete(); // medias
        });
    }

    public function getAvailableQuantityAttribute(){

        $res = DB::select("
        SELECT available_quantity - (SELECT IF( (SUM(quantity) > 0), SUM(quantity), 0) FROM `solds` where status IN('paid','on_hold','shipped'
        ,'completed') AND product_id = ?) AS available_qnty
            FROM products
            WHERE id = ?
        ", [$this->id, $this->id]);
        // $available_qnty = null != $res;
        $available_qnty = (null != $res)? (int)$res[0]->available_qnty : 0;

        return $available_qnty??0;
    }

    public function getIsAddedInWatchlistAttribute(){

        $request = app('request');
        return ProductWatchlist::where('product_id',$this->id)->where('profile_id',$request->user()->active_profile_id)->first()?1:0;
    }
    public function getAuctionHouseNameAttribute(){


        $auction_house_name = AuctionProduct::where('product_id',$this->id)->first();
        if(NULL != $auction_house_name){
            $auction_house_name = auction::where('id',$auction_house_name->auction_id)->first();
            if(NULL != $auction_house_name){
                $auction_house_name = $auction_house_name->title;
                return $auction_house_name;
            }
        }
        return NULL;
    }

    public function getIsWonByMeAttribute(){

        $request = app('request');
        return Sold::where('product_id',$this->id)->where('profile_id',$request->user()->active_profile_id)->first()?1:0;
    }

    public function getMyProductStatusAttribute(){

        $request = app('request');
        $sold = Sold::where('product_id',$this->id)->where('profile_id',$request->user()->active_profile_id)->first();
        return $sold->status??Null;
    }
    public function getIsDeliveredAttribute(){
        return 0; 
    }
}
