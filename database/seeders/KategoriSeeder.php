<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            ['kode_kategori' => 'KTG001', 'nama_kategori' => 'Sains'],
            ['kode_kategori' => 'KTG002', 'nama_kategori' => 'Sejarah'],
            ['kode_kategori' => 'KTG003', 'nama_kategori' => 'Teknologi'],
            ['kode_kategori' => 'KTG004', 'nama_kategori' => 'Sastra'],
            ['kode_kategori' => 'KTG005', 'nama_kategori' => 'Pendidikan'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}