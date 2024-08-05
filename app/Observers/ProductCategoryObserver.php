<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\ProductCategory;

class ProductCategoryObserver
{
    /**
     * Handle the ProductCategory "deleting" event.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return void
     */
    public function deleting(ProductCategory $productCategory)
    {
        $defaultCategory = ProductCategory::where('category_name', 'Tous les produits')->firstOrFail();

        // Update products to the default category before deleting the original category
        Product::where('category_id', $productCategory->id)
                ->update(['category_id' => $defaultCategory->id]);
    }
}
