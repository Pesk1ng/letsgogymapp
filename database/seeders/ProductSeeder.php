<?php

namespace Database\Seeders;

use App\Models\FitnessCenter;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assurez-vous que les utilisateurs, catégories, et centres de fitness existent
        $defaultUser = User::first(); // Obtenez le premier utilisateur ou ajustez selon vos besoins
        $defaultCategory = ProductCategory::first(); // Obtenez la première catégorie ou ajustez selon vos besoins
        $defaultFitnessCenter = FitnessCenter::first(); // Obtenez le premier centre de fitness ou ajustez selon vos besoins

        // Définissez les produits par défaut
        $products = [
            [
                'product_name' => 'Jus d\'ananas',
                'product_price' => 500,
                'product_stock' => 0,
                'product_description' => 'Jus naturel fait à base d\'ananas frais',
                'product_category_id' => $defaultCategory->id,
                'product_create_by' => $defaultUser->id,
                'product_creator_name' => $defaultUser->fullname,
                'fitness_center_id' => $defaultFitnessCenter->id,
            ],
            [
                'product_name' => 'Jus de tamarin',
                'product_price' => 500,
                'product_stock' => 0,
                'product_description' => 'Jus natuel fait à base de tamarin',
                'product_category_id' => $defaultCategory->id,
                'product_create_by' => $defaultUser->id,
                'product_creator_name' => $defaultUser->fullname,
                'fitness_center_id' => $defaultFitnessCenter->id,
            ],
            // Ajoutez d'autres produits par défaut ici
        ];

        // Insérez les produits dans la base de données
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
