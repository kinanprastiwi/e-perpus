@extends('admin.layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Detail Peminjaman</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Member Information -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Informasi Anggota</h3>
            <div class="space-y-2">
                <p><strong>Nama:</strong> {{ $peminjaman->user->fullname }}</p>
                <p><strong>Kode User:</strong> {{ $peminjaman->user->kode_user }}</p>
                <p><strong>NIS:</strong> {{ $peminjaman->user->nis }}</p>
            </div>
        </div>

        <!-- Book Information -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Informasi Buku</h3>
            <div class="space-y-2">
                <p><strong>Judul:</strong> {{ $peminjaman->buku->judul_buku }}</p>
                <p><strong>Pengarang:</strong> {{ $peminjaman->buku->pengarang }}</p>
                <p><strong>Penerbit:</strong> {{ $peminjaman->buku->penerbit->nama_penerbit }}</p>
            </div>
        </div>

        <!-- Loan Information -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Informasi Peminjaman</h3>
            <div class="space-y-2">
                <p><strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_peminjaman->format('d M Y') }}</p>
                <p><strong>Jatuh Tempo:</strong> {{ $peminjaman->tanggal_harus_kembali->format('d M Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="px-2 py-1 rounded-full text-xs 
                        {{ $peminjaman->status == 'Dipinjam' ? 'bg-yellow-200 text-yellow-800' : 
                           ($peminjaman->status == 'Dikembalikan' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800') }}">
                        {{ $peminjaman->status }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Return Information -->
        <div class="border rounded-lg p-4">
            <h3 class="text-lg font-semibold mb-4">Informasi Pengembalian</h3>
            <div class="space-y-2">
                @if($peminjaman->status == 'Dikembalikan')
                    <p><strong>Tanggal Kembali:</strong> {{ $peminjaman->tanggal_pengembalian->format('d M Y') }}</p>
                    <p><strong>Kondisi Kembali:</strong> {{ $peminjaman->kondisi_buku_saat_dikembalikan }}</p>
                    <p><strong>Denda:</strong> Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</p>
                @else
                    <p class="text-gray-500">Belum dikembalikan</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($peminjaman->catatan)
    <div class="mt-6 border rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-4">Catatan</h3>
        <p>{{ $peminjaman->catatan }}</p>
    </div>
    @endif

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.peminjaman.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
            Kembali
        </a>
    </div>
</div>
@endsection