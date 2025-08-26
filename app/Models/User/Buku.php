<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kategori;
use App\Models\Penerbit;

class Buku extends Model // BUKAN BukuController
{
    use HasFactory;

    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';
    protected $fillable = [
        'judul_buku',
        'id_kategori',
        'id_penerbit', 
        'pengarang',
        'tahun_terbit',
        'isbn',
        'j_buku_baik',
        'j_buku_rusak',
        'deskripsi',
        'cover_buku'
    ];

    // RELASI KE KATEGORI
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    // RELASI KE PENERBIT
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    // RELASI KE PEMINJAMAN
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku');
    }

    // SCOPE UNTUK BUKU TERSEDIA
    public function scopeTersedia($query)
    {
        return $query->where('j_buku_baik', '>', 0);
    }

    // METHOD CEK KETERSEDIAAN
    public function isTersedia()
    {
        return $this->j_buku_baik > 0;
    }

    // ACCESSOR UNTUK JUDUL (kompatibilitas)
    public function getJudulAttribute()
    {
        return $this->judul_buku;
    }

    // ACCESSOR UNTUK PENULIS (kompatibilitas)
    public function getPenulisAttribute()
    {
        return $this->pengarang;
    }

    // ACCESSOR UNTUK STOK (kompatibilitas)
    public function getJumlahStokAttribute()
    {
        return $this->j_buku_baik;
    }
}