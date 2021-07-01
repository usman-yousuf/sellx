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
    ];
    
    public function auction_product()
    {
        return $this->belongsTo(AuctionProduct::class, 'auction_product_id', 'id');
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

        // if($this->whereHas('sold'))
        return 0;
    }
}
