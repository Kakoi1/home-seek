<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Notification extends Model
{
    protected $fillable = ['user_id', 'type', 'data', 'read', 'route', 'dorm_id', 'sender_id', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}

