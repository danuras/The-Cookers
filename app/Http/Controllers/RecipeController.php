<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GroupIngredient;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function showDetail($recipeId)
    {
        $recipe = Recipe::where('id', $recipeId)->first();
        $groups = GroupIngredient::where('recipe_id', $recipeId)->get();
        $groupIngredients = [];

        foreach ($groups as $group) {
            array_push(
                $groupIngredients, 
                Ingredient::select('id', 'value', 'group_ingredient_id')->where(
                    [
                        ['group_ingredient_id', $group->id],
                    ], 
                )->get(), 
            );
        }

        $steps = Step::select('id', 'value', 'images', 'recipe_id')->where('recipe_id', [$recipeId])->get();

        $data['groupIngredients'] = $groupIngredients;
        $data['recipe'] = $recipe;
        $data['steps'] = $steps;
        return view('recipe.detail_recipe', $data);
    }
}