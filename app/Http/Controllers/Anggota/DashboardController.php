<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $stats = [
            'peminjaman_aktif_count' => Peminjaman::where('user_id', $user->id_user)
                ->where('status', 'Dipinjam')
                ->count(),
            'riwayat_count' => Peminjaman::where('user_id', $user->id_user)->count(),
        ];

        $recentLoans = Peminjaman::with('buku')
            ->where('user_id', $user->id_user)
            ->latest()
            ->take(5)
            ->get();

        return view('anggota.dashboard', compact('stats', 'recentLoans'));
    }
}