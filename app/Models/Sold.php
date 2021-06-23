<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $with = ['product'];

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
