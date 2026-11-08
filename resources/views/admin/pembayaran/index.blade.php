@extends('layouts.admin')

@section('title', 'Pembayaran')
@section('page_title', 'Pembayaran')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Pembayaran</span>
            <a href="{{ route('admin.pembayaran.create') }}" class="btn btn-camp btn-sm">+ Catat Pembayaran</a>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-5">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari ID sewa atau nama pelanggan">
                </div>
                <div class="col-md-4">
                    <select name="metode" class="form-select">
                        <option value="">Semua metode</option>
                        <option value="Midtrans" {{ request('metode') === 'Midtrans' ? 'selected' : '' }}>Midtrans</option>
                        <option value="Tunai" {{ request('metode') === 'Tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="Transfer Bank" {{ request('metode') === 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="QRIS" {{ request('metode') === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-camp">Filter</button>
                </div>
            </form>

            <div class="alert alert-light border mb-3">
                Total Penerimaan: <strong>Rp {{ number_format($totalPenerimaan ?? 0, 0, ',', '.') }}</strong>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID Bayar</th>
                            <th>ID Sewa</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $bayar)
                            <tr>
                                <td>{{ $bayar->id_bayar }}</td>
                                <td><a href="{{ route('admin.penyewaan.show', $bayar->id_sewa) }}">{{ $bayar->id_sewa }}</a></td>
                                <td>{{ $bayar->penyewaan?->pelanggan?->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($bayar->tgl_bayar)->translatedFormat('d M Y') }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $bayar->metode }}</span></td>
                                <td class="fw-semibold">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.pembayaran.kuitansi', $bayar->id_bayar) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Kuitansi</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data pembayaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $pembayarans->links() }}</div>
        </div>
    </div>
@endsection
