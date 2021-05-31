<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'stories';
    Protected $guarded = [];
    protected $with = ['media'];

    public function media()
    {
        return $this->hasone(UploadMedia::class, 'ref_id', 'id')->where('type', 'story');
    }

    public function blocks()
    {
        return $this->hasMany(Block::class, 'ref_id', 'id')->where('ref_type', 'story');
    }
}
