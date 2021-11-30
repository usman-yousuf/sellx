<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
    
    public function auction_product()
    {
        return $this->hasMany(AuctionProduct::class, 'auction_product_id', 'id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id')->with('user');
    }

    public function auctioneer()
    {
        return $this->belongsTo(Profile::class, 'auctioneer_id', 'id')->with('user');
    }

    public function addresses()
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

}
