<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    public function rattings()
    {
        return $this->hasMany(Ratting::class);
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function steps()
    {
        return $this->hasMany(Step::class);
    }
    public function group_ingredients()
    {
        return $this->hasMany(GroupIngredient::class);
    }
}
