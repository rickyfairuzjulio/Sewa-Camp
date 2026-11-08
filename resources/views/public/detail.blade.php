@extends('layouts.public')

@section('title', $alat->nama_alat . ' - CampSewa Adventure')

@section('styles')
<style>
    .foresta-tour-title {
        font-size: clamp(1.75rem, 3vw, 2.35rem);
        font-weight: 900;
        letter-spacing: -0.02em;
        color: #101010;
    }

    .foresta-gallery-frame {
        position: relative;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #e4e6e8;
        background: #f6f7f8;
        aspect-ratio: 16 / 10;
    }

    .foresta-gallery-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .box-collapse-expand {
        border: 1px solid #e4e6e8;
        border-radius: 16px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .box-collapse-expand .collapse-btn {
        width: 100%;
        padding: 18px 22px;
        border: 0;
        border-bottom: 1px solid #e4e6e8;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 1.05rem;
        font-weight: 800;
        color: #101010;
    }

    .box-collapse-expand .card-body {
        padding: 22px;
    }

    .sidebar-price-card {
        border: 1px solid #e4e6e8;
        border-radius: 18px;
        padding: 24px;
        background: #ffffff;
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.05);
    }

    .related-item-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #eef0f2;
        text-decoration: none;
        color: #101010;
    }

    .related-item-row:last-child {
        border-bottom: 0;
        padding-bottom: 0;
    }

    .related-item-thumb {
        width: 72px;
        height: 72px;
        border-radius: 12px;
        overflow: hidden;
        background: #f4f6f8;
        flex-shrink: 0;
        border: 1px solid #e6e8ec;
    }

    .related-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .related-item-title {
        font-size: 0.92rem;
        font-weight: 800;
        line-height: 1.35;
        color: #101010;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .related-item-row:hover .related-item-title {
        color: #28a745;
    }
</style>
@endsection

