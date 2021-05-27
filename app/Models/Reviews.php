<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reviews extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'sender_profile_id',
        'receiver_profile_id',
        'auction_product_id',
        'message',
        'rating'
    ];


    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = ['sender', 'receiver'];

    use SoftDeletes;

    public function sender(){
        return $this->belongsTo(Profile::class, 'sender_profile_id', 'id');
    }

    public function receiver(){
        return $this->belongsTo(Profile::class, 'receiver_profile_id', 'id');
    }

    public function auction_product(){
        return $this->belongsTo(AuctionProduct::class, 'auction_product_id', 'id');
    }

}
