<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShowEditRecipeAtributeTest extends TestCase
{
    // Pengujian jika sesi 'image_url_r' ada
    public function test_show_edit_recipe_atribute_with_image_url_r()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);
        // Memasukkan nilai 'image_url_r' ke dalam sesi
        Session::put('image_url_r', 'path/to/image.jpg');

        // Mengakses rute /edit-recipe-atribute
        $response = $this->get('recipes/edit-recipe/edit-recipe-atribute');

        // Memastikan respons memiliki status 200 (OK)
        $response->assertStatus(200)
            // Memastikan respons menggunakan view yang benar
            ->assertViewIs('recipes.edit_recipe.edit_recipe_atribute')
            // Memastikan respons memiliki data 'image_url_r' dengan nilai yang sesuai
            ->assertViewHas('image_url_r', 'path/to/image.jpg');
    }

    // Pengujian jika sesi 'image_url_r' tidak ada
    public function test_show_edit_recipe_atribute_without_image_url_r()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);
        // Menghapus nilai 'image_url_r' dari sesi
        Session::forget('image_url_r');

        // Mengakses rute /edit-recipe-atribute
        $response = $this->get('recipes/edit-recipe/edit-recipe-atribute');

        // Memastikan respons memiliki status 200 (OK)
        $response->assertStatus(200)
            // Memastikan respons menggunakan view yang benar
            ->assertViewIs('recipes.edit_recipe.edit_image');
    }
    public function test_show_edit_recipe_atribute_unauthorized()
    {
        // Membuat user baru 
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user2->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);
        // Memasukkan nilai 'image_url_r' ke dalam sesi
        Session::put('image_url_r', 'path/to/image.jpg');

        // Mengakses rute /edit-recipe-atribute
        $response = $this->get('recipes/edit-recipe/edit-recipe-atribute');

        // Memastikan respons memiliki status 403 (Unauthorized)
        $response->assertStatus(403);
    }
}