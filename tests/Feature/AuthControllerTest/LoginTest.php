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
