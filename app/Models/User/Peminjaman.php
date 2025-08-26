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
        'id_user', // SESUAI MIGRATION
        'id_buku', // SESUAI MIGRATION
        'tanggal_peminjaman', // SESUAI MIGRATION
        'tanggal_pengembalian', // SESUAI MIGRATION
        'tanggal_harus_kembali', // SESUAI MIGRATION
        'kondisi_buku_saat_dipinjam', // SESUAI MIGRATION
        'kondisi_buku_saat_dikembalikan', // SESUAI MIGRATION
        'denda', // SESUAI MIGRATION
        'status', // SESUAI MIGRATION
        'catatan' // SESUAI MIGRATION
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user'); // SESUAI MIGRATION
    }

    // RELASI KE BUKU
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku'); // SESUAI MIGRATION
    }

    // SCOPE UNTUK PEMINJAMAN AKTIF
    public function scopeAktif($query)
    {
        return $query->where('status', 'Dipinjam');
    }

    // METHOD UNTUK CEK KETERLAMBATAN
    public function isTerlambat()
    {
        return $this->status === 'Dipinjam' && 
               now()->greaterThan($this->tanggal_harus_kembali); // SESUAI MIGRATION
    }

    // METHOD HITUNG DENDA
    public function hitungDenda()
    {
        if ($this->isTerlambat()) {
            $hariTerlambat = now()->diffInDays($this->tanggal_harus_kembali); // SESUAI MIGRATION
            return $hariTerlambat * 5000; // Contoh denda Rp 5000/hari
        }
        return 0;
    }
    // Accessor untuk kompatibilitas
public function getTglPinjamAttribute()
{
    return $this->tanggal_peminjaman;
}

public function getTglJatuhTempoAttribute()
{
    return $this->tanggal_harus_kembali;
}
}