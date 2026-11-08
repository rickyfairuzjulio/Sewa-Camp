@extends('layouts.admin')

@section('title', 'Katalog & Inventaris Alat - CampSewa')
@section('page_title', 'Katalog & Inventaris Alat')
@section('page_subtitle', 'Kelola daftar peralatan camping, stok tersedia, dan harga sewa harian.')

@section('content')
    @php
        $selectedPrice = request('price_range', 'all');
        $selectedKategoriObj = $kategori->firstWhere('id_kategori', (int) request('kategori'));
        $maxSliderVal = (int) request('max_price', 150000);
        $hasFilter = request()->filled('q') || request()->filled('kategori') || ($selectedPrice !== 'all') || request()->filled('kondisi') || request()->filled('stok_status') || request()->filled('min_price') || request()->filled('max_price');
    @endphp

    <div class="shoplytic-workspace">
        {{-- Panel Filter Kiri --}}
        <aside class="shoplytic-filter-card {{ $hasFilter ? '' : 'd-none d-lg-block' }}">
            <div class="filter-card-title d-flex align-items-center justify-content-between">
                <span><i class="bi bi-sliders me-1"></i> Filter Peralatan</span>
                <div class="d-flex align-items-center gap-2">
                    @if($hasFilter)
                        <a href="{{ route('admin.alat.index') }}" class="filter-reset-link">Reset</a>
                    @endif
                    <button type="button" class="btn-close d-lg-none" data-close-shop-filter aria-label="Tutup Filter"></button>
                </div>
            </div>

            <form action="{{ route('admin.alat.index') }}" method="GET">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif

                {{-- Kategori Alat --}}
                <div class="filter-group-box">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#alatFilterKategori" aria-expanded="true">
                        <span>Kategori Alat</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                    <div class="collapse show mt-2" id="alatFilterKategori">
                        <select name="kategori" class="form-select form-select-sm border-0 bg-white rounded-3 fw-semibold" onchange="this.form.submit()">
                            <option value="">Semua Kategori ({{ $priceCounts['all'] ?? 0 }})</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ (string) request('kategori') === (string) $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }} ({{ $kat->alat_count ?? 0 }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Harga Sewa / Hari --}}
                <div class="filter-group-box mb-2">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#alatFilterHarga" aria-expanded="true">
                        <span>Harga Sewa / Hari</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                </div>

                <div class="collapse show" id="alatFilterHarga">
                    <div class="filter-price-list">
                        <label class="filter-check-item">
                            <span class="filter-check-left">
                                <input type="radio" name="price_range" value="all" {{ $selectedPrice === 'all' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="filter-check-box"><i class="bi bi-check-lg"></i></span>
                                <span class="filter-check-label">Semua Harga</span>
                            </span>
                            <span class="filter-count-pill">{{ number_format($priceCounts['all'] ?? 0) }}</span>
                        </label>
                        <label class="filter-check-item">
                            <span class="filter-check-left">
                                <input type="radio" name="price_range" value="under_25k" {{ $selectedPrice === 'under_25k' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="filter-check-box"><i class="bi bi-check-lg"></i></span>
                                <span class="filter-check-label">&lt; Rp 25.000</span>
                            </span>
                            <span class="filter-count-pill">{{ number_format($priceCounts['under_25k'] ?? 0) }}</span>
                        </label>
                        <label class="filter-check-item">
                            <span class="filter-check-left">
                                <input type="radio" name="price_range" value="25k_50k" {{ $selectedPrice === '25k_50k' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="filter-check-box"><i class="bi bi-check-lg"></i></span>
                                <span class="filter-check-label">Rp 25rb – 50rb</span>
                            </span>
                            <span class="filter-count-pill">{{ number_format($priceCounts['25k_50k'] ?? 0) }}</span>
                        </label>
                        <label class="filter-check-item">
                            <span class="filter-check-left">
                                <input type="radio" name="price_range" value="50k_75k" {{ $selectedPrice === '50k_75k' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="filter-check-box"><i class="bi bi-check-lg"></i></span>
                                <span class="filter-check-label">Rp 50rb – 75rb</span>
                            </span>
                            <span class="filter-count-pill">{{ number_format($priceCounts['50k_75k'] ?? 0) }}</span>
                        </label>
                        <label class="filter-check-item">
                            <span class="filter-check-left">
                                <input type="radio" name="price_range" value="75k_100k" {{ $selectedPrice === '75k_100k' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="filter-check-box"><i class="bi bi-check-lg"></i></span>
                                <span class="filter-check-label">Rp 75rb – 100rb</span>
                            </span>
                            <span class="filter-count-pill">{{ number_format($priceCounts['75k_100k'] ?? 0) }}</span>
                        </label>
                        <label class="filter-check-item">
                            <span class="filter-check-left">
                                <input type="radio" name="price_range" value="above_100k" {{ $selectedPrice === 'above_100k' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="filter-check-box"><i class="bi bi-check-lg"></i></span>
                                <span class="filter-check-label">&gt; Rp 100.000</span>
                            </span>
                            <span class="filter-count-pill">{{ number_format($priceCounts['above_100k'] ?? 0) }}</span>
                        </label>
                    </div>

                    <div class="price-slider-wrap">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-extrabold">Batas Harga :</span>
                            <span class="price-bubble mb-0" id="alatPriceBubble">Rp {{ number_format($maxSliderVal, 0, ',', '.') }}</span>
                        </div>
                        <input
                            type="range"
                            class="shop-range-input"
                            min="0"
                            max="150000"
                            step="5000"
                            value="{{ $maxSliderVal }}"
                            oninput="document.getElementById('alatMaxPriceInput').value = this.value; document.getElementById('alatPriceBubble').textContent = 'Rp ' + Number(this.value).toLocaleString('id-ID');"
                        >
                        <div class="price-minmax-row">
                            <input type="number" name="min_price" value="{{ request('min_price', 0) }}" class="price-minmax-input" placeholder="Min Rp">
                            <span class="text-muted small">-</span>
                            <input type="number" name="max_price" id="alatMaxPriceInput" value="{{ request('max_price') }}" class="price-minmax-input" placeholder="Maks Rp">
                        </div>
                    </div>
                </div>

                {{-- Kondisi Fisik --}}
                <div class="filter-group-box">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#alatFilterKondisi" aria-expanded="true">
                        <span>Kondisi Fisik</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                    <div class="collapse show mt-2" id="alatFilterKondisi">
                        <select name="kondisi" class="form-select form-select-sm border-0 bg-white rounded-3 fw-semibold">
                            <option value="">Semua kondisi</option>
                            <option value="Baik" {{ request('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak" {{ request('kondisi') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        </select>
                    </div>
                </div>

                {{-- Ketersediaan Stok --}}
                <div class="filter-group-box mb-3">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#alatFilterStok" aria-expanded="true">
                        <span>Ketersediaan Stok</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                    <div class="collapse show mt-2" id="alatFilterStok">
                        <select name="stok_status" class="form-select form-select-sm border-0 bg-white rounded-3 fw-semibold">
                            <option value="">Semua Stok</option>
                            <option value="tersedia" {{ request('stok_status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="menipis" {{ request('stok_status') === 'menipis' ? 'selected' : '' }}>Stok Menipis (&lt; 7)</option>
                            <option value="habis" {{ request('stok_status') === 'habis' ? 'selected' : '' }}>Habis</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-shoplytic-lime w-100">
                    <i class="bi bi-funnel-fill"></i> Terapkan Filter
                </button>
            </form>
        </aside>

        {{-- Area Product Grid Kanan --}}
        <section class="shoplytic-main-panel">
            <div class="shoplytic-subbar">
                <div>
                    <div class="shoplytic-breadcrumb">
                        Katalog Alat &gt; <strong>{{ $selectedKategoriObj?->nama_kategori ?? 'Semua Kategori' }}</strong>
                    </div>
                    <div class="shoplytic-count">
                        Menampilkan <strong>{{ number_format($alats->total()) }}</strong> peralatan
                    </div>
                </div>

                <div class="shoplytic-subbar-actions">
                    <form action="{{ route('admin.alat.index') }}" method="GET" class="subbar-search-wrap">
                        <i class="bi bi-search subbar-search-icon"></i>
                        <input type="text" name="q" value="{{ request('q') }}" class="subbar-search-input" placeholder="Cari alat...">
                    </form>

                    <button type="button" class="btn-subbar-pill btn-filter-toggle {{ $hasFilter ? 'is-on active' : 'is-off' }}" data-toggle-shop-filter data-has-active-filter="{{ $hasFilter ? '1' : '0' }}" aria-pressed="{{ $hasFilter ? 'true' : 'false' }}" title="Buka / Tutup Filter Peralatan">
                        <i class="bi bi-funnel"></i>
                        <span>Filter</span>
                        <span class="filter-toggle-state badge-on">ON</span>
                        <span class="filter-toggle-state badge-off">OFF</span>
                    </button>

                    <a href="{{ route('admin.alat.create') }}" class="btn-shoplytic-lime py-2 px-3">
                        <i class="bi bi-plus-lg"></i> Tambah Alat Baru
                    </a>
                </div>
            </div>

            <div class="shoplytic-product-grid">
                @forelse($alats as $alat)
                    <article class="shoplytic-product-card">
                        <div class="shoplytic-img-box">
                            <span class="shoplytic-stock-chip {{ $alat->stok < 3 ? 'low' : '' }}">
                                Stok: {{ $alat->stok }} unit
                            </span>
                            <span class="shoplytic-cat-chip">
                                {{ $alat->kategori?->nama_kategori ?? 'Outdoor' }}
                            </span>
                            <img
                                src="{{ $alat->gambar_url }}"
                                alt="{{ $alat->nama_alat }}"
                                onerror="this.onerror=null;this.src='{{ asset('images/default-camp.svg') }}';"
                            >
                        </div>

                        <h3 class="shoplytic-product-title" title="{{ $alat->nama_alat }}">
                            {{ $alat->nama_alat }}
                        </h3>
                        <p class="shoplytic-product-desc">
                            {{ $alat->deskripsi ?: 'Perlengkapan camping kategori ' . ($alat->kategori?->nama_kategori ?? 'Outdoor') . ' siap sewa dengan kondisi ' . strtolower($alat->kondisi) . '.' }}
                        </p>

                        <div class="shoplytic-product-footer">
                            <div class="shoplytic-price-wrap">
                                <span class="shoplytic-price">
                                    Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}<small>/hari</small>
                                </span>
                            </div>
                            <div class="shoplytic-card-actions">
                                <a href="{{ route('admin.alat.edit', $alat->id_alat) }}" class="shoplytic-icon-btn btn-edit-action" title="Edit Data Alat">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('admin.alat.destroy', $alat->id_alat) }}" method="POST" class="shoplytic-action-form" onsubmit="return confirm('Hapus alat &quot;{{ addslashes($alat->nama_alat) }}&quot;? Tindakan ini akan menghapus data dari inventaris.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="shoplytic-icon-btn btn-delete-action" title="Hapus Alat">
                                        <i class="bi bi-trash3"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-12 text-center py-5 text-muted" style="grid-column: 1 / -1;">
                        Belum ada alat camping.
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $alats->links() }}
            </div>
        </section>
    </div>
@endsection
