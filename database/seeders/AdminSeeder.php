<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat / Update Akun Admin Tunggal
        User::updateOrCreate(
            ['email' => 'admin@smarteco.com'], // Email Login Admin
            [
                'name'     => 'Administrator Utama',
                'password' => Hash::make('admin12345'), // Password Admin
                'role'     => 'admin',
            ]
        );
    }
}
