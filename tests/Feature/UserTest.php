<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    /** @test */
    public function it_deletes_user_if_password_is_correct()
    {
        // Membuat user baru untuk dihapus
        $user = User::factory()->create();

        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
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
        
        $response->assertStatus(302);
        // Memastikan bahwa pengguna diarahkan ke halaman yang diinginkan
        $response->assertRedirect('/');
        
        // Memastikan bahwa pesan sukses ditampilkan
        $response->assertSessionHas('success', 'User has been deleted successfully');
    }
    /** @test */
    public function it_does_not_delete_user_if_password_is_incorrect()
    {
        // Membuat pengguna (user) baru
        $user = User::factory()->create();
        
        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Mengirim permintaan DELETE ke rute destroy dengan kata sandi yang salah
        $response = $this->actingAs($user)
            ->delete(route('profiles.destroy', $user->id), [
                'password' => 'wrongpassword',
            ]);

        // Memastikan bahwa pengguna tidak dihapus dari database
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);

        $response->assertStatus(302);
        // Memastikan bahwa pengguna diarahkan kembali ke halaman sebelumnya
        $response->assertRedirect(null);
        
        // Memastikan bahwa pesan kesalahan ditampilkan
        $response->assertSessionHasErrors('ecode', 'Password Salah');
    }
    /** @test */
    public function it_does_logout_succesfully()
    {
        // Membuat pengguna (user) baru
        $user = User::factory()->create();
        
        // Authentikasi user
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        // Logout
        $response = $this->get('logout');

        // Memastikan user telah logout dan 
        $response->assertStatus(302);
        $response->assertRedirect('/');

        // Memastikan user tidak di authentikasi
        $this->assertFalse(Auth::check());

    }
    /** @test */
    public function it_does_login_succesfully()
    {
        // Membuat pengguna (user) baru
        $user = User::factory()->create();
        
        // Authentikasi user
        $response=$this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        // Assert that user is logged in and redirected to '/'
        $response->assertStatus(302);
        $response->assertRedirect('/');

        // Assert that user is authenticated
        $this->assertTrue(Auth::check());

    }
    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        // Membuat pengguna (user) baru
        $user = User::factory()->create();
        
        // Authentikasi user
        $response=$this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrongPassword', // Ganti dengan password pengguna yang valid
        ]);

        // Assert that user is redirected back to the login page with errors
        $response->assertStatus(302);
        $response->assertRedirect(null);
        $response->assertSessionHasErrors(['logine']);

        // Assert that user is not authenticated
        $this->assertFalse(Auth::check());
    }
}
