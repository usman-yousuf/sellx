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

    /**
     * Get all of the categories for the profile.
     */
    public function roles()
    {
        return $this->belongsToMany('\App\Models\Profile', 'profile_categories');
    }

}
