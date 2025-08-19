<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_buku',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'tanggal_harus_kembali',
        'kondisi_buku_saat_dipinjam',
        'kondisi_buku_saat_dikembalikan',
        'denda',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
        'tanggal_pengembalian' => 'date',
        'tanggal_harus_kembali' => 'date',
        'denda' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function hitungDenda()
    {
        if ($this->status === 'Dikembalikan' || $this->status === 'Terlambat') {
            $hariTerlambat = max(0, now()->diffInDays($this->tanggal_harus_kembali, false) * -1);
            $dendaPerHari = 5000; // Rp 5.000 per hari
            $this->denda = $hariTerlambat * $dendaPerHari;
            $this->save();
        }
        return $this->denda;
    }
}