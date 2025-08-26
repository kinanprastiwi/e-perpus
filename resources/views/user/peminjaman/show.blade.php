@extends('user.layouts.app')

@section('title', 'Detail Peminjaman')
@section('page-title', 'Detail Peminjaman')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Kode Peminjaman:</strong></div>
                    <div class="col-sm-8">#{{ $peminjaman->id_peminjaman }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Judul Buku:</strong></div>
                    <div class="col-sm-8">{{ $peminjaman->buku->judul_buku ?? 'Buku tidak ditemukan' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Tanggal Pinjam:</strong></div>
                    <div class="col-sm-8">{{ $peminjaman->tanggal_peminjaman->format('d M Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Jatuh Tempo:</strong></div>
                    <div class="col-sm-8">{{ $peminjaman->tanggal_harus_kembali->format('d M Y') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Tanggal Kembali:</strong></div>
                    <div class="col-sm-8">
                        @if($peminjaman->tanggal_pengembalian)
                            {{ $peminjaman->tanggal_pengembalian->format('d M Y') }}
                        @else
                            <span class="text-muted">Belum dikembalikan</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Status:</strong></div>
                    <div class="col-sm-8">
                        <span class="badge bg-{{ $peminjaman->status == 'Dipinjam' ? 'warning' : ($peminjaman->status == 'Dikembalikan' ? 'success' : 'danger') }}">
                            {{ $peminjaman->status }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Denda:</strong></div>
                    <div class="col-sm-8">
                        @if($peminjaman->denda > 0)
                            Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Kondisi Buku:</strong></div>
                    <div class="col-sm-8">{{ $peminjaman->kondisi_buku_saat_dipinjam }}</div>
                </div>
                @if($peminjaman->catatan)
                <div class="row mb-3">
                    <div class="col-sm-4"><strong>Catatan:</strong></div>
                    <div class="col-sm-8">{{ $peminjaman->catatan }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Buku</h5>
            </div>
            <div class="card-body">
                @if($peminjaman->buku->cover_buku)
                <img src="{{ asset('storage/' . $peminjaman->buku->cover_buku) }}" class="img-fluid rounded mb-3" alt="{{ $peminjaman->buku->judul_buku }}">
                @endif
                
                <p><strong>Penulis:</strong> {{ $peminjaman->buku->pengarang ?? '-' }}</p>
                <p><strong>Penerbit:</strong> {{ $peminjaman->buku->penerbit->nama_penerbit ?? '-' }}</p>
                <p><strong>ISBN:</strong> {{ $peminjaman->buku->isbn ?? '-' }}</p>
                <p><strong>Kategori:</strong> {{ $peminjaman->buku->kategori->nama_kategori ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('user.peminjaman.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Peminjaman
    </a>
</div>
@endsection