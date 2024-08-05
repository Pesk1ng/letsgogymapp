<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashbox extends Model
{
    use HasFactory;

    protected $fillable = [
        'fitness_center_id',
        'user_id',
        'user_name',
        'total_sales_today',
        'description',
    ];

    public function fitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
