<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $anggota = User::where('role', 'anggota')->orderBy('fullname')->get();
        $buku = Buku::where('jumlah_stok', '>', 0)->orderBy('judul')->get();
        
        return view('admin.peminjaman.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'status' => 'required|in:Dipinjam,Dikembalikan'
        ]);

        // Check book availability
        $buku = Buku::find($validated['buku_id']);
        if ($buku->jumlah_stok < 1) {
            return redirect()->back()
                ->with('error', 'Stok buku tidak tersedia')
                ->withInput();
        }

        $peminjaman = Peminjaman::create($validated);

        // Update book stock
        if ($validated['status'] === 'Dipinjam') {
            $buku->decrement('jumlah_stok');
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'buku']);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $anggota = User::where('role', 'anggota')->orderBy('fullname')->get();
        $buku = Buku::orderBy('judul')->get();
        
        return view('admin.peminjaman.edit', compact('peminjaman', 'anggota', 'buku'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id_buku',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'status' => 'required|in:Dipinjam,Dikembalikan'
        ]);

        $oldStatus = $peminjaman->status;
        $oldBukuId = $peminjaman->buku_id;

        $peminjaman->update($validated);

        // Handle book stock changes
        if ($oldBukuId != $validated['buku_id']) {
            // Return old book stock
            $oldBuku = Buku::find($oldBukuId);
            if ($oldStatus === 'Dipinjam') {
                $oldBuku->increment('jumlah_stok');
            }

            // Deduct new book stock
            $newBuku = Buku::find($validated['buku_id']);
            if ($validated['status'] === 'Dipinjam') {
                $newBuku->decrement('jumlah_stok');
            }
        } else {
            // Same book, update stock based on status change
            $buku = Buku::find($validated['buku_id']);
            if ($oldStatus === 'Dipinjam' && $validated['status'] === 'Dikembalikan') {
                $buku->increment('jumlah_stok');
            } elseif ($oldStatus === 'Dikembalikan' && $validated['status'] === 'Dipinjam') {
                $buku->decrement('jumlah_stok');
            }
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        // Return book stock if still borrowed
        if ($peminjaman->status === 'Dipinjam') {
            $peminjaman->buku->increment('jumlah_stok');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }

    public function returnBook(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'Dikembalikan') {
            return redirect()->back()
                ->with('error', 'Buku sudah dikembalikan sebelumnya');
        }

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => Carbon::now()
        ]);

        // Return book stock
        $peminjaman->buku->increment('jumlah_stok');

        return redirect()->back()
            ->with('success', 'Buku berhasil dikembalikan');
    }
}