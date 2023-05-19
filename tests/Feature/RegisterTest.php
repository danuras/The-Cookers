<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use WithFaker;

    public function test_successful_registration()
    {

        $email = fake()->unique()->safeEmail();

        $response = $this->post('register', [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => $email,
            'email_verified_at' => now(),
            'password' => '@Sadnak123', // password
            'remember_token' => Str::random(10),
            'photo_profile'=> 'profile.png',
            'password_confirmation' => '@Sadnak123',
            'gender' => fake()->randomElement(['L', 'P']),
            'info' => Str::random(20),
            'bio' => Str::random(50),
        ]);

        $response->assertRedirect('show-verification-code');
        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]); 
        
    }

    /**@test */
    public function test_failed_registration_required()
    {
        $response = $this->post('register', [
            'email_verified_at' => now(),
            'password' => '@Sadnak123', // password
            'remember_token' => Str::random(10),
            'photo_profile'=> 'profile.png',
            'password_confirmation' => '@Sadnak123',
            'info' => Str::random(20),
            'bio' => Str::random(50),
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['name', 'username', 'email', 'gender']);
    } 
    
    /**@test */
    public function test_failed_registration_email()
    {
        $response = $this->post('register', [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => 'aaa',
            'email_verified_at' => now(),
            'password' => '@Sadnak123', // password
            'remember_token' => Str::random(10),
            'photo_profile'=> 'profile.png',
            'password_confirmation' => '@Sadnak123',
            'gender' => fake()->randomElement(['L', 'P']),
            'info' => Str::random(20),
            'bio' => Str::random(50),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['email']);
    } 
    
    /**@test */
    public function test_failed_registration_password_format()
    {
        $response = $this->post('register', [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => 'a@a',
            'email_verified_at' => now(),
            'password' => 'sadnak123', // password
            'remember_token' => Str::random(10),
            'photo_profile'=> 'profile.png',
            'password_confirmation' => '@Sadnak123',
            'gender' => fake()->randomElement(['L', 'P']),
            'info' => Str::random(20),
            'bio' => Str::random(50),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['password']);
    } 
    /**@test */
    public function test_failed_registration_password_not_same()
    {
        $response = $this->post('register', [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => 'a@a',
            'email_verified_at' => now(),
            'password' => '@Sadnak12', // password
            'remember_token' => Str::random(10),
            'photo_profile'=> 'profile.png',
            'password_confirmation' => '@Sadnak123',
            'gender' => fake()->randomElement(['L', 'P']),
            'info' => Str::random(20),
            'bio' => Str::random(50),
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $response->assertSessionHasErrors(['password']);
    } 
    /**@test */
    public function test_call_register_route(): void
    {
        $response = $this->get('register');

        $response->assertStatus(200);
    }
}
