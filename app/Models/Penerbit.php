<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penerbit extends Model
{
    use HasFactory;

    protected $table = 'penerbits';
    protected $primaryKey = 'id_penerbit';
    
    protected $fillable = [
        'kode_penerbit',
        'nama_penerbit',
        'verif_penerbit'
    ];

    protected $casts = [
        'verif_penerbit' => 'string'
    ];

    /**
     * Relasi ke tabel buku
     */
    public function buku(): HasMany
    {
        return $this->hasMany(Buku::class, 'id_penerbit');
    }

    /**
     * Scope untuk penerbit terverifikasi
     */
    public function scopeTerverifikasi($query)
    {
        return $query->where('verif_penerbit', 'Terverifikasi');
    }

    /**
     * Scope untuk penerbit belum terverifikasi
     */
    public function scopeBelumTerverifikasi($query)
    {
        return $query->where('verif_penerbit', 'Belum Terverifikasi');
    }

    /**
     * Generate kode penerbit otomatis
     */
    public static function generateKodePenerbit()
    {
        $count = self::count() + 1;
        return 'PBL' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}