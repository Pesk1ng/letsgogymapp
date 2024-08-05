<?php

use App\Http\Controllers\CashboxController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ContractSaleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FitnessCenterController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSaleController;
use App\Http\Controllers\ProductStockController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::resource('centers', FitnessCenterController::class)->middleware(['auth']);
Route::resource('users', UserController::class)->middleware(['auth']);
Route::resource('contracts', ContractController::class)->middleware(['auth']);
Route::resource('customers', CustomerController::class)->middleware(['auth']);
Route::resource('categories', ProductCategoryController::class)->middleware(['auth']);
Route::resource('products', ProductController::class)->middleware(['auth']);
Route::resource('stocks', ProductStockController::class)->middleware(['auth']);
Route::resource('cashbox', CashboxController::class)->middleware(['auth']);

Route::resource('product_sales', ProductSaleController::class)->only([
    'store', 'update', 'destroy'
])->middleware(['auth']);

Route::resource('contracts_sales', ContractSaleController::class)->only([
    'store', 'update', 'destroy'
])->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});


require __DIR__.'/auth.php';