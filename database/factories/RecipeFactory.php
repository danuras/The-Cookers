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
            'name' => fake()->text(50),
            'image_url' => fake()->text(),
            'video_url' => 'https://www.youtube.com/watch?v=pQrchxj2gC8',
            'portion' => fake()->numberBetween(0, 20),
            'cooking_time' => fake()->numberBetween(0, 100),
            'description' => fake()->text(),
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
