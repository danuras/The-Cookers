<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_update()
    {
        // Membuat dummy user
        $user = User::factory()->create([
            'email_verified_at'=>Carbon::now(),
        ]);
        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'login' => $user->email,
            'password' => 'password', 
        ]);

        $username = fake()->unique()->userName();
        $email = fake()->unique()->safeEmail();

        // Menjalankan route 'profiles.update' dengan user yang diotentikasi dan data terkirim
        $response = $this->actingAs($user)->put(route('profiles.update', $user->id), [
            'name' => 'John Doe',
            'no_phone' => '123456789',
            'username' =>$username,
            'gender' => 'L',
            'bio' => 'Lorem ipsum dolor sit amet.',
            'info' => 'Lorem ipsum',
            'photo_profile' => 'profile.png',
            'email'=>$user->email
        ]);

        // Memastikan respons mengarahkan ke route 'profiles.index'
        $response->assertStatus(302);
        $response->assertRedirect(route('profiles.index'));

        // Memastikan bahwa data user telah diperbarui sesuai dengan data yang dikirim
        $this->assertEquals('John Doe', $user->fresh()->name);
        $this->assertEquals('123456789', $user->fresh()->no_phone);
        $this->assertEquals($username, $user->fresh()->username);
        $this->assertEquals('L', $user->fresh()->gender);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $user->fresh()->bio);
        $this->assertEquals('Lorem ipsum', $user->fresh()->info);

        // Memastikan bahwa foto profil telah diunggah
        Storage::disk('public')->assertExists($user->fresh()->photo_profile);
    }
    public function test_update_email()
    {
        // Membuat dummy user
        $user = User::factory()->create([
            'email_verified_at'=>Carbon::now(),
        ]);
        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', 
        ]);

        $username = fake()->unique()->userName();
        $email = fake()->unique()->safeEmail();

        // Menjalankan route 'profiles.update' dengan user yang diotentikasi dan data terkirim
        $response = $this->actingAs($user)->put(route('profiles.update', $user->id), [
            'name' => 'John Doe',
            'no_phone' => '123456789',
            'gender' => 'L',
            'username' =>$username,
            'bio' => 'Lorem ipsum dolor sit amet.',
            'info' => 'Lorem ipsum',
            'photo_profile' => 'profile.png',
            'email'=>$email
        ]);

        // Memastikan respons mengarahkan ke route 'profiles.index'
        $response->assertStatus(302);
        $response->assertRedirect('show-verification-code');

        // Memastikan bahwa data user telah diperbarui sesuai dengan data yang dikirim
        $this->assertEquals('John Doe', $user->fresh()->name);
        $this->assertEquals($email, $user->fresh()->email);
        $this->assertEquals('123456789', $user->fresh()->no_phone);
        $this->assertEquals('L', $user->fresh()->gender);
        $this->assertEquals('Lorem ipsum dolor sit amet.', $user->fresh()->bio);
        $this->assertEquals('Lorem ipsum', $user->fresh()->info);

        // Memastikan bahwa foto profil telah diunggah
        Storage::disk('public')->assertExists($user->fresh()->photo_profile);
    }

    public function test_update_validation()
    {
        // Membuat dummy user
        $user = User::factory()->create();
        
        // Menjalankan HTTP POST request ke route 'login' untuk mengotentikasi pengguna
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', 
        ]);

        // Menjalankan route 'profiles.update' dengan user yang diotentikasi dan data tidak valid
        $response = $this->actingAs($user)->put(route('profiles.update', $user->id), []);

        // Memastikan respons mengarahkan kembali ke halaman sebelumnya
        $response->assertRedirect();

        // Memastikan bahwa terjadi kesalahan validasi pada beberapa field
        $response->assertSessionHasErrors(['name', 'gender', 'email', 'username']);
    }

}
