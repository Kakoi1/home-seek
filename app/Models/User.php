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
        'fb_id',
        'google_id',
        'profile_picture',
        'active_status',
        'role',
        'strike',
        'note',
        'address',
        'email_verification_code',
        'email_verified_at',
        'stripe_account_id',
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

    public function favorites()
    {
        return $this->belongsToMany(Dorm::class, 'favorites')->withTimestamps();
    }


}

