@extends('layouts.app')

@section('title', 'Dashboard Administrator')
@section('page-heading', 'Dashboard Administrator')

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

<div class="row">
    <!-- Welcome Message -->
    <div class="col-md-12 mb-4">
        <div class="alert alert-primary">
            <h5 class="alert-heading">Selamat datang, {{ Auth::user()->name ?? Auth::user()->username }}</h5>
            <p class="mb-0">Anda login sebagai <strong>Administrator Utama</strong></p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Anggota Card -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Anggota</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['anggota_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Card -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['buku_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Card -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Kategori</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['kategori_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Penerbit Card -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Penerbit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['penerbit_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-building fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Aktif Card -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Peminjaman Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['peminjaman_aktif_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengembalian Card -->
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Pengembalian</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pengembalian_count'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-undo fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Peminjaman Terbaru -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Peminjaman Terbaru</h6>
            </div>
            <div class="card-body">
                @if($recentLoans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
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
                                    <td>
                                        <span class="badge badge-{{ ($loan->status ?? '') == 'Dipinjam' ? 'warning' : 'success' }}">
                                            {{ $loan->status ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">Belum ada data peminjaman.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Menu Administrator -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Menu Administrator</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-primary btn-block">
                            <i class="fas fa-users fa-2x mb-2"></i><br>
                            Kelola Anggota
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-success btn-block">
                            <i class="fas fa-book fa-2x mb-2"></i><br>
                            Kelola Buku
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-info btn-block">
                            <i class="fas fa-tags fa-2x mb-2"></i><br>
                            Kelola Kategori
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-warning btn-block">
                            <i class="fas fa-exchange-alt fa-2x mb-2"></i><br>
                            Kelola Peminjaman
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.penerbit.index') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fas fa-building fa-2x mb-2"></i><br>
                            Kelola Penerbit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection