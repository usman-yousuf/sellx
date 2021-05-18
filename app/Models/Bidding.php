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
        return $this->hasMany(AuctionProduct::class,);
    }
}
