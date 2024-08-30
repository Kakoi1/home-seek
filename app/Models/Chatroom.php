<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    protected $fillable = ['dorm_id', 'user_id', 'message_id'];

    public function messages()
    {
        return $this->hasMany(Message::class, 'room_id');
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

