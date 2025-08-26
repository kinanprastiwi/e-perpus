@extends('user.layouts.app')

@section('title', 'Daftar Peminjaman')
@section('page-title', 'Daftar Peminjaman')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Riwayat Peminjaman Buku</h5>
    </div>
    <div class="card-body">
        @if($peminjaman->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->buku->judul_buku ?? 'Buku tidak ditemukan' }}</td>
                        <td>{{ $item->tanggal_peminjaman->format('d M Y') }}</td>
                        <td>{{ $item->tanggal_harus_kembali->format('d M Y') }}</td>
                        <td>
                            @if($item->tanggal_pengembalian)
                                {{ $item->tanggal_pengembalian->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $item->status == 'Dipinjam' ? 'warning' : ($item->status == 'Dikembalikan' ? 'success' : 'danger') }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            @if($item->denda > 0)
                                Rp {{ number_format($item->denda, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('user.peminjaman.show', $item->id_peminjaman) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $peminjaman->links() }}
        </div>
        @else
        <div class="text-center py-4">
            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada riwayat peminjaman buku.</p>
            <a href="{{ route('user.buku.index') }}" class="btn btn-primary">
                <i class="fas fa-book"></i> Pinjam Buku Sekarang
            </a>
        </div>
        @endif
    </div>
</div>
@endsection