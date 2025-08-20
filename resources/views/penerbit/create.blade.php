@extends('layouts.app')

@section('title', 'Tambah Penerbit')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-building"></i> Tambah Penerbit Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('penerbit.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="kode_penerbit" class="form-label">Kode Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="kode_penerbit" name="kode_penerbit" 
                               required placeholder="Contoh: P001" pattern="[A-Za-z0-9]+" title="Hanya huruf dan angka">
                        <small class="text-muted">Kode unik untuk identifikasi penerbit</small>
                    </div>

                    <div class="mb-3">
                        <label for="nama_penerbit" class="form-label">Nama Penerbit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama_penerbit" name="nama_penerbit" 
                               required placeholder="Contoh: Gramedia, Erlangga">
                    </div>

                    <div class="mb-3">
                        <label for="verif_penerbit" class="form-label">Status Verifikasi</label>
                        <select class="form-select" id="verif_penerbit" name="verif_penerbit">
                            <option value="Belum Terverifikasi">Belum Terverifikasi</option>
                            <option value="Terverifikasi" selected>Terverifikasi</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Penerbit
                        </button>
                        <a href="{{ route('penerbit.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection