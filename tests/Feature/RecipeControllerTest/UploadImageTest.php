<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class UploadImageTest extends TestCase
{
    /**@test */
    public function test_upload_image_with_valid_image(): void
    {

        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat file gambar palsu
        $file = UploadedFile::fake()->image('test_image.jpg', 101, 101);

        // Mengirimkan permintaan POST dengan file gambar
        $response = $this->post('recipes/upload-image', ['image_url' => $file]);
        $response->assertStatus(302);

        // Memastikan bahwa respons mengalihkan pengguna ke rute yang diharapkan
        $response->assertRedirect(route('recipes.upload-recipe-atribute'));
        ;

        // Memastikan bahwa sesi memiliki path gambar yang diharapkan
        $this->assertEquals('images/recipe/image_url/' . date('YmdHi') . 'test_image.jpg', Session::get('image_url_r'));

        // Memastikan bahwa file gambar terunggah ke penyimpanan publik
        $this->assertTrue(file_exists(public_path('images/recipe/image_url/' . date('YmdHi') . 'test_image.jpg'))); 
    }

    public function testUploadImageWithInvalidImage()
    {
         // Membuat user baru untuk dihapus
         $user = User::factory()->create();

         // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
         $this->post(route('login'), [
             'email' => $user->email,
             'password' => 'password', // Ganti dengan password pengguna yang valid
         ]);
        // Membuat file gambar palsu dengan ekstensi yang tidak valid
        $file = UploadedFile::fake()->create('test_file.txt');

        // Mengirimkan permintaan POST dengan file gambar yang tidak valid
        $response = $this->post('recipes/upload-image', ['image_url' => $file]);

        // Memastikan bahwa respons mengalihkan pengguna kembali ke halaman sebelumnya
        $response->assertRedirect();

        // Memastikan bahwa terdapat pesan error yang sesuai
        $response->assertSessionHasErrors(['image_url']);
    }
}