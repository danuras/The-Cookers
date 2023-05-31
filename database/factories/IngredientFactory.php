<?php

namespace Database\Factories;

use App\Models\GroupIngredient;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
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
            'group_ingredient_id' => GroupIngredient::factory(),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => null,
            'group_ingredient_id' => null,
        ]);
    }
}
