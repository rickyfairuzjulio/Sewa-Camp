@extends('layouts.admin')

@section('title', 'Laporan Penyewaan')
@section('page_title', 'Laporan Penyewaan')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>Laporan Transaksi Penyewaan</span>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.laporan.penyewaan', array_merge(request()->query(), ['export' => 'csv'])) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel / CSV
                </a>
                <a href="{{ route('admin.laporan.penyewaan', array_merge(request()->query(), ['cetak' => 1])) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" value="{{ $tglSelesai }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Berjalan" {{ ($status ?? '') === 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="Selesai" {{ ($status ?? '') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ ($status ?? '') === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-camp w-100">Filter</button>
                </div>
            </form>
            <div class="alert alert-light border mb-3">
                Total Nilai Penyewaan: <strong>Rp {{ number_format($totalNilaiSewa ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID Sewa</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyewaans as $sewa)
                            <tr>
                                <td>{{ $sewa->id_sewa }}</td>
                                <td>{{ $sewa->pelanggan?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tgl_sewa)->translatedFormat('d M Y') }}</td>
                                <td>{{ $sewa->status }}</td>
                                <td>Rp {{ number_format($sewa->total_biaya ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data laporan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
