<?php

namespace Database\Seeders;
use Carbon\Carbon;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'username' => 'bogeng',
             'email' => 'a@a',
             'password'=>Hash::make('password'),
             'email_verified_at' => Carbon::now(),
        ]);
    }
}
