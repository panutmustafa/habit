<?php

namespace Database\Seeders;

use App\Models\Habit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Habit::create([
            'name' => 'Membaca Buku',
            'description' => 'Membaca buku pelajaran atau cerita selama 15 menit setiap hari.',
            'is_active' => true,
        ]);

        Habit::create([
            'name' => 'Merapikan Meja Belajar',
            'description' => 'Merapikan meja belajar setelah selesai belajar.',
            'is_active' => true,
        ]);

        Habit::create([
            'name' => 'Membantu Orang Tua',
            'description' => 'Membantu pekerjaan rumah tangga orang tua (misal: menyapu, mencuci piring).',
            'is_active' => true,
        ]);

        Habit::create([
            'name' => 'Berolahraga',
            'description' => 'Melakukan aktivitas fisik minimal 30 menit.',
            'is_active' => true,
        ]);
    }
}
