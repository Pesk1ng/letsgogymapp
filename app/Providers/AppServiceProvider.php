<?php

namespace App\Providers;

use App\Models\ProductCategory;
use App\Observers\ProductCategoryObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        ProductCategory::observe(ProductCategoryObserver::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
