<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'kode_user',
        'nis',
        'fullname',
        'username',
        'password',
        'kelas',
        'alamat',
        'verif',
        'role',
        'join_date',
        'terakhir_login'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'join_date' => 'date',
        'terakhir_login' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'id_user');
    }

    public function pesanDiterima()
    {
        return $this->hasMany(Pesan::class, 'penerima');
    }

    public function pesanDikirim()
    {
        return $this->hasMany(Pesan::class, 'pengirim');
    }
}