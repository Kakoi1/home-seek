<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtendRequest extends Model
{
    protected $fillable = ['form_id', 'new_end_date', 'status', 'term', 'status', 't_price', 'new_duration'];

    public function rentForm()
    {
        return $this->belongsTo(RentForm::class);
    }

}
