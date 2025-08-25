<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    protected $fillable = [
        'kode_peminjaman',
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_pengembalian',
        'status',
        'denda'
    ];

    // RELASI KE USER
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // RELASI KE BUKU
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
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
               now()->greaterThan($this->tanggal_kembali);
    }

    // METHOD HITUNG DENDA
    public function hitungDenda()
    {
        if ($this->isTerlambat()) {
            $hariTerlambat = now()->diffInDays($this->tanggal_kembali);
            return $hariTerlambat * 5000; // Contoh denda Rp 5000/hari
        }
        return 0;
    }
}