@extends('layouts.admin')

@section('title', 'Edit Pelanggan')
@section('page_title', 'Edit Pelanggan')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Edit Pelanggan</div>
        <div class="card-body">
            <form action="{{ route('admin.pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" value="{{ old('nama', $pelanggan->nama) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Identitas</label>
                        <input type="text" name="no_identitas" value="{{ old('no_identitas', $pelanggan->no_identitas) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $pelanggan->alamat) }}" class="form-control">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Perbarui</button>
                    <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
