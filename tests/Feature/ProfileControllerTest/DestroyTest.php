<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    /** @test */
    public function it_deletes_user_if_password_is_correct()
    {
        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        // Mengirim permintaan POST ke rute destroy dengan kata sandi yang benar
        $response = $this->actingAs($user)
            ->delete(route('profiles.destroy', $user->id), [
                'password' => 'password',
            ]);

        // Memastikan bahwa pengguna telah dihapus dari database
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
        
        $response->assertStatus(200);
    }
    
}
