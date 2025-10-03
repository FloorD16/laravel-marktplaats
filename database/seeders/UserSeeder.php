<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Guest',
            'email' => 'guest@example.com',
            'password' => Hash::make('guest'),
            'email_notifications' => false,
        ]);
        
        User::factory()->count(23)->create();

        User::create([
            'name' => 'Floor',
            'email' => 'floor@example.com',
            'password' => Hash::make('test'),
            'email_notifications' => true,
        ]);
    }
}
