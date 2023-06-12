<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\User;

class RecipePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Mengecek user terotentikasi memiliki akses untuk melakukan aksi
     */
    public function admin(User $user, Recipe $recipe){
        return $recipe->user_id === $user->id;
    }

}
