<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    use SoftDeletes;

    protected $with = ['sender'];

    public function sender(){
        return $this->belongsTo(Profile::class,'sender_id','id');
    }

    public function receiver(){
        return $this->belongsTo(Profile::class,'receiver_id','id');
    }
}
