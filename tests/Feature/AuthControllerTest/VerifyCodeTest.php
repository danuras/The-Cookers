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