<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowVerificationCodeTest extends TestCase
{
    
    public function test_show_verification_code_when_already_verified()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)->get('show-verification-code');

        $response->assertRedirect('/');
    }

    public function test_show_verification_code()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)->get('show-verification-code');

        $response->assertViewIs('auth.verifyCode');
    }
}
