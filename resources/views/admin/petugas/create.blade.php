@extends('layouts.admin')

@section('title', 'Tambah Petugas')
@section('page_title', 'Tambah Petugas')

@section('content')
    <div class="card-panel">
        <div class="card-header">Form Tambah Petugas</div>
        <div class="card-body">
            <form action="{{ route('admin.petugas.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Petugas</label>
                        <input type="text" name="nama_petugas" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email Login</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-camp">Simpan</button>
                    <a href="{{ route('admin.petugas.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection
