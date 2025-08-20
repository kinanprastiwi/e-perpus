<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'anggota_count' => User::where('role', 'anggota')->count(),
            'buku_count' => Buku::count(),
            'kategori_count' => Kategori::count(),
            'penerbit_count' => Penerbit::count(),
            'peminjaman_aktif_count' => Peminjaman::where('status', 'Dipinjam')->count(),
            'pengembalian_count' => Peminjaman::where('status', 'Dikembalikan')->count(),
        ];

        $recentLoans = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLoans'));
    }
}