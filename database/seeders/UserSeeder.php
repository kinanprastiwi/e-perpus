<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'kode_user' => 'AD001',
            'nis' => null,
            'fullname' => 'Administrator Utama',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'kelas' => null,
            'alamat' => 'Kantor Perpustakaan',
            'verif' => 'Terverifikasi',
            'role' => 'admin',
            'join_date' => now(),
        ]);

        // Petugas
        User::create([
            'kode_user' => 'PT001',
            'nis' => null,
            'fullname' => 'Petugas Perpustakaan',
            'username' => 'petugas',
            'password' => Hash::make('password'),
            'kelas' => null,
            'alamat' => 'Kantor Perpustakaan',
            'verif' => 'Terverifikasi',
            'role' => 'petugas',
            'join_date' => now(),
        ]);

        // Anggota
        $anggotas = [
            [
                'kode_user' => 'AG001',
                'nis' => '123',
                'fullname' => 'Gunokian',
                'username' => 'gunokian',
                'password' => Hash::make('password'),
                'kelas' => 'X - Administrasi Perkantoran',
                'alamat' => 'Bandung',
                'verif' => 'Terverifikasi',
                'role' => 'anggota',
                'join_date' => now()->subMonths(3),
            ],
            [
                'kode_user' => 'AG002',
                'nis' => '123456',
                'fullname' => 'Muh. Nurrohman',
                'username' => 'nurrohman',
                'password' => Hash::make('password'),
                'kelas' => 'X - Rekayasa Perangkat Lunak',
                'alamat' => 'Jl. Nusantara Plaza',
                'verif' => 'Terverifikasi',
                'role' => 'anggota',
                'join_date' => now()->subMonths(2),
            ]
        ];

        foreach ($anggotas as $anggota) {
            User::create($anggota);
        }
    }
}