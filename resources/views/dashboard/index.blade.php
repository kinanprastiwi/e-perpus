@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h2>Dashboard Administrator</h2>
        <p class="text-muted">Selamat datang, {{ Auth::user()->fullname }}</p>
    </div>
</div>

<div class="row mt-4">
    <!-- Statistik Cards -->
    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-primary mb-2">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <h3>{{ $stats['anggota'] }}</h3>
                <p class="text-muted mb-0">Anggota</p>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-success mb-2">
                    <i class="fas fa-book fa-2x"></i>
                </div>
                <h3>{{ $stats['buku'] }}</h3>
                <p class="text-muted mb-0">Buku</p>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-info mb-2">
                    <i class="fas fa-tags fa-2x"></i>
                </div>
                <h3>{{ $stats['kategori'] }}</h3>
                <p class="text-muted mb-0">Kategori</p>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-warning mb-2">
                    <i class="fas fa-building fa-2x"></i>
                </div>
                <h3>{{ $stats['penerbit'] }}</h3>
                <p class="text-muted mb-0">Penerbit</p>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-danger mb-2">
                    <i class="fas fa-exchange-alt fa-2x"></i>
                </div>
                <h3>{{ $stats['peminjaman_aktif'] }}</h3>
                <p class="text-muted mb-0">Peminjaman Aktif</p>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4 col-sm-6 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-secondary mb-2">
                    <i class="fas fa-undo fa-2x"></i>
                </div>
                <h3>{{ $stats['pengembalian'] }}</h3>
                <p class="text-muted mb-0">Pengembalian</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Peminjaman -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Peminjaman Terbaru</h5>
            </div>
            <div class="card-body">
                @if($recent_peminjaman->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent_peminjaman as $peminjaman)
                            <tr>
                                <td>{{ $peminjaman->user->fullname }}</td>
                                <td>{{ $peminjaman->buku->judul_buku }}</td>
                                <td>{{ $peminjaman->tanggal_peminjaman }}</td>
                                <td>
                                    <span class="badge bg-{{ $peminjaman->status == 'Dipinjam' ? 'warning' : 'success' }}">
                                        {{ $peminjaman->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted">Belum ada data peminjaman.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection