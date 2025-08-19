<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;

class PeminjamanSeeder extends Seeder
{
    public function run()
    {
        $peminjamans = [
            [
                'id_user' => 3, // Gunokian
                'id_buku' => 1, // Pemrograman Dasar
                'tanggal_peminjaman' => now()->subDays(5),
                'tanggal_harus_kembali' => now()->addDays(2),
                'kondisi_buku_saat_dipinjam' => 'Baik',
                'status' => 'Dipinjam'
            ],
            [
                'id_user' => 4, // Muh. Nurrohman
                'id_buku' => 2, // Sejarah Indonesia Modern
                'tanggal_peminjaman' => now()->subDays(10),
                'tanggal_pengembalian' => now()->subDays(3),
                'tanggal_harus_kembali' => now()->subDays(5),
                'kondisi_buku_saat_dipinjam' => 'Baik',
                'kondisi_buku_saat_dikembalikan' => 'Baik',
                'status' => 'Dikembalikan'
            ]
        ];

        foreach ($peminjamans as $peminjaman) {
            Peminjaman::create($peminjaman);
        }
    }
}