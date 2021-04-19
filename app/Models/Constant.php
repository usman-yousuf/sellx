<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Constant extends Model
{
    use HasFactory;

    protected $table = 'constants';
    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'name',
        'value',
        'type',
        'image_path',
        'status',
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    use SoftDeletes;

}