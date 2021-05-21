<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Watchlist extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'watchlist';
    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'profile_id',
        'auction_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $with = [
        'user', 'auction'
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id')->with('auction_products');
    }

    public function user()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

}