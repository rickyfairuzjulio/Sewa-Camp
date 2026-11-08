@extends('layouts.admin')

@section('title', 'Dashboard Petugas')
@section('page_title', 'Dashboard Petugas')

@section('content')
    <div class="dashboard-shell">
        <section class="dashboard-welcome">
            <div class="dashboard-welcome-copy">
                <p class="eyebrow">Area operasional</p>
                <h1>Halo, {{ auth()->user()->name }}!</h1>
                <p>Pantau penyewaan aktif, pembayaran Midtrans & tunai, serta jadwal pengembalian perlengkapan hari ini.</p>
            </div>
            <div class="dashboard-welcome-actions">
                <span class="date-pill"><i class="bi bi-calendar3"></i> {{ now()->translatedFormat('d M Y') }}</span>
                <a href="{{ route('admin.penyewaan.create') }}" class="add-wallet"><i class="bi bi-plus-lg"></i> Buat penyewaan</a>
                <a href="{{ route('admin.pengembalian.index') }}" class="add-wallet"><i class="bi bi-arrow-return-left"></i> Kelola pengembalian</a>
            </div>
        </section>

        <section class="dashboard-stats" aria-label="Ringkasan operasional">
            <article class="dashboard-stat">
                <div>
                    <div class="dashboard-stat-label">Sewa berjalan</div>
                    <p class="dashboard-stat-value">{{ number_format($stats['sewa_berjalan'] ?? 0) }}</p>
                    <p class="dashboard-stat-note">Penyewaan aktif</p>
                </div>
                <span class="dashboard-stat-icon"><i class="bi bi-arrow-left-right"></i></span>
            </article>
            <article class="dashboard-stat">
                <div>
                    <div class="dashboard-stat-label">Kembali hari ini</div>
                    <p class="dashboard-stat-value">{{ number_format($stats['perlu_kembali_hari_ini'] ?? 0) }}</p>
                    <p class="dashboard-stat-note">Perlu diproses hari ini</p>
                </div>
                <span class="dashboard-stat-icon"><i class="bi bi-calendar-check"></i></span>
            </article>
            <article class="dashboard-stat">
                <div>
                    <div class="dashboard-stat-label">Terlambat</div>
                    <p class="dashboard-stat-value">{{ number_format($stats['terlambat'] ?? 0) }}</p>
                    <p class="dashboard-stat-note">Perlu tindak lanjut</p>
                </div>
                <span class="dashboard-stat-icon"><i class="bi bi-exclamation-circle"></i></span>
            </article>
            <article class="dashboard-stat">
                <div>
                    <div class="dashboard-stat-label">Jenis perlengkapan</div>
                    <p class="dashboard-stat-value">{{ number_format($stats['total_alat'] ?? 0) }}</p>
                    <p class="dashboard-stat-note">Tercatat di inventaris</p>
                </div>
                <span class="dashboard-stat-icon"><i class="bi bi-backpack"></i></span>
            </article>
        </section>

        <div class="dashboard-content-grid">
            <section class="panel-card table-panel">
                <div class="panel-head">
                    <div>
                        <h2 class="dashboard-section-title">Jadwal pengembalian</h2>
                        <p class="dashboard-section-caption">Penyewaan aktif diurutkan berdasarkan tanggal kembali.</p>
                    </div>
                    <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">Lihat semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table dashboard-table align-middle">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Jadwal kembali</th>
                                <th>Perlengkapan</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perluKembali as $sewa)
                                @php
                                    $isLate = $sewa->tgl_kembali_rencana->lt(today());
                                @endphp
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.penyewaan.show', $sewa->id_sewa) }}" class="dashboard-item text-decoration-none text-reset">
                                            <span class="dashboard-item-icon"><i class="bi bi-person"></i></span>
                                            <span class="min-w-0">
                                                <span class="dashboard-item-name d-block">{{ $sewa->pelanggan?->nama ?? 'Pelanggan' }}</span>
                                                <span class="dashboard-item-meta d-block">Penyewaan {{ $sewa->id_sewa }}</span>
                                            </span>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="fw-semibold d-block">{{ \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->translatedFormat('d M Y') }}</span>
                                        @if(!$isLate)
                                            <span class="dashboard-item-meta">{{ $sewa->tgl_kembali_rencana->isToday() ? 'Hari ini' : 'Akan datang' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach($sewa->details as $detail)
                                            <span class="d-block">{{ $detail->alat?->nama_alat ?? 'Perlengkapan' }} ({{ $detail->jumlah }})</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill {{ $isLate ? 'bg-danger' : 'bg-warning text-dark' }}">
                                            {{ $isLate ? 'Terlambat' : ($sewa->tgl_kembali_rencana->isToday() ? 'Hari ini' : 'Segera') }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ route('admin.penyewaan.show', $sewa->id_sewa) }}" class="btn btn-sm btn-outline-secondary rounded-pill">Detail</a>
                                            <a href="{{ route('admin.pengembalian.proses', $sewa->id_sewa) }}" class="btn btn-sm btn-primary rounded-pill">Proses</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-5 text-center text-muted">Tidak ada penyewaan yang memerlukan pengembalian saat ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="dashboard-stack">
                <section class="panel-card">
                    <div class="panel-head">
                        <div>
                            <h2 class="dashboard-section-title">Tugas hari ini</h2>
                            <p class="dashboard-section-caption">Prioritas operasional petugas.</p>
                        </div>
                        <span class="panel-icon"><i class="bi bi-list-check"></i></span>
                    </div>
                    <div class="dashboard-quick-links">
                        <a href="{{ route('admin.pengembalian.index') }}" class="dashboard-quick-link">
                            <span class="dashboard-item-icon"><i class="bi bi-arrow-return-left"></i></span>
                            <span class="min-w-0 flex-grow-1">
                                <span class="dashboard-item-name d-block">Proses pengembalian</span>
                                <span class="dashboard-item-meta d-block">{{ number_format($stats['perlu_kembali_hari_ini'] ?? 0) }} jadwal hari ini</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.penyewaan.index') }}" class="dashboard-quick-link">
                            <span class="dashboard-item-icon"><i class="bi bi-receipt"></i></span>
                            <span class="min-w-0 flex-grow-1">
                                <span class="dashboard-item-name d-block">Daftar penyewaan</span>
                                <span class="dashboard-item-meta d-block">Periksa transaksi aktif</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.pembayaran.index') }}" class="dashboard-quick-link">
                            <span class="dashboard-item-icon"><i class="bi bi-wallet2"></i></span>
                            <span class="min-w-0 flex-grow-1">
                                <span class="dashboard-item-name d-block">Pembayaran & Midtrans</span>
                                <span class="dashboard-item-meta d-block">Catat & verifikasi pembayaran</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.pelanggan.index') }}" class="dashboard-quick-link">
                            <span class="dashboard-item-icon"><i class="bi bi-people"></i></span>
                            <span class="min-w-0 flex-grow-1">
                                <span class="dashboard-item-name d-block">Data pelanggan</span>
                                <span class="dashboard-item-meta d-block">Kelola data penyewa</span>
                            </span>
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </section>

                @if(($stats['terlambat'] ?? 0) > 0)
                    <div class="dashboard-notice">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Ada {{ number_format($stats['terlambat']) }} penyewaan terlambat yang perlu ditindaklanjuti.
                    </div>
                @else
                    <div class="dashboard-notice">
                        <i class="bi bi-check-circle me-1"></i>
                        Tidak ada penyewaan yang terlambat saat ini.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
