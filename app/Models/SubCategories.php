<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategories extends Model
{
    use HasFactory;

    protected $table = 'sub_categories';
    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'cat_id',
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

    public function subCategoriesLevel3(){
        return $this->hasMany(SubCategoriesLevel3::class, 'sub_cat_id', 'id');
    }

}
