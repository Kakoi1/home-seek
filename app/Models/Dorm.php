<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    protected $fillable = ['name', 'description', 'address', 'latitude', 'longitude', 'image', 'price', 'price_day', 'user_id', 'archive', 'type'];

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
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }
    public function favoriteCount()
    {
        return $this->favoritedBy()->count();
    }
    public function views()
    {
        return $this->hasMany(PropertyView::class);
    }

    public function reviews()
    {
        return $this->hasMany(Reviews::class);
    }
}

