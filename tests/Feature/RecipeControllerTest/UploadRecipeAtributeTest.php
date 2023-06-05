<?php

namespace Tests\Feature;

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
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Data input yang akan diuji
        $data = [
            'name' => 'Recipe Name',
            'description' => Str::random(31),
            'portion' => 4,
            'cooking_time' => 30,
        ];

        // Mengakses rute upload-recipe-atribute dengan metode POST dan mengirimkan data input
        $response = $this->post('recipes/upload-recipe-atribute', $data);

        // Memastikan respons melakukan redirect ke rute show-review-upload-recipe
        $response->assertRedirect(route('recipes.review-upload-recipe'));

        // Memastikan data input disimpan dengan benar dalam sesi
        $this->assertEquals($data['name'], Session::get('name_r'));
        $this->assertEquals($data['description'], Session::get('description_r'));
        $this->assertEquals($data['portion'], Session::get('portion_r'));
        $this->assertEquals($data['cooking_time'], Session::get('cooking_time_r'));
    }
    public function test_upload_recipe_atribute_invalid_input()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
        // Data input yang tidak valid
        $data = [
            'name' => '',
            'description' => 'Recipe Description',
            'portion' => -2,
            'cooking_time' => 'abc',
        ];

        // Mengakses rute upload-recipe-atribute dengan metode POST dan mengirimkan data input tidak valid
        $response = $this->post('recipes/upload-recipe-atribute', $data);

        // Memastikan respons kembali ke halaman sebelumnya (back)
        $response->assertRedirect();

        // Memastikan bahwa respons memiliki error validasi sesuai dengan input yang tidak valid
        $response->assertSessionHasErrors(['name', 'portion', 'cooking_time', 'description']);
    }
}