<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShowEditIngredientsAndStepsTest extends TestCase
{
    public function test_show_edit_ingredients_and_steps()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'login' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);

        // Memanggil method showEditIngredientsAndSteps()
        $response = $this->get(route('recipes.edit-recipe-ingredient-and-step'));

        // Memeriksa bahwa response memiliki status 200 (OK)
        $response->assertStatus(200);

        // Memeriksa bahwa tampilan yang diharapkan terkembalikan
        $response->assertViewIs('recipes.edit_recipe.edit_recipe_ingredients_and_steps');

        // Memeriksa bahwa data yang diharapkan ada di dalam view
        $response->assertViewHas('steps');
        $response->assertViewHas('ingredients');

        // Memeriksa bahwa data yang diambil dari model sesuai dengan yang diharapkan
        $recipe = Recipe::find(Session::get('recipe_id_r'));

        $this->assertEquals($recipe->steps(), $response->viewData('steps'));
        $this->assertEquals($recipe->ingredients(), $response->viewData('ingredients'));
    }
    public function test_show_edit_ingredients_and_steps_unauthorized()
    {
         // Membuat user baru 
         $user = User::factory()->create();
         $user2 = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'login' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user2->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);

        // Memanggil method showEditIngredientsAndSteps()
        $response = $this->get(route('recipes.edit-recipe-ingredient-and-step'));

        // Memeriksa bahwa response memiliki status 403 (Unauthorized)
        $response->assertStatus(403);
   }
    
}
