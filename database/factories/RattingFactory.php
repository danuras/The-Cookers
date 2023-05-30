<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ratting>
 */
class RattingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value'=>  fake()->numberBetween(0, 5),
            'recipe_id' => Recipe::factory(),
            'user_id' => User::factory(),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => null,
            'recipe_id' => null,
            'user_id' => null,
        ]);
    }
}
