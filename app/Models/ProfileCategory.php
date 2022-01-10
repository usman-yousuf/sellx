<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileCategory extends Model
{
    use HasFactory;

    protected $table = 'profile_categories';

    protected $fillable = [
        'profile_id',
        'category_id'
    ];

}
