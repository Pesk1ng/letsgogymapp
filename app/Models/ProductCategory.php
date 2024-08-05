<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'category_name',
        'category_description',
        'customer_create_by',
        'customer_creator_name',
        'fitness_center_id',
    ];

    // protected static function booted()
    // {
    //     static::deleting(function ($category) {
    //         $defaultCategory = ProductCategory::where('category_name', 'Défaut')->first();
            
    //         if (!$defaultCategory) {
    //             $defaultCategory = ProductCategory::create([
    //                 'category_name' => 'Défaut',
    //                 'category_description' => 'Default category',
    //             ]);
    //         }

    //         // Reassign the products to the default category
    //         Product::where('product_category_id', $category->id)->update([
    //             'product_category_id' => $defaultCategory->id,
    //         ]);
    //     });
    // }


    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'customer_create_by');
    }

    public function fitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class, 'fitness_center_id');
    }
}
