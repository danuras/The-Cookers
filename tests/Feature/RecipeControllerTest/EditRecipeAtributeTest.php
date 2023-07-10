<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Tests\TestCase;

class EditRecipeAtributeTest extends TestCase
{
    /**@test */
    public function test_edit_recipe_atribute_success()
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

        Session::put('image_url_r', 'recipe_image.jpg');

        // Mengirimkan permintaan POST dengan data yang valid
        $response = $this->post('/recipes/edit-recipe/edit-recipe-atribute', [
            'name' => 'Recipe Name',
            'description' => 'Recipe description with more than 30 characters.',
            'portion' => 2,
            'cooking_time' => 30,
            'steps' => 'gulung\ngulung\ngulung',
            'ingredients' => 'fiesta\nchicken\nnugget',
            'video_url' => 'https://www.youtube.com/watch?v=pQrchxj2gC8'
        ]);

        // Memastikan status respons adalah 302 (redirect)
        $response->assertStatus(302);


        // Memastikan bahwa session telah disimpan dengan benar
        $this->assertNotNull(Session::get('has_ea'));
        $this->assertNotNull(Session::get('r_name'));
        $this->assertNotNull(Session::get('r_description'));
        $this->assertNotNull(Session::get('r_portion'));
        $this->assertNotNull(Session::get('r_cooking_time'));
        $this->assertNotNull(Session::get('r_steps'));
        $this->assertNotNull(Session::get('r_ingredients'));

        // Memastikan pengalihan ke rute yang tepat
        $response->assertRedirect(route('recipes.review-edit-recipe'));
    }
    public function test_edit_recipe_atribute_invalid_input()
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

        Session::put('image_url_r', 'recipe_image.jpg');

        // Mengirimkan permintaan POST dengan data yang valid
        $response = $this->post('/recipes/edit-recipe/edit-recipe-atribute', [
            'name' => '',
            'description' => '',
            'portion' => -2,
            'cooking_time' => 'abc',
            'video_url' => 'https://www.youtube.com/watch?v=pQrchxj2gC8'
        ]);
        // Memastikan respons kembali ke halaman sebelumnya (back)
        $response->assertRedirect();

        // Memastikan bahwa respons memiliki error validasi sesuai dengan input yang tidak valid
        $response->assertSessionHasErrors(['name', 'portion', 'cooking_time', 'description']);
    }
    /**@test */
    public function test_edit_recipe_atribute_unauthorized()
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

        Session::put('image_url_r', 'recipe_image.jpg');

        // Mengirimkan permintaan POST dengan data yang valid
        $response = $this->post('/recipes/edit-recipe/edit-recipe-atribute', [
            'name' => 'Recipe Name',
            'description' => 'Recipe description with more than 30 characters.',
            'portion' => 2,
            'video_url' => 'https://www.youtube.com/watch?v=pQrchxj2gC8',
            'cooking_time' => 30,
        ]);

        
        // Memeriksa bahwa response memiliki status 403 (Unauthorized)
        $response->assertStatus(403);
    }
    /**@test */
    public function test_edit_recipe_atribute_invalid_youtube_url()
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

        Session::put('image_url_r', 'recipe_image.jpg');

        // Mengirimkan permintaan POST dengan data yang valid
        $response = $this->post('/recipes/edit-recipe/edit-recipe-atribute', [
            'name' => 'Recipe Name',
            'description' => 'Recipe description with more than 30 characters.',
            'portion' => 2,
            'cooking_time' => 30,
            'steps' => 'gulung\ngulung\ngulung',
            'ingredients' => 'fiesta\nchicken\nnugget',
            'video_url' => '123'
        ]);


        // Memastikan respons kembali ke halaman sebelumnya (back)
        $response->assertRedirect();

        // Memastikan bahwa respons memiliki error validasi sesuai dengan input yang tidak valid
        $response->assertSessionHasErrors(['video_url']);  
    }
}