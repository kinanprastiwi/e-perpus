<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Kategori;
use App\Models\Penerbit;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'anggota' => User::where('role', 'anggota')->count(),
            'buku' => Buku::count(),
            'kategori' => Kategori::count(),
            'penerbit' => Penerbit::count(),
            'peminjaman_aktif' => Peminjaman::where('status', 'Dipinjam')->count(),
            'pengembalian' => Peminjaman::where('status', 'Dikembalikan')->count(),
        ];

        $recent_peminjaman = Peminjaman::with(['user', 'buku'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recent_peminjaman'));
    }
}