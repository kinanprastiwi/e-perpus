<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Identitas;

class IdentitasSeeder extends Seeder
{
    public function run()
    {
        Identitas::create([
            'nama_app' => 'E-Perpus LSP',
            'alamat_app' => 'JL SPIEAH & Coiverig, Kramaljati',
            'email_app' => 'e-perpuskag@gmail.com',
            'nomor_hp' => '021809773',
            'foto_app' => null
        ]);
    }
}