<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['dorm_id', 'user_id', 'message', 'room_id', 'rooms_id', 'chat_id', 'is_read'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class, 'dorm_id');
    }

    public function chatroom()
    {
        return $this->belongsTo(Chatroom::class, 'room_id');
    }
    public function rooms()
    {
        return $this->belongsTo(Room::class, 'rooms_id');
    }

    public function roomchats()
    {
        return $this->belongsTo(Roomchat::class, 'chat_id');
    }
}



