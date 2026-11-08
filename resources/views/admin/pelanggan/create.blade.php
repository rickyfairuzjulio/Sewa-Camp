@extends('layouts.admin')

@section('title', 'Tambah Pelanggan')
@section('page_title', 'Tambah Pelanggan')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Tambah Pelanggan</div>
        <div class="card-body">
            <form action="{{ route('admin.pelanggan.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No. Identitas</label>
                        <input type="text" name="no_identitas" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Simpan</button>
                    <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
