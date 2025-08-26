<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris'; // Nama tabel di database
    protected $primaryKey = 'id_kategori'; // Primary key
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'status'
    ];

    // Relasi ke Buku
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_kategori');
    }
}