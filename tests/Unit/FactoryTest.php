<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Country;
use App\Models\Favorite;
use App\Models\GroupIngredient;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use App\Models\Ratting;
use Tests\TestCase;


class FactoryTest extends TestCase
{
    public function test_factory_creates_user()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }
    public function test_factory_creates_country()
    {
        $country = Country::factory()->create();

        $this->assertDatabaseHas('countries', [
            'name' => $country->name,
        ]);
    }
    public function test_factory_creates_recipe()
    {
        $recipe = Recipe::factory()->create(
            [
                'image_url' => 'dami/ayam-bakar.jpg',
            ]
        );

        $this->assertDatabaseHas('recipes', [
            'name' => $recipe->name,
            'image_url' => $recipe->image_url,
            'video_url' => $recipe->video_url,
            'portion' => $recipe->portion,
            'description' => $recipe->description,
            'country_id' => $recipe->country_id,
            'user_id' => $recipe->user_id,
            'cooking_time' => $recipe->cooking_time,
        ]);
    }
    public function test_factory_creates_step()
    {
        $step = Step::factory()->create([
            'images' => json_encode([
                'dami/ayam-goreng.jpg',
                'dami/brownies.jpg',
            ]),
        ]);

        $this->assertDatabaseHas('steps', [
            'value' => $step->value,
            'images' => $step->images,
            'recipe_id' => $step->recipe_id,
        ]);
    }
    public function test_factory_creates_group_ingredient()
    {
        $groupIngredient = GroupIngredient::factory()->create();

        $this->assertDatabaseHas('group_ingredients', [
            'value' => $groupIngredient->value,
            'recipe_id' => $groupIngredient->recipe_id,
        ]);
    }
    public function test_factory_creates_ingredient()
    {
        $Ingredient = Ingredient::factory()->create();

        $this->assertDatabaseHas('ingredients', [
            'value' => $Ingredient->value,
            'group_ingredient_id' => $Ingredient->group_ingredient_id,
        ]);
    }

    public function test_factory_creates_comment()
    {
        $comment = Comment::factory()->create([
            'images' => json_encode([
                'dami/ayam-goreng.jpg',
                'dami/brownies.jpg',
            ]),
        ]);

        $this->assertDatabaseHas('comments', [
            'value' => $comment->value,
            'images' => $comment->images,
            'recipe_id' => $comment->recipe_id,
            'user_id' => $comment->user_id,
        ]);
    }
    public function test_factory_creates_ratting()
    {
        $ratting = Ratting::factory()->create();

        $this->assertDatabaseHas('rattings', [
            'value' => $ratting->value,
            'recipe_id' => $ratting->recipe_id,
            'user_id' => $ratting->user_id,
        ]);
    }
    public function test_factory_creates_favorite()
    {
        $favorite = Favorite::factory()->create();

        $this->assertDatabaseHas('favorites', [
            'recipe_id' => $favorite->recipe_id,
            'user_id' => $favorite->user_id,
        ]);
    } 
}