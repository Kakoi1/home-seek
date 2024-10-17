<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'user_id',
        'rent_form_id',
        'amount',
        'billing_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rentForm()
    {
        return $this->belongsTo(RentForm::class);
    }

}
