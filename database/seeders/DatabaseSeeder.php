<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Module;
use App\Models\ClimateStat;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Mahasiswa
        $user = User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@smart-eco.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'level' => 3,
            'xp' => 720,
        ]);

        // 2. Buat Modul Pembelajaran
        $modules = [
            ['title' => 'Climate Change Fundamentals', 'category' => 'Climate', 'order_number' => 1],
            ['title' => 'Energy and Sustainability', 'category' => 'Energy', 'order_number' => 2],
            ['title' => 'Computational Thinking', 'category' => 'AI', 'order_number' => 3],
        ];

        foreach ($modules as $mod) {
            $module = Module::create($mod);

            // Berikan progress untuk user ini
            UserProgress::create([
                'user_id' => $user->id,
                'module_id' => $module->id,
                'progress_percentage' => rand(40, 80),
                'status' => 'in_progress'
            ]);
        }

        // 3. Buat Data Dashboard Iklim Global
        ClimateStat::insert([
            ['indicator' => 'Suhu Global', 'value' => 1.18, 'unit' => '°C', 'subtitle' => 'di atas era pra-industri'],
            ['indicator' => 'Konsentrasi CO2', 'value' => 421.00, 'unit' => 'ppm', 'subtitle' => '(Mei 2024)'],
            ['indicator' => 'Emisi CO2 Global', 'value' => 36.80, 'unit' => 'Gt', 'subtitle' => '/tahun'],
            ['indicator' => 'Emisi CO2 Indonesia', 'value' => 0.70, 'unit' => 'Gt', 'subtitle' => '/tahun'],
        ]);
    }
}
