<?php

namespace Database\Seeders;

use App\Models\Kela;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kela::create([
            'name' => 'Kelas 1A',
            'description' => 'Kelas satu A untuk siswa baru.',
        ]);

        Kela::create([
            'name' => 'Kelas 2B',
            'description' => 'Kelas dua B untuk siswa tahun kedua.',
        ]);
    }
}
