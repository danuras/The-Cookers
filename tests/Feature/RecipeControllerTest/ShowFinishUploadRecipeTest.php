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
        // Buat resep palsu untuk pengujian
        Session::put('r_name', fake()->text(5));
        Session::put('r_description', fake()->text(15));
        Session::put('r_portion', fake()->numberBetween(0, 10));
        Session::put('r_cooking_time', fake()->numberBetween(0, 200));
        Session::put('r_steps', ['ngulang', 'ngulang', 'ngulang']);
        Session::put('r_ingredients', ['fiesta', 'chicken', 'nugget']);
        Session::put('image_url_r','recipe.jpg');
        // Mengirimkan permintaan GET ke rute yang sesuai
        $response = $this->get('recipes/upload-recipe/finish-upload-recipe');

        // Memastikan bahwa respons memiliki status 200 (OK)
        $response->assertStatus(200);

        // Memastikan data sesi dihapus
        $this->assertNull(Session::get('image_url_r'));
        $this->assertNull(Session::get('r_name'));
        $this->assertNull(Session::get('r_description'));
        $this->assertNull(Session::get('r_portion'));
        $this->assertNull(Session::get('r_cooking_time'));
        $this->assertNull(Session::get('r_steps'));
        $this->assertNull(Session::get('r_ingredients'));

        // Memastikan bahwa tampilan yang diharapkan (view) adalah 'recipes.upload_recipe.finish'
        $response->assertViewIs('recipes.upload_recipe.finish');
    }
    public function test_show_finish_upload_recipe_refresh()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Mengirimkan permintaan GET ke rute yang sesuai
        $response = $this->get('recipes/upload-recipe/finish-upload-recipe');

        // Memastikan bahwa respons memiliki status 200 (OK)
        $response->assertStatus(200);

        // Memastikan data sesi dihapus
        $this->assertNull(Session::get('image_url_r'));
        $this->assertNull(Session::get('r_name'));
        $this->assertNull(Session::get('r_description'));
        $this->assertNull(Session::get('r_portion'));
        $this->assertNull(Session::get('r_cooking_time'));
        $this->assertNull(Session::get('r_steps'));
        $this->assertNull(Session::get('r_ingredients'));

        // Memastikan bahwa tampilan yang diharapkan (view) adalah 'recipes.upload_recipe.finish'
        $response->assertViewIs('recipes.upload_recipe.finish');
    }
}