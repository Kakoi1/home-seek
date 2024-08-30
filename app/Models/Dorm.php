<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    protected $fillable = ['name', 'description', 'address', 'latitude', 'longitude', 'rooms_available', 'image', 'price', 'user_id', 'archive', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    protected $casts = [
        'image' => 'array',
    ];
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}

