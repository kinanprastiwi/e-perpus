<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User\Buku; // IMPORT MODEL BUKU
use Illuminate\Http\Request;

class BukuController extends Controller // EXTENDS CONTROLLER
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $buku = Buku::with('kategori')
            ->when($search, function($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                           ->orWhere('pengarang', 'like', "%{$search}%")
                           ->orWhere('isbn', 'like', "%{$search}%");
            })
            ->where('j_buku_baik', '>', 0)
            ->orderBy('judul_buku')
            ->paginate(12);

        return view('user.buku.index', compact('buku', 'search'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategori', 'penerbit')->findOrFail($id);
        return view('user.buku.show', compact('buku'));
    }
}