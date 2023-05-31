<?php

namespace Database\Factories;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'images' => fake(),
            'recipe_id' => Recipe::factory(),
            'user_id' => User::factory(),
        ];
    }
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'value' => null,
            'recipe_id' => null,
            'user_id' => null,
        ]);
    }
}