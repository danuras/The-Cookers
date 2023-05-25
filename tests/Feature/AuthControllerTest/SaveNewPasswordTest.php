<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SaveNewPasswordTest extends TestCase
{
    /** @test */
public function it_saves_new_password_and_redirects_to_homepage_on_success()
{
    $email = fake()->unique()->safeEmail();
    $tokenCode = '123456';
    $newPassword = '@@!';

    $user = User::factory()->create([
        'email' => $email,
        'verification_code' => bcrypt($tokenCode),
    ]);

    $response = $this->withSession(['erp' => $email, 'token_code' => $tokenCode])
                     ->post('save-new-password', [
                         'password' => $newPassword,
                         'password_confirmation' => $newPassword,
                     ]);

    $response->assertRedirect('/');
    $response->assertSessionHas('success', 'Password telah di ubah');
    $this->assertTrue(Hash::check($newPassword, $user->fresh()->password));
    $this->assertNull(Session::get('erp'));
    $this->assertNull(Session::get('token_code'));
}

/** @test */
public function it_returns_error_when_verification_code_does_not_match()
{
    $email = fake()->unique()->safeEmail();
    $tokenCode = '123456';
    $newPassword = '@NewPassword123!';

    $user = User::factory()->create([
        'email' => $email,
        'verification_code' => bcrypt($tokenCode),
    ]);

    $response = $this->withSession(['erp' => $email, 'token_code' => '654321'])
                     ->post('save-new-password', [
                         'password' => $newPassword,
                         'password_confirmation' => $newPassword,
                     ]);

    $response->assertRedirect(null);
    $response->assertSessionHasErrors('ecode', 'Password gagal di ubah');
    $this->assertFalse(Hash::check($newPassword, $user->fresh()->password));
}

}
