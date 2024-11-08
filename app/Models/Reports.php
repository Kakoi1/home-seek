<?php
// app/Models/Report.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reported_id', 'dorm_id', 'reason', 'status', 'reported_type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
}
