<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendVerificationCodeTest extends TestCase
{
    public function test_send_verification_code_when_already_verified()
    {
        $user = User::factory()->create(['email_verified_at' => Carbon::now()]);
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // Ganti dengan password pengguna yang valid
        ]);

        $response = $this->actingAs($user)->post('send-verification-code');

        $response->assertRedirect('/');
    }

    public function test_send_verification_code_when_code_expired()
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

    public function test_send_verification_code_when_code_not_expired()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'verification_code_expired_at' => Carbon::now()->addMinutes(5),
        ]);

        $response = $this->actingAs($user)->post('/send-verification-code');

        $response->assertSessionHasErrors('ecode', function ($error) use ($user) {
            $diff = Carbon::createFromFormat('Y-m-d H:i:s', $user->verification_code_expired_at)->diff(Carbon::now());
            $expectedErrorMessage = 'Tunggu sampai ' . $diff->format('%i menit, %s detik') . ' lagi untuk mengirimkan kode verifikasi';
            return $error === $expectedErrorMessage;
        });
        $this->assertNull($user->fresh()->verification_code);
    }
}
