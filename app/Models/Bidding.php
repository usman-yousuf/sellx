<?php

namespace App\Models;

use App\Models\AuctionProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function auction_product()
    {
        return $this->belongsTo(AuctionProduct::class, 'auction_product_id', 'id');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id', 'id');
    }
}
