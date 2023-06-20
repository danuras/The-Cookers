<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\User;
use Tests\TestCase;

class DeleteIngredientTest extends TestCase
{
    /**
     * @test
     */
    public function test_delete_ingredient()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        
        $recipe = Recipe::factory()->create(['user_id'=>$user->id]);
        // Buat bahan palsu untuk pengujian
        $ingredient = Ingredient::factory()->create([
            'value' => 'lorem apalah',
            'recipe_id' => $recipe->id,
        ]);
        
        

        // Hapus bahan
        $response = $this->delete('/ingredients/delete/' . $ingredient->id);

        // Pastikan bahan berhasil dihapus dari database
        $response->assertRedirect();
        // Memastikan bahwa bahan telah dihapus dari database
        $this->assertDatabaseMissing('ingredients', [
            'id' => $ingredient->id,
            'recipe_id' => $recipe->id,
        ]);
    }
    /**
     * @test
     */
    public function test_delete_ingredient_unauthorized()
    {
        // Membuat user baru 
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        
        $recipe = Recipe::factory()->create(['user_id'=>$user2->id]);
        // Buat bahan palsu untuk pengujian
        $ingredient = Ingredient::factory()->create([
            'value' => 'lorem apalah',
            'recipe_id' => $recipe->id,
        ]);
        
        

        // Hapus bahan
        $response = $this->delete('/ingredients/delete/' . $ingredient->id);

        // Pastikan bahwa user tidak terotorisasi
        $response->assertStatus(403);
    }
}