<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creator = User::find(1);

        if($creator){
            Contract::create([
                'contract_name' => 'Abonnement Particulier',
                'contract_code' => 'LGG123',
                'contract_duration' => 12, // 12 jours
                'fitness_center_id' => 1,
                'contract_create_by' => $creator->id, // Assurez-vous que cet utilisateur existe
                'contract_creator_name' => $creator->fullname,
                'contract_amount' => 500,
            ]);
        }
    }
}
