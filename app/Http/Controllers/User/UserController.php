<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        
        $peminjaman_aktif = Peminjaman::where('id_user', $user->id_user)
            ->where('status', 'Dipinjam')
            ->count();
            
        $total_peminjaman = Peminjaman::where('id_user', $user->id_user)->count();
        $buku_dikembalikan = Peminjaman::where('id_user', $user->id_user)
            ->where('status', 'Dikembalikan')
            ->count();
            
        $buku_tersedia = Buku::where('stok', '>', 0)->count();
        
        $peminjaman_aktif_list = Peminjaman::with('buku')
            ->where('id_user', $user->id_user)
            ->where('status', 'Dipinjam')
            ->orderBy('tgl_pinjam', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'peminjaman_aktif',
            'total_peminjaman',
            'buku_dikembalikan',
            'buku_tersedia',
            'peminjaman_aktif_list'
        ));
    }

    public function profil()
    {
        $user = auth()->user();
        return view('user.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'kelas' => 'required|string|max:50',
            'alamat' => 'required|string'
        ]);

        $user->update($validated);

        return redirect()->route('user.profil')
            ->with('success', 'Profil berhasil diperbarui');
    }
}