@section('content')
<main class="container py-4 py-lg-5">
    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb small fw-bold mb-0">
            <li class="breadcrumb-item"><a href="{{ route('public.beranda') }}" class="text-decoration-none text-secondary">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('public.katalog') }}" class="text-decoration-none text-secondary">Peralatan</a></li>
            @if($alat->kategori)
                <li class="breadcrumb-item"><a href="{{ route('public.katalog', ['kategori' => $alat->id_kategori]) }}" class="text-decoration-none text-secondary">{{ $alat->kategori->nama_kategori }}</a></li>
            @endif
            <li class="breadcrumb-item active text-dark" aria-current="page">{{ $alat->nama_alat }}</li>
        </ol>
    </nav>

    {{-- Foresta Tour/Product Header --}}
    <div class="mb-4">
        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="badge rounded-pill text-dark px-3 py-1 fw-extrabold" style="background: var(--foresta-lime);">
                {{ $alat->kategori->nama_kategori ?? 'Outdoor Gear' }}
            </span>
            <span class="badge rounded-pill bg-light text-dark border px-3 py-1 fw-bold">
                Kondisi: {{ $alat->kondisi ?: 'Baik' }}
            </span>
            @if($alat->stok > 0)
                <span class="badge rounded-pill bg-dark text-white px-3 py-1 fw-bold">
                    Tersedia {{ $alat->stok }} Unit
                </span>
            @else
                <span class="badge rounded-pill bg-danger text-white px-3 py-1 fw-bold">
                    Stok Habis
                </span>
            @endif
        </div>
        <h1 class="foresta-tour-title mb-0">{{ $alat->nama_alat }}</h1>
    </div>

    <div class="row g-4">
        {{-- Left Column (col-lg-8): Photo Frame + Collapsible Description --}}
        <div class="col-lg-8">
            <div class="foresta-gallery-frame mb-4">
                <img
                    src="{{ $alat->gambar_url }}"
                    alt="{{ $alat->nama_alat }}"
                    onerror="this.onerror=null;this.src='{{ asset('images/default-camp.svg') }}';"
                >
            </div>

            <div class="box-collapse-expand">
                <button class="collapse-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDesc" aria-expanded="true" aria-controls="collapseDesc">
                    <span>Deskripsi</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="collapse show" id="collapseDesc">
                    <div class="card-body">
                        <p class="mb-4" style="line-height: 1.75; color: #363a3e;">
                            {{ $alat->deskripsi ?: 'Peralatan camping dan pendakian standar ekspedisi, selalu dicuci bersih dan dicek kelengkapannya sebelum diserahkan kepada penyewa.' }}
                        </p>

                        <div class="row g-3">
                            <div class="col-sm-6 col-md-3">
                                <div class="p-3 rounded-3 bg-light border">
                                    <div class="small text-secondary fw-bold">Kategori</div>
                                    <div class="fw-extrabold">{{ $alat->kategori->nama_kategori ?? 'Outdoor' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="p-3 rounded-3 bg-light border">
                                    <div class="small text-secondary fw-bold">Kondisi Fisik</div>
                                    <div class="fw-extrabold text-success">{{ $alat->kondisi ?: 'Baik' }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="p-3 rounded-3 bg-light border">
                                    <div class="small text-secondary fw-bold">Stok Gudang</div>
                                    <div class="fw-extrabold">{{ $alat->stok }} Unit</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <div class="p-3 rounded-3 bg-light border">
                                    <div class="small text-secondary fw-bold">Denda Terlambat</div>
                                    <div class="fw-extrabold">Rp 10.000/hari</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-collapse-expand">
                <button class="collapse-btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTerms" aria-expanded="true" aria-controls="collapseTerms">
                    <span>Ketentuan &amp; Jaminan Penyewaan</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="collapse show" id="collapseTerms">
                    <div class="card-body">
                        <ul class="mb-0 ps-3 d-flex flex-column gap-2 small fw-semibold text-secondary">
                            <li>Wajib meninggalkan <strong>1 identitas asli aktif (KTP / SIM / KTM)</strong> saat pengambilan peralatan di store.</li>
                            <li>Hitungan tarif sewa adalah per hari kalender sesuai tanggal ambil dan tanggal rencana kembali.</li>
                            <li>Pembayaran dapat dilakukan secara online melalui <strong>Midtrans (QRIS, Virtual Account, GoPay)</strong> atau langsung di kasir store.</li>
                            <li>Lokasi pengambilan &amp; pengembalian: <strong>CampSewa Store, Jl. Prof. Hamka No. 12, Ngaliyan, Semarang</strong>.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column (col-lg-4): Foresta Price Box & Peralatan Lainnya --}}
        <div class="col-lg-4">
            <div class="sidebar-price-card mb-4">
                <h6 class="fw-extrabold text-secondary mb-2">Harga sewa</h6>
                <div class="d-flex align-items-baseline gap-1 mb-3">
                    <span class="fs-2 fw-black" style="font-weight: 900;">Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}</span>
                    <span class="text-secondary fw-bold">/ hari</span>
                </div>

                @if($alat->stok > 0)
                    <div class="p-3 rounded-4 mb-3" style="background: #f2f4f4;">
                        <div class="row g-2">
                            <div class="col-6">
                                <label for="est-qty" class="form-label small fw-extrabold text-secondary mb-1">Jumlah Unit</label>
                                <input type="number" id="est-qty" class="form-control form-control-sm fw-bold border-0" value="1" min="1" max="{{ $alat->stok }}">
                            </div>
                            <div class="col-6">
                                <label for="est-days" class="form-label small fw-extrabold text-secondary mb-1">Durasi (Hari)</label>
                                <input type="number" id="est-days" class="form-control form-control-sm fw-bold border-0" value="2" min="1" max="30">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top small">
                            <span class="text-secondary fw-bold">Estimasi Total:</span>
                            <strong id="est-total" class="fs-6 fw-extrabold text-dark">
                                Rp {{ number_format($alat->harga_sewa_per_hari * 2, 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button
                            type="button"
                            class="btn-foresta-lime w-100 py-3 justify-content-center"
                            data-add-to-cart
                            data-id="{{ $alat->id_alat }}"
                            data-name="{{ $alat->nama_alat }}"
                            data-price="{{ $alat->harga_sewa_per_hari }}"
                            data-stok="{{ $alat->stok }}"
                        >
                            <i class="bi bi-cart-plus"></i> + Tambah ke Keranjang
                        </button>
                        <a href="{{ route('public.sewa', ['alat_id' => $alat->id_alat]) }}" class="btn btn-outline-dark w-100 py-2 rounded-pill fw-bold text-center text-decoration-none">
                            <i class="bi bi-calendar-check me-1"></i> Sewa Langsung Sekarang
                        </a>
                    </div>
                @else
                    <div class="alert alert-danger rounded-3 py-2 small fw-bold mb-3">
                        <i class="bi bi-exclamation-circle me-1"></i> Maaf, stok peralatan ini sedang habis disewa.
                    </div>
                @endif

                <p class="small text-secondary mb-0">
                    <i class="bi bi-person-vcard me-1 text-dark"></i> Menggunakan KTP / SIM / KTM asli sebagai jaminan saat pengambilan di store.
                </p>
            </div>

            {{-- Peralatan Lainnya Sidebar (Foresta style) --}}
            @if($terkait->isNotEmpty())
                <div class="foresta-box-sidebar">
                    <div class="foresta-box-sidebar-head">Peralatan Lainnya</div>
                    <div class="foresta-box-sidebar-body">
                        @foreach($terkait as $item)
                            <div class="related-item-row">
                                <a href="{{ route('public.detail', $item->id_alat) }}" class="related-item-thumb">
                                    <img
                                        src="{{ $item->gambar_url }}"
                                        alt="{{ $item->nama_alat }}"
                                        loading="lazy"
                                        onerror="this.onerror=null;this.src='{{ asset('images/default-camp.svg') }}';"
                                    >
                                </a>
                                <div class="min-w-0 flex-grow-1">
                                    <a href="{{ route('public.detail', $item->id_alat) }}" class="related-item-title text-decoration-none">
                                        {{ $item->nama_alat }}
                                    </a>
                                    <div class="fw-extrabold small text-dark">
                                        Rp {{ number_format($item->harga_sewa_per_hari, 0, ',', '.') }}
                                        <span class="text-secondary fw-normal">/ hari</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@section('scripts')
@if($alat->stok > 0)
<script>
    (function () {
        const dailyRate = {{ (int) $alat->harga_sewa_per_hari }};
        const qtyInput = document.getElementById('est-qty');
        const daysInput = document.getElementById('est-days');
        const totalEl = document.getElementById('est-total');

        function updateEstimate() {
            const qty = Math.max(1, Number(qtyInput?.value || 1));
            const days = Math.max(1, Number(daysInput?.value || 1));
            const total = dailyRate * qty * days;
            if (totalEl) {
                totalEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }

        qtyInput?.addEventListener('input', updateEstimate);
        daysInput?.addEventListener('input', updateEstimate);
    })();
</script>
@endif
@endsection
