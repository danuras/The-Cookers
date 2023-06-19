<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShowFinishEditRecipeTest extends TestCase
{
    public function test_show_finish_edit_recipe()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Mengirimkan permintaan GET ke rute yang sesuai
        $response = $this->get('recipes/edit-recipe/finish-edit-recipe');

        // Memastikan bahwa respons memiliki status 200 (OK)
        $response->assertStatus(200);

        // Memastikan data sesi dihapus
        $this->assertNull(Session::get('image_url_r'));
        $this->assertNull(Session::get('recipe_id_r'));

        // Memastikan bahwa tampilan yang diharapkan (view) adalah 'recipes.edit_recipe.finish'
        $response->assertViewIs('recipes.edit_recipe.finish');


    }
}
