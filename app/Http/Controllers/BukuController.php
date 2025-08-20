<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    public function index()
    {
        $books = Buku::with('kategori')->get();
        return response()->json($books);
    }

    public function publicIndex()
    {
        $books = Buku::with('kategori')
            ->where('status', 'Tersedia')
            ->get();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|integer',
            'kategori_id' => 'required|exists:kategoris,id',
            'isbn' => 'nullable|string|unique:bukus,isbn',
            'jumlah_halaman' => 'nullable|integer',
            'sinopsis' => 'nullable|string',
            'cover' => 'nullable|string',
            'status' => 'required|in:Tersedia,Dipinjam,Rusak,Hilang',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $book = Buku::create($request->all());

        return response()->json([
            'message' => 'Book created successfully',
            'book' => $book
        ], 201);
    }

    public function show($id)
    {
        $book = Buku::with('kategori')->find($id);
        
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book);
    }

    public function update(Request $request, $id)
    {
        $book = Buku::find($id);
        
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:255',
            'penulis' => 'sometimes|required|string|max:255',
            'penerbit' => 'sometimes|required|string|max:255',
            'tahun_terbit' => 'sometimes|required|integer',
            'kategori_id' => 'sometimes|required|exists:kategoris,id',
            'isbn' => 'sometimes|nullable|string|unique:bukus,isbn,' . $id,
            'status' => 'sometimes|required|in:Tersedia,Dipinjam,Rusak,Hilang',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $book->update($request->all());

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => $book
        ]);
    }

    public function destroy($id)
    {
        $book = Buku::find($id);
        
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Cek jika buku sedang dipinjam
        if ($book->status === 'Dipinjam') {
            return response()->json([
                'message' => 'Cannot delete book that is currently borrowed'
            ], 400);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }

    public function search($keyword)
    {
        $books = Buku::with('kategori')
            ->where('judul', 'like', "%$keyword%")
            ->orWhere('penulis', 'like', "%$keyword%")
            ->orWhere('penerbit', 'like', "%$keyword%")
            ->orWhere('isbn', 'like', "%$keyword%")
            ->get();

        return response()->json($books);
    }

    public function popularBooks()
    {
        $popularBooks = Buku::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($popularBooks);
    }
}