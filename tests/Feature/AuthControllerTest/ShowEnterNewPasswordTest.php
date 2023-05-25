<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowEnterNewPasswordTest extends TestCase
{
    /** @test */
    public function it_displays_enter_new_password_page_when_erp_and_token_code_sessions_exist()
    {
        $response = $this->withSession(['erp' => fake()->unique()->safeEmail(), 'token_code' => '123456'])
            ->get('show-enter-new-password');

        $response->assertViewIs('auth.reset_password.enterNewPassword');
        $response->assertStatus(200);
    }

    /** @test */
    public function it_redirects_to_verification_code_page_when_erp_session_exists_but_token_code_session_is_missing()
    {
        $response = $this->withSession(['erp' => fake()->unique()->safeEmail()])
            ->get('show-enter-new-password');

        $response->assertRedirect('show-verification-code-reset-password');
        $response->assertSessionHas('status', 'Masukan Kode Verifikasi Terlebih Dahulu');
    }

    /** @test */
    public function it_redirects_to_reset_password_page_when_erp_session_is_missing()
    {
        $response = $this->get('show-enter-new-password');

        $response->assertRedirect('reset-password');
        $response->assertSessionHas('status', 'Masukan Email Terlebih Dahulu');
    }
}