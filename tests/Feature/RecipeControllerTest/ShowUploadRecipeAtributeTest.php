<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class ShowUploadRecipeAtributeTest extends TestCase
{
    // Pengujian jika sesi 'image_url_r' ada
public function test_show_upload_recipe_atribute_with_image_url_r()
{
    // Membuat user baru 
    $user = User::factory()->create();

    // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
    $this->post(route('login'), [
        'login' => $user->email,
        'password' => 'password', // Ganti dengan password pengguna yang valid
    ]);
    // Memasukkan nilai 'image_url_r' ke dalam sesi
    Session::put('image_url_r', 'path/to/image.jpg');
    
    // Mengakses rute /upload-recipe-atribute
    $response = $this->get('recipes/upload-recipe/upload-recipe-atribute');
    
    // Memastikan respons memiliki status 200 (OK)
    $response->assertStatus(200)
        // Memastikan respons menggunakan view yang benar
        ->assertViewIs('recipes.upload_recipe.upload_recipe_atribute')
        // Memastikan respons memiliki data 'image_url_r' dengan nilai yang sesuai
        ->assertViewHas('image_url_r', 'path/to/image.jpg');
}

// Pengujian jika sesi 'image_url_r' tidak ada
public function test_show_upload_recipe_atribute_without_image_url_r()
{
    // Membuat user baru 
    $user = User::factory()->create();

    // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
    $this->post(route('login'), [
        'login' => $user->email,
        'password' => 'password', // Ganti dengan password pengguna yang valid
    ]);
    // Menghapus nilai 'image_url_r' dari sesi
    Session::forget('image_url_r');
    
    // Mengakses rute /upload-recipe-atribute
    $response = $this->get('recipes/upload-recipe/upload-recipe-atribute');
    
    // Memastikan respons memiliki status 302
    $response->assertStatus(302)
        // Memastikan respons menggunakan view yang benar
        ->assertRedirect(route('recipes.upload-image'));
}
}
