<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerRequest extends Model
{
    use HasFactory;

    protected $table = 'buyer_requests';

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function auction_product()
    {
        return $this->belongsTo(AuctionProduct::class, 'auction_product_id', 'id');
    }

}
