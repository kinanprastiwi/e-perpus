@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>
        <i class="fas fa-plus"></i> Tambah Buku
    </h2>
    <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<x-card header="Form Tambah Buku">
    <form action="{{ route('admin.buku.store') }}" method="POST">
        @csrf
        
        @include('admin.buku.partials.form')
        
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('admin.buku.index') }}" class="btn btn-secondary me-md-2">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</x-card>
@endsection