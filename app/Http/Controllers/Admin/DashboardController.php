<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        // Chart data - peminjaman per bulan
        $peminjamanPerBulan = Peminjaman::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

        // Buku paling populer
        $bukuPopuler = Buku::withCount(['peminjaman as total_pinjam'])
            ->orderBy('total_pinjam', 'desc')
            ->take(5)
            ->get();

        $recentLoans = Peminjaman::with(['user', 'buku'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats', 
            'recentLoans', 
            'peminjamanPerBulan',
            'bukuPopuler'
        ));
    }

    public function getChartData()
    {
        $data = Peminjaman::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
        ->whereDate('created_at', '>=', Carbon::now()->subDays(30))
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        return response()->json($data);
    }
}