<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Tests\TestCase;

class UploadRecipeAtributeTest extends TestCase
{
    /**@test */
    public function test_upload_recipe_atribute_success()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        Session::put('image_url_r', 'recipe_image.jpg');

        // Mengirimkan permintaan POST dengan data yang valid
        $response = $this->post('/recipes/upload-recipe/upload-recipe-atribute', [
            'name' => 'Recipe Name',
            'description' => 'Recipe description with more than 30 characters.',
            'portion' => 2,
            'cooking_time' => 30,
            'steps' => 'gulung\ngulung\ngulung',
            'ingredients' => 'fiesta\nchicken\nnugget',
        ]);

        // Memastikan status respons adalah 302 (redirect)
        $response->assertStatus(302);

        // Memastikan bahwa session telah disimpan dengan benar
        $this->assertNotNull(Session::get('r_name'));
        $this->assertNotNull(Session::get('r_description'));
        $this->assertNotNull(Session::get('r_portion'));
        $this->assertNotNull(Session::get('r_cooking_time'));
        $this->assertNotNull(Session::get('r_steps'));
        $this->assertNotNull(Session::get('r_ingredients'));

        // Memastikan pengalihan ke rute yang tepat
        $response->assertRedirect(route('recipes.review-upload-recipe'));
    }
    public function test_upload_recipe_atribute_invalid_input()
    {
         // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        Session::put('image_url_r', 'recipe_image.jpg');

        // Mengirimkan permintaan POST dengan data yang valid
        $response = $this->post('/recipes/upload-recipe/upload-recipe-atribute', [
            'name' => '',
            'description' => '',
            'portion' => -2,
            'cooking_time' => 'abc',
        ]);
        // Memastikan respons kembali ke halaman sebelumnya (back)
        $response->assertRedirect();

        // Memastikan bahwa respons memiliki error validasi sesuai dengan input yang tidak valid
        $response->assertSessionHasErrors(['name', 'portion', 'cooking_time', 'description']);
    }
}