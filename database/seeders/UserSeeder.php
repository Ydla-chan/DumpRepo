<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin account
        User::updateOrCreate(
            ['email' => 'aldyjhonatanhutasoit.1@gmail.com'],
            [
                'name' => 'Admin Aldy',
                'password' => Hash::make('aldyjhonatanhutasoit.1@gmail.com'), // ganti sesuai kebutuhan
                'role' => 'admin',
            ]
        );

        // User account
        User::updateOrCreate(
            ['email' => 'aldyjhonatanhutasoit.31@gmail.com'],
            [
                'name' => 'User Aldy',
                'password' => Hash::make('password123'), // ganti sesuai kebutuhan
                'role' => 'user',
            ]
        );
    }
}
