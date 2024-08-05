<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\FitnessCenter;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Assurez-vous qu'il y a des utilisateurs et des centres de fitness dans la base de données
        $user = User::first();
        $fitnessCenters = FitnessCenter::all();

        if ($user && $fitnessCenters->count() > 0) {
            foreach ($fitnessCenters as $center) {
                for ($i = 0; $i < 2; $i++) {
                    Customer::create([
                        'unique_id' => strtoupper(Str::random(10)),
                        'fullname' => $faker->name,
                        'email' => $faker->unique()->safeEmail,
                        'avatar' => $faker->imageUrl(),
                        'phoneNumber' => $faker->unique()->phoneNumber,
                        'customer_create_by' => $user->id,
                        'customer_creator_name' => $user->fullname,
                        'fitness_center_id' => $center->id,
                    ]);
                }
            }
        }
    }
}
