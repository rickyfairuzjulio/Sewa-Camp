@extends('layouts.public')

@section('title', 'Daftar Peralatan Camping - CampSewa Adventure')

@section('styles')
<style>
    .katalog-filter-box {
        background: #ffffff;
        border: 1px solid #e4e6e8;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 14px 34px rgba(0, 0, 0, 0.05);
    }

    .foresta-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 999px;
        border: 1.5px solid #e2e5e8;
        background: #ffffff;
        color: #101010;
        font-size: 0.84rem;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .foresta-chip:hover {
        border-color: #101010;
        color: #101010;
    }

    .foresta-chip.active {
        background: var(--foresta-lime);
        border-color: var(--foresta-lime);
        color: #101010;
    }
</style>
@endsection

@section('content')
<div class="container pt-4 pb-5">
    {{-- Foresta Page Header Banner (page-header-2) --}}
    <div class="foresta-page-banner mb-4">
        <span class="foresta-banner-tag">Katalog Store</span>
        <h1 class="fw-black mb-2" style="font-size: clamp(1.9rem, 3.6vw, 2.75rem); font-weight: 900;">Daftar Peralatan</h1>
        <p class="mb-0 text-white-50 fw-semibold">Cari peralatan camping murah &amp; terawat di sini</p>
    </div>

    {{-- Foresta Filter & Schedule Bar --}}
    <div class="katalog-filter-box mb-4">
        <form action="{{ route('public.katalog') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-6 col-md-3 col-lg-2">
                <label class="form-label small fw-extrabold text-secondary mb-1">Tgl Ambil</label>
                <input type="date" name="tgl_sewa" id="katTglSewa" class="form-control fw-bold" value="{{ request('tgl_sewa', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <label class="form-label small fw-extrabold text-secondary mb-1">Durasi</label>
                <select name="durasi" id="katDurasi" class="form-select fw-bold">
                    @for($d = 1; $d <= 14; $d++)
                        <option value="{{ $d }}" {{ (int) request('durasi', 2) === $d ? 'selected' : '' }}>{{ $d }} Hari</option>
                    @endfor
                </select>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <label class="form-label small fw-extrabold text-secondary mb-1">Kategori</label>
                <select name="kategori" class="form-select fw-bold">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ (string) request('kategori') === (string) $kat->id_kategori ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-3 col-lg-2">
                <label class="form-label small fw-extrabold text-secondary mb-1">Urutkan</label>
                <select name="sort" class="form-select fw-bold">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A–Z</option>
                </select>
            </div>

            <div class="col-12 col-md-8 col-lg-2">
                <label class="form-label small fw-extrabold text-secondary mb-1">Cari</label>
                <input type="search" name="q" class="form-control fw-bold" placeholder="Cari peralatan ..." value="{{ request('q') }}">
            </div>

            <div class="col-12 col-md-4 col-lg-2 d-grid">
                <button type="submit" class="btn-foresta-lime py-2 justify-content-center" style="height: 40px;">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>

            <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2 pt-2 border-top mt-3">
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="stok" value="tersedia" id="stokCheck" {{ request('stok') == 'tersedia' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label class="form-check-label small fw-bold" for="stokCheck">
                            Hanya tampilkan stok siap sewa
                        </label>
                    </div>
                    <select name="kondisi" class="form-select form-select-sm w-auto fw-bold" onchange="this.form.submit()">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Kondisi: Baik</option>
                        <option value="Sangat Baik" {{ request('kondisi') == 'Sangat Baik' ? 'selected' : '' }}>Kondisi: Sangat Baik</option>
                    </select>
                </div>

                @if(request()->hasAny(['q', 'kategori', 'kondisi', 'stok', 'sort']))
                    <a href="{{ route('public.katalog') }}" class="small fw-extrabold text-danger text-decoration-none">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Category Quick Pills --}}
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('public.katalog', request()->except(['kategori', 'page'])) }}"
               class="foresta-chip {{ !request()->filled('kategori') ? 'active' : '' }}">
                Semua ({{ $alats->total() }})
            </a>
            @foreach($kategori as $kat)
                <a href="{{ route('public.katalog', array_merge(request()->except('page'), ['kategori' => $kat->id_kategori])) }}"
                   class="foresta-chip {{ (string) request('kategori') === (string) $kat->id_kategori ? 'active' : '' }}">
                    {{ $kat->nama_kategori }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Foresta 4-Column Product Grid --}}
    @if($alats->isEmpty())
        <div class="text-center py-5 px-3 border rounded-4 bg-light">
            <i class="bi bi-search fs-1 text-secondary"></i>
            <h3 class="h5 fw-extrabold mt-3">Tidak ada peralatan yang cocok</h3>
            <p class="text-secondary small mb-3">Silakan ubah kata kunci pencarian atau reset filter untuk melihat semua peralatan.</p>
            <a href="{{ route('public.katalog') }}" class="btn-foresta-dark">Reset Filter</a>
        </div>
    @else
        <div class="row g-4 mb-4">
            @foreach($alats as $alat)
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card-journey-small">
                        <a class="card-image" href="{{ route('public.detail', $alat->id_alat) }}">
                            <img
                                src="{{ $alat->gambar_url }}"
                                alt="{{ $alat->nama_alat }}"
                                loading="lazy"
                                onerror="this.onerror=null;this.src='{{ asset('images/default-camp.svg') }}';"
                            >
                            <span class="card-journey-badge-cat">{{ $alat->kategori->nama_kategori ?? 'Outdoor' }}</span>
                            @if($alat->stok > 0)
                                <span class="card-journey-badge-stock ready">Stok: {{ $alat->stok }}</span>
                            @else
                                <span class="card-journey-badge-stock empty">Habis</span>
                            @endif
                        </a>
                        <div class="card-info">
                            <div class="card-title">
                                <a href="{{ route('public.detail', $alat->id_alat) }}">{{ $alat->nama_alat }}</a>
                            </div>
                            <div class="card-price">
                                Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }} <span>/ hari</span>
                            </div>
                            <div class="card-journey-actions">
                                @if($alat->stok > 0)
                                    <button
                                        type="button"
                                        class="btn-card-cart"
                                        style="grid-column: 1 / -1;"
                                        data-add-to-cart
                                        data-id="{{ $alat->id_alat }}"
                                        data-name="{{ $alat->nama_alat }}"
                                        data-price="{{ $alat->harga_sewa_per_hari }}"
                                        data-stok="{{ $alat->stok }}"
                                    >
                                        <i class="bi bi-cart-plus"></i> + Keranjang
                                    </button>
                                @else
                                    <a href="{{ route('public.detail', $alat->id_alat) }}" class="btn-card-cart" style="grid-column: 1 / -1;">
                                        Lihat Detail
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $alats->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    (function () {
        const tglInput = document.getElementById('katTglSewa');
        const durSelect = document.getElementById('katDurasi');
        if (tglInput && durSelect && window.CampSewaCart) {
            tglInput.addEventListener('change', () => window.CampSewaCart.saveSchedule(tglInput.value, durSelect.value));
            durSelect.addEventListener('change', () => window.CampSewaCart.saveSchedule(tglInput.value, durSelect.value));
        }
    })();
</script>
@endsection
