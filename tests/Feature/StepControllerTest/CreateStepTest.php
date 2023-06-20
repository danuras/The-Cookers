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
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create([
            'user_id'=>$user->id,
        ]);
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
        
    }
    /**@test */
    public function test_create_step_failed()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create([
            'user_id'=>$user->id,
        ]);
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

    /**@test */
    public function test_create_step_not_authorized()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Membuat user baru lagi 
        $user2 = User::factory()->create();
        
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create([
            'user_id'=>$user2->id
        ]);
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
        // memastikan user tidak terotorisasi
        $response->assertStatus(403);
    }
}