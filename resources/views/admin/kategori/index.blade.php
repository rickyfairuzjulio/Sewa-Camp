@extends('layouts.admin')

@section('title', 'Kategori Alat - CampSewa')
@section('page_title', 'Kategori Alat')
@section('page_subtitle', 'Kelola daftar kategori peralatan camping dalam satu panel.')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3 py-3">
            <div>
                <div class="fw-extrabold fs-6">Daftar &amp; Tambah Kategori</div>
                <div class="text-muted small fw-normal">Total {{ $kategori->count() }} kategori peralatan terdaftar</div>
            </div>

            <form action="{{ route('admin.kategori.store') }}" method="POST" class="d-flex flex-wrap align-items-center gap-2 ms-auto" style="min-width: min(100%, 420px);">
                @csrf
                <div class="flex-grow-1">
                    <input
                        type="text"
                        name="nama_kategori"
                        class="form-control"
                        placeholder="Nama kategori baru (Contoh: Tenda & Shelter)..."
                        required
                    >
                </div>
                <button type="submit" class="btn-shoplytic-lime py-2 px-3 flex-shrink-0">
                    <i class="bi bi-plus-lg"></i> Tambah Kategori
                </button>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Nama Kategori</th>
                            <th style="width: 180px;">Jumlah Alat</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $item)
                            <tr>
                                <td class="fw-bold text-muted">{{ $item->id_kategori }}</td>
                                <td class="fw-bold">{{ $item->nama_kategori }}</td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2" style="background: var(--shop-soft); color: var(--shop-text); font-weight: 700;">
                                        {{ $item->alat_count }} unit jenis alat
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('admin.kategori.destroy', $item->id_kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $item->nama_kategori }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="bi bi-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Belum ada kategori peralatan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
