<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShowReviewUploadTest extends TestCase
{
    public function testShowReviewUploadRecipe()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
        // Menyiapkan data dalam sesi
        $sessionData = [
            'name_r' => 'Recipe Name',
            'description_r' => 'Recipe Description',
            'portion_r' => 4,
            'cooking_time_r' => 30,
            'image_url_r' => 'images/recipe/image_url/test_image.jpg',
        ];
        Session::put($sessionData);

        // Mengakses rute review-upload-recipe
        $response = $this->get('recipes/review-upload-recipe');

        // Memastikan respons berhasil dengan status 200
        $response->assertStatus(200);

        // Memastikan bahwa data dalam sesi disertakan dalam tampilan
        $response->assertViewHas('image_url_r', $sessionData['image_url_r']);
        $response->assertViewHas('name_r', $sessionData['name_r']);
        $response->assertViewHas('description_r', $sessionData['description_r']);
        $response->assertViewHas('portion_r', $sessionData['portion_r']);
        $response->assertViewHas('cooking_time_r', $sessionData['cooking_time_r']);
    }

    public function testShowReviewUploadRecipe_NoDataInSession()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
        // Mengakses rute review-upload-recipe tanpa adanya data dalam sesi
        $response = $this->get('recipes/review-upload-recipe');

        // Memastikan respons ke halaman upload_image jika tidak ada data dalam sesi
        $response->assertViewIs('recipes.upload_recipe.upload_image');
    }

    public function testShowReviewUploadRecipe_OnlyImageUrlInSession()
    {
         // Membuat user baru 
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
        // Menyiapkan data hanya untuk image_url_r dalam sesi
        $sessionData = [
            'image_url_r' => 'images/recipe/image_url/test_image.jpg',
        ];
        Session::put($sessionData);

        // Mengakses rute review-upload-recipe
        $response = $this->get('recipes/review-upload-recipe');

        // Memastikan respons berhasil dengan status 200
        $response->assertStatus(200);

        
        // Memastikan respons ke halaman upload_recipe_atribute jika hanya ada data gambar di sesi
        $response->assertViewIs('recipes.upload_recipe.upload_recipe_atribute');

        // Memastikan bahwa data image_url_r dalam sesi disertakan dalam tampilan
        $response->assertViewHas('image_url_r', $sessionData['image_url_r']);
    }
}