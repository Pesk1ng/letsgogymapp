<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ProductCategory::with('creator', 'fitnessCenter')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('shop.categories.index', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_name' => ['required', 'unique:product_categories,category_name', 'string', 'max:30'],
            'category_description' => ['required', 'string', 'max:200'],
        ]);

        $user = Auth::user();

        ProductCategory::create([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description,
            'customer_create_by' => $user->id,
            'customer_creator_name' => $user->fullname,
            'fitness_center_id' => $user->fitness_center_id,
        ]);

        return redirect()->route('categories.index')->with('message', 'Catégorie créée avec succès !');
    }

    public function update(Request $request, $productCategoryID)
    {
        
        $productCategory = ProductCategory::findOrFail($productCategoryID);

        $request->validate([
            'category_name' => 'required|string|max:30|unique:product_categories,category_name,' . $productCategory->id,
            'category_description' => 'required|string|max:200',
        ]);

        $productCategory->update([
            'category_name' => $request->input('category_name'),
            'category_description' => $request->input('category_description'),
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

 
    public function destroy($id)
    {
        $productCategory = ProductCategory::findOrFail($id);

        // Reassign products to the default category before deleting
        $defaultCategory = ProductCategory::firstOrCreate(
            ['category_name' => 'Défaut'],
            ['category_description' => 'Default category']
        );

        Product::where('product_category_id', $productCategory->id)->update([
            'product_category_id' => $defaultCategory->id,
        ]);

        $productCategory->delete();

        return redirect()->route('categories.index')->with('message', 'Catégorie supprimée avec succès !');
    }
}
