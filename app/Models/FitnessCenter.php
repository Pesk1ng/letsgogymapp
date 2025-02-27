<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FitnessCenter extends Model
{
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
