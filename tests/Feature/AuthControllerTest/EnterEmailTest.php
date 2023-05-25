<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EnterEmailTest extends TestCase
{
    public function test_show_enter_email_view()
    {
        $response = $this->get('reset-password');
        $response->assertStatus(200);
        $response->assertViewIs('auth.reset_password.enterEmail');
    }

    public function test_enter_email_with_registered_email()
    {

        $email = fake()->unique()->safeEmail();

        $user = User::factory()->create(['email' => $email]);

        $response = $this->post('reset-password', [
            'email' => $email,
        ]);

        $response->assertRedirect('show-verification-code-reset-password');
        $response->assertSessionHas('email', $email);
    }

    public function test_enter_email_with_unregistered_email()
    {
        $response = $this->post('reset-password', [
            'email' => 'nonexistent@example.com',
        ]);

        $response->assertRedirect(null);
        $response->assertSessionHasErrors('ecode', 'Email tidak terdaftar');
    }
}
