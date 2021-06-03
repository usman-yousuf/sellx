<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    public function members(){
        return $this->hasMany(ChatMember::class, 'chat_id', 'id');
    }

    public function messages(){
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }

    public function lastMessage(){
        return $this->hasOne(ChatMessage::class)->orderBy('created_at', 'desc')->where('is_msg_deleted', '0');
    }
}
