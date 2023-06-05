<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateStepTest extends TestCase
{
    /**@test */
    public function test_create_step_successfull()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create();
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => 'Lorem ipsum dolor sit amet',
            'images1' => UploadedFile::fake()->image('step1.jpg'),
            'images2' => UploadedFile::fake()->image('step2.jpg'),
            'images3' => UploadedFile::fake()->image('step3.jpg'),
        ];

        // Simpan langkah
        $response = $this->post('steps/create', $data);

        // Pastikan langkah berhasil dibuat
        $response->assertRedirect();
        $this->assertDatabaseHas('steps', [
            'value' => $data['value'],
            'recipe_id' => $recipe->id,
        ]);
        

        // Pastikan gambar langkah berhasil diunggah dan disimpan dengan benar
        $step = Step::latest()->first();
        $this->assertEquals([
            'images/step/images/' . date('YmdHi') . 'step1.jpg',
            'images/step/images/' . date('YmdHi') . 'step2.jpg',
            'images/step/images/' . date('YmdHi') . 'step3.jpg',
        ], json_decode($step->images, true));
    }
    /**@test */
    public function test_create_step_failed()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create();
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => '',
            'images1' => UploadedFile::fake()->image('step1.jpg'),
            'images2' => UploadedFile::fake()->image('step2.jpg'),
            'images3' => UploadedFile::fake()->image('step3.jpg'),
        ];

        // Simpan langkah
        $response = $this->post('steps/create', $data);

        // Pastikan langkah berhasil dibuat
        $response->assertRedirect();
        $this->assertDatabaseMissing('steps', [
            'value' => $data['value'],
            'recipe_id' => $recipe->id,
        ]);
        $response->assertSessionHasErrors(['value']);
    }
}