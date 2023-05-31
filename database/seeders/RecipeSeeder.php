<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array_image = [
            'dami/ayam-bakar.jpg',
            'dami/ayam-goreng.jpg',
            'dami/bg_profil.jpg',
            'dami/brownies.jpg',
            'dami/burger.jpg',
            //5
            'dami/donat.jpg',
            'dami/ikan-bumbu.jpg',
            'dami/kue-lumpur.jpg',
            'dami/nasi-goreng.jpg',
            'dami/salad.jpg',
            //10
            'dami/salmon.jpg',
            'dami/spageti.jpg',
            'dami/tumis-tahu.jpg',
        ];
        $i = 0;
        for ($i = 0; $i < 10; $i++) {
            Recipe::factory()->create([
                'image_url' => $array_image[fake()->numberBetween(0, 13)],
            ]);
        }
    }
}