<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class UpdateStepTest extends TestCase
{
    /**@test */
    public function test_update_step_successfull()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(['user_id'=>$user->id]);
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => 'Lorem ipsum dolor sit amut',
            'images1' => UploadedFile::fake()->image('step1.jpg'),
            'images2' => UploadedFile::fake()->image('step2.jpg'),
            'images3' => UploadedFile::fake()->image('step3.jpg'),
        ];

        // Buat step palsu untuk pengujian
        $step = 
        Step::factory()->create([
            'images' => json_encode([
                'images1' => UploadedFile::fake()->image('stup1.jpg'),
                'images2' => UploadedFile::fake()->image('stup2.jpg'),
                'images3' => UploadedFile::fake()->image('stup3.jpg'),
            ]),
            'recipe_id' => $recipe->id,

        ]);

        // Simpan perubahan langkah
        $response = $this->put('steps/update/'.$step->id, $data);

        // Pastikan perubahan langkah berhasil disimpan
        $response->assertRedirect();
        $this->assertDatabaseHas('steps', [
            'value' => $data['value'],
            'recipe_id' => $recipe->id,
        ]);
        

        // Pastikan gambar langkah berhasil diunggah dan disimpan dengan benar
        $step = Step::find($step->id);
        $this->assertEquals([
            'images/step/images/' . date('YmdHi') . 'step1.jpg',
            'images/step/images/' . date('YmdHi') . 'step2.jpg',
            'images/step/images/' . date('YmdHi') . 'step3.jpg',
        ], json_decode($step->images, true));
    }
    /**@test */
    public function test_update_step_failed()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(['user_id'=>$user->id]);
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => '',
            'images1' => UploadedFile::fake()->image('step1.jpg'),
            'images2' => UploadedFile::fake()->image('step2.jpg'),
            'images3' => UploadedFile::fake()->image('step3.jpg'),
        ];

        // Buat step palsu untuk pengujian
        $step = 
        Step::factory()->create([
            'images' => json_encode([
                'images1' => UploadedFile::fake()->image('stup1.jpg'),
                'images2' => UploadedFile::fake()->image('stup2.jpg'),
                'images3' => UploadedFile::fake()->image('stup3.jpg'),
            ]),
            'recipe_id' => $recipe->id,

        ]);
        // Simpan langkah
        $response = $this->put('steps/update/'.$step->id, $data);

        // Pastikan ada error value
        $response->assertSessionHasErrors(['value']);
    }
    /**@test */
    public function test_update_step_unauthorized()
    {
        // Membuat user baru 
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Buat resep palsu untuk pengujian
        $recipe = Recipe::factory()->create(['user_id'=>$user2->id]);
        Session::put('recipe_id_r', $recipe->id);

        // Persiapkan data permintaan
        $data = [
            'value' => 'ada',
            'images1' => UploadedFile::fake()->image('step1.jpg'),
            'images2' => UploadedFile::fake()->image('step2.jpg'),
            'images3' => UploadedFile::fake()->image('step3.jpg'),
        ];

        // Buat step palsu untuk pengujian
        $step = 
        Step::factory()->create([
            'images' => json_encode([
                'images1' => UploadedFile::fake()->image('stup1.jpg'),
                'images2' => UploadedFile::fake()->image('stup2.jpg'),
                'images3' => UploadedFile::fake()->image('stup3.jpg'),
            ]),
            'recipe_id' => $recipe->id,

        ]);
        // Simpan langkah
        $response = $this->put('steps/update/'.$step->id, $data);

        // memastikan user tidak terotorisasi
        $response->assertStatus(403);
    }
}
