cr@extends('layouts.app')

@section('title', 'Data Penerbit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-building"></i> Data Penerbit</h2>
    <a href="{{ route('penerbit.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Penerbit
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Daftar Penerbit Buku</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode Penerbit</th>
                        <th>Nama Penerbit</th>
                        <th>Status Verifikasi</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penerbits as $index => $penerbit)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $penerbit->kode_penerbit }}</strong></td>
                        <td>{{ $penerbit->nama_penerbit }}</td>
                        <td>
                            <span class="badge bg-{{ $penerbit->verif_penerbit == 'Terverifikasi' ? 'success' : 'warning' }}">
                                {{ $penerbit->verif_penerbit }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($penerbit->created_at)->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('penerbit.edit', $penerbit->id_penerbit) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('penerbit.destroy', $penerbit->id_penerbit) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus penerbit ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-building fa-3x mb-3"></i>
                            <p>Belum ada data penerbit.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($penerbits->count() > 0)
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Menampilkan {{ $penerbits->count() }} dari {{ $penerbits->total() }} penerbit
            </div>
        </div>
        @endif
    </div>
</div>
@endsection