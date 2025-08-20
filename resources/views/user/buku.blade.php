<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koleksi Buku - E-Perpus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @extends('user.layouts.app')
    
    @section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Koleksi Buku</h2>
        
        <!-- Search Form -->
        <form action="{{ route('user.buku') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari buku..." value="{{ $search }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Books Grid -->
        <div class="row">
            @foreach($buku as $book)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book->judul }}</h5>
                        <p class="card-text">
                            <strong>Penulis:</strong> {{ $book->penulis }}<br>
                            <strong>Penerbit:</strong> {{ $book->penerbit }}<br>
                            <strong>Tahun:</strong> {{ $book->tahun_terbit }}<br>
                            <strong>Kategori:</strong> {{ $book->kategori->nama_kategori ?? '-' }}
                        </p>
                    </div>
                    <div class="card-footer">
                        <span class="badge bg-success">Tersedia: {{ $book->jumlah_stok }}</span>
                        <a href="{{ route('user.detail-buku', $book->id) }}" class="btn btn-primary btn-sm float-end">Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $buku->links() }}
        </div>
    </div>
    @endsection
</body>
</html>