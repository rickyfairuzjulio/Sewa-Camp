@extends('layouts.public')

@section('title', 'Pengajuan Sewa Berhasil - CampSewa Adventure')

@section('styles')
<style>
    .pay-choice-label {
        display: block;
        cursor: pointer;
    }

    .pay-choice-label input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .pay-choice-box {
        padding: 16px;
        border: 2px solid #e4e6e8;
        border-radius: 14px;
        background: #ffffff;
        transition: all 0.2s ease;
        height: 100%;
    }

    .pay-choice-label input:checked + .pay-choice-box {
        border-color: #101010;
        background: var(--foresta-lime-soft);
        box-shadow: 0 8px 20px rgba(112, 244, 109, 0.2);
    }
</style>
@endsection

@section('content')
<div class="container pt-4 pb-5">
    <div class="foresta-page-banner mb-4">
        <span class="foresta-banner-tag">Booking Berhasil</span>
        <h1 class="fw-black mb-2" style="font-size: clamp(1.85rem, 3.5vw, 2.6rem); font-weight: 900;">Pengajuan sewa berhasil</h1>
        <p class="mb-0 text-white-50 fw-semibold">Pilih pembayaran DP 50% atau Bayar Penuh 100% dan pantau status barang Anda</p>
    </div>

    @php
        $totalBiaya = (int) round($sewa->total_biaya);
        $totalDibayar = (int) round($sewa->total_dibayar);
        $sisaTagihan = (int) round($sewa->sisa_tagihan);
        $nominalDp = max(1000, (int) ceil($totalBiaya * 0.5));
        $defaultSkema = session('skema_bayar', 'penuh');
        $statusBayar = $sewa->status_pembayaran;
    @endphp

    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="p-4 p-md-5 rounded-4 border bg-white shadow-sm">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pb-4 mb-4 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 56px; height: 56px; background: var(--foresta-lime); color: #101010;">
                            <i class="bi bi-check-lg fs-2"></i>
                        </div>
                        <div>
                            <div class="small text-secondary fw-bold">Nomor Transaksi</div>
                            <div class="fs-3 fw-black text-dark" style="font-weight: 900;">{{ $sewa->id_sewa }}</div>
                        </div>
                    </div>
                    <div class="text-md-end">
                        <div class="small text-secondary fw-bold mb-1">Status Transaksi &amp; Pembayaran</div>
                        <span class="badge rounded-pill text-bg-dark px-3 py-2">{{ $sewa->status }}</span>
                        @if($sisaTagihan <= 0)
                            <span class="badge rounded-pill text-dark px-3 py-2 fw-extrabold" style="background: var(--foresta-lime);">
                                Lunas ({{ $sewa->pembayaran->last()?->metode ?? 'Midtrans' }})
                            </span>
                        @elseif($totalDibayar > 0)
                            <span class="badge rounded-pill text-bg-info px-3 py-2 fw-bold">
                                Sudah DP (Rp {{ number_format($totalDibayar, 0, ',', '.') }})
                            </span>
                        @else
                            <span class="badge rounded-pill text-bg-warning px-3 py-2 fw-bold">Menunggu Pembayaran</span>
                        @endif
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4 bg-light border h-100">
                            <div class="small text-secondary fw-bold mb-1">Penyewa</div>
                            <strong class="d-block fs-6">{{ $sewa->pelanggan->nama }}</strong>
                            <span class="small text-secondary">{{ $sewa->pelanggan->no_hp }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 rounded-4 bg-light border h-100">
                            <div class="small text-secondary fw-bold mb-1">Periode Sewa ({{ $sewa->durasi_hari }} hari)</div>
                            <strong class="d-block fs-6">{{ $sewa->tgl_sewa->format('d M Y') }} – {{ $sewa->tgl_kembali_rencana->format('d M Y') }}</strong>
                            <span class="small text-secondary">Pengambilan di Store Ngaliyan Semarang</span>
                        </div>
                    </div>
                </div>

                {{-- Rincian & Status Barang --}}
                <h2 class="h6 fw-extrabold text-uppercase text-secondary mb-3">
                    <i class="bi bi-box-seam me-1 text-dark"></i> Rincian &amp; Status Barang yang Disewa
                </h2>
                <div class="d-flex flex-column gap-2 mb-4">
                    @foreach($sewa->details as $detail)
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 p-3 rounded-4 border bg-white">
                            <div class="d-flex align-items-center gap-3">
                                <img
                                    src="{{ $detail->alat?->gambar_url ?? asset('images/default-camp.svg') }}"
                                    alt="{{ $detail->alat?->nama_alat }}"
                                    style="width: 56px; height: 56px; object-fit: cover; border-radius: 12px;"
                                    onerror="this.onerror=null;this.src='{{ asset('images/default-camp.svg') }}';"
                                >
                                <div>
                                    <div class="fw-extrabold">{{ $detail->alat?->nama_alat }}</div>
                                    <div class="small text-secondary">
                                        {{ $detail->jumlah }} unit &times; Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}/hari
                                        &middot; Kondisi Barang: <strong class="text-success">{{ $detail->alat?->kondisi ?? 'Baik' }}</strong>
                                    </div>
                                    <div class="mt-1">
                                        @if($sewa->status === 'Selesai')
                                            <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle">
                                                <i class="bi bi-check-circle-fill me-1"></i> Barang Sudah Dikembalikan
                                            </span>
                                        @elseif($sewa->status === 'Dibatalkan')
                                            <span class="badge rounded-pill bg-secondary-subtle text-secondary">
                                                Dibatalkan
                                            </span>
                                        @elseif($totalDibayar > 0)
                                            <span class="badge rounded-pill text-dark fw-extrabold" style="background: var(--foresta-lime);">
                                                <i class="bi bi-box-seam-fill me-1"></i> Siap Diambil / Sedang Disewa
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-warning-subtle text-dark border border-warning-subtle">
                                                <i class="bi bi-clock-history me-1"></i> Barang Dipesan (Menunggu Pembayaran DP / Penuh)
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <strong class="text-nowrap fs-6 fw-extrabold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan Tagihan --}}
                <div class="p-3 rounded-4 border bg-light mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="fw-bold text-secondary">Total biaya sewa</span>
                        <strong class="fs-5 fw-black text-dark">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</strong>
                    </div>
                    @if($totalDibayar > 0)
                        <div class="d-flex justify-content-between align-items-center mb-1 small text-success fw-bold">
                            <span>Sudah dibayar (DP / Cicilan)</span>
                            <span>- Rp {{ number_format($totalDibayar, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                        <span class="fw-extrabold text-dark">Sisa Tagihan Saat Ini</span>
                        <strong class="fs-4 fw-black text-dark" style="font-weight: 900;">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</strong>
                    </div>
                </div>

                {{-- Pilih Bayar DP (50%) atau Bayar Penuh (100%) --}}
                @if($sisaTagihan > 0 && $sewa->status !== 'Dibatalkan')
                    <div class="p-4 rounded-4 border mb-4" style="background: #f8fafa;">
                        <h3 class="h6 fw-extrabold mb-1">
                            <i class="bi bi-credit-card-2-front me-1"></i> Pilih Pembayaran: Bayar DP atau Bayar Penuh
                        </h3>
                        <p class="small text-secondary mb-3">
                            Silakan pilih nominal yang ingin Anda bayarkan sekarang menggunakan Midtrans (<strong>QRIS</strong> &amp; <strong>DANA</strong>):
                        </p>

                        <div id="midtrans-error-alert" class="alert alert-danger d-none rounded-3 small py-2 mb-3"></div>

                        @if($totalDibayar === 0)
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="pay-choice-label">
                                        <input type="radio" name="pilihan_tipe_bayar" value="dp" data-amount="{{ $nominalDp }}" {{ $defaultSkema === 'dp' ? 'checked' : '' }}>
                                        <div class="pay-choice-box">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-extrabold">Bayar DP 50%</span>
                                                <span class="badge rounded-pill bg-dark text-white">Uang Muka</span>
                                            </div>
                                            <div class="fs-5 fw-black mb-1" style="font-weight: 900;">Rp {{ number_format($nominalDp, 0, ',', '.') }}</div>
                                            <div class="small text-secondary">Sisa Rp {{ number_format(max(0, $totalBiaya - $nominalDp), 0, ',', '.') }} dilunasi saat ambil barang.</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <label class="pay-choice-label">
                                        <input type="radio" name="pilihan_tipe_bayar" value="penuh" data-amount="{{ $sisaTagihan }}" {{ $defaultSkema !== 'dp' ? 'checked' : '' }}>
                                        <div class="pay-choice-box">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-extrabold">Bayar Penuh 100%</span>
                                                <span class="badge rounded-pill text-dark fw-extrabold" style="background: var(--foresta-lime);">Langsung Lunas</span>
                                            </div>
                                            <div class="fs-5 fw-black mb-1" style="font-weight: 900;">Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</div>
                                            <div class="small text-secondary">Langsung lunas tanpa sisa tagihan di store.</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @else
                            <input type="radio" name="pilihan_tipe_bayar" value="penuh" data-amount="{{ $sisaTagihan }}" checked class="d-none">
                            <div class="alert alert-info rounded-3 small fw-semibold mb-3">
                                Anda telah membayar DP sebesar <strong>Rp {{ number_format($totalDibayar, 0, ',', '.') }}</strong>. Klik tombol di bawah untuk melunasi sisa tagihan sebesar <strong>Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</strong>.
                            </div>
                        @endif

                        <button
                            type="button"
                            id="btn-pay-midtrans"
                            class="btn-foresta-lime w-100 py-3 fs-6 justify-content-center"
                            data-token-url="{{ route('public.sewa.midtrans.token', $sewa->id_sewa) }}"
                            data-confirm-url="{{ route('public.sewa.midtrans.confirm', $sewa->id_sewa) }}"
                        >
                            <i class="bi bi-shield-lock-fill"></i>
                            <span id="btn-pay-midtrans-text">Bayar Sekarang via Midtrans</span>
                        </button>
                    </div>
                @endif

                <div class="d-flex flex-wrap justify-content-center gap-2">
                    @auth
                        <a href="{{ route('pelanggan.dashboard') }}" class="btn-foresta-dark">
                            <i class="bi bi-receipt"></i> Lihat Transaksi &amp; Status Barang
                        </a>
                    @endauth
                    <a href="{{ route('public.katalog') }}" class="btn-foresta-outline">Kembali ke Katalog</a>
                    <a href="{{ route('public.beranda') }}" class="btn-foresta-outline">Ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    if (window.CampSewaCart) {
        window.CampSewaCart.saveCart([]);
    }
</script>
@if($sisaTagihan > 0 && $sewa->status !== 'Dibatalkan')
<script src="{{ config('services.midtrans.snap_js_url', 'https://app.sandbox.midtrans.com/snap/snap.js') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    (function () {
        const payBtn = document.getElementById('btn-pay-midtrans');
        const payBtnText = document.getElementById('btn-pay-midtrans-text');
        const errAlert = document.getElementById('midtrans-error-alert');
        const radios = document.querySelectorAll('input[name="pilihan_tipe_bayar"]');

        function getSelectedPayment() {
            const checked = document.querySelector('input[name="pilihan_tipe_bayar"]:checked');
            return {
                tipe: checked ? checked.value : 'penuh',
                amount: checked ? parseInt(checked.dataset.amount || '0', 10) : {{ $sisaTagihan }}
            };
        }

        function updatePayButtonLabel() {
            if (!payBtnText) return;
            const sel = getSelectedPayment();
            const label = sel.tipe === 'dp' ? 'Bayar DP 50%' : 'Bayar Penuh';
            payBtnText.textContent = label + ' (Rp ' + sel.amount.toLocaleString('id-ID') + ') via Midtrans';
        }

        radios.forEach(r => r.addEventListener('change', updatePayButtonLabel));
        updatePayButtonLabel();

        async function confirmClientSettlement(confirmUrl, orderId, grossAmount, tipeBayar) {
            try {
                await fetch(confirmUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        gross_amount: grossAmount,
                        tipe_bayar: tipeBayar
                    })
                });
            } catch (e) {
                // Ignore network error on fallback
            }
        }

        if (payBtn) {
            payBtn.addEventListener('click', async () => {
                const sel = getSelectedPayment();
                const originalHtml = payBtn.innerHTML;
                payBtn.disabled = true;
                if (errAlert) errAlert.classList.add('d-none');
                payBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menghubungi Midtrans...';

                try {
                    const response = await fetch(payBtn.dataset.tokenUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            tipe_bayar: sel.tipe,
                            jumlah_bayar: sel.amount
                        })
                    });

                    const data = await response.json();
                    const snapToken = data.token || data.snap_token;

                    if (!response.ok || !snapToken) {
                        throw new Error(data.message || 'Gagal membuat sesi pembayaran Midtrans.');
                    }

                    if (!data.simulation && window.snap) {
                        window.snap.pay(snapToken, {
                            onSuccess: async () => {
                                await confirmClientSettlement(payBtn.dataset.confirmUrl, data.order_id, data.gross_amount, sel.tipe);
                                window.location.reload();
                            },
                            onPending: async () => {
                                await confirmClientSettlement(payBtn.dataset.confirmUrl, data.order_id, data.gross_amount, sel.tipe);
                                window.location.reload();
                            },
                            onError: () => {
                                if (errAlert) {
                                    errAlert.textContent = 'Pembayaran gagal diproses oleh Midtrans.';
                                    errAlert.classList.remove('d-none');
                                }
                                payBtn.disabled = false;
                                payBtn.innerHTML = originalHtml;
                            },
                            onClose: () => {
                                payBtn.disabled = false;
                                payBtn.innerHTML = originalHtml;
                            }
                        });
                    } else if (!data.simulation && data.redirect_url) {
                        window.location.href = data.redirect_url;
                    } else if (window.CampSewaMidtrans) {
                        payBtn.disabled = false;
                        payBtn.innerHTML = originalHtml;
                        window.CampSewaMidtrans.openModal(data, payBtn.dataset.confirmUrl, sel.tipe, async () => {
                            await confirmClientSettlement(payBtn.dataset.confirmUrl, data.order_id, data.gross_amount, sel.tipe);
                        });
                    }
                } catch (err) {
                    if (errAlert) {
                        errAlert.textContent = err.message || 'Terjadi kesalahan saat menghubungi Midtrans.';
                        errAlert.classList.remove('d-none');
                    }
                    payBtn.disabled = false;
                    payBtn.innerHTML = originalHtml;
                }
            });
        }
    })();
</script>
@endif
@endsection
