\<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auctions';
    protected $guarded =[];
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = ['setting'];
    protected $appends = [
        'allowed_to_post',
        'allow_to_bid',
    ];

    protected $withCount = ['biddings','comments','viewers','auction_products'];

    public function getAllowedToPostAttribute(){
        $userLocalTime = get_locale_datetime(Carbon::now()->toDateTimeString(), \Request::ip());
        $auctionLocalTime = $this->scheduled_date_time;

        if($this->is_scheduled == 1){
            if($userLocalTime >= $auctionLocalTime){
                return 1;
            }
            if($userLocalTime < $auctionLocalTime){
                return 0;
            }
        }
        else{

            return 0;
        }
    }

    public function getAllowToBidAttribute(){

        // &&    ($this->setting->auction_type == 'ticker_price')
        if(isset($this->setting->auction_type) ){
            return 1;
        }
        return 0;
         
    }


    public function auction_products()
    {
        return $this->hasMany(AuctionProduct::class, 'auction_id', 'id')->orderBy('sort_order', 'ASC');
    }

    public function auctioneer()
    {
        return $this->belongsTo(Profile::class, 'auctioneer_id', 'id')->with('user');
    }

    public function medias()
    {
        return $this->hasMany(UploadMedia::class, 'ref_id', 'id')->where('type', 'auction');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'ref_id', 'id')->where('ref_type', 'auction');
    }

    public function biddings()
    { 
        return $this->hasMany(Bidding::class, 'auction_id', 'id');
    }

    public function comments()
    { 
        return $this->hasMany(Comment::class, 'auction_id', 'id');
    }

    public function viewers()
    { 
        return $this->hasMany(Viewer::class, 'auction_id', 'id');
    }

    public function solds()
    { 
        return $this->hasMany(Sold::class, 'auction_id', 'id');
    }

    public function setting()
    { 
        return $this->hasone(AuctionSetting::class, 'auction_id', 'id');
    }

    // public function watchlist()
    // {
    //     return $this->hasMany(Watchlist::class, 'auction_id' , 'id');
    // }

    /**
     * Boot Method of Modal
     */
    protected static function boot()
    {
        parent::boot();

        // static::updating(function ($model){
        //     d;
        //     try{
        //         dd('Updating');
        //     }
        //     catch(\Exception $ex){
        //         return sendError($ex->getMessage(), $ex->getTrace());
        //     }
        // });

        // delete an Auction
        static::deleting(function ($model) {
            try{
                foreach($model->auction_products as $ap){
                    if($ap->product->getAvailableQuantityAttribute() > 0){
                        $ap->product()->update(['is_added_in_auction' => (Bool)false]);
                    }
                    else{
                        $ap->product()->delete();
                    }
                }
                $model->auction_products()->delete(); // auction_products
                $model->medias()->delete(); // medias
            }
            catch(\Exception $ex){
                return sendError($ex->getMessage(), $ex->getTrace());
            }
        });

        
    }
}
