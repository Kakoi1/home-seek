<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    protected $fillable = ['name', 'description', 'address', 'latitude', 'longitude', 'image', 'price', 'capacity', 'beds', 'bedroom', 'user_id', 'archive', 'availability', 'flag'];

    public function user()
    {
        return $this->belongsTo(User::class);
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
    public function favourites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'dorm_id', 'user_id');
    }
    public function tenants()
    {
        return $this->hasMany(RentForm::class);  // Adjust if tenants are stored differently
    }
}

