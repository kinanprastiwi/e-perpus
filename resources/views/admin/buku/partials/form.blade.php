<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="judul_buku">Judul Buku *</label>
            <input type="text" class="form-control @error('judul_buku') is-invalid @enderror" id="judul_buku" name="judul_buku" value="{{ old('judul_buku', $buku->judul_buku ?? '') }}" required>
            @error('judul_buku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn', $buku->isbn ?? '') }}">
            @error('isbn')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="pengarang">Pengarang *</label>
            <input type="text" class="form-control @error('pengarang') is-invalid @enderror" id="pengarang" name="pengarang" value="{{ old('pengarang', $buku->pengarang ?? '') }}" required>
            @error('pengarang')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="id_penerbit">Penerbit *</label>
            <select class="form-control @error('id_penerbit') is-invalid @enderror" id="id_penerbit" name="id_penerbit" required>
                <option value="">Pilih Penerbit</option>
                @foreach($penerbits as $penerbit)
                    <option value="{{ $penerbit->id_penerbit }}" {{ old('id_penerbit', $buku->id_penerbit ?? '') == $penerbit->id_penerbit ? 'selected' : '' }}>
                        {{ $penerbit->nama_penerbit }}
                    </option>
                @endforeach
            </select>
            @error('id_penerbit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="id_kategori">Kategori *</label>
            <select class="form-control @error('id_kategori') is-invalid @enderror" id="id_kategori" name="id_kategori" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori', $buku->id_kategori ?? '') == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('id_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="tahun_terbit">Tahun Terbit *</label>
            <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit" name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" min="1900" max="{{ date('Y') + 5 }}" required>
            @error('tahun_terbit')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="jumlah_halaman">Jumlah Halaman</label>
            <input type="number" class="form-control @error('jumlah_halaman') is-invalid @enderror" id="jumlah_halaman" name="jumlah_halaman" value="{{ old('jumlah_halaman', $buku->jumlah_halaman ?? '') }}" min="1">
            @error('jumlah_halaman')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="j_buku_baik">Stok Baik *</label>
            <input type="number" class="form-control @error('j_buku_baik') is-invalid @enderror" id="j_buku_baik" name="j_buku_baik" value="{{ old('j_buku_baik', $buku->j_buku_baik ?? 0) }}" min="0" required>
            @error('j_buku_baik')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="j_buku_rusak">Stok Rusak *</label>
            <input type="number" class="form-control @error('j_buku_rusak') is-invalid @enderror" id="j_buku_rusak" name="j_buku_rusak" value="{{ old('j_buku_rusak', $buku->j_buku_rusak ?? 0) }}" min="0" required>
            @error('j_buku_rusak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="rak">Rak / Lokasi</label>
            <input type="text" class="form-control @error('rak') is-invalid @enderror" id="rak" name="rak" value="{{ old('rak', $buku->rak ?? '') }}">
            @error('rak')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group">
    <label for="deskripsi">Deskripsi</label>
    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="cover_buku">Cover Buku</label>
    <input type="file" class="form-control-file @error('cover_buku') is-invalid @enderror" id="cover_buku" name="cover_buku">
    @error('cover_buku')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @if(isset($buku) && $buku->cover_buku)
        <div class="mt-2">
            <img src="{{ asset('storage/covers/' . $buku->cover_buku) }}" alt="Cover Buku" style="max-height: 100px;">
            <br>
            <small class="text-muted">Cover saat ini</small>
        </div>
    @endif
</div>