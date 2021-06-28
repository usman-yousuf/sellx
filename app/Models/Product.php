<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $timestamps = true;
    protected $with = ['medias','category','profile'];

    protected $fillable = [
        'uuid',
        'profile_id',
        'cat_id',
        'sub_cat_id',
        'sub_cat_id_level_3',
        'title',
        'description',
        'available_quantity',
        'max_bid',
        'min_bid',
        'start_bid',
        'target_price',
        'auction_type',
        'set_timer',
        'is_sell_out',
        'is_added_in_auction'
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    protected $appends = ['available_quantity'];

    use SoftDeletes;

    public function category(){
        return $this->belongsTo(Category::class, 'cat_id', 'id');
    }

    public function subCategory(){
        return $this->belongsTo(SubCategories::class, 'sub_cat_id', 'id');
    }

    public function subCategoryLevel3(){
        return $this->belongsTo(SubCategoriesLevel3::class, 'sub_cat_level_3_id', 'id');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'ref_id', 'id')->where('ref_type', 'product');
    }

    public function medias(){
        return $this->hasMany(UploadMedia::class, 'ref_id', 'id')->where('type', 'product');
    }

    public function profile()
    {
        return $this->belongsTo('App\Models\Profile', 'profile_id', 'id');
    }

    public function auction_products()
    {
        return $this->hasMany(AuctionProduct::class, 'product_id', 'id')->without('product');
    }

    public function sold()
    {
        return $this->hasMany(Sold::class, 'product_id', 'id');
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

    public function getAvailableQuantityAttribute(){

        $res = DB::select("
        SELECT available_quantity - (SELECT IF( (SUM(quantity) > 0), SUM(quantity), 0) FROM `solds` where status IN('paid') AND product_id = ?) AS available_qnty
            FROM products
            WHERE id = ?
        ", [$this->id, $this->id]);
        // $available_qnty = null != $res;
        $available_qnty = (null != $res)? (int)$res[0]->available_qnty : 0;

        return $available_qnty??0;
    }
}
