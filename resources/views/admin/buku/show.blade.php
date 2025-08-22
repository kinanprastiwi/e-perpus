@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-book"></i> Detail Buku
    </h2>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informasi Buku</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">ISBN:</div>
                    <div class="col-sm-9">{{ $buku->isbn ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Judul Buku:</div>
                    <div class="col-sm-9">{{ $buku->judul_buku }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Pengarang:</div>
                    <div class="col-sm-9">{{ $buku->pengarang }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Tahun Terbit:</div>
                    <div class="col-sm-9">{{ $buku->tahun_terbit }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Stok Baik:</div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $buku->j_buku_baik > 0 ? 'success' : 'danger' }}">
                            {{ $buku->j_buku_baik }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Stok Rusak:</div>
                    <div class="col-sm-9">
                        <span class="badge bg-{{ $buku->j_buku_rusak > 0 ? 'warning' : 'secondary' }}">
                            {{ $buku->j_buku_rusak }}
                        </span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Kategori:</div>
                    <div class="col-sm-9">{{ $buku->kategori->nama_kategori ?? '-' }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3 fw-bold">Penerbit:</div>
                    <div class="col-sm-9">{{ $buku->penerbit->nama_penerbit ?? '-' }}</div>
                </div>
                <div class="row">
                    <div class="col-sm-3 fw-bold">Deskripsi:</div>
                    <div class="col-sm-9">
                        {{ $buku->deskripsi ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Aksi</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.buku.edit', $buku->id_buku) }}" class="btn btn-warning mb-2">
                        <i class="fas fa-edit"></i> Edit Buku
                    </a>
                    <form action="{{ route('admin.buku.destroy', $buku->id_buku) }}" method="POST" class="d-grid">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus buku ini?')">
                            <i class="fas fa-trash"></i> Hapus Buku
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistik</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="display-4 text-primary">{{ $buku->j_buku_baik }}</div>
                    <p>Stok Baik</p>
                </div>
                <div class="text-center">
                    <div class="display-4 text-warning">{{ $buku->j_buku_rusak }}</div>
                    <p>Stok Rusak</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
