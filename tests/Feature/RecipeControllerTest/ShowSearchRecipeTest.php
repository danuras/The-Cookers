<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowSearchRecipeTest extends TestCase
{
    public function testShowSearchRecipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat data dummy untuk pengujian
        Recipe::factory()->count(25)->create();

        // Memanggil route
        $response = $this->get('/recipes/search-recipe/');

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
