<?php

namespace App\Policies;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;

class IngredientPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Mengecek apakah user yang ter otentikasi memiliki akses untuk melakukan perubahan/penghapusan ke nilai bahan
     */
    public function admin(User $user, Ingredient $ingredient)
    {
        $recipe = Recipe::find($ingredient->recipe_id);
        return $user->id === $recipe->user_id;
    }
    public function create(User $user, $recipe_id)
    {
        $recipe = Recipe::find($recipe_id);
        return $user->id === $recipe->user_id;
    }

}
