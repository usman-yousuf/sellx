<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuctionProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auction_products';
    public $timestamps = true;

    protected $with = ['product', 'auction'];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->with('medias');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
}
