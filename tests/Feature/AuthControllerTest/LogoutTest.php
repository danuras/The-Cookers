<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    
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
}
