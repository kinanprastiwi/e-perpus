<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_user',
        'id_buku',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
        'tanggal_harus_kembali',
        'kondisi_buku_saat_dipinjam',
        'kondisi_buku_saat_dikembalikan',
        'denda',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'datetime:Y-m-d',
        'tanggal_pengembalian' => 'datetime:Y-m-d',
        'tanggal_harus_kembali' => 'datetime:Y-m-d',
        'denda' => 'decimal:2'
    ];

    // Relasi dengan user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi dengan buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    // Hitung denda otomatis
    public function hitungDenda()
    {
        if (in_array($this->status, ['Dikembalikan', 'Terlambat']) && $this->tanggal_pengembalian) {
            $jatuhTempo = Carbon::parse($this->tanggal_harus_kembali);
            $kembali = Carbon::parse($this->tanggal_pengembalian);
            
            // Hanya hitung denda jika pengembalian terlambat
            if ($kembali->gt($jatuhTempo)) {
                $hariTerlambat = $jatuhTempo->diffInDays($kembali);
                $dendaPerHari = 5000; // Rp 5.000 per hari
                $this->denda = $hariTerlambat * $dendaPerHari;
                $this->save();
            } else {
                // Reset denda jika tidak terlambat
                $this->denda = 0;
                $this->save();
            }
        }
        return $this->denda;
    }

    // Cek status keterlambatan
    public function cekKeterlambatan()
    {
        if ($this->status === 'Dipinjam') {
            $sekarang = now();
            $jatuhTempo = Carbon::parse($this->tanggal_harus_kembali);
            
            if ($sekarang->gt($jatuhTempo)) {
                $this->status = 'Terlambat';
                $this->save();
                
                // Otomatis hitung denda harian untuk yang terlambat
                $hariTerlambat = $jatuhTempo->diffInDays($sekarang);
                $dendaPerHari = 5000;
                $this->denda = $hariTerlambat * $dendaPerHari;
                $this->save();
            }
        }
        return $this->status;
    }

    // Scope untuk peminjaman aktif
    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['Dipinjam', 'Terlambat']);
    }

    // Scope untuk yang sudah dikembalikan
    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'Dikembalikan');
    }

    // Scope untuk yang terlambat
    public function scopeTerlambat($query)
    {
        return $query->where('status', 'Terlambat');
    }

    // Accessor untuk status dengan warna
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Dipinjam' => 'yellow',
            'Dikembalikan' => 'green',
            'Terlambat' => 'red',
            default => 'gray'
        };
    }

    // Accessor untuk format denda
    public function getDendaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->denda, 0, ',', '.');
    }

    // Method untuk mengembalikan buku
    public function kembalikanBuku($kondisi, $catatan = null)
    {
        $this->update([
            'status' => 'Dikembalikan',
            'tanggal_pengembalian' => now(),
            'kondisi_buku_saat_dikembalikan' => $kondisi,
            'catatan' => $catatan ?? $this->catatan
        ]);

        // Kembalikan stok buku
        if ($this->buku) {
            $this->buku->increment('j_buku_baik');
        }

        // Hitung denda
        $this->hitungDenda();

        return $this;
    }
}