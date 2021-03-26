<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategoriesLevel3 extends Model
{
    use HasFactory;

    protected $table = 'sub_categories_level_3';
    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'sub_cat_id',
        'name',
        'slug',
        'status',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    use SoftDeletes;

}
