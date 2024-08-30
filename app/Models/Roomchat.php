<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roomchat extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'other_user_id', 'room_id', 'message_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function otherUser()
    {
        return $this->belongsTo(User::class, 'other_user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'room_id');
    }
}

