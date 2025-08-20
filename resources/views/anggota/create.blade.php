@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-plus"></i> Tambah Anggota Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nis" class="form-label">NIS <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nis" name="nis" required 
                                   placeholder="Masukkan NIS">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" required 
                                   placeholder="Masukkan username">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname" required 
                               placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required 
                                   placeholder="Masukkan password">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="kelas" name="kelas" required 
                                   placeholder="Contoh: X - RPL">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required 
                                  placeholder="Masukkan alamat lengkap"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="verif" class="form-label">Status Verifikasi</label>
                        <select class="form-select" id="verif" name="verif">
                            <option value="Belum Terverifikasi">Belum Terverifikasi</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('anggota.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    <small>
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Pastikan data yang dimasukkan sudah benar. Data anggota akan digunakan untuk proses peminjaman buku.
                    </small>
                </p>
                <p class="card-text">
                    <small>
                        <i class="fas fa-key text-primary"></i>
                        Password akan dienkripsi untuk keamanan data.
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection