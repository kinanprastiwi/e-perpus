<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku; // PASTIKAN IMPORT MODEL BUKU YANG BENAR
use App\Models\Peminjaman; // PASTIKAN IMPORT MODEL PEMINJAMAN YANG BENAR
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $peminjaman = Peminjaman::with('buku')
            ->where('id_user', $user->id_user)
            ->orderBy('tanggal_peminjaman', 'desc') // SESUAI MIGRATION
            ->paginate(10);
            
        return view('user.peminjaman.index', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('id_peminjaman', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();
            
        return view('user.peminjaman.show', compact('peminjaman'));
    }

    public function pinjam(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $user = Auth::user();

        // Validasi stok buku
        if ($buku->j_buku_baik <= 0) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia untuk dipinjam');
        }

        // Validasi apakah user sudah meminjam buku yang sama dan belum dikembalikan
        $peminjamanAktif = Peminjaman::where('id_user', $user->id_user)
            ->where('id_buku', $id)
            ->whereIn('status', ['Dipinjam', 'Terlambat'])
            ->exists();

        if ($peminjamanAktif) {
            return redirect()->back()
                ->with('error', 'Anda sudah meminjam buku ini dan belum dikembalikan');
        }

        // Buat peminjaman baru
        $peminjaman = Peminjaman::create([
            'id_user' => $user->id_user,
            'id_buku' => $id,
            'tanggal_peminjaman' => now(),
            'tanggal_harus_kembali' => now()->addDays(7),
            'kondisi_buku_saat_dipinjam' => 'Baik',
            'status' => 'Dipinjam',
            'catatan' => $request->catatan ?? null
        ]);

        // Kurangi stok buku
        $buku->decrement('j_buku_baik');

        return redirect()->route('user.peminjaman.index')
            ->with('success', 'Buku berhasil dipinjam. Jangan lupa dikembalikan sebelum ' 
                . $peminjaman->tanggal_harus_kembali->format('d M Y'));
    }
}