<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowSearchRecipeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testShowSearchRecipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Menjalankan permintaan GET ke rute yang sesuai
        $response = $this->get('/recipes/page/search-recipe');

        // Memeriksa bahwa responsenya berhasil (kode status 200)
        $response->assertStatus(200);

        // Memeriksa bahwa tampilan yang diharapkan digunakan
        $response->assertViewIs('recipes.search_recipe');
    }
    public function testShowSearchRecipePopular()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat data dummy untuk pengujian
        Recipe::factory()->count(25)->create();

        // Memanggil metode dengan parameter 'popular'
        $response = $this->get('/recipes/search-recipe/page/popular');

        // Memastikan bahwa respons statusnya adalah 200 (OK)
        $response->assertStatus(200);

        // Memastikan bahwa view yang digunakan adalah 'recipes.search_recipe'
        $response->assertViewIs('recipes.search_recipe');

        // Memastikan bahwa data 'recipes' dikirim ke view
        $response->assertViewHas('recipes');

        // Memastikan bahwa data 'recipes' berisi instance dari Paginator
        $recipes = $response->viewData('recipes');
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $response->viewData('recipes'));


        // Memastikan bahwa jumlah data 'recipes' yang ditampilkan adalah 25
        $this->assertCount(25, $recipes->items());
    }

    public function testShowSearchRecipeNewest()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat data dummy untuk pengujian
        Recipe::factory()->count(25)->create();

        // Memanggil metode dengan parameter 'newest'
        $response = $this->get('/recipes/search-recipe/page/newest');

        // Memastikan bahwa respons statusnya adalah 200 (OK)
        $response->assertStatus(200);

        // Memastikan bahwa view yang digunakan adalah 'recipes.search_recipe'
        $response->assertViewIs('recipes.search_recipe');

        // Memastikan bahwa data 'recipes' dikirim ke view
        $response->assertViewHas('recipes');

        // Memastikan bahwa data 'recipes' berisi instance dari Paginator
        $recipes = $response->viewData('recipes');
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $recipes);

        // Memastikan bahwa jumlah data 'recipes' yang ditampilkan adalah 25
        $this->assertCount(25, $recipes->items());
    }
}
