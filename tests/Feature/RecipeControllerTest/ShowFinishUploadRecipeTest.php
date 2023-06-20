<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShowFinishUploadRecipeTest extends TestCase
{
    public function test_show_finish_upload_recipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Mengirimkan permintaan GET ke rute yang sesuai
        $response = $this->get('recipes/finish-upload-recipe');

        // Memastikan bahwa respons memiliki status 200 (OK)
        $response->assertStatus(200);

        // Memastikan data sesi dihapus
        $this->assertNull(Session::get('image_url_r'));
        $this->assertNull(Session::get('recipe_id_r'));

        // Memastikan bahwa tampilan yang diharapkan (view) adalah 'recipes.upload_recipe.finish'
        $response->assertViewIs('recipes.upload_recipe.finish');


    }
}
