<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GroupIngredient;
use App\Models\Ingredient;
use App\Models\Ratting;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    /**
     * Mengambil data resep, bahan-bahan resep, langkah-langkah resep, komentar-komentar resep, dan rata-rata rattingnya
     */
    public function showDetail(Recipe $recipe)
    {
        $groups = GroupIngredient::where('recipe_id', $recipe->id)->get();
        $groupIngredients = [];

        foreach ($groups as $group) {
            array_push(
                $groupIngredients, 
                $group->ingredients, 
            );
        }

        $data['groupIngredients'] = $groupIngredients;
        $data['recipe'] = $recipe;
        $data['steps'] = $recipe->steps;
        $data['comments'] = $recipe->comments;
        $data['avg_ratting'] = $recipe->averageRatting();
        return view('recipe.detail_recipe', $data);
    }
}