<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verifications extends Model
{
    use HasFactory;

    protected $table = 'verifications'; // Specify the table name

    protected $fillable = [
        'user_id',
        'id_document',
        'business_permit',
        'status',
        'created_at',
    ];

    // Cast images to an array when retrieving from the database

    // Relationship: A verification request belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

