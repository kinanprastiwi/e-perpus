<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;

class BukuSeeder extends Seeder
{
    public function run()
    {
        $bukus = [
            [
                'judul_buku' => 'Pemrograman Dasar',
                'id_kategori' => 3, // Teknologi
                'id_penerbit' => 1, // Erlangga
                'pengarang' => 'John Doe',
                'tahun_terbit' => 2020,
                'isbn' => '978-623-00-1234-5',
                'j_buku_baik' => 10,
                'j_buku_rusak' => 2,
                'deskripsi' => 'Buku pemrograman dasar untuk pemula'
            ],
            [
                'judul_buku' => 'Sejarah Indonesia Modern',
                'id_kategori' => 2, // Sejarah
                'id_penerbit' => 2, // Gramedia
                'pengarang' => 'Jane Smith',
                'tahun_terbit' => 2018,
                'isbn' => '978-623-00-5678-9',
                'j_buku_baik' => 5,
                'j_buku_rusak' => 1,
                'deskripsi' => 'Sejarah perkembangan Indonesia modern'
            ],
            [
                'judul_buku' => 'Fisika Dasar',
                'id_kategori' => 1, // Sains
                'id_penerbit' => 1, // Erlangga
                'pengarang' => 'Robert Johnson',
                'tahun_terbit' => 2019,
                'isbn' => '978-623-00-9012-3',
                'j_buku_baik' => 8,
                'j_buku_rusak' => 0,
                'deskripsi' => 'Konsep dasar fisika untuk siswa'
            ]
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}