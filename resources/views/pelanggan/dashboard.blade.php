@extends('layouts.public')

@section('title', 'Transaksi & Status Barang - Dashboard Pelanggan CampSewa')

@section('styles')
<style>
    .member-nav-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 24px;
    }

    .member-nav-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 999px;
        border: 1.5px solid #e2e5e8;
        background: #ffffff;
        color: #101010;
        font-size: 0.92rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .member-nav-pill:hover {
        border-color: #101010;
        color: #101010;
    }

    .member-nav-pill.active {
        background: var(--foresta-lime);
        border-color: var(--foresta-lime);
        color: #ffffff;
    }

    .upgrade-member-card {
        position: relative;
        overflow: hidden;
        padding: 36px;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid #e4e6e8;
        color: #111827;
        box-shadow: 0 14px 34px rgba(0, 0, 0, 0.06);
    }

    .upgrade-member-card::after {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(112, 244, 109, 0.16);
        pointer-events: none;
    }

    .upgrade-tier-badge {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 999px;
        background: var(--foresta-lime);
        color: #ffffff;
        font-size: 0.76rem;
        font-weight: 800;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .upgrade-stat-box {
        padding: 18px;
        border-radius: 16px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .btn-upgrade-cream {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 14px 28px;
        border: 0;
        border-radius: 999px;
        background: var(--foresta-lime);
        color: #ffffff !important;
        font-size: 0.95rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-upgrade-cream i {
        color: #ffffff !important;
    }

    .btn-upgrade-cream:hover {
        background: var(--foresta-lime-hover);
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(112, 244, 109, 0.28);
    }

    .upgrade-benefit-card {
        padding: 32px;
        border-radius: 24px;
        border: 1px solid #e4e6e8;
        background: #ffffff;
    }

    .upgrade-benefit-item {
        padding: 14px 16px;
        border-radius: 14px;
        background: #f6f8f7;
        border-left: 4px solid var(--foresta-lime);
    }

    .trx-card {
        border: 1px solid #e4e6e8;
        border-radius: 18px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.03);
    }

    .trx-card-header {
        padding: 18px 24px;
        background: #f8f9fa;
        border-bottom: 1px solid #e4e6e8;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }

    .trx-card-body {
        padding: 22px 24px;
    }

    /* Tracking Stepper */
    .item-stepper {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 14px;
        background: #f4f6f7;
    }

    .item-step {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        color: #8c939a;
    }

    .item-step.done {
        color: #101010;
    }

    .item-step .step-dot {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 999px;
        background: #dce0e4;
        color: #5e646a;
        font-size: 0.74rem;
        font-weight: 800;
        flex-shrink: 0;
    }

    .item-step.done .step-dot {
        background: var(--foresta-lime);
        color: #ffffff;
    }

    .trx-item-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        border: 1px solid #ebedef;
        border-radius: 14px;
        margin-bottom: 10px;
        background: #ffffff;
    }

    .trx-pay-option {
        display: block;
        cursor: pointer;
    }

    .trx-pay-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .trx-pay-box {
        padding: 12px 14px;
        border: 2px solid #e2e5e8;
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.18s ease;
    }

    .trx-pay-option input:checked + .trx-pay-box {
        border-color: #101010;
        background: var(--foresta-lime-soft);
    }

    @media (max-width: 767.98px) {
        .member-nav-pills {
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 6px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .member-nav-pills::-webkit-scrollbar {
            display: none;
        }

        .member-nav-pill {
            white-space: nowrap;
            flex-shrink: 0;
            padding: 9px 16px;
            font-size: 0.84rem;
        }

        .upgrade-member-card {
            padding: 22px 18px;
            border-radius: 18px;
        }

        .upgrade-benefit-card {
            padding: 22px 18px;
            border-radius: 18px;
        }

        .trx-card-header,
        .trx-card-body {
            padding: 16px;
        }

        .item-stepper {
            grid-template-columns: repeat(2, 1fr);
            padding: 12px;
        }
    }
</style>
@endsection

@section('content')
@php
    $activeTab = request('tab', 'transaksi');
    $statusVerifikasi = $profil->status_verifikasi ?? 'belum_verifikasi';
@endphp

<div class="container pt-4 pb-5">
    {{-- Foresta Banner --}}
    <div class="foresta-page-banner mb-4">
        <span class="foresta-banner-tag">Area Member &middot; Dashboard Pelanggan</span>
        <h1 class="fw-black mb-2" style="font-size: clamp(1.85rem, 3.5vw, 2.5rem); font-weight: 900;">
            Halo, {{ auth()->user()->name }}!
        </h1>
        <p class="mb-0 text-white-50 fw-semibold">
            Pantau transaksi, lihat status barang sewaan secara real-time, dan pilih pembayaran DP 50% atau Bayar Penuh
        </p>
    </div>

    <div id="midtrans-alert" class="alert d-none rounded-4 border-0 mb-3" role="alert"></div>

    @if($statusVerifikasi === 'belum_verifikasi')
        <div class="alert alert-warning rounded-4 border-0 d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
            <div>
                <span class="badge bg-warning text-dark fw-extrabold me-2">Belum Verifikasi</span>
                <span class="small fw-semibold">Akun Anda sedang menunggu verifikasi KTP oleh admin. Riwayat transaksi akan tampil lengkap setelah admin memverifikasi data Anda.</span>
            </div>
        </div>
    @elseif($statusVerifikasi === 'diblokir')
        <div class="alert alert-danger rounded-4 border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-circle me-1"></i> Akun pelanggan Anda sedang diblokir. Silakan hubungi admin store untuk bantuan.
        </div>
    @endif

    {{-- Navigation Pills (Matches User Dropdown Items: Transaksi, Upgrade Member, Pengaturan) --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div class="member-nav-pills mb-0">
            <a href="{{ route('pelanggan.dashboard', ['tab' => 'transaksi']) }}" class="member-nav-pill {{ $activeTab === 'transaksi' ? 'active' : '' }}">
                <i class="bi bi-receipt"></i> Transaksi &amp; Status Barang
            </a>
            <a href="{{ route('pelanggan.dashboard', ['tab' => 'member']) }}" class="member-nav-pill {{ $activeTab === 'member' ? 'active' : '' }}">
                Upgrade Member
            </a>
            <a href="{{ route('pelanggan.dashboard', ['tab' => 'pengaturan']) }}" class="member-nav-pill {{ $activeTab === 'pengaturan' ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Pengaturan Akun
            </a>
        </div>

        <a href="{{ route('public.katalog') }}" class="btn-foresta-lime py-2 px-4">
            <i class="bi bi-plus-circle"></i> Sewa Barang Baru
        </a>
    </div>

    {{-- TAB 1: TRANSAKSI & STATUS BARANG --}}
    @if($activeTab === 'transaksi')
        @forelse($riwayatSewa as $sewa)
            @php
                $totalBiaya = (int) round($sewa->total_biaya);
                $totalDibayar = (int) round($sewa->total_dibayar);
                $sisaTagihan = (int) round($sewa->sisa_tagihan);
                $nominalDp = max(1000, (int) ceil($sisaTagihan * 0.5));
                $statusBayar = $sewa->status_pembayaran;
                $isTerlambat = $sewa->status === 'Berjalan' && $sewa->tgl_kembali_rencana && $sewa->tgl_kembali_rencana->lt(today());
            @endphp

            <div class="trx-card">
                <div class="trx-card-header">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <span class="fw-black fs-5" style="font-weight: 900;">Transaksi {{ $sewa->id_sewa }}</span>
                        <span class="small text-secondary fw-bold">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ \Carbon\Carbon::parse($sewa->tgl_sewa)->translatedFormat('d M Y') }} – {{ \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->translatedFormat('d M Y') }}
                            ({{ $sewa->durasi_hari }} hari)
                        </span>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span class="badge rounded-pill {{ $sewa->status === 'Berjalan' ? 'bg-dark text-white' : ($sewa->status === 'Selesai' ? 'bg-success' : 'bg-secondary') }} px-3 py-2">
                            Status Sewa: {{ $sewa->status }}
                        </span>
                        @if($statusBayar === 'Lunas')
                            <span class="badge rounded-pill text-white px-3 py-2 fw-extrabold" style="background: var(--foresta-lime);">
                                <i class="bi bi-check-circle-fill me-1"></i> Lunas
                            </span>
                        @elseif($totalDibayar > 0)
                            <span class="badge rounded-pill bg-info text-dark px-3 py-2 fw-extrabold">
                                Sudah DP: Rp {{ number_format($totalDibayar, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2 fw-extrabold">
                                Belum Bayar
                            </span>
                        @endif
                    </div>
                </div>

                <div class="trx-card-body">
                    {{-- Visual Tracking Stepper Status Barang --}}
                    <div class="item-stepper">
                        <div class="item-step done">
                            <span class="step-dot"><i class="bi bi-check"></i></span>
                            <span>1. Booking Dibuat</span>
                        </div>
                        <div class="item-step {{ $totalDibayar > 0 ? 'done' : '' }}">
                            <span class="step-dot">{{ $totalDibayar > 0 ? '✓' : '2' }}</span>
                            <span>2. {{ $statusBayar === 'Lunas' ? 'Pembayaran Lunas' : ($totalDibayar > 0 ? 'DP 50% Diterima' : 'Menunggu Bayar DP/Penuh') }}</span>
                        </div>
                        <div class="item-step {{ ($sewa->status === 'Berjalan' && $totalDibayar > 0) || $sewa->status === 'Selesai' ? 'done' : '' }}">
                            <span class="step-dot">{{ ($sewa->status === 'Berjalan' && $totalDibayar > 0) || $sewa->status === 'Selesai' ? '✓' : '3' }}</span>
                            <span>3. Barang Disewa / Diambil</span>
                        </div>
                        <div class="item-step {{ $sewa->status === 'Selesai' ? 'done' : '' }}">
                            <span class="step-dot">{{ $sewa->status === 'Selesai' ? '✓' : '4' }}</span>
                            <span>4. Barang Dikembalikan</span>
                        </div>
                    </div>

                    {{-- Daftar & Status Tiap Barang --}}
                    <h3 class="small fw-extrabold text-uppercase text-secondary mb-2">
                        <i class="bi bi-box-seam me-1 text-dark"></i> Daftar &amp; Status Barang yang Disewa
                    </h3>
                    <div class="mb-3">
                        @forelse($sewa->details as $detail)
                            <div class="trx-item-row">
                                <div class="d-flex align-items-center gap-3">
                                    <img
                                        src="{{ $detail->alat?->gambar_url ?? asset('images/default-camp.svg') }}"
                                        alt="{{ $detail->alat?->nama_alat ?? 'Perlengkapan' }}"
                                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 12px; border: 1px solid #e4e6e8;"
                                        onerror="this.onerror=null;this.src='{{ asset('images/default-camp.svg') }}';"
                                    >
                                    <div>
                                        <div class="fw-extrabold fs-6">{{ $detail->alat?->nama_alat ?? 'Perlengkapan Outdoor' }}</div>
                                        <div class="small text-secondary">
                                            Jumlah: <strong>{{ $detail->jumlah }} unit</strong> &middot;
                                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}/hari &middot;
                                            Kondisi Fisik: <strong class="text-success">{{ $detail->alat?->kondisi ?? 'Baik' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-md-end">
                                    <div class="mb-1">
                                        @if($sewa->status === 'Selesai')
                                            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-1">
                                                <i class="bi bi-check2-all me-1"></i> Barang Sudah Dikembalikan ({{ $sewa->tgl_kembali_aktual ? \Carbon\Carbon::parse($sewa->tgl_kembali_aktual)->format('d M Y') : 'Selesai' }})
                                            </span>
                                        @elseif($sewa->status === 'Dibatalkan')
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary px-3 py-1">
                                                <i class="bi bi-x-circle me-1"></i> Pesanan Dibatalkan
                                            </span>
                                        @elseif($isTerlambat)
                                            <span class="badge rounded-pill bg-danger text-white px-3 py-1">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Terlambat Kembali (Jatuh Tempo {{ \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->format('d M Y') }})
                                            </span>
                                        @elseif($totalDibayar > 0)
                                            <span class="badge rounded-pill text-white fw-extrabold px-3 py-1" style="background: var(--foresta-lime);">
                                                <i class="bi bi-bag-check-fill me-1"></i> Barang Sedang Disewa / Siap Diambil
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-warning-subtle text-dark border border-warning-subtle px-3 py-1">
                                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Pembayaran DP / Penuh
                                            </span>
                                        @endif
                                    </div>
                                    <div class="fw-extrabold text-dark">Subtotal: Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-secondary small py-2">Detail barang tercatat pada transaksi {{ $sewa->id_sewa }}.</div>
                        @endforelse
                    </div>

                    {{-- Footer Tagihan & Pilihan Bayar DP / Penuh --}}
                    <div class="row g-3 align-items-center pt-3 border-top">
                        <div class="col-lg-5">
                            <div class="d-flex flex-column gap-1 small">
                                <div class="d-flex justify-content-between">
                                    <span class="text-secondary fw-semibold">Total Biaya Sewa:</span>
                                    <strong class="fs-6">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong>
                                </div>
                                @if($totalDibayar > 0)
                                    <div class="d-flex justify-content-between text-success fw-bold">
                                        <span>Sudah Dibayar:</span>
                                        <span>Rp {{ number_format($totalDibayar, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                                @if($sisaTagihan > 0 && $sewa->status !== 'Dibatalkan')
                                    <div class="d-flex justify-content-between text-danger fw-extrabold">
                                        <span>Sisa Tagihan:</span>
                                        <span>Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-7">
                            @if($sisaTagihan > 0 && $sewa->status !== 'Dibatalkan')
                                <div class="p-3 rounded-4 border" style="background: #f8fafa;" data-payment-box="{{ $sewa->id_sewa }}">
                                    @if($totalDibayar === 0)
                                        <div class="small fw-extrabold mb-2">Pilih Opsi Pembayaran Midtrans:</div>
                                        <div class="row g-2 mb-3">
                                            <div class="col-sm-6">
                                                <label class="trx-pay-option">
                                                    <input type="radio" name="tipe_bayar_{{ $sewa->id_sewa }}" value="dp" data-amount="{{ $nominalDp }}">
                                                    <div class="trx-pay-box">
                                                        <div class="fw-extrabold small">Bayar DP 50%</div>
                                                        <div class="fw-black" style="font-weight: 900;">Rp {{ number_format($nominalDp, 0, ',', '.') }}</div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="trx-pay-option">
                                                    <input type="radio" name="tipe_bayar_{{ $sewa->id_sewa }}" value="penuh" data-amount="{{ $sisaTagihan }}" checked>
                                                    <div class="trx-pay-box">
                                                        <div class="fw-extrabold small">Bayar Penuh 100%</div>
                                                        <div class="fw-black" style="font-weight: 900;">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    @else
                                        <input type="radio" name="tipe_bayar_{{ $sewa->id_sewa }}" value="penuh" data-amount="{{ $sisaTagihan }}" checked class="d-none">
                                        <div class="small fw-bold text-secondary mb-2">
                                            DP telah diterima. Lunasi sisa tagihan <strong>Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</strong>:
                                        </div>
                                    @endif

                                    <div class="d-flex flex-wrap justify-content-end gap-2">
                                        @if($sewa->status === 'Berjalan' && $totalDibayar === 0)
                                            <form action="{{ route('pelanggan.penyewaan.batal', $sewa->id_sewa) }}" method="POST" onsubmit="return confirm('Batalkan pesanan sewa {{ $sewa->id_sewa }}? Stok alat akan dikembalikan.')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger rounded-pill py-2 px-3 small fw-bold">
                                                    <i class="bi bi-x-circle me-1"></i> Batalkan Pesanan
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('public.sewa.sukses', $sewa->id_sewa) }}" class="btn-foresta-outline py-2 px-3 small">
                                            Detail Bukti
                                        </a>
                                        <button
                                            type="button"
                                            class="btn-foresta-lime py-2 px-4 pay-midtrans-btn"
                                            data-sewa-id="{{ $sewa->id_sewa }}"
                                            data-url="{{ route('pelanggan.pembayaran.midtrans.token', $sewa->id_sewa) }}"
                                            data-confirm-url="{{ route('public.sewa.midtrans.confirm', $sewa->id_sewa) }}"
                                        >
                                            <i class="bi bi-credit-card me-1"></i> Bayar Midtrans
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="d-flex justify-content-lg-end gap-2">
                                    <a href="{{ route('public.sewa.sukses', $sewa->id_sewa) }}" class="btn-foresta-outline py-2 px-3 small">
                                        Lihat Bukti Sewa
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-5 rounded-4 border bg-white text-center">
                <i class="bi bi-bag-x fs-1 text-secondary"></i>
                <h3 class="h5 fw-extrabold mt-3">Belum Ada Transaksi Aktif</h3>
                <p class="text-secondary small mb-3">
                    @if($statusVerifikasi === 'belum_verifikasi')
                        Riwayat transaksi akan tampil setelah admin memverifikasi data Anda, atau silakan buat pesanan sewa baru.
                    @else
                        Anda belum memiliki transaksi penyewaan. Yuk pilih peralatan outdoor untuk petualangan Anda!
                    @endif
                </p>
                <a href="{{ route('public.katalog') }}" class="btn-foresta-lime">
                    Lihat Daftar Peralatan <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        @endforelse
    @endif

    {{-- TAB 2: UPGRADE MEMBER (Tanpa Icon, Warna Awal Hitam & Lime) --}}
    @if($activeTab === 'member')
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="upgrade-member-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <span class="upgrade-tier-badge">CAMPSEWA ADVENTURE CLUB</span>
                            <span class="px-3 py-1 rounded-pill small fw-extrabold" style="background: var(--foresta-lime-soft); color: #111827;">
                                {{ $statusVerifikasi === 'terverifikasi' ? 'Priority Member' : 'Regular Member' }}
                            </span>
                        </div>

                        <h2 class="h3 fw-black mb-1 text-dark" style="font-weight: 900;">
                            {{ $statusVerifikasi === 'terverifikasi' ? 'Verified Priority Member' : 'Upgrade ke Priority Member' }}
                        </h2>
                        <p class="small text-secondary mb-4">
                            {{ auth()->user()->name }} &middot; {{ auth()->user()->email }}
                        </p>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-4">
                                <div class="upgrade-stat-box">
                                    <div class="small text-secondary">Poin Loyalitas</div>
                                    <div class="fs-4 fw-black mt-1 text-dark" style="font-weight: 900;">{{ $profil->poin_loyalitas ?? 0 }} Poin</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="upgrade-stat-box">
                                    <div class="small text-secondary">Sewa Selesai</div>
                                    <div class="fs-4 fw-black text-dark mt-1" style="font-weight: 900;">{{ $stats['sewa_selesai'] ?? 0 }}x</div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="upgrade-stat-box">
                                    <div class="small text-secondary">Status Identitas</div>
                                    <div class="fw-extrabold mt-2 text-dark">
                                        {{ $statusVerifikasi === 'terverifikasi' ? 'Terverifikasi' : 'Belum Verifikasi' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('pelanggan.member.upgrade') }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn-upgrade-cream w-100">
                            {{ $statusVerifikasi === 'terverifikasi' ? 'Status Priority Member Aktif' : 'Ajukan Upgrade & Verifikasi Member Sekarang' }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="upgrade-benefit-card h-100">
                    <span class="d-inline-block px-3 py-1 rounded-pill small fw-extrabold mb-2" style="background: var(--foresta-lime-soft); color: #101010;">
                        KEUNTUNGAN EKSKLUSIF
                    </span>
                    <h3 class="h5 fw-extrabold mb-3" style="color: #101010;">Keuntungan Upgrade Member</h3>
                    <div class="d-flex flex-column gap-3 small mb-0">
                        <div class="upgrade-benefit-item">
                            <div class="fw-extrabold mb-1" style="color: #101010;">Opsi Bayar DP 50%</div>
                            <div class="text-secondary">Cukup bayar 50% uang muka via Midtrans (QRIS / DANA) untuk mengunci stok peralatan di tanggal pendakian.</div>
                        </div>
                        <div class="upgrade-benefit-item">
                            <div class="fw-extrabold mb-1" style="color: #101010;">Fast Track Ambil Barang</div>
                            <div class="text-secondary">Data identitas KTP/SIM/KTM sudah terverifikasi sehingga pengambilan di store jauh lebih cepat.</div>
                        </div>
                        <div class="upgrade-benefit-item">
                            <div class="fw-extrabold mb-1" style="color: #101010;">Poin Loyalitas Setiap Transaksi</div>
                            <div class="text-secondary">Kumpulkan poin dari setiap penyewaan yang selesai tepat waktu.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- TAB 3: PENGATURAN AKUN --}}
    @if($activeTab === 'pengaturan')
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-4 p-md-5 rounded-4 border bg-white">
                    <h2 class="h4 fw-black mb-1" style="font-weight: 900;">Pengaturan Akun</h2>
                    <p class="small text-secondary mb-4">Perbarui informasi kontak, alamat, dan kata sandi akun Anda.</p>

                    <form action="{{ route('pelanggan.pengaturan.update') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-md-6">
                            <label class="form-label small fw-extrabold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control fw-semibold" value="{{ old('nama', $profil->nama ?? auth()->user()->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-extrabold">Email Akun</label>
                            <input type="email" class="form-control bg-light" value="{{ auth()->user()->email }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-extrabold">Nomor HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control fw-semibold" value="{{ old('no_hp', $profil->no_hp ?? auth()->user()->no_hp) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-extrabold">Nomor Identitas (KTP/SIM/KTM)</label>
                            <input type="text" class="form-control bg-light" value="{{ $profil->no_identitas ?? '-' }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-extrabold">Alamat Lengkap</label>
                            <input type="text" name="alamat" class="form-control fw-semibold" value="{{ old('alamat', $profil->alamat ?? '') }}" placeholder="Alamat domisili">
                        </div>

                        <div class="col-12 pt-2 border-top mt-3">
                            <div class="small fw-extrabold text-secondary mb-2">Ganti Password (Opsional — kosongkan jika tidak ingin mengubah)</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-extrabold">Password Baru</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-extrabold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                        </div>

                        <div class="col-12 pt-3">
                            <button type="submit" class="btn-foresta-lime px-4 py-3">
                                <i class="bi bi-check2-circle"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
    @if(config('services.midtrans.client_key'))
        <script src="{{ config('services.midtrans.snap_js_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @endif
    <script>
        (function () {
            async function confirmSettlement(confirmUrl, orderId, grossAmount, tipeBayar) {
                if (!confirmUrl) return;
                try {
                    await fetch(confirmUrl, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                            gross_amount: grossAmount,
                            tipe_bayar: tipeBayar
                        }),
                    });
                } catch (e) {
                    // ignore
                }
            }

            document.querySelectorAll('.pay-midtrans-btn').forEach((button) => {
                button.addEventListener('click', async () => {
                    const url = button.dataset.url;
                    const confirmUrl = button.dataset.confirmUrl;
                    const sewaId = button.dataset.sewaId;
                    const alertBox = document.getElementById('midtrans-alert');
                    const checkedRadio = sewaId
                        ? document.querySelector(`input[name="tipe_bayar_${sewaId}"]:checked`)
                        : null;

                    const payload = {};
                    const tipeBayar = checkedRadio ? checkedRadio.value : 'penuh';
                    if (checkedRadio && checkedRadio.value === 'dp') {
                        payload.tipe_bayar = 'dp';
                        payload.jumlah_bayar = parseInt(checkedRadio.dataset.amount || '0', 10);
                    }

                    button.disabled = true;

                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify(payload),
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal memulai pembayaran Midtrans.');
                        }

                        if (!data.simulation && window.snap && data.token) {
                            window.snap.pay(data.token, {
                                onSuccess: async function () {
                                    await confirmSettlement(confirmUrl, data.order_id, data.gross_amount, tipeBayar);
                                    window.location.reload();
                                },
                                onPending: async function () {
                                    await confirmSettlement(confirmUrl, data.order_id, data.gross_amount, tipeBayar);
                                    window.location.reload();
                                },
                                onError: function () {
                                    button.disabled = false;
                                },
                                onClose: function () {
                                    button.disabled = false;
                                }
                            });
                        } else if (!data.simulation && data.redirect_url) {
                            window.location.href = data.redirect_url;
                        } else if (window.CampSewaMidtrans) {
                            button.disabled = false;
                            window.CampSewaMidtrans.openModal(data, confirmUrl, tipeBayar, async function () {
                                await confirmSettlement(confirmUrl, data.order_id, data.gross_amount, tipeBayar);
                            });
                        }
                    } catch (error) {
                        if (alertBox) {
                            alertBox.className = 'alert alert-danger rounded-4 border-0 mb-3';
                            alertBox.textContent = error.message;
                        }
                        button.disabled = false;
                    }
                });
            });
        })();
    </script>
@endsection
