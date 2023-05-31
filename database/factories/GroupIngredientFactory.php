<?php

namespace Database\Factories;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GroupIngredient>
 */
class GroupIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => fake()->text(20),
            'recipe_id' => Recipe::factory(),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => null,
            'recipe_id' => null,
        ]);
    }
}
