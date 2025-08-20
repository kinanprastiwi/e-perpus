@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Data Anggota</h2>
    <a href="{{ route('anggota.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Anggota
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anggota as $item)
                    <tr>
                        <td>{{ $item->kode_user }}</td>
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>
                            <span class="badge bg-{{ $item->verif == 'Terverifikasi' ? 'success' : 'warning' }}">
                                {{ $item->verif }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('anggota.edit', $item->id_user) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('anggota.destroy', $item->id_user) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus anggota?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection