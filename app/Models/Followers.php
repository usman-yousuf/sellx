<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Followers extends Model
{
    use HasFactory;

    protected $table = 'followers';

    protected $fillable = [
        'uuid',
        'profile_id',
        'following_id',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];


    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function following()
    {
        return $this->belongsTo(Profile::class, 'profile_id', 'id');
    }

    public function follower()
    {
        return $this->belongsTo(Profile::class, 'following_id', 'id');
    }
}

?>
