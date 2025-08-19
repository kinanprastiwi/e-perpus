<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori'
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'id_kategori');
    }
}