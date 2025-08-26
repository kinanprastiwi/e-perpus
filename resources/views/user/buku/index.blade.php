<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku - E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    @extends('user.layouts.app')
    
    @section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Koleksi Buku</h2>
        
        <!-- Search Form -->
        <form action="{{ route('user.buku.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari buku..." value="{{ $search }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Cari
                </button>
            </div>
        </form>

        <!-- Books Grid -->
        <div class="row">
            @forelse($buku as $book)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($book->cover_buku)
                    <img src="{{ asset('storage/' . $book->cover_buku) }}" class="card-img-top" alt="{{ $book->judul_buku }}" style="height: 200px; object-fit: cover;">
                    @else
                    <div class="text-center py-5 bg-light">
                        <i class="fas fa-book fa-3x text-muted"></i>
                    </div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->judul_buku }}</h5>
                        <p class="card-text">
                            <strong>Penulis:</strong> {{ $book->pengarang }}<br>
                            <strong>Tahun:</strong> {{ $book->tahun_terbit }}<br>
                            <strong>Kategori:</strong> {{ $book->kategori->nama_kategori ?? '-' }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <span class="badge bg-{{ $book->j_buku_baik > 0 ? 'success' : 'danger' }}">
                            {{ $book->j_buku_baik > 0 ? 'Tersedia: ' . $book->j_buku_baik : 'Habis' }}
                        </span>
                        <a href="{{ route('user.buku.show', $book->id_buku) }}" class="btn btn-primary btn-sm float-end">Detail</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> Tidak ada buku yang ditemukan.
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($buku->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $buku->links() }}
        </div>
        @endif
    </div>
    @endsection
</body>
</html>