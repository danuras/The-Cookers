<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\Step;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class DeleteStepTest extends TestCase
{
    /**
     * @test
     */
    public function test_delete_step()
    {
        // Membuat user baru 
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        
        $recipe = Recipe::factory()->create(['user_id'=>$user->id]);
        // Buat langkah palsu untuk pengujian
        $step = Step::factory()->create([
            'images' => json_encode([
                'images1' => UploadedFile::fake()->image('stup1.jpg'),
                'images2' => UploadedFile::fake()->image('stup2.jpg'),
                'images3' => UploadedFile::fake()->image('stup3.jpg'),
            ]),
            'recipe_id' => $recipe->id,

        ]);

        // Hapus langkah
        $response = $this->delete('/steps/delete/' . $step->id);

        // Pastikan langkah berhasil dihapus dari database
        $response->assertRedirect();
        // Memastikan bahwa langkah telah dihapus dari database
        $this->assertDatabaseMissing('steps', [
            'id' => $step->id,
        ]);
    }
    /**
     * @test
     */
    public function test_delete_step_unauthorized()
    {
        // Membuat user baru 
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        
        $recipe = Recipe::factory()->create(['user_id'=>$user2->id]);
        // Buat langkah palsu untuk pengujian
        $step = Step::factory()->create([
            'images' => json_encode([
                'images1' => UploadedFile::fake()->image('stup1.jpg'),
                'images2' => UploadedFile::fake()->image('stup2.jpg'),
                'images3' => UploadedFile::fake()->image('stup3.jpg'),
            ]),
            'recipe_id' => $recipe->id,

        ]);

        // Hapus langkah
        $response = $this->delete('/steps/delete/' . $step->id);

        // memastikan user tidak terotorisasi
        $response->assertStatus(403);
    }
}