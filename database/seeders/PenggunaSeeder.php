<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengguna;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pengguna::create([
            'nomor_identitas' => '100203',
            'nama' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('00000000'), // Password terenkripsi
            'role' => 'admin', // Sesuaikan dengan role yang diizinkan
        ]);
    }
}
