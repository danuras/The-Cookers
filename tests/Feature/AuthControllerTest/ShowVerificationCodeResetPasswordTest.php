<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowVerificationCodeResetPasswordTest extends TestCase
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
}
