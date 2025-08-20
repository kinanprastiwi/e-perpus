@extends('layouts.app')

@section('title', 'Peminjaman Baru')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-book"></i> Form Peminjaman Buku</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="id_user" class="form-label">Pilih Anggota <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_user" name="id_user" required>
                            <option value="">-- Pilih Anggota --</option>
                            @foreach($anggota as $agt)
                            <option value="{{ $agt->id_user }}">
                                {{ $agt->kode_user }} - {{ $agt->fullname }} ({{ $agt->kelas }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="id_buku" class="form-label">Pilih Buku <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_buku" name="id_buku" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($buku as $bk)
                            @if($bk->j_buku_baik > 0)
                            <option value="{{ $bk->id_buku }}" data-stok="{{ $bk->j_buku_baik }}">
                                {{ $bk->judul_buku }} - {{ $bk->pengarang }} (Stok: {{ $bk->j_buku_baik }})
                            </option>
                            @endif
                            @endforeach
                        </select>
                        <small class="text-muted">Hanya menampilkan buku yang tersedia</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_harus_kembali" class="form-label">Tanggal Harus Kembali <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="tanggal_harus_kembali" name="tanggal_harus_kembali" 
                                   required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            <small class="text-muted">Maksimal 7 hari dari sekarang</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kondisi_buku_saat_dipinjam" class="form-label">Kondisi Buku <span class="text-danger">*</span></label>
                            <select class="form-select" id="kondisi_buku_saat_dipinjam" name="kondisi_buku_saat_dipinjam" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2" 
                                  placeholder="Catatan tambahan untuk peminjaman"></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Proses Peminjaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Peminjaman</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle"></i> Peraturan Peminjaman:</h6>
                    <ul class="mb-0 ps-3">
                        <li><small>Maksimal peminjaman 7 hari</small></li>
                        <li><small>Denda keterlambatan Rp 5.000/hari</small></li>
                        <li><small>Buku harus dikembalikan dalam kondisi baik</small></li>
                    </ul>
                </div>
                <hr>
                <p class="text-muted mb-0">
                    <small>
                        <i class="fas fa-clock"></i> Tanggal peminjaman: {{ date('d F Y') }}
                    </small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalInput = document.getElementById('tanggal_harus_kembali');
    const maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 7);
    tanggalInput.max = maxDate.toISOString().split('T')[0];
});
</script>
@endsection