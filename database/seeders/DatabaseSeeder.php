<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Favorite;
use App\Models\GroupIngredient;
use App\Models\Ingredient;
use App\Models\Ratting;
use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Carbon\Carbon;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $mc = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'username' => 'bogeng',
            'email' => 'a@a',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);

        $array_image = collect([
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
        ]);
        for ($i = 0; $i < 50; $i++) {
            $recipe = Recipe::factory()->create([
                'image_url' => $array_image->random(),
                'user_id' => $mc->id,
            ]);
            for ($k = 0; $k < mt_rand(1, 5); $k++) {
                Step::factory()->create([
                    'images' => json_encode([
                        $array_image->random(),
                        $array_image->random(),
                        $array_image->random(),
                    ]),
                    'recipe_id' => $recipe->id,

                ]);
            }

            for ($k = 0; $k < mt_rand(1, 5); $k++) {
                Ingredient::factory()->create([
                    'recipe_id' => $recipe->id,
                ]);
            }
            for ($k = 0; $k < mt_rand(1, 5); $k++) {
                Ingredient::factory()->create([
                    'recipe_id' => $recipe->id,
                ]);
            }
        }
        $i = 0;
        $j = 0;
        $k = 0;
        $num_of_recipe = 0;

        for ($i = 0; $i < 10; $i++) {
            $user = User::factory()->create();
            for ($j = 0; $j < mt_rand(1, 10); $j++) {
                $recipe = Recipe::factory()->create([
                    'image_url' => $array_image->random(),
                    'user_id' => $user->id,
                ]);
                $num_of_recipe += 1;

                for ($k = 0; $k < mt_rand(1, 5); $k++) {
                    Step::factory()->create([
                        'images' => json_encode([
                            $array_image->random(),
                            $array_image->random(),
                            $array_image->random(),
                        ]),
                        'recipe_id' => $recipe->id,

                    ]);
                }

                for ($k = 0; $k < mt_rand(1, 5); $k++) {
                    Ingredient::factory()->create([
                        'recipe_id' => $recipe->id,
                    ]);
                }
                for ($k = 0; $k < mt_rand(1, 5); $k++) {
                    Ingredient::factory()->create([
                        'recipe_id' => $recipe->id,
                    ]);
                }
            }
        }
        $last_user = User::orderBy('id', 'Desc')->first();
        $last_recipe = Recipe::orderBy('id', 'Desc')->first();
        for ($i = 0; $i < $num_of_recipe * (mt_rand(1, 10)); $i++) {
            $user_id = mt_rand($last_user->id - 9, $last_user->id);
            $recipe_id = mt_rand($last_recipe->id - $num_of_recipe + 1, $last_recipe->id, );
            $check = Favorite::where([['user_id', $user_id], ['recipe_id', $recipe_id],])->get();
            if ($check->isEmpty()) {
                Favorite::factory()->create([
                    'recipe_id' => $recipe_id,
                    'user_id' => $user_id,
                ]);
            } else {
                $i--;
            }
        }
        for ($i = 0; $i < $num_of_recipe * (mt_rand(1, 5)); $i++) {
            $user_id = mt_rand($last_user->id - 9, $last_user->id);
            $recipe_id = mt_rand($last_recipe->id - $num_of_recipe + 1, $last_recipe->id, );
            Comment::factory()->create([
                'images' => json_encode([
                    $array_image->random(),
                    $array_image->random(),
                    $array_image->random(),
                ]),
                'recipe_id' => $recipe_id,
                'user_id' => $user_id,
            ]);
        }
        for ($i = 0; $i < $num_of_recipe * (mt_rand(1, 5)); $i++) {
            $user_id = mt_rand($last_user->id - 9, $last_user->id);
            $recipe_id = mt_rand($last_recipe->id - $num_of_recipe + 1, $last_recipe->id, );
            $check = Ratting::where([['user_id', $user_id], ['recipe_id', $recipe_id],])->get();
            if ($check->isEmpty()) {
                Ratting::factory()->create([
                    'recipe_id' => $recipe_id,
                    'user_id' => $user_id,
                ]);
            } else {
                $i--;
            }
        }
    }
}