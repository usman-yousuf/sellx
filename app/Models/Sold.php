<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sold extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bidding()
    {
        return $this->belongsTo(Bidding::class, 'bidding_id', 'id');
    }
}
