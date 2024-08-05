<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'fullname',
        'email',
        'avatar',
        'phoneNumber',
        'customer_create_by',
        'customer_creator_name',
        'fitness_center_id',
    ];

    /**
     * Get the user who created the customer.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'customer_create_by');
    }

    public function fitnessCenter()
    {
        return $this->belongsTo(FitnessCenter::class);
    }
}
