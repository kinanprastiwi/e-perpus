@extends('user.layouts.app')

@section('title', 'Detail Buku')
@section('page-title', 'Detail Buku')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($buku->cover_buku)
                <img src="{{ asset('storage/' . $buku->cover_buku) }}" class="img-fluid rounded" alt="{{ $buku->judul_buku }}">
                @else
                <div class="py-5 bg-light">
                    <i class="fas fa-book fa-5x text-muted"></i>
                </div>
                @endif
                
                <div class="mt-3">
                    <span class="badge bg-{{ $buku->j_buku_baik > 0 ? 'success' : 'danger' }} fs-6">
                        {{ $buku->j_buku_baik > 0 ? 'Tersedia: ' . $buku->j_buku_baik : 'Habis' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h3>{{ $buku->judul_buku }}</h3>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><strong>Penulis:</strong> {{ $buku->pengarang }}</p>
                        <p><strong>Penerbit:</strong> {{ $buku->penerbit->nama_penerbit ?? '-' }}</p>
                        <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>ISBN:</strong> {{ $buku->isbn }}</p>
                        <p><strong>Kategori:</strong> {{ $buku->kategori->nama_kategori ?? '-' }}</p>
                        <p><strong>Buku Rusak:</strong> {{ $buku->j_buku_rusak }}</p>
                    </div>
                </div>
                
                @if($buku->deskripsi)
                <div class="mt-3">
                    <strong>Deskripsi:</strong>
                    <p class="text-muted">{{ $buku->deskripsi }}</p>
                </div>
                @endif
                
                <div class="mt-4">
                    @if($buku->j_buku_baik > 0)
                    <!-- PERBAIKAN: GANTI DENGAN FORM POST -->
                    <form action="{{ route('user.buku.pinjam', $buku->id_buku) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-book"></i> Pinjam Buku
                        </button>
                    </form>
                    @else
                    <button class="btn btn-secondary" disabled>
                        <i class="fas fa-times-circle"></i> Buku Tidak Tersedia
                    </button>
                    @endif
                    
                    <!-- PERBAIKAN: TAMBAHKAN TEXT UNTUK BUTTON KEMBALI -->
                    <a href="{{ route('user.buku.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Koleksi Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- TAMBAHKAN ALERT UNTUK NOTIFIKASI -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@endsection