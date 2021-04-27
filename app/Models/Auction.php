<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'auctions';
    public $timestamps = true;

    // protected $with = ['auction_products', 'auctioneer'];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function auction_products()
    {
        return $this->hasMany(AuctionProduct::class, 'auction_id', 'id')->orderBy('sort_order', 'ASC');
    }

    public function auctioneer()
    {
        return $this->belongsTo(Profile::class, 'auctioneer_id', 'id');
    }

    public function medias()
    {
        return $this->hasMany(UploadMedia::class, 'ref_id', 'id')->where('type', 'auction');
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
