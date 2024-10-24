<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dorm_id',
        'start_date',
        'end_date',
        'guest',
        'total_price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
    public function extendRequests()
    {
        return $this->hasMany(ExtendRequest::class);
    }
    public function tenant()
    {
        return $this->belongsTo(User::class, 'user_id');  // Assuming a tenant is a User
    }
}


