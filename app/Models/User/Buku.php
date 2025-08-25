<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';
    protected $fillable = [
        'judul',
        'penulis', 
        'penerbit',
        'tahun_terbit',
        'kategori_id',
        'stock', // PASTIKAN INI SESUAI DENGAN DATABASE
        'cover',
        'sinopsis',
        'status'
    ];

    // RELASI KE KATEGORI
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // RELASI KE PEMINJAMAN
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    // SCOPE UNTUK BUKU TERSEDIA - PERBAIKI DARI 'stok' MENJADI 'stock'
    public function scopeTersedia($query)
    {
        return $query->where('stock', '>', 0); // PERBAIKAN DI SINI
    }

    // METHOD CEK KETERSEDIAAN
    public function isTersedia()
    {
        return $this->stock > 0; // PERBAIKAN DI SINI
    }

    // ACCESSOR UNTUK STOCK
    public function getStockAttribute($value)
    {
        return $value; // Pastikan menggunakan 'stock' bukan 'stok'
    }
}