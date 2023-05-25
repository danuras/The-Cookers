<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowLoginTest extends TestCase
{
    /** @test */
    public function test_show_login_view()
    {
        $response = $this->get('login');
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }
}
