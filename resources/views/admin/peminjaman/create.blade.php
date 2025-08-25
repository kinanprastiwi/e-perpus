@extends('admin.layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Tambah Peminjaman Baru</h2>
    
    <form action="{{ route('admin.peminjaman.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Anggota Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Anggota</label>
                <select name="id_user" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">Pilih Anggota</option>
                    @foreach($anggota as $user)
                        <option value="{{ $user->id_user }}">{{ $user->fullname }} - {{ $user->kode_user }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Book Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Buku</label>
                <select name="id_buku" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                    <option value="">Pilih Buku</option>
                    @foreach($buku as $book)
                        <option value="{{ $book->id_buku }}">{{ $book->judul_buku }} (Stok: {{ $book->j_buku_baik }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Dates -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Peminjaman</label>
                <input type="date" name="tanggal_peminjaman" value="{{ date('Y-m-d') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Jatuh Tempo</label>
                <input type="date" name="tanggal_harus_kembali" 
                       value="{{ date('Y-m-d', strtotime('+7 days')) }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
            </div>

            <!-- Book Condition -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kondisi Buku Saat Dipinjam</label>
                <select name="kondisi_buku_saat_dipinjam" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                    <option value="Baik">Baik</option>
                    <option value="Rusak Ringan">Rusak Ringan</option>
                    <option value="Rusak Berat">Rusak Berat</option>
                </select>
            </div>

            <!-- Notes -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <textarea name="catatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg" rows="3"></textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.peminjaman.index') }}" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-lg">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection