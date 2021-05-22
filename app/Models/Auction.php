<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auctions';
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $appends = [
        'allowed_to_post'
    ];

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

    public function biddings()
    { 
        return $this->hasMany(Bidding::class, 'auction_id', 'id');
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
}