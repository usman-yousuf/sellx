<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'profile_id',
        'cat_id',
        'sub_cat_id',
        'sub_cat_id_level_3',
        'title',
        'description',
        'max_bid',
        'min_bid',
        'start_bid',
        'target_price'
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

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

    public function medias(){
        return $this->hasMany(UploadMedia::class, 'ref_id', 'id')->where('type', 'product');
    }

}