<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemberitahuan extends Model
{
    use HasFactory;

    protected $table = 'pemberitahuan';
    protected $primaryKey = 'id_pemberitahuan';

    protected $fillable = [
        'isi_pemberitahuan',
        'level_user',
        'status'
    ];
}