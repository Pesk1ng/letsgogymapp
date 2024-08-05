<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'fullname' => 'Alassane Ousmane',
                'email' => 'alassaneousmane@gmail.com',
                'role' => 'admin',
                'fitness_center_id' => 1,
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Pesquidox AKODAZOUN',
                'email' => 'pesquilou@gmail.com',
                'role' => 'superadmin',
                'fitness_center_id' => 2,
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $adminUser = User::where('email', 'alassaneousmane@gmail.com')->first();
        $adminUser->assignRole('admin');

        $superAdminUser = User::where('email', 'pesquilou@gmail.com')->first();
        $superAdminUser->assignRole('superadmin');
    }
}
