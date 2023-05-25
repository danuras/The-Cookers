<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowEnterEmaiiCodeTest extends TestCase
{
    
    public function test_show_enter_email_view()
    {
        //Memanggil route reset-password
        $response = $this->get('reset-password');
        //Memastikan status kode 200
        $response->assertStatus(200);
        //Memastikan view yang dipanggil adalah auth.reset_password.enterEmail
        $response->assertViewIs('auth.reset_password.enterEmail');
    }
}
