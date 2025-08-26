@extends('user.layouts.app')

@section('title', 'Pinjam Buku')
@section('page-title', 'Pinjam Buku')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Form Peminjaman</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('buku.pinjam', $buku->id_buku) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" value="{{ $buku->judul_buku }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" class="form-control" value="{{ $buku->pengarang }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Perkiraan Tanggal Kembali</label>
                        <input type="text" class="form-control" value="{{ now()->addDays(7)->format('d M Y') }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan jika perlu"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Konfirmasi Peminjaman
                    </button>
                    <a href="{{ route('user.buku.show', $buku->id_buku) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Buku</h5>
            </div>
            <div class="card-body">
                @if($buku->cover_buku)
                <img src="{{ asset('storage/' . $buku->cover_buku) }}" class="img-fluid rounded mb-3" alt="{{ $buku->judul_buku }}">
                @endif
                
                <p><strong>ISBN:</strong> {{ $buku->isbn }}</p>
                <p><strong>Penerbit:</strong> {{ $buku->penerbit->nama_penerbit ?? '-' }}</p>
                <p><strong>Kategori:</strong> {{ $buku->kategori->nama_kategori ?? '-' }}</p>
                <p><strong>Tersedia:</strong> {{ $buku->j_buku_baik }} buku</p>
            </div>
        </div>
    </div>
</div>
@endsection