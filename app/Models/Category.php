<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    public $timestamps = true;

    protected $fillable = [
        'uuid',
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

    public function subCategories(){
        return $this->hasMany(SubCategories::class, 'cat_id', 'id');
    }

    public function profile(){
        return $this->belongsToMany('\App\Models\Profile', 'profile_categories');
    }

}
