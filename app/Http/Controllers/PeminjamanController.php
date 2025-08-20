<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->get();
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggota = User::where('role', 'anggota')->where('verif', 'Terverifikasi')->get();
        $buku = Buku::where('j_buku_baik', '>', 0)->get();
        return view('peminjaman.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_buku' => 'required|exists:bukus,id_buku',
            'kondisi_buku_saat_dipinjam' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'tanggal_harus_kembali' => 'required|date|after:today',
        ]);

        // Cek stok buku
        $buku = Buku::find($request->id_buku);
        if ($buku->j_buku_baik <= 0) {
            return back()->withErrors(['id_buku' => 'Buku tidak tersedia untuk dipinjam.']);
        }

        Peminjaman::create([
            'id_user' => $request->id_user,
            'id_buku' => $request->id_buku,
            'tanggal_peminjaman' => now(),
            'tanggal_harus_kembali' => $request->tanggal_harus_kembali,
            'kondisi_buku_saat_dipinjam' => $request->kondisi_buku_saat_dipinjam,
            'status' => 'Dipinjam',
        ]);

        // Kurangi stok buku
        $buku->decrement('j_buku_baik');

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function pengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status === 'Dikembalikan') {
            return redirect()->route('peminjaman.index')->with('error', 'Buku sudah dikembalikan.');
        }

        return view('peminjaman.pengembalian', compact('peminjaman'));
    }

    public function processPengembalian(Request $request, $id)
    {
        $request->validate([
            'kondisi_buku_saat_dikembalikan' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'tanggal_pengembalian' => now(),
            'kondisi_buku_saat_dikembalikan' => $request->kondisi_buku_saat_dikembalikan,
            'status' => 'Dikembalikan',
        ]);

        // Tambah stok buku kembali
        $buku = Buku::find($peminjaman->id_buku);
        $buku->increment('j_buku_baik');

        return redirect()->route('peminjaman.index')->with('success', 'Pengembalian berhasil diproses.');
    }
}