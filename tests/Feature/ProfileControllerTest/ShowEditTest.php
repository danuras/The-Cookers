<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowEditTest extends TestCase
{
    public function test_show_edit()
    {
        // Membuat dummy user
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        // Menjalankan route 'profiles.edit' dengan user yang diotentikasi
        $response = $this->actingAs($user)->get(route('profiles.edit', $user));

        // Memastikan respons memiliki status kode 200 (OK)
        $response->assertStatus(200);

        // Memastikan data user terkirim ke view 'profiles.edit'
        $response->assertViewHas('profile', $user);
    }
}
