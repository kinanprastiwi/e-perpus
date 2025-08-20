@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Data Anggota</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.update', $anggota->id_user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kode_user" class="form-label">Kode Anggota</label>
                            <input type="text" class="form-control" id="kode_user" 
                                   value="{{ $anggota->kode_user }}" readonly>
                            <small class="text-muted">Kode anggota tidak dapat diubah</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nis" name="nis" 
                                   value="{{ $anggota->nis }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname" 
                               value="{{ $anggota->fullname }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="{{ $anggota->username }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="kelas" name="kelas" 
                                   value="{{ $anggota->kelas }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ $anggota->alamat }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="verif" class="form-label">Status Verifikasi</label>
                        <select class="form-select" id="verif" name="verif">
                            <option value="Belum Terverifikasi" {{ $anggota->verif == 'Belum Terverifikasi' ? 'selected' : '' }}>
                                Belum Terverifikasi
                            </option>
                            <option value="Terverifikasi" {{ $anggota->verif == 'Terverifikasi' ? 'selected' : '' }}>
                                Terverifikasi
                            </option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('anggota.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Anggota</h5>
            </div>
            <div class="card-body">
                <p><strong>Tanggal Bergabung:</strong><br>
                   {{ \Carbon\Carbon::parse($anggota->join_date)->format('d F Y') }}</p>
                <p><strong>Login Terakhir:</strong><br>
                   {{ $anggota->terakhir_login ? \Carbon\Carbon::parse($anggota->terakhir_login)->format('d F Y H:i') : 'Belum pernah login' }}</p>
                <hr>
                <p class="text-muted">
                    <small>
                        Untuk mengubah password, hubungi administrator.
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection