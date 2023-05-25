<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
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
    /** @test */
    public function it_verifies_code_and_redirects_to_enter_new_password_page()
    {
        $email = fake()->unique()->safeEmail();
        $verificationCode = '123456';

        $user = User::factory()->create([
            'email' => $email,
            'verification_code' => Hash::make($verificationCode),
            'verification_code_expired_at' => Carbon::now()->addMinutes(10),
        ]);

        $response = $this->withSession(['erp' => $email])->post('verify-code', [
            'verification_code' => $verificationCode,
        ]);

        $response->assertRedirect('show-enter-new-password');
        $this->assertNotNull(Session::get('token_code'));
        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /** @test */
    public function it_returns_error_when_verification_code_is_expired()
    {
        $email = fake()->unique()->safeEmail();
        $verificationCode = '123456';

        $user = User::factory()->create([
            'email' => $email,
            'verification_code' => Hash::make($verificationCode),
            'verification_code_expired_at' => Carbon::now()->subMinutes(10),
        ]);

        $response = $this->withSession(['erp' => $email])->post('verify-code', [
            'verification_code' => $verificationCode,
        ]);

        $response->assertRedirect(null);
        $response->assertSessionHasErrors('ecode', 'Kode verifikasi telah kadaluarsa');
    }

    /** @test */
    public function it_returns_error_when_verification_code_is_invalid()
    {
        $email = fake()->unique()->safeEmail();
        $verificationCode = '123456';
        $invalidVerificationCode = '654321';

        $user = User::factory()->create([
            'email' => $email,
            'verification_code' => Hash::make($verificationCode),
            'verification_code_expired_at' => Carbon::now()->addMinutes(10),
        ]);

        $response = $this->withSession(['erp' => $email])->post('verify-code', [
            'verification_code' => $invalidVerificationCode,
        ]);

        $response->assertRedirect(null);
        $response->assertSessionHasErrors('ecode', 'Kode verifikasi salah');
    }

}