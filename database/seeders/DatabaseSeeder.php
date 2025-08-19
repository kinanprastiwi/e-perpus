<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Buku;
use App\Models\Identitas;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Data Identitas
        Identitas::create([
            'nama_app' => 'E-Perpus LSP',
            'alamat_app' => 'JL SPIEAH & Coiverig, Kramaljati',
            'email_app' => 'e-perpuskag@gmail.com',
            'nomor_hp' => '021809773',
            'foto_app' => null
        ]);

        // Data Users
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

        // Data Kategori
        $kategoris = [
            ['kode_kategori' => 'KTG001', 'nama_kategori' => 'Sains'],
            ['kode_kategori' => 'KTG002', 'nama_kategori' => 'Sejarah'],
            ['kode_kategori' => 'KTG003', 'nama_kategori' => 'Teknologi'],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }

        // Data Penerbit
        $penerbits = [
            ['kode_penerbit' => 'P001', 'nama_penerbit' => 'Erlangga', 'verif_penerbit' => 'Terverifikasi'],
            ['kode_penerbit' => 'P002', 'nama_penerbit' => 'Gramedia', 'verif_penerbit' => 'Terverifikasi'],
        ];

        foreach ($penerbits as $penerbit) {
            Penerbit::create($penerbit);
        }

        // Data Buku
        $bukus = [
            [
                'judul_buku' => 'Pemrograman Dasar',
                'id_kategori' => 3,
                'id_penerbit' => 1,
                'pengarang' => 'John Doe',
                'tahun_terbit' => 2020,
                'isbn' => '978-623-00-1234-5',
                'j_buku_baik' => 10,
                'j_buku_rusak' => 2,
            ],
            [
                'judul_buku' => 'Sejarah Indonesia Modern',
                'id_kategori' => 2,
                'id_penerbit' => 2,
                'pengarang' => 'Jane Smith',
                'tahun_terbit' => 2018,
                'isbn' => '978-623-00-5678-9',
                'j_buku_baik' => 5,
                'j_buku_rusak' => 1,
            ],
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}