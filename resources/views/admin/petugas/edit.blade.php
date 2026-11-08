@extends('layouts.admin')

@section('title', 'Edit Petugas')
@section('page_title', 'Edit Petugas')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Edit Petugas</div>
        <div class="card-body">
            <form action="{{ route('admin.petugas.update', $petugas->id_petugas) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" value="{{ old('nama_petugas', $petugas->nama_petugas) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" value="{{ $petugas->username }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $petugas->no_hp) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Perbarui</button>
                    <a href="{{ route('admin.petugas.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
