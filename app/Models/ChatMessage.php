<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_msg_deleted',
        'tag_msg_id'
    ];

    protected $with = ['taggedMessage'];

    public function sender()
    {
        return $this->belongsTo(Profile::class, 'sender_id', 'id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }

    public function taggedMessage()
    {
        return $this->belongsTo(ChatMessage::class, 'tag_msg_id', 'id')->with('sender');
    }
}
