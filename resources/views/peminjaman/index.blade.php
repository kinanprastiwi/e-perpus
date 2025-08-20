@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-exchange-alt"></i> Data Peminjaman Buku</h2>
    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Peminjaman Baru
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
        <h5 class="mb-0">Daftar Peminjaman Buku</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Harus Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $pinjam)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $pinjam->user->fullname }}</td>
                        <td>{{ $pinjam->buku->judul_buku }}</td>
                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_peminjaman)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_harus_kembali)->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $today = \Carbon\Carbon::now();
                                $kembali = \Carbon\Carbon::parse($pinjam->tanggal_harus_kembali);
                                $isLate = $today->gt($kembali) && $pinjam->status == 'Dipinjam';
                            @endphp
                            <span class="badge bg-{{ $pinjam->status == 'Dipinjam' ? ($isLate ? 'danger' : 'warning') : 'success' }}">
                                {{ $pinjam->status }}{{ $isLate ? ' (Terlambat)' : '' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                @if($pinjam->status == 'Dipinjam')
                                <a href="{{ route('peminjaman.pengembalian', $pinjam->id_peminjaman) }}" 
                                   class="btn btn-sm btn-success" title="Pengembalian">
                                    <i class="fas fa-undo"></i> Kembalikan
                                </a>
                                @endif
                                <button class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="fas fa-exchange-alt fa-3x mb-3"></i>
                            <p>Belum ada data peminjaman.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection