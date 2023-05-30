<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'image_url' => fake(),
            'video_url' => fake(),
            'portion' => fake()->numberBetween(0, 20),
            'cooking_time' => fake()->time(),
            'description' => fake()->text(),
            'country_id' => Country::factory(),
            'user_id' => User::factory(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => null,
            'image_url' => null,
            'portion' => null,
            'cooking_time' => null,
            'description' => null,
            'origin_id' => null,
            'category_id' => null,
        ]);
    }
}
