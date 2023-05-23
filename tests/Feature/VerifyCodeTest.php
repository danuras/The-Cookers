<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VerifyCodeTest extends TestCase
{
    /** @test */
    public function it_displays_enter_verification_code_page()
    {
        $response = $this->withSession(['erp' => 'test@gmail.com'])
            ->get('show-verification-code-reset-password');

        $response->assertViewIs('auth.reset_password.enterVerificationCode');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_redirects_to_reset_password_page_with_status_when_erp_session_not_set()
    {
        $response = $this->get('show-verification-code-reset-password');

        $response->assertRedirect(route('reset-password'));
        $response->assertSessionHas('status', 'Masukan Email Terlebih Dahulu');
    }

    /** @test */
    public function it_sends_verification_code_and_updates_user_data()
    {

        $email = fake()->unique()->safeEmail();
        $user = User::factory()->create([
            'email' => $email,
            'verification_code_expired_at' => Carbon::now()->subMinutes(1),
        ]);

        $response = $this->post('send-verification-code-reset-password', ['email' => $user->email]);

        $response->assertSessionHas('ecode', 'Kode Verifikasi Telah Dikirim');
        $response->assertRedirect(null);

        $this->assertNotNull($user->fresh()->verification_code);
        $this->assertGreaterThan(Carbon::now(), $user->fresh()->verification_code_expired_at);
        
    }

    /** @test */
    public function it_returns_error_when_sending_verification_code_within_five_minutes()
    {

        $email = fake()->unique()->safeEmail();
        $user = User::factory()->create([
            'email' => $email,
            'verification_code_expired_at' => Carbon::now()->addMinutes(2),
        ]);

        $response = $this->post('send-verification-code-reset-password', ['email' => $user->email]);

        $response->assertSessionHasErrors('ecode', 'Tunggu sampai 2 menit, 0 detik lagi untuk mengirimkan kode verifikasi');
        $response->assertRedirect(null);
    }
}
