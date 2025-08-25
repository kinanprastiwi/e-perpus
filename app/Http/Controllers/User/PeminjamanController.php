
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $peminjaman = Peminjaman::with('buku')
            ->where('id_user', $user->id_user)
            ->orderBy('tgl_pinjam', 'desc')
            ->paginate(10);
            
        return view('user.peminjaman.index', compact('peminjaman'));
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('id_peminjaman', $id)
            ->where('id_user', auth()->id())
            ->firstOrFail();
            
        return view('user.peminjaman.show', compact('peminjaman'));
    }
}