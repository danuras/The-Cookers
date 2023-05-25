<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EnterEmailTest extends TestCase
{

    public function test_enter_email_with_registered_email()
    {
        //Membuat email yang unik 
        $email = fake()->unique()->safeEmail();

        //Membuat user
        $user = User::factory()->create(['email' => $email]);

        //Memanggil route reset-password dengan email yang terdaftar
        $response = $this->post('reset-password', [
            'email' => $email,
        ]);

        //Memastikan pengguna diarahkan ke route show-verification-code-reset-password
        $response->assertRedirect('show-verification-code-reset-password');
        $response->assertSessionHas('email', $email);
    }

    public function test_enter_email_with_unregistered_email()
    {
        //Memanggil route reset-password dengan email yang tidak terdaftar
        $response = $this->post('reset-password', [
            'email' => 'nonexistent@example.com',
        ]);

        //Memastikan pengguna tidak diarahkan route berbeda
        $response->assertRedirect(null);
        //Memastikan ada pesan error seperti dibawah
        $response->assertSessionHasErrors('ecode', 'Email tidak terdaftar');
    }
}
