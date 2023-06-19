<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShowReviewEditTest extends TestCase
{
    public function testShowReviewEditRecipe()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
         
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        Session::put('recipe_id_r', $recipe->id);
        Session::put('has_ea', 'true');
        Session::put('image_url_r','recipe.jpg');

        // Mengakses rute review-edit-recipe
        $response = $this->get('recipes/edit-recipe/review-edit-recipe');

        // Memastikan respons berhasil dengan status 200
        $response->assertStatus(200);

        // Memastikan bahwa data dalam sesi disertakan dalam tampilan
        $recipe = Recipe::find($recipe->id);
        $response->assertViewHas('recipe', $recipe);
        $response->assertViewHas('ingredients', $recipe->ingredients());
        $response->assertViewHas('steps', $recipe->steps());
    }

    public function testShowReviewEditRecipe_NoDataInSession()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
         
         
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        Session::put('recipe_id_r', $recipe->id);
        // Mengakses rute review-edit-recipe tanpa adanya data dalam sesi
        $response = $this->get('recipes/edit-recipe/review-edit-recipe');

        // Memastikan respons ke halaman edit_image jika tidak ada data dalam sesi
        $response->assertViewIs('recipes.edit_recipe.edit_image');
    }

    public function testShowReviewEditRecipe_OnlyImageUrlInSession()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
         
         
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        Session::put('recipe_id_r', $recipe->id);
        // Menyiapkan data hanya untuk image_url_r dalam sesi
        $sessionData = [
            'image_url_r' => 'images/recipe/image_url/test_image.jpg',
        ];
        Session::put($sessionData);

        // Mengakses rute review-edit-recipe
        $response = $this->get('recipes/edit-recipe/review-edit-recipe');

        // Memastikan respons berhasil dengan status 200
        $response->assertStatus(200);

        
        // Memastikan respons ke halaman edit_recipe_atribute jika hanya ada data gambar di sesi
        $response->assertViewIs('recipes.edit_recipe.edit_recipe_atribute');

        // Memastikan bahwa data image_url_r dalam sesi disertakan dalam tampilan
        $response->assertViewHas('image_url_r', $sessionData['image_url_r']);
    }
    public function testShowReviewEditRecipeUnauthorized()
    {
         // Membuat user baru 
         $user = User::factory()->create();
         $user2 = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
         
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(
            [
                'user_id' => $user2->id,
            ]
        );
        Session::put('recipe_id_r', $recipe->id);
        Session::put('has_ea', 'true');
        Session::put('image_url_r','recipe.jpg');

        // Mengakses rute review-edit-recipe
        $response = $this->get('recipes/edit-recipe/review-edit-recipe');

        // Memastikan respons unauthorized dengan kode 403
        $response->assertStatus(403);
    }
}