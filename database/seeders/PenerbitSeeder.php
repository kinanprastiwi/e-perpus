<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penerbit;

class PenerbitSeeder extends Seeder
{
    public function run()
    {
        $penerbits = [
            ['kode_penerbit' => 'P001', 'nama_penerbit' => 'Erlangga', 'verif_penerbit' => 'Terverifikasi'],
            ['kode_penerbit' => 'P002', 'nama_penerbit' => 'Gramedia', 'verif_penerbit' => 'Terverifikasi'],
            ['kode_penerbit' => 'P003', 'nama_penerbit' => 'Pustaka Jaya', 'verif_penerbit' => 'Terverifikasi'],
            ['kode_penerbit' => 'P004', 'nama_penerbit' => 'Mizan', 'verif_penerbit' => 'Belum Terverifikasi'],
        ];

        foreach ($penerbits as $penerbit) {
            Penerbit::create($penerbit);
        }
    }
}