@extends('layouts.admin')

@section('title', 'Manajemen Peminjaman')
@section('page-heading', 'Daftar Peminjaman')

@section('page-actions')
    <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Peminjaman
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
                <div class="d-flex">
                    <form action="{{ route('admin.peminjaman.index') }}" method="GET" class="d-flex me-2">
                        <input type="text" name="search" class="form-control form-control-sm me-2" 
                               placeholder="Cari anggota atau buku..." value="{{ request('search') }}">
                        <select name="status" class="form-control form-control-sm me-2">
                            <option value="">Semua Status</option>
                            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                            <option value="Terlambat" {{ request('status') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Harus Kembali</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}</td>
                                <td>
                                    <strong>{{ $item->user?->fullname ?? 'User Tidak Ditemukan' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $item->user?->kode_user ?? 'N/A' }}</small>
                                </td>
                                <td>{{ $item->buku?->judul_buku ?? 'Buku Tidak Ditemukan' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->format('d/m/Y') }}</td>
                                <td>
                                    @if($item->tanggal_pengembalian)
                                        {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if($item->status == 'Dipinjam')
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @elseif($item->status == 'Dikembalikan')
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @else
                                        <span class="badge bg-danger">Terlambat</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.peminjaman.show', $item->id_peminjaman) }}" 
                                           class="btn btn-info btn-sm" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($item->status == 'Dipinjam')
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#returnModal{{ $item->id_peminjaman }}"
                                                    title="Kembalikan Buku">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" 
                                                    data-bs-toggle="modal" data-bs-target="#extendModal{{ $item->id_peminjaman }}"
                                                    title="Perpanjang Waktu">
                                                <i class="fas fa-calendar-plus"></i>
                                            </button>
                                        @endif
                                        <form action="{{ route('admin.peminjaman.destroy', $item->id_peminjaman) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" 
                                                    title="Hapus" 
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Modal Pengembalian -->
                                    <div class="modal fade" id="returnModal{{ $item->id_peminjaman }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Pengembalian Buku</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.peminjaman.return', $item->id_peminjaman) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Kondisi Buku Saat Dikembalikan</label>
                                                            <select name="kondisi_buku_saat_dikembalikan" class="form-control" required>
                                                                <option value="Baik">Baik</option>
                                                                <option value="Rusak Ringan">Rusak Ringan</option>
                                                                <option value="Rusak Berat">Rusak Berat</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan Pengembalian</label>
                                                            <textarea name="catatan_pengembalian" class="form-control" rows="3"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Konfirmasi Pengembalian</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Perpanjangan -->
                                    <div class="modal fade" id="extendModal{{ $item->id_peminjaman }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Perpanjang Waktu Peminjaman</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.peminjaman.extend', $item->id_peminjaman) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Harus Kembali Baru</label>
                                                            <input type="date" name="tanggal_harus_kembali_baru" 
                                                                   class="form-control" 
                                                                   value="{{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->addWeek()->format('Y-m-d') }}"
                                                                   min="{{ \Carbon\Carbon::parse($item->tanggal_harus_kembali)->addDay()->format('Y-m-d') }}"
                                                                   required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Perpanjang</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data peminjaman</p>
                                    <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Tambah Peminjaman Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($peminjaman->hasPages())
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $peminjaman->firstItem() }} hingga {{ $peminjaman->lastItem() }} 
                        dari {{ $peminjaman->total() }} entri
                    </div>
                    <nav>
                        {{ $peminjaman->links() }}
                    </nav>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .table th {
        background-color: #4e73df;
        color: white;
        font-weight: bold;
    }
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 0.85em;
        padding: 0.4em 0.6em;
    }
</style>
@endsection

@section('scripts')
<script>
    // Auto close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection