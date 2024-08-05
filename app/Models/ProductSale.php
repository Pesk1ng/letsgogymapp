<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'product_id',
        'customer_id',
        'customer_name',
        'user_id',
        'user_name',
        'product_fitness_center_id',
        'user_fitness_center_id',
        'quantity_sold',
        'total_amount',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productFitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class, 'product_fitness_center_id');
    }

    public function userFitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class, 'user_fitness_center_id');
    }
}
