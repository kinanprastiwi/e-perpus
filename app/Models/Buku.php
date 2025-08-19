<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
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

    protected $casts = [
        'tahun_terbit' => 'integer',
        'j_buku_baik' => 'integer',
        'j_buku_rusak' => 'integer'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_buku');
    }

    public function getJumlahTersediaAttribute()
    {
        return $this->j_buku_baik - $this->peminjaman()->where('status', 'Dipinjam')->count();
    }
}