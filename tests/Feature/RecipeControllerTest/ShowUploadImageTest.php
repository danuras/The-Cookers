<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowUploadImageTest extends TestCase
{
    /**
     * @test
     */
    public function test_show_upload_image()
    {

        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Mengirimkan permintaan GET ke URL '/upload-image'
        $response = $this->get('recipes/upload-recipe/upload-image');

        // Memastikan bahwa respons memiliki status kode 200
        $response->assertStatus(200);

        // Memastikan bahwa view yang digunakan adalah 'recipes.upload_recipe.upload_image'
        $response->assertViewIs('recipes.upload_recipe.upload_image');
    }
}