<?php

namespace App\Policies;

use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;

class StepPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    /**
     * Mengecek apakah user yang ter otentikasi memiliki akses untuk melakukan perubahan/penghapusan ke nilai langkah
     */
    public function admin(User $user, Step $step)
    {
        $recipe = Recipe::find($step->recipe_id);
        return $user->id === $recipe->user_id;
    }
    public function create(User $user, $recipe_id)
    {
        $recipe = Recipe::find($recipe_id);
        return $user->id === $recipe->user_id;
    }
}
