<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $penerbits = Penerbit::when($search, function($query, $search) {
                return $query->where('nama_penerbit', 'like', "%{$search}%")
                           ->orWhere('alamat', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%");
            })
            ->orderBy('nama_penerbit')
            ->paginate(10);

        return view('admin.penerbit.index', compact('penerbits', 'search'));
    }

    public function create()
    {
        return view('admin.penerbit.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerbit' => 'required|string|max:255|unique:penerbits,nama_penerbit',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:penerbits,email',
            'website' => 'nullable|url|max:255',
        ]);

        Penerbit::create($validated);

        return redirect()->route('admin.penerbit.index')
            ->with('success', 'Penerbit berhasil ditambahkan');
    }

    public function show(Penerbit $penerbit)
    {
        return view('admin.penerbit.show', compact('penerbit'));
    }

    public function edit(Penerbit $penerbit)
    {
        return view('admin.penerbit.edit', compact('penerbit'));
    }

    public function update(Request $request, Penerbit $penerbit)
    {
        $validated = $request->validate([
            'nama_penerbit' => 'required|string|max:255|unique:penerbits,nama_penerbit,' . $penerbit->id_penerbit . ',id_penerbit',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255|unique:penerbits,email,' . $penerbit->id_penerbit . ',id_penerbit',
            'website' => 'nullable|url|max:255',
        ]);

        $penerbit->update($validated);

        return redirect()->route('admin.penerbit.index')
            ->with('success', 'Penerbit berhasil diperbarui');
    }

    public function destroy(Penerbit $penerbit)
    {
        // Check if penerbit is used by any books
        if ($penerbit->buku()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus penerbit karena masih digunakan oleh buku');
        }

        $penerbit->delete();

        return redirect()->route('admin.penerbit.index')
            ->with('success', 'Penerbit berhasil dihapus');
    }
}