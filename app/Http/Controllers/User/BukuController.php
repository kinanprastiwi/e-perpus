
<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $buku = Buku::when($search, function($query, $search) {
                return $query->where('judul', 'like', "%{$search}%")
                           ->orWhere('penulis', 'like', "%{$search}%")
                           ->orWhere('penerbit', 'like', "%{$search}%");
            })
            ->where('stok', '>', 0)
            ->orderBy('judul')
            ->paginate(12);

        return view('user.buku.index', compact('buku', 'search'));
    }

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('user.buku.show', compact('buku'));
    }
}