<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UpdateIngredientTest extends TestCase
{
    /**@test */
    public function test_update_ingredient_successfull()
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
            'value' => 'Lorem ipsum dolor sit amut',
            'recipe_id' =>$recipe->id,
        ];

        // Buat ingredient palsu untuk pengujian
        $ingredient = 
        Ingredient::factory()->create([
            'recipe_id' => $recipe->id,
        ]);

        // Simpan perubahan langkah
        $response = $this->put('/ingredients/update/'.$ingredient->id, $data);

        // Pastikan perubahan langkah berhasil disimpan
        $response->assertRedirect();
        $this->assertDatabaseHas('ingredients', [
            'value' => $data['value'],
            'recipe_id' => $recipe->id,
        ]);
    }
    /**@test */
    public function test_update_ingredient_failed()
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
            'recipe_id' =>$recipe->id,
        ];

        // Buat ingredient palsu untuk pengujian
        $ingredient = 
        Ingredient::factory()->create([
            'recipe_id' => $recipe->id,

        ]);
        // Simpan langkah
        $response = $this->put('ingredients/update/'.$ingredient->id, $data);

        // Pastikan ada error value
        $response->assertSessionHasErrors(['value']);
    }
    /**@test */
    public function test_update_ingredient_unauthorized()
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
            'value' => 'Lorem ipsum dolor sit amut',
            'recipe_id' =>$recipe->id,
        ];

        // Buat ingredient palsu untuk pengujian
        $ingredient = 
        Ingredient::factory()->create([
            'recipe_id' => $recipe->id,
        ]);

        // Simpan perubahan langkah
        $response = $this->put('/ingredients/update/'.$ingredient->id, $data);

        // Pastikan bahwa user tidak terotorisasi
        $response->assertStatus(403);
    }
}
