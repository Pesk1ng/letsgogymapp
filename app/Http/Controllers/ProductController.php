<?php

namespace App\Http\Controllers;

use App\Models\FitnessCenter;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Product::with('category', 'creator', 'fitnessCenter');

        // Si l'utilisateur n'est pas un admin ou un superadmin, filtrer par centre de fitness
        if ($user->role !== 'admin' && $user->role !== 'superadmin') {
            $query->where('fitness_center_id', $user->fitness_center_id);
        }

        // Ajouter la logique de recherche
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($query) use ($search) {
                $query->where('product_name', 'like', '%' . $search . '%')
                      ->orWhere('product_description', 'like', '%' . $search . '%');
            });
        }

        // Pagination et tri des résultats
        $products = $query->orderBy('created_at', 'desc')->paginate(15);

        $productCategories = ProductCategory::all();
        
        if(in_array($user->role, ['admin', 'superadmin'])){
            $centers = FitnessCenter::all();
        }else{$centers = null;}
        

        return view('shop.index', compact('products','productCategories','centers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:35',
            'product_price' => 'required|numeric|min:0',
            'product_stock' => 'nullable|numeric|min:0',
            'product_description' => 'required|string|max:250',
            'product_category_id' => 'required|exists:product_categories,id',
            'fitness_center_id' => 'exists:fitness_centers,id',
        ]);

        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Déterminer le fitness_center_id en fonction du rôle de l'utilisateur
        $fitnessCenterId = ($user->role === 'admin' || $user->role === 'superadmin') 
            ? $request->fitness_center_id 
            : $user->fitness_center_id;

        // Créer le produit
        Product::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_stock' => $request->product_stock,
            'product_description' => $request->product_description,
            'product_category_id' => $request->product_category_id,
            'product_create_by' => $user->id,
            'product_creator_name' => $user->fullname,
            'fitness_center_id' => $fitnessCenterId,
        ]);

        return redirect()->route('products.index')->with('message', 'Produit créé avec succès !');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required|string|max:35',
            'product_price' => 'required|numeric|min:0',
            'product_stock' => 'nullable|numeric|min:0',
            'product_description' => 'required|string|max:250',
            'product_category_id' => 'required|exists:product_categories,id',
            'fitness_center_id' => 'exists:fitness_centers,id',
        ]);

        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Déterminer le fitness_center_id en fonction du rôle de l'utilisateur
        $fitnessCenterId = ($user->role === 'admin' || $user->role === 'superadmin') 
            ? $request->fitness_center_id 
            : $user->fitness_center_id;

        // Mettre à jour le produit
        $product->update([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_stock' => $request->product_stock,
            'product_description' => $request->product_description,
            'product_category_id' => $request->product_category_id,
            'fitness_center_id' => $fitnessCenterId,
        ]);

        return redirect()->route('products.index')->with('message', 'Produit mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $user = Auth::user();

        // Vérifier si l'utilisateur est un admin ou un superadmin
        if (!in_array($user->role, ['admin', 'superadmin', 'manager'])) {
            return redirect()->route('customers.index')
                             ->with('error', 'Vous n\'êtes pas autorisé à supprimer des produits.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('message', 'produit supprimé avec succès !');
    }
}
