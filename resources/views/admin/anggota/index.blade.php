@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Kelola Anggota Perpustakaan</h1>
    <div>
        <a href="{{ route('admin.anggota.export') }}" class="btn btn-outline-success">
            <i class="bi bi-download"></i> Export
        </a>
        <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Anggota
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.anggota.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari anggota..." value="{{ $search }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>NIS</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($anggota->currentPage() - 1) * $anggota->perPage() }}</td>
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->fullname }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->kelas }}</td>
                        <td>
                            <span class="badge {{ $item->verif == 'Terverifikasi' ? 'bg-success' : 'bg-warning' }}">
                                {{ $item->verif }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.anggota.show', $item->id_user) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.anggota.edit', $item->id_user) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.anggota.destroy', $item->id_user) }}" method="POST" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.anggota.toggleStatus', $item->id_user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $item->verif == 'Terverifikasi' ? 'btn-secondary' : 'btn-success' }}">
                                        <i class="bi {{ $item->verif == 'Terverifikasi' ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">Tidak ada data anggota</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <div>Menampilkan {{ $anggota->firstItem() }} - {{ $anggota->lastItem() }} dari {{ $anggota->total() }} anggota</div>
            <div>
                {{ $anggota->links() }}
            </div>
        </div>
    </div>
</div>
@endsection