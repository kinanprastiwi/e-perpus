<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    use HasFactory;

    protected $table = 'penerbits'; // Nama tabel di database
    protected $primaryKey = 'id_penerbit'; // Primary key
    protected $fillable = [
        'nama_penerbit',
        'alamat',
        'telepon',
        'email'
    ];

    // Relasi ke Buku
    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_penerbit');
    }
}