@extends('layouts.app')

@section('title', 'Dashboard Administrator')
@section('content')

@php
    // Default values jika $stats tidak ada
    $stats = $stats ?? [
        'anggota_count' => 0,
        'buku_count' => 0,
        'kategori_count' => 0,
        'penerbit_count' => 0,
        'peminjaman_aktif_count' => 0,
        'pengembalian_count' => 0
    ];
    
    $recentLoans = $recentLoans ?? collect([]);
@endphp

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Dashboard Administrator</h2>
            <p class="text-muted">Selamat datang, {{ Auth::user()->fullname }}</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5><i class="fas fa-users"></i> Anggota</h5>
                    <h3>{{ $stats['anggota_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5><i class="fas fa-book"></i> Buku</h5>
                    <h3>{{ $stats['buku_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5><i class="fas fa-tags"></i> Kategori</h5>
                    <h3>{{ $stats['kategori_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5><i class="fas fa-building"></i> Penerbit</h5>
                    <h3>{{ $stats['penerbit_count'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-exchange-alt"></i> Peminjaman Aktif</h5>
                </div>
                <div class="card-body">
                    <h3>{{ $stats['peminjaman_aktif_count'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-undo"></i> Pengembalian</h5>
                </div>
                <div class="card-body">
                    <h3>{{ $stats['pengembalian_count'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-history"></i> Peminjaman Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentLoans->count() > 0)
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
                                    @foreach($recentLoans as $loan)
                                    <tr>
                                        <td>{{ $loan->user->fullname ?? 'N/A' }}</td>
                                        <td>{{ $loan->buku->judul ?? 'N/A' }}</td>
                                        <td>{{ $loan->tanggal_pinjam ?? 'N/A' }}</td>
                                        <td><span class="badge bg-{{ ($loan->status ?? '') == 'Dipinjam' ? 'warning' : 'success' }}">{{ $loan->status ?? 'N/A' }}</span></td>
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

    {{-- Menu Admin --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-cog"></i> Menu Administrator</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <a href="#" class="btn btn-outline-primary btn-lg w-100 mb-2">
                                <i class="fas fa-users fa-2x"></i><br>
                                Kelola Anggota
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="#" class="btn btn-outline-success btn-lg w-100 mb-2">
                                <i class="fas fa-book fa-2x"></i><br>
                                Kelola Buku
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="#" class="btn btn-outline-info btn-lg w-100 mb-2">
                                <i class="fas fa-tags fa-2x"></i><br>
                                Kelola Kategori
                            </a>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="#" class="btn btn-outline-warning btn-lg w-100 mb-2">
                                <i class="fas fa-exchange-alt fa-2x"></i><br>
                                Kelola Peminjaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection