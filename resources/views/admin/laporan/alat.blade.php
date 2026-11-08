@extends('layouts.admin')

@section('title', 'Laporan Alat')
@section('page_title', 'Laporan Alat')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>Laporan Alat Terlaris &amp; Inventaris</span>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.laporan.alat', ['export' => 'csv']) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel / CSV
                </a>
                <a href="{{ route('admin.laporan.alat', ['cetak' => 1]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Nama Alat</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Disewa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($alatTerlaris as $item)
                            <tr>
                                <td>{{ $item->alat?->nama_alat ?? '-' }}</td>
                                <td>{{ $item->alat?->kategori?->nama_kategori ?? '-' }}</td>
                                <td>{{ $item->alat?->stok ?? 0 }}</td>
                                <td>{{ $item->total_disewa ?? 0 }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">Belum ada data alat terlaris.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
