<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_id' => 'required|exists:customers,id',
            'quantity_sold' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);
        $customer = Customer::findOrFail($request->customer_id);

        // Ensure there is enough stock to make the sale
        if ($product->product_stock < $request->quantity_sold) {
            return redirect()->route('dashboard')->with('error', 'Ce produit ne dispose pas de stock : <a href="' . route('stocks.index') . '">Ajouter du stock</a>');
        }

        // Calculate the total amount
        $totalAmount = $request->quantity_sold * $product->product_price;

        // Create the product sale entry
        ProductSale::create([
            'product_id' => $request->product_id,
            'customer_id' => $request->customer_id,
            'customer_name' => $customer->fullname,
            'user_id' => $user->id,
            'user_name' => $user->fullname,
            'product_fitness_center_id' => $product->fitness_center_id,
            'user_fitness_center_id' => $user->fitness_center_id,
            'quantity_sold' => $request->quantity_sold,
            'total_amount' => $totalAmount,
        ]);

        // Update the product's stock quantity
        $product->decrement('product_stock', $request->quantity_sold);

        return redirect()->route('dashboard')->with('message', 'Le Produit a été vendu avec succès !');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductSale $productSale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSale $productSale)
    {
        //
    }
}
