<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowUserRecipeTest extends TestCase
{
    public function testShowUserRecipe()
    {
        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);


        // Membuat beberapa resep palsu untuk pengguna
        $recipes = Recipe::factory()->count(10)->create([
            'user_id' => $user->id,
        ]);

        // Memanggil metode showUserRecipe()
        $response = $this->get('recipes/user-recipe');

        // Memastikan respons berhasil
        $response->assertStatus(200);

        // Memastikan tampilan yang benar digunakan
        $response->assertViewIs('recipes.user_recipe');

        // Memastikan data resep diteruskan ke tampilan
        $response->assertViewHas('recipes');

        // Memastikan bahwa data 'recipes' berisi instance dari Paginator
        $recipes = $response->viewData('recipes');
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $recipes);

        // Memastikan bahwa jumlah data 'recipes' yang ditampilkan adalah 10
        $this->assertCount(10, $recipes->items());
    }
}
