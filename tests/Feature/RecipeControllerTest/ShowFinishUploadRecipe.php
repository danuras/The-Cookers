<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowFinishUploadRecipe extends TestCase
{
    /**
     * @test
     */
    public function test_show_finish_upload_recipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Mengirimkan permintaan GET ke rute yang sesuai
        $response = $this->get('/recipes/upload/finish');

        // Memastikan bahwa respons memiliki status 200 (OK)
        $response->assertStatus(200);

        // Memastikan bahwa tampilan yang diharapkan (view) adalah 'recipes.upload_recipe.finish'
        $response->assertViewIs('recipes.upload_recipe.finish');
    }
}
