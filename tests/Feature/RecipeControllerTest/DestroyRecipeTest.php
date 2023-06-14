<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyRecipeTest extends TestCase
{
    /** @test */
    public function authenticated_user_can_delete_recipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat resep palsu
        $recipe = Recipe::factory()->create(['user_id'=>$user->id]);

        // Mengirim permintaan penghapusan resep sebagai pengguna terotentikasi
        $response = $this->delete('/recipes/'. $recipe->id);

        // Memastikan bahwa permintaan berhasil dan mengarahkan kembali
        $response->assertStatus(302);

        // Memastikan bahwa resep telah dihapus dari database
        $this->assertDatabaseMissing('recipes', ['id' => $recipe->id]);
    }

    /** @test */
    public function unauthenticated_user_cannot_delete_recipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat resep palsu
        $recipe = Recipe::factory()->create(['user_id'=>$user2->id]);

        // Mengirim permintaan penghapusan resep sebagai pengguna terotentikasi
        $response = $this->delete('/recipes/'. $recipe->id);

        // Memastikan bahwa user tidak terotorisasi
        $response->assertStatus(403);
    }
}
