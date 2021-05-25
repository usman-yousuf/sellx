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
        'biddings',
        'viewers',
    ];

    protected $withCount = ['biddings','viewers'];


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

    public function biddings()
    { 
        return $this->hasMany(Bidding::class,'auction_product_id', 'id');
    }

    public function viewers()
    { 
        return $this->hasMany(Viewer::class,'auction_product_id', 'id');
    }

    public function comments()
    { 
        return $this->hasMany(Comment::class,'auction_product_id', 'id');
    }

    public function complains()
    { 
        return $this->hasMany(Complain::class, 'auction_product_id', 'id');
    }
}
