<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'dorm_id',
        'start_date',
        'duration',
        'status',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
}

