<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    protected $fillable = ['user_id', 'dorm_id', 'rating', 'comments'];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }

    public function property()
    {
        return $this->belongsTo(Dorm::class); // Assuming Property is the model for dorms
    }
}

