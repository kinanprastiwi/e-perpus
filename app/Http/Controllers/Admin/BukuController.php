<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $bukus = Buku::with('kategori', 'penerbit')
            ->when($search, function($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                           ->orWhere('pengarang', 'like', "%{$search}%")
                           ->orWhereHas('penerbit', function($q) use ($search) {
                               $q->where('nama_penerbit', 'like', "%{$search}%");
                           })
                           ->orWhere('isbn', 'like', "%{$search}%");
            })
            ->orderBy('judul_buku')
            ->paginate(10);

        return view('admin.buku.index', compact('bukus', 'search'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $penerbits = Penerbit::orderBy('nama_penerbit')->get();
        
        return view('admin.buku.create', compact('kategoris', 'penerbits'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'id_penerbit' => 'required|exists:penerbits,id_penerbit',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'isbn' => 'nullable|string|max:50|unique:bukus,isbn',
            'j_buku_baik' => 'required|integer|min:0',
            'j_buku_rusak' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'cover_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('cover_buku')) {
            $file = $request->file('cover_buku');
            $filename = time() . '_' . Str::slug($validated['judul_buku']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/covers', $filename);
            $validated['cover_buku'] = $filename;
        }

        Buku::create($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    public function show(Buku $buku)
    {
        $buku->load('kategori', 'penerbit');
        return view('admin.buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $penerbits = Penerbit::orderBy('nama_penerbit')->get();
        
        return view('admin.buku.edit', compact('buku', 'kategoris', 'penerbits'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'judul_buku' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'id_penerbit' => 'required|exists:penerbits,id_penerbit',
            'pengarang' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'isbn' => 'nullable|string|max:50|unique:bukus,isbn,' . $buku->id_buku . ',id_buku',
            'j_buku_baik' => 'required|integer|min:0',
            'j_buku_rusak' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
            'cover_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('cover_buku')) {
            // Delete old cover if exists
            if ($buku->cover_buku && Storage::exists('public/covers/' . $buku->cover_buku)) {
                Storage::delete('public/covers/' . $buku->cover_buku);
            }
            
            $file = $request->file('cover_buku');
            $filename = time() . '_' . Str::slug($validated['judul_buku']) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/covers', $filename);
            $validated['cover_buku'] = $filename;
        }

        $buku->update($validated);

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjaman()->where('status', 'Dipinjam')->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus buku karena sedang dipinjam');
        }

        // Delete cover image if exists
        if ($buku->cover_buku && Storage::exists('public/covers/' . $buku->cover_buku)) {
            Storage::delete('public/covers/' . $buku->cover_buku);
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus');
    }

    public function updateStock(Request $request, Buku $buku)
    {
        $request->validate([
            'type' => 'required|in:baik,rusak',
            'action' => 'required|in:tambah,kurang',
            'jumlah' => 'required|integer|min:1'
        ]);

        $field = $request->type === 'baik' ? 'j_buku_baik' : 'j_buku_rusak';
        $current = $buku->$field;

        if ($request->action === 'tambah') {
            $buku->increment($field, $request->jumlah);
        } else {
            if ($current < $request->jumlah) {
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi');
            }
            $buku->decrement($field, $request->jumlah);
        }

        return redirect()->back()
            ->with('success', 'Stok buku berhasil diperbarui');
    }
    
    public function export()
    {
        // Implement export functionality
        return redirect()->back()
            ->with('success', 'Export functionality will be implemented soon');
    }
}