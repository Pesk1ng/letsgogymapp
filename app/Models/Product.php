<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_price',
        'product_stock',
        'product_description',
        'product_create_by',
        'product_creator_name',
        'fitness_center_id',
        'product_category_id',
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'product_create_by');
    }

    public function fitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class, 'fitness_center_id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    // protected static function booted()
    // {
    //     static::deleting(function ($product) {
    //         if ($product->isDirty('product_create_by') && $product->product_create_by === null) {
    //             $admin = User::where('role', 'admin')->first();
    //             $product->product_create_by = $admin->id;
    //             $product->product_creator_name = $admin->fullname;
    //             $product->save();
    //         }

    //         if ($product->isDirty('product_category_id') && $product->product_category_id === null) {
    //             $defaultCategory = ProductCategory::where('category_name', 'Défaut')->first();
    //             $product->product_category_id = $defaultCategory->id;
    //             $product->save();
    //         }
    //     });
    // }

}
