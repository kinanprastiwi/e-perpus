<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\Kategori;
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Pastikan nama kolom sesuai database Anda
        $peminjamanAktif = Peminjaman::where('id_user', $user->id)
            ->where('status_peminjaman', 'Dipinjam')
            ->count();
            
        $totalPeminjaman = Peminjaman::where('id_user', $user->id)->count();
        
        // Buku terbaru dengan pagination
        $bukuTerbaru = Buku::with('kategori')
            ->where('jumlah_stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('user.dashboard', compact('user', 'peminjamanAktif', 'totalPeminjaman', 'bukuTerbaru'));
    }

    public function peminjaman()
    {
        $user = auth()->user();
        $peminjaman = Peminjaman::with(['buku', 'buku.kategori'])
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.peminjaman', compact('user', 'peminjaman'));
    }

    public function pengembalian()
    {
        $user = auth()->user();
        $pengembalian = Peminjaman::with(['buku', 'buku.kategori'])
            ->where('id_user', $user->id)
            ->where('status_peminjaman', 'Dikembalikan')
            ->orderBy('tanggal_pengembalian', 'desc')
            ->paginate(10);

        return view('user.pengembalian', compact('user', 'pengembalian'));
    }

    public function buku(Request $request)
    {
        $search = $request->get('search');
        
        $buku = Buku::with('kategori')
            ->when($search, function($query) use ($search) {
                return $query->where('judul', 'like', '%'.$search.'%')
                           ->orWhere('penulis', 'like', '%'.$search.'%')
                           ->orWhere('penerbit', 'like', '%'.$search.'%');
            })
            ->where('jumlah_stok', '>', 0)
            ->orderBy('judul')
            ->paginate(12);

        return view('user.buku', compact('buku', 'search'));
    }

    public function profil()
    {
        $user = auth()->user();
        $riwayatPeminjaman = Peminjaman::with('buku')
            ->where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.profil', compact('user', 'riwayatPeminjaman'));
    }

    // ✅ Method baru untuk detail buku
    public function detailBuku($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('user.detail-buku', compact('buku'));
    }

    // ✅ Method untuk pinjam buku
    public function pinjamBuku(Request $request, $id)
    {
        $request->validate([
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman'
        ]);

        $buku = Buku::findOrFail($id);
        
        if ($buku->jumlah_stok < 1) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam');
        }

        // Buat peminjaman
        Peminjaman::create([
            'id_user' => auth()->id(),
            'id_buku' => $id,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status_peminjaman' => 'Dipinjam'
        ]);

        // Kurangi stok buku
        $buku->decrement('jumlah_stok');

        return redirect()->route('user.peminjaman')
            ->with('success', 'Buku berhasil dipinjam');
}
    }