<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Assurez-vous qu'un utilisateur existe
        $fitnessCenterId = 1; // Assurez-vous que ce centre de fitness existe

        $categories = [
            [
                'category_name' => 'Défaut',
                'category_description' => 'Tous les produits n\'ayant pas de catégorie.',
                'customer_create_by' => $user->id,
                'customer_creator_name' => $user->fullname,
                'fitness_center_id' => $fitnessCenterId,
            ],
            [
                'category_name' => 'Fruits',
                'category_description' => 'Tous les produits à base de fruits.',
                'customer_create_by' => $user->id,
                'customer_creator_name' => $user->fullname,
                'fitness_center_id' => $fitnessCenterId,
            ],
            [
                'category_name' => 'Protéïnes',
                'category_description' => 'Tous les protéïnes et compléments ou suppléments alimentaires.',
                'customer_create_by' => $user->id,
                'customer_creator_name' => $user->fullname,
                'fitness_center_id' => $fitnessCenterId,
            ],
            [
                'category_name' => 'Accessoires Fitness',
                'category_description' => 'Tous les accesoires ou équipements fitness.',
                'customer_create_by' => $user->id,
                'customer_creator_name' => $user->fullname,
                'fitness_center_id' => $fitnessCenterId,
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}