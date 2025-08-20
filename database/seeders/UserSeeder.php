<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        
        DB::table('users')->insert([
            [
                'kode_user' => 'ADM001',
                'nis' => null,
                'fullname' => 'Administrator Utama',
                'username' => 'admin',
                'email' => 'admin@perpustakaan.com',
                'password' => Hash::make('password123'),
                'kelas' => null,
                'alamat' => 'Jl. Administrasi No. 1',
                'verif' => 'Terverifikasi',
                'role' => 'admin',
                'join_date' => $now->toDateString(), // Tambahkan ini
                'terakhir_login' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'kode_user' => 'PTG001',
                'nis' => null,
                'fullname' => 'Petugas Perpustakaan',
                'username' => 'petugas',
                'email' => 'petugas@perpustakaan.com',
                'password' => Hash::make('password123'),
                'kelas' => null,
                'alamat' => 'Jl. Petugas No. 1',
                'verif' => 'Terverifikasi',
                'role' => 'petugas',
                'join_date' => $now->toDateString(), // Tambahkan ini
                'terakhir_login' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'kode_user' => 'AGT001',
                'nis' => '2024001',
                'fullname' => 'Anggota Contoh',
                'username' => 'anggota',
                'email' => 'anggota@email.com',
                'password' => Hash::make('password123'),
                'kelas' => 'XII IPA 1',
                'alamat' => 'Jl. Anggota No. 1',
                'verif' => 'Terverifikasi',
                'role' => 'anggota',
                'join_date' => $now->toDateString(), // Tambahkan ini
                'terakhir_login' => null,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
    'kode_user' => 'ADM001',
    'nis' => null,
    'fullname' => 'Administrator Utama',
    'username' => 'admin',
    'email' => 'admin@perpustakaan.com',
    'password' => Hash::make('password123'),
    'kelas' => null,
    'alamat' => 'Jl. Administrasi No. 1',
    'verif' => 'Terverifikasi',
    'role' => 'admin',
    'join_date' => '2024-01-01', // Tanggal spesifik
    'terakhir_login' => null,
    'created_at' => $now,
    'updated_at' => $now
]
        ]);
    }
}