<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionAccessRight extends Model
{
    use HasFactory;

    protected $table = 'auction_access_rights';

    protected $fillable = [
    	'uuid',
    	'profile_id',
    	'auction_id',
    	'access',
    ];
    
}
