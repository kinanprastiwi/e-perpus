<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    use HasFactory;

    protected $table = 'pesan';
    protected $primaryKey = 'id_pesan';

    protected $fillable = [
        'penerima',
        'pengirim',
        'judul_pesan',
        'isi_pesan',
        'status',
        'tanggal_kirim'
    ];

    protected $casts = [
        'tanggal_kirim' => 'datetime'
    ];

    public function penerimaUser()
    {
        return $this->belongsTo(User::class, 'penerima');
    }

    public function pengirimUser()
    {
        return $this->belongsTo(User::class, 'pengirim');
    }
}