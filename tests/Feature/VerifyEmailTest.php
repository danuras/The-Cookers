<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\Assert as PHPUnit;
use Tests\TestCase;

class VerifyEmailTest extends TestCase
{
    public function testVerifyEmailWithValidCode()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'verification_code' => Hash::make('valid_code'),
            'verification_code_expired_at' => Carbon::now()->addHours(1),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        $response = $this->actingAs($user)
            ->post('verify-email', ['verification_code' => 'valid_code']);

        $response->assertRedirect('/');
        PHPUnit::assertNotNull($user->fresh()->email_verified_at);
        $response->assertSessionHas('success', 'Email Berhasil di Konfirmasi');
    }

    public function testVerifyEmailWithExpiredCode()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'verification_code' => Hash::make('expired_code'),
            'verification_code_expired_at' => Carbon::now(),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)
            ->post('verify-email', ['verification_code' => 'expired_code']);

        $response->assertRedirect(null);
        $response->assertSessionHasErrors('ecode', 'Kode verifikasi telah kadaluarsa');
        PHPUnit::assertNull($user->fresh()->email_verified_at);
        
    }

    public function testVerifyEmailWithInvalidCode()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'verification_code' => Hash::make('valid_code'),
            'verification_code_expired_at' => Carbon::now()->addHours(1),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)
            ->post('verify-email', ['verification_code' => 'invalid_code']);

        $response->assertRedirect(null);
        $response->assertSessionHasErrors('ecode', 'Kode verifikasi salah');
        PHPUnit::assertNull($user->fresh()->email_verified_at);
    }

    public function testVerifyEmailWhenAlreadyVerified()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'verification_code' => Hash::make('valid_code'),
            'verification_code_expired_at' => Carbon::now()->addHours(1),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)
            ->post('verify-email', ['verification_code' => 'valid_code']);

        $response->assertRedirect('/');
    }

    public function testShowVerificationCodeWhenAlreadyVerified()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)->get('show-verification-code');

        $response->assertRedirect('/');
    }

    public function testShowVerificationCode()
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)->get('show-verification-code');

        $response->assertViewIs('auth.verifyCode');
    }

    public function testSendVerificationCodeWhenAlreadyVerified()
    {
        $user = User::factory()->create(['email_verified_at' => Carbon::now()]);
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        $response = $this->actingAs($user)->post('send-verification-code');

        $response->assertRedirect('/');
    }

    public function testSendVerificationCodeWhenCodeExpired()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'verification_code_expired_at' => Carbon::now(),
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);
        $response = $this->actingAs($user)->post('/send-verification-code');

        $response->assertSessionHas('ecode', 'Kode Verifikasi Telah Dikirim');
        $this->assertNotNull($user->fresh()->verification_code);
        $this->assertTrue(Carbon::now()->diffInMinutes($user->fresh()->verification_code_expired_at) <= 5);
    }

    public function testSendVerificationCodeWhenCodeNotExpired()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'verification_code_expired_at' => Carbon::now()->addMinutes(5),
        ]);

        Notification::fake();
        $response = $this->actingAs($user)->post('/send-verification-code');

        $response->assertSessionHasErrors('ecode', function ($error) use ($user) {
            $diff = Carbon::createFromFormat('Y-m-d H:i:s', $user->verification_code_expired_at)->diff(Carbon::now());
            $expectedErrorMessage = 'Tunggu sampai ' . $diff->format('%i menit, %s detik') . ' lagi untuk mengirimkan kode verifikasi';
            return $error === $expectedErrorMessage;
        });
        Notification::assertNothingSent();
        $this->assertNull($user->fresh()->verification_code);
    }
}
