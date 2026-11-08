@extends('layouts.admin')

@section('title', 'Data Petugas')
@section('page_title', 'Data Petugas')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Petugas</span>
            <a href="{{ route('admin.petugas.create') }}" class="btn btn-camp btn-sm">+ Tambah Petugas</a>
        </div>
        <div class="card-body">
            <form method="GET" class="mb-4">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, username, atau nomor HP">
            </form>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Nomor HP</th>
                            <th>Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($petugasList as $petugas)
                            <tr>
                                <td>{{ $petugas->nama_petugas }}</td>
                                <td>{{ $petugas->username }}</td>
                                <td>{{ $petugas->no_hp ?? '-' }}</td>
                                <td>{{ $petugas->penyewaan_count }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.petugas.edit', $petugas->id_petugas) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('admin.petugas.destroy', $petugas->id_petugas) }}" method="POST" onsubmit="return confirm('Hapus petugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada petugas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $petugasList->links() }}</div>
        </div>
    </div>
@endsection
