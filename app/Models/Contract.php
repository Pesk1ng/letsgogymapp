<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_name',
        'contract_code',
        'contract_duration',
        'fitness_center_id',
        'contract_create_by',
        'contract_creator_name',
        'contract_amount',
    ];

    /**
     * Get the user who created the contract.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'contract_create_by');
    }

    public function fitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class);
    }
}
