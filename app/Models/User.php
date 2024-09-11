<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone',
        'address',
        'dob',
        'gender',
        'profile_picture',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function dorms()
    {
        return $this->hasMany(Dorm::class);
    }

    public function isPartOfDormChatRoom($chat_id)
    {
        // Assuming you have a many-to-many relationship with DormChatRoom
        return $this->dormChatRooms()->where('id', $chat_id)->exists();
    }

    /**
     * Check if the user is part of a general chat room.
     *
     * @param int $chat_id
     * @return bool
     */
    public function isPartOfRoomChatRoom($chat_id)
    {
        // Assuming you have a many-to-many relationship with RoomChatRoom
        return $this->roomChatRooms()->where('id', $chat_id)->exists();
    }

    /**
     * Define the many-to-many relationship with DormChatRoom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dormChatRooms()
    {
        return $this->belongsToMany(ChatRoom::class);
    }

    /**
     * Define the many-to-many relationship with RoomChatRoom.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roomChatRooms()
    {
        return $this->belongsToMany(RoomChat::class);
    }
}

