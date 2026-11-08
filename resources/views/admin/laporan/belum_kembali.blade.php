@extends('layouts.admin')

@section('title', 'Laporan Keterlambatan & Belum Kembali')
@section('page_title', 'Laporan Belum Kembali')

@section('content')
    <div class="card-panel">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>Daftar Penyewaan Belum Kembali (Per {{ \Carbon\Carbon::parse($today)->translatedFormat('d M Y') }})</span>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.laporan.belum_kembali', ['export' => 'csv']) }}" class="btn btn-sm btn-success">
                    <i class="bi bi-file-earmark-excel me-1"></i> Export Excel / CSV
                </a>
                <a href="{{ route('admin.laporan.belum_kembali', ['cetak' => 1]) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>ID Sewa</th>
                            <th>Pelanggan</th>
                            <th>Tgl Sewa</th>
                            <th>Rencana Kembali</th>
                            <th>Status</th>
                            <th class="text-end">Total Biaya</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyewaans as $sewa)
                            @php
                                $isLate = \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->lt(\Carbon\Carbon::parse($today));
                                $waMsg = 'Halo Kak ' . ($sewa->pelanggan?->nama ?? '') . ', pengingat dari CampSewa untuk penyewaan ' . $sewa->id_sewa . ' dengan jadwal pengembalian pada ' . \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->translatedFormat('d M Y') . '. Terima kasih.';
                            @endphp
                            <tr>
                                <td><a href="{{ route('admin.penyewaan.show', $sewa->id_sewa) }}">{{ $sewa->id_sewa }}</a></td>
                                <td>{{ $sewa->pelanggan?->nama ?? '-' }} ({{ $sewa->pelanggan?->no_hp ?? '-' }})</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tgl_sewa)->translatedFormat('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->translatedFormat('d M Y') }}</td>
                                <td>
                                    <span class="badge {{ $isLate ? 'bg-danger' : 'bg-warning text-dark' }}">
                                        {{ $isLate ? 'Terlambat' : 'Berjalan' }}
                                    </span>
                                </td>
                                <td class="text-end">Rp {{ number_format($sewa->total_biaya ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <div class="d-inline-flex gap-1">
                                        @if($sewa->pelanggan?->whatsappUrl())
                                            <a href="{{ $sewa->pelanggan->whatsappUrl($waMsg) }}" target="_blank" class="btn btn-sm btn-outline-success" title="Hubungi via WhatsApp">
                                                <i class="bi bi-whatsapp me-1"></i> Chat WA
                                            </a>
                                        @endif
                                        <a href="{{ route('admin.pengembalian.proses', $sewa->id_sewa) }}" class="btn btn-sm btn-warning">
                                            Proses Kembali
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada penyewaan yang belum dikembalikan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

