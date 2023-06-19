<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class EditImageTest extends TestCase
{
    /**@test */
    public function test_edit_image_with_valid_image(): void
    {

        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);
        // Membuat file gambar palsu
        $file = UploadedFile::fake()->image('test_image.jpg', 101, 101);

        // Mengirimkan permintaan POST dengan file gambar
        $response = $this->post('recipes/edit-recipe/edit-image', ['image_url' => $file]);
        $response->assertStatus(302);

        // Memastikan bahwa respons mengalihkan pengguna ke rute yang diharapkan
        $response->assertRedirect(route('recipes.edit-recipe-atribute'));
        ;

        // Memastikan bahwa sesi memiliki path gambar yang diharapkan
        $this->assertEquals('images/recipe/image_url/' . date('YmdHi') . 'test_image.jpg', Session::get('image_url_r'));

        // Memastikan bahwa file gambar terunggah ke penyimpanan publik
        $this->assertTrue(file_exists(public_path('images/recipe/image_url/' . date('YmdHi') . 'test_image.jpg'))); 
    }

    public function testeditImageWithInvalidImage()
    {
         // Membuat user baru untuk dihapus
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
         
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);
        // Membuat file gambar palsu dengan ekstensi yang tidak valid
        $file = uploadedFile::fake()->create('test_file.txt');

        // Mengirimkan permintaan POST dengan file gambar yang tidak valid
        $response = $this->post('recipes/edit-recipe/edit-image', ['image_url' => $file]);

        // Memastikan bahwa respons mengalihkan pengguna kembali ke halaman sebelumnya
        $response->assertRedirect();

        // Memastikan bahwa terdapat pesan error yang sesuai
        $response->assertSessionHasErrors(['image_url']);
    }

    /**@test */
    public function test_edit_image_unauthorized(): void
    {

        // Membuat user baru untuk dihapus
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat dummy recipe untuk diuji
        $recipe = Recipe::factory()->create([
            'user_id'=> $user2->id,
        ]);
        Session::put('recipe_id_r', $recipe->id);
        // Membuat file gambar palsu
        $file = UploadedFile::fake()->image('test_image.jpg', 101, 101);

        // Mengirimkan permintaan POST dengan file gambar
        $response = $this->post('recipes/edit-recipe/edit-image', ['image_url' => $file]);
        
        // Memastikan bahwa respons memiliki status kode 403 (unauthorized)
        $response->assertStatus(403);
    }
}