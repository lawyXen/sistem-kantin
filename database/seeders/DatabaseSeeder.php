<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'user_id' => 'superadmin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'role' => json_encode(['SuperAdmin']),
            'status' => '1',
            'jabatan' => json_encode(['SuperAdmin']),
            'token' => null,
            'token_expires_at' => null,
            'password' => Hash::make('password')
        ]);
    }
}
