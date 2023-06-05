<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SubmitRecipeTest extends TestCase
{
    /**@test */
    public function testSubmitRecipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Menyiapkan data dalam sesi
        $sessionData = [
            'name_r' => 'Recipe Name',
            'description_r' => 'Recipe Description',
            'portion_r' => 4,
            'cooking_time_r' => 30,
            'image_url_r' => 'images/recipe/image_url/test_image.jpg',
        ];
        Session::put($sessionData);

        // Mengakses rute submit-recipe dengan metode POST
        $response = $this->post('recipes/submit-recipe');

        // Memastikan respons berhasil dengan status 200
        $response->assertStatus(200);

        // Memastikan bahwa resep telah disimpan dalam database
        $this->assertDatabaseHas('recipes', [
            'name' => $sessionData['name_r'],
            'description' => $sessionData['description_r'],
            'portion' => $sessionData['portion_r'],
            'cooking_time' => $sessionData['cooking_time_r'],
            'image_url' => $sessionData['image_url_r'],
        ]);

        // Memastikan bahwa data dalam sesi telah dihapus setelah disubmit
        $this->assertNull(Session::get('name_r'));
        $this->assertNull(Session::get('description_r'));
        $this->assertNull(Session::get('portion_r'));
        $this->assertNull(Session::get('cooking_time_r'));
        $this->assertNull(Session::get('image_url_r'));

        // Memastikan tampilan finish ditampilkan
        $response->assertViewIs('recipes.upload_recipe.finish');
    }
}