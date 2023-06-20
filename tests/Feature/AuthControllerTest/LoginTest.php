<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    
    /** @test */
    public function it_does_login_succesfully()
    {
        // Membuat pengguna (user) baru
        $user = User::factory()->create();
        
        // Authentikasi user
        $response=$this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        // Memastikan user di arahkan ke '/' dan status kode 302
        $response->assertStatus(302);
        $response->assertRedirect('/');

        // Memastikan user di autentikasi
        $this->assertTrue(Auth::check());

    }
    /** @test */
    public function it_does_login_succesfully_with_username()
    {
        // Membuat pengguna (user) baru
        $user = User::factory()->create();
        
        // Authentikasi user
        $response=$this->post(route('login'), [
            'login' => $user->username,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        // Memastikan user di arahkan ke '/' dan status kode 302
        $response->assertStatus(302);
        $response->assertRedirect('/');

        // Memastikan user di autentikasi
        $this->assertTrue(Auth::check());

    }
    /** @test */
    public function user_cannot_login_with_invalid_credentials()
    {
        // Membuat pengguna (user) baru
        $user = User::factory()->create();
        
        // Authentikasi user
        $response=$this->post(route('login'), [
            'login' => $user->email,
            'password' => 'wrongPassword', // Ganti dengan password pengguna yang valid
        ]);

        // Memastikan user tetap berada di login page dan ada pesan errornya
        $response->assertStatus(302);
        $response->assertRedirect(null);
        $response->assertSessionHasErrors(['logine']);

        // Memastikan user tidak di autentikasi
        $this->assertFalse(Auth::check());
    }
}
