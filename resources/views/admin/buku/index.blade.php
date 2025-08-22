@extends('layouts.admin')

@section('title', 'Manajemen Buku')
@section('page-heading', 'Daftar Buku')

@section('page-actions')
    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Buku
    </a>
    <a href="{{ route('admin.buku.export') }}" class="btn btn-success btn-sm">
        <i class="fas fa-download"></i> Export
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
                <div class="search-form">
                    <form action="{{ route('admin.buku.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                               placeholder="Cari judul, pengarang, atau ISBN..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Stok Baik</th>
                                <th>Stok Rusak</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bukus as $buku)
                            <tr>
                                <td>{{ $loop->iteration + ($bukus->currentPage() - 1) * $bukus->perPage() }}</td>
                                <td>
                                    <strong>{{ $buku->judul_buku }}</strong>
                                    @if($buku->isbn)
                                    <br>
                                    <small class="text-muted">ISBN: {{ $buku->isbn }}</small>
                                    @endif
                                </td>
                                <td>{{ $buku->pengarang }}</td>
                                <td>{{ $buku->penerbit->nama_penerbit ?? 'N/A' }}</td>
                                <td>{{ $buku->tahun_terbit }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $buku->j_buku_baik }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ $buku->j_buku_rusak }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $buku->kategori->nama_kategori ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.buku.show', $buku->id_buku) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.buku.edit', $buku->id_buku) }}" 
                                           class="btn btn-primary btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.buku.destroy', $buku->id_buku) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    title="Hapus" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data buku</p>
                                    <a href="{{ route('admin.buku.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Tambah Buku Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($bukus->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $bukus->firstItem() }} hingga {{ $bukus->lastItem() }} 
                        dari {{ $bukus->total() }} entri
                    </div>
                    <nav>
                        {{ $bukus->links() }}
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table th {
        background-color: #4e73df;
        color: white;
        font-weight: bold;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.6em;
    }
    .search-form {
        width: 300px;
    }
    .pagination {
        margin-bottom: 0;
    }
</style>
@endsection