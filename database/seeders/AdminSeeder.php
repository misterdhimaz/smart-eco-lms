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
            ['email' => 'smartecolms@gmail.com'], // Email Login Admin
            [
                'name'     => 'Evelina A. P.',
                'password' => Hash::make('AdMinSmaRtEco123321@'), // Password Admin
                'role'     => 'admin',
            ]
        );
    }
}
