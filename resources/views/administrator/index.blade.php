@extends('layouts.app')

@section('title', 'Data Administrator')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-user-shield"></i> Data Administrator & Petugas</h2>
    <a href="{{ route('administrator.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Admin
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Daftar Administrator dan Petugas</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $index => $admin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $admin->kode_user }}</strong></td>
                        <td>{{ $admin->username }}</td>
                        <td>{{ $admin->fullname }}</td>
                        <td>
                            <span class="badge bg-{{ $admin->role == 'admin' ? 'danger' : 'info' }}">
                                {{ ucfirst($admin->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $admin->verif }}</span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($admin->join_date)->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('administrator.edit', $admin->id_user) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($admin->id_user != Auth::id())
                                <form action="{{ route('administrator.destroy', $admin->id_user) }}" method="POST" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus administrator ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-user-shield fa-3x mb-3"></i>
                            <p>Belum ada data administrator.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection