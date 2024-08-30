<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'dorm_id',
        'number',
        'capacity',
        'price',
        'description',
        'images',
        'status',
    ];

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
}
