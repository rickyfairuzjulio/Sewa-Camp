@extends('layouts.admin')

@section('title', 'Edit Alat')
@section('page_title', 'Edit Alat')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Edit Alat</div>
        <div class="card-body">
            <form action="{{ route('admin.alat.update', $alat->id_alat) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control" value="{{ old('nama_alat', $alat->nama_alat) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $alat->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga / Hari</label>
                        <input type="number" name="harga_sewa_per_hari" class="form-control" value="{{ old('harga_sewa_per_hari', $alat->harga_sewa_per_hari) }}" min="1000" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" value="{{ old('stok', $alat->stok) }}" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select" required>
                            <option value="Baik" {{ old('kondisi', $alat->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak" {{ old('kondisi', $alat->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Gambar Baru (opsional)</label>
                        <input type="file" name="gambar" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Perbarui</button>
                    <a href="{{ route('admin.alat.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
