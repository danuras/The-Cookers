<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowRegisterTest extends TestCase
{
    
    /**@test */
    public function test_call_register_route(): void
    {
        $response = $this->get('register');

        $response->assertStatus(200);
    }
}
