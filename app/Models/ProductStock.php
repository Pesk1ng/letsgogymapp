<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'quantity',
        'user_id',
        'stock_creator_name',
        'fitness_center_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class);
    }
}
