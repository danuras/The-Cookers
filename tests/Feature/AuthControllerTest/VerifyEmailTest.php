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
    public function test_verify_email_with_valid_code()
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

    public function test_verify_email_with_expired_code()
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

    public function test_cerify_email_with_invalid_code()
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

    public function test_verify_email_when_already_verified()
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

}
