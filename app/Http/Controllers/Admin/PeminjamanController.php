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
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->when($search, function($query, $search) {
                return $query->whereHas('user', function($q) use ($search) {
                    $q->where('fullname', 'like', "%{$search}%")
                      ->orWhere('kode_user', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%");
                })->orWhereHas('buku', function($q) use ($search) {
                    $q->where('judul_buku', 'like', "%{$search}%");
                });
            })
            ->when($status, function($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.peminjaman.index', compact('peminjaman', 'search', 'status'));
    }

    public function create()
    {
        $anggota = User::where('role', 'anggota')
            ->where('verif', 'Terverifikasi')
            ->orderBy('fullname')
            ->get();
            
        $buku = Buku::where('j_buku_baik', '>', 0)
            ->orderBy('judul_buku')
            ->get();
        
        return view('admin.peminjaman.create', compact('anggota', 'buku'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_buku' => 'required|exists:bukus,id_buku',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after:tanggal_peminjaman',
            'kondisi_buku_saat_dipinjam' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan' => 'nullable|string|max:500'
        ]);

        // Check book availability
        $buku = Buku::find($validated['id_buku']);
        if ($buku->j_buku_baik < 1) {
            return redirect()->back()
                ->with('error', 'Stok buku tidak tersedia!')
                ->withInput();
        }

        // Check if user already borrowed this book
        $existingPeminjaman = Peminjaman::where('id_user', $validated['id_user'])
            ->where('id_buku', $validated['id_buku'])
            ->where('status', 'Dipinjam')
            ->exists();
            
        if ($existingPeminjaman) {
            return redirect()->back()
                ->with('error', 'Anggota sudah meminjam buku ini!')
                ->withInput();
        }

        // Create peminjaman
        $peminjaman = Peminjaman::create([
            'id_user' => $validated['id_user'],
            'id_buku' => $validated['id_buku'],
            'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
            'tanggal_harus_kembali' => $validated['tanggal_harus_kembali'],
            'kondisi_buku_saat_dipinjam' => $validated['kondisi_buku_saat_dipinjam'],
            'catatan' => $validated['catatan'] ?? null,
            'status' => 'Dipinjam'
        ]);

        // Update book stock
        $buku->decrement('j_buku_baik');

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan!');
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggota = User::where('role', 'anggota')
            ->where('verif', 'Terverifikasi')
            ->orderBy('fullname')
            ->get();
        $buku = Buku::orderBy('judul_buku')->get();
        
        return view('admin.peminjaman.edit', compact('peminjaman', 'anggota', 'buku'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_buku' => 'required|exists:bukus,id_buku',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_harus_kembali' => 'required|date|after:tanggal_peminjaman',
            'kondisi_buku_saat_dipinjam' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan' => 'nullable|string|max:500'
        ]);

        $peminjaman->update($validated);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status === 'Dipinjam') {
            // Return book stock
            $peminjaman->buku->increment('j_buku_baik');
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus!');
    }

    public function returnBook(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status === 'Dikembalikan') {
            return redirect()->back()
                ->with('error', 'Buku sudah dikembalikan sebelumnya!');
        }

        $validated = $request->validate([
            'kondisi_buku_saat_dikembalikan' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'catatan_pengembalian' => 'nullable|string|max:500'
        ]);

        $peminjaman->update([
            'status' => 'Dikembalikan',
            'tanggal_pengembalian' => Carbon::now(),
            'kondisi_buku_saat_dikembalikan' => $validated['kondisi_buku_saat_dikembalikan'],
            'catatan' => $validated['catatan_pengembalian'] ?? $peminjaman->catatan
        ]);

        // Return book stock
        $peminjaman->buku->increment('j_buku_baik');

        // Hitung denda otomatis
        $peminjaman->hitungDenda();

        return redirect()->back()
            ->with('success', 'Buku berhasil dikembalikan!');
    }

    public function extendDueDate(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $validated = $request->validate([
            'tanggal_harus_kembali_baru' => 'required|date|after:' . $peminjaman->tanggal_harus_kembali
        ]);

        $peminjaman->update([
            'tanggal_harus_kembali' => $validated['tanggal_harus_kembali_baru']
        ]);

        return redirect()->back()
            ->with('success', 'Tanggal jatuh tempo berhasil diperpanjang!');
    }
}