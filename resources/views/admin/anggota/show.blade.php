@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                </div>
                <h4>{{ $anggota->fullname }}</h4>
                <span class="badge {{ $anggota->verif == 'Terverifikasi' ? 'bg-success' : 'bg-warning' }}">
                    {{ $anggota->verif }}
                </span>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5>Informasi Login</h5>
            </div>
            <div class="card-body">
                <p><strong>Username:</strong> {{ $anggota->username }}</p>
                <p><strong>Email:</strong> {{ $anggota->email }}</p>
                <p><strong>Bergabung:</strong> {{ $anggota->join_date->format('d M Y') }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Detail Anggota</h5>
                <div>
                    <a href="{{ route('admin.anggota.edit', $anggota->id_user) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">NIS:</div>
                    <div class="col-md-8">{{ $anggota->nis }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Nama Lengkap:</div>
                    <div class="col-md-8">{{ $anggota->fullname }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kelas:</div>
                    <div class="col-md-8">{{ $anggota->kelas }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Alamat:</div>
                    <div class="col-md-8">{{ $anggota->alamat }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Kode User:</div>
                    <div class="col-md-8">{{ $anggota->kode_user }}</div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge {{ $anggota->verif == 'Terverifikasi' ? 'bg-success' : 'bg-warning' }}">
                            {{ $anggota->verif }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5>Riwayat Peminjaman</h5>
            </div>
            <div class="card-body">
                <p class="text-center">Fitur riwayat peminjaman akan segera hadir</p>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('admin.anggota.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Anggota
    </a>
</div>
@endsection