<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateIngredientTest extends TestCase
{
    /**@test */
    public function test_create_ingredient_successfull()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(['user_id'=>$user->id]);
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => 'Lorem ipsum dolor sit amet',
            'recipe_id'=>$recipe->id,
        ];

        // Simpan bahan
        $response = $this->post('ingredients/create', $data);

        // Pastikan bahan berhasil dibuat
        $response->assertRedirect();
        $this->assertDatabaseHas('ingredients', [
            'value' => $data['value'],
            'recipe_id' => $recipe->id,
        ]);
    }
    /**@test */
    public function test_create_ingredient_failed()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(['user_id'=>$user->id]);
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => '',
            'recipe_id'=>$recipe->id,
        ];

        // Simpan bahan
        $response = $this->post('ingredients/create', $data);

        // Pastikan bahan berhasil dibuat
        $response->assertRedirect();
        $this->assertDatabaseMissing('ingredients', [
            'value' => $data['value'],
            'recipe_id' => $recipe->id,
        ]);
        $response->assertSessionHasErrors(['value']);
    }
    /**@test */
    public function test_create_ingredient_unauthorized()
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
        $recipe = Recipe::factory()->create(['user_id'=>$user2->id]);
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => 'Lorem ipsum dolor sit amet',
            'recipe_id'=>$recipe->id,
        ];

        // Simpan bahan
        $response = $this->post('ingredients/create', $data);

        // Pastikan bahwa user tidak terotorisasi
        $response->assertStatus(403);
    }
}