<?php

namespace Database\Seeders;

use App\Models\Kela;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing classes
        $kela1A = Kela::where('name', 'Kelas 1A')->first();
        $kela2B = Kela::where('name', 'Kelas 2B')->first();

        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => User::ADMIN_ROLE,
            'kela_id' => null, // Admin does not belong to a specific class
        ]);

        // Create Teacher User
        User::create([
            'name' => 'Guru A',
            'email' => 'guruA@example.com',
            'password' => Hash::make('password'),
            'role' => User::GURU_ROLE,
            'kela_id' => $kela1A ? $kela1A->id : null,
        ]);

        User::create([
            'name' => 'Guru B',
            'email' => 'guruB@example.com',
            'password' => Hash::make('password'),
            'role' => User::GURU_ROLE,
            'kela_id' => $kela2B ? $kela2B->id : null,
        ]);

        // Create Student User
        User::create([
            'name' => 'Siswa 1A',
            'email' => 'siswa1a@example.com',
            'password' => Hash::make('password'),
            'role' => User::SISWA_ROLE,
            'kela_id' => $kela1A ? $kela1A->id : null,
        ]);

        User::create([
            'name' => 'Siswa 2B',
            'email' => 'siswa2b@example.com',
            'password' => Hash::make('password'),
            'role' => User::SISWA_ROLE,
            'kela_id' => $kela2B ? $kela2B->id : null,
        ]);
    }
}
