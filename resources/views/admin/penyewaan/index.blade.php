@extends('layouts.admin')

@section('title', 'Transaksi Sewa')
@section('page_title', 'Transaksi Sewa')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Daftar Penyewaan</span>
            <a href="{{ route('admin.penyewaan.create') }}" class="btn btn-camp btn-sm">+ Buat Transaksi</a>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-5">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari ID atau nama pelanggan">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Semua status</option>
                        <option value="Berjalan" {{ request('status') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-4 d-grid">
                    <button type="submit" class="btn btn-camp">Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID Sewa</th>
                            <th>Pelanggan</th>
                            <th>Petugas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Biaya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyewaans as $sewa)
                            <tr>
                                <td>{{ $sewa->id_sewa }}</td>
                                <td>{{ $sewa->pelanggan?->nama ?? '-' }}</td>
                                <td>{{ $sewa->petugas?->nama_petugas ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tgl_sewa)->translatedFormat('d M Y') }}</td>
                                <td><span class="badge {{ $sewa->status === 'Berjalan' ? 'bg-warning text-dark' : ($sewa->status === 'Selesai' ? 'bg-success' : 'bg-danger') }}">{{ $sewa->status }}</span></td>
                                <td>Rp {{ number_format($sewa->total_biaya ?? 0, 0, ',', '.') }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <a href="{{ route('admin.penyewaan.show', $sewa->id_sewa) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                        @if($sewa->pelanggan?->whatsappUrl())
                                            <a href="{{ $sewa->pelanggan->whatsappUrl('Halo Kak ' . $sewa->pelanggan->nama . ', berikut konfirmasi pesanan sewa ' . $sewa->id_sewa . ' di CampSewa.') }}" target="_blank" class="btn btn-sm btn-outline-success" title="Chat WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                        @endif
                                        @if($sewa->status === 'Berjalan' && $sewa->pembayaran->isEmpty())
                                            <form action="{{ route('admin.penyewaan.batal', $sewa->id_sewa) }}" method="POST" onsubmit="return confirm('Batalkan transaksi {{ $sewa->id_sewa }} dan kembalikan stok alat?')">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Batalkan</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Belum ada transaksi penyewaan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $penyewaans->links() }}</div>
        </div>
    </div>
@endsection
