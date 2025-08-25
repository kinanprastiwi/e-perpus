@extends('user.layouts.app')

@section('title', 'Dashboard Anggota')
@section('page-title', 'Dashboard')

@section('content')
<div class="welcome-banner">
    <h3>Selamat Datang, {{ auth()->user()->fullname }}!</h3>
    <p>Selamat membaca dan jelajahi koleksi buku kami yang lengkap</p>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card-stat card text-center p-4">
            <div class="card-icon">
                <i class="fas fa-book"></i>
            </div>
            <h3>{{ $peminjaman_aktif }}</h3>
            <p class="text-muted">Buku Dipinjam</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card-stat card text-center p-4">
            <div class="card-icon">
                <i class="fas fa-history"></i>
            </div>
            <h3>{{ $total_peminjaman }}</h3>
            <p class="text-muted">Total Peminjaman</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card-stat card text-center p-4">
            <div class="card-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>{{ $buku_dikembalikan }}</h3>
            <p class="text-muted">Buku Dikembalikan</p>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card-stat card text-center p-4">
            <div class="card-icon">
                <i class="fas fa-star"></i>
            </div>
            <h3>{{ $buku_tersedia }}</h3>
            <p class="text-muted">Buku Tersedia</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Peminjaman Aktif</h5>
            </div>
            <div class="card-body">
                @if($peminjaman_aktif > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjaman_aktif_list as $peminjaman)
                                <tr>
                                    <td>{{ $peminjaman->buku->judul }}</td>
                                    <td>{{ $peminjaman->tgl_pinjam->format('d M Y') }}</td>
                                    <td>{{ $peminjaman->tgl_jatuh_tempo->format('d M Y') }}</td>
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
                    <p class="text-center text-muted">Tidak ada peminjaman aktif</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Informasi Akun</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>NIS:</strong> {{ auth()->user()->nis }}<br>
                    <strong>Nama:</strong> {{ auth()->user()->fullname }}<br>
                    <strong>Kelas:</strong> {{ auth()->user()->kelas }}<br>
                    <strong>Status:</strong> 
                    <span class="badge bg-{{ auth()->user()->verif == 'Terverifikasi' ? 'success' : 'warning' }}">
                        {{ auth()->user()->verif }}
                    </span>
                </div>
                <a href="{{ route('user.profil') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection