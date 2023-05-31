<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupIngredient extends Model
{
    use HasFactory;
    
    public function ingrdients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
