<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'customer_id',
        'customer_name',
        'user_id',
        'user_name',
        'contract_fitness_center_id',
        'user_fitness_center_id',
        'quantity_sold',
        'total_amount',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contractFitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class, 'contract_fitness_center_id');
    }

    public function userFitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class, 'user_fitness_center_id');
    }
}
