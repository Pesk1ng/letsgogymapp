<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FitnessCentersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fitness_centers')->insert([
            [
                'name' => 'LGG - Abomey-Calavi',
                'location' => 'Abomey-Calavi en face de l\'uac',
                'email_address' => 'letsggogym4@gmail.com',
            ],
            [
                'name' => 'LGG - Fidjrosse',
                'location' => 'Fidjrosse fin pavé',
                'email_address' => 'letgogymfidjrosse@gmail.com',
            ]
        ]);
    }
}
