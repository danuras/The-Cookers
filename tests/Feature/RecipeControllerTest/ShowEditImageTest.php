<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowEditImageTest extends TestCase
{
    /**
     * @test
     */
    public function test_show_edit_image()
    {

        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(
            [
                'user_id' => $user->id,
            ]
        );
        
        // Mengirimkan permintaan GET ke URL '/edit-image'
        $response = $this->get('recipes/edit-recipe/edit-image/'.$recipe->id);

        // Memastikan bahwa respons memiliki status kode 200
        $response->assertStatus(200);

        // Memastikan bahwa view yang digunakan adalah 'recipes.edit_recipe.edit_image'
        $response->assertViewIs('recipes.edit_recipe.edit_image');
    }
    /**
     * @test
     */
    public function test_show_edit_image_unauthorized()
    {

        // Membuat user baru untuk dihapus
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(
            [
                'user_id' => $user2->id,
            ]
        );
        
        // Mengirimkan permintaan GET ke URL '/edit-image'
        $response = $this->get('recipes/edit-recipe/edit-image/'.$recipe->id);

        // Memastikan bahwa respons memiliki status kode 403 (unauthorized)
        $response->assertStatus(403);
    }
}