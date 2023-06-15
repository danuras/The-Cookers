<?php

namespace Tests\Feature;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardIndexTest extends TestCase
{
    /**
     * @test
     */
    public function test_home(): void
    {
        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Mengirimkan permintaan HTTP GET ke rute 'dashboard.index'
        $response = $this->get('/');

        // Memastikan respons berhasil (kode status 200)
        $response->assertStatus(200);

        // Memastikan tampilan 'dashboard' digunakan
        $response->assertViewIs('home');

        // Memastikan data 'f_recipes' dan 'n_recipes' tersedia di tampilan
        $response->assertViewHas(['f_recipes', 'n_recipes']);
        // Memastikan jumlah resep yang dikirim ke tampilan sesuai dengan batas yang ditentukan
        $response->assertViewHas('f_recipes', Recipe::withCount('favorites')->orderByDesc('favorites_count')->limit(4)->get());
        $response->assertViewHas('n_recipes', Recipe::orderByDesc('created_at')->limit(4)->get());
    }
    /**
     * @test
     */
    public function test_dashboard(): void
    {

        // Mengirimkan permintaan HTTP GET ke rute 'dashboard.index'
        $response = $this->get('/');

        // Memastikan respons berhasil (kode status 200)
        $response->assertStatus(200);

        // Memastikan tampilan 'dashboard' digunakan
        $response->assertViewIs('dashboard');

    }
}