<?php

namespace App\Http\Controllers;

use App\Models\FitnessCenter;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = ProductStock::with('product', 'user', 'fitnessCenter');

        // If the user is not an admin or superadmin, filter by the user's fitness center
        if ($user->role !== 'admin' && $user->role !== 'superadmin') {
            $query->where('fitness_center_id', $user->fitness_center_id);
        }

        // Add search logic
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('product', function($query) use ($search) {
                $query->where('product_name', 'like', '%' . $search . '%')
                      ->orWhere('product_description', 'like', '%' . $search . '%');
            });
        }

        // Pagination and sorting
        $stocks = $query->orderBy('created_at', 'desc')->paginate(15);

        $products = Product::with('category', 'creator', 'fitnessCenter')->orderBy('created_at', 'desc')->get();

        return view('shop.stocks.index', compact('stocks', 'products'));
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        ProductStock::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'user_id' => $user->id,
            'stock_creator_name' => $user->fullname,
            'fitness_center_id' => $product->fitness_center_id,
        ]);

        $product->increment('product_stock', $request->quantity);

        return redirect()->route('stocks.index')->with('message', 'Stock créé avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        // Only allow admins or superadmins to delete a stock entry
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('stocks.index')->with('error', 'Vous n\'avez les droits pour supprimer un stock.');
        }

        $stock = ProductStock::findOrFail($id);
        $product = $stock->product;

        // Decrement the product's stock quantity
        $product->decrement('product_stock', $stock->quantity);

        // Delete the stock entry
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock supprimé avec succès !');
    }
}
