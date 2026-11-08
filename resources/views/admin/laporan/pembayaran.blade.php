@extends('layouts.admin')

@section('title', 'Laporan Pembayaran')
@section('page_title', 'Laporan Pembayaran')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>Laporan Pendapatan</span>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.laporan.pembayaran', array_merge(request()->query(), ['export' => 'csv'])) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel / CSV
                </a>
                <a href="{{ route('admin.laporan.pembayaran', array_merge(request()->query(), ['cetak' => 1])) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">Dari Tanggal</label>
                    <input type="date" name="tgl_mulai" value="{{ $tglMulai }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">Sampai Tanggal</label>
                    <input type="date" name="tgl_selesai" value="{{ $tglSelesai }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-camp w-100">Filter</button>
                </div>
            </form>
            <div class="alert alert-light border mb-3">
                Total Pendapatan: <strong>Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID Bayar</th>
                            <th>ID Sewa</th>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $bayar)
                            <tr>
                                <td>{{ $bayar->id_bayar }}</td>
                                <td>{{ $bayar->id_sewa }}</td>
                                <td>{{ \Carbon\Carbon::parse($bayar->tgl_bayar)->translatedFormat('d M Y') }}</td>
                                <td>{{ $bayar->metode }}</td>
                                <td>Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data pembayaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
