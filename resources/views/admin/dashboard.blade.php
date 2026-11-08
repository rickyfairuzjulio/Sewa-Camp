@extends('layouts.admin')

@section('title', 'Dashboard Admin - CampSewa')
@section('page_title', 'Dashboard & Katalog Alat')
@section('page_subtitle', 'Pantau performa penyewaan, kelola inventaris alat camping, dan buat transaksi dengan cepat.')

@section('content')
    @php
        $selectedPrice = request('price_range', 'all');
        $selectedKategoriObj = $kategoris->firstWhere('id_kategori', (int) request('kategori'));
        $maxSliderVal = (int) request('max_price', 150000);
        $hasFilter = request()->filled('q') || request()->filled('kategori') || ($selectedPrice !== 'all') || request()->filled('kondisi') || request()->filled('stok_status') || request()->filled('min_price') || request()->filled('max_price');
    @endphp

    {{-- BARIS ATAS: 4 KARTU RINGKASAN STATISTIK UTAMA --}}
    <section class="dashboard-stats" aria-label="Ringkasan statistik">
        <article class="dashboard-stat">
            <div>
                <div class="dashboard-stat-label">Total Penyewaan</div>
                <p class="dashboard-stat-value">{{ number_format($stats['total_sewa'] ?? 0) }}</p>
                <p class="dashboard-stat-note">{{ number_format($stats['sewa_berjalan'] ?? 0) }} berjalan &middot; {{ number_format($stats['sewa_selesai'] ?? 0) }} selesai</p>
            </div>
            <span class="dashboard-stat-icon"><i class="bi bi-bag-check"></i></span>
        </article>
        <article class="dashboard-stat">
            <div>
                <div class="dashboard-stat-label">Total Pendapatan</div>
                <p class="dashboard-stat-value">Rp {{ number_format($stats['total_pendapatan'] ?? 0, 0, ',', '.') }}</p>
                <p class="dashboard-stat-note">Pembayaran terverifikasi</p>
            </div>
            <span class="dashboard-stat-icon"><i class="bi bi-wallet2"></i></span>
        </article>
        <article class="dashboard-stat">
            <div>
                <div class="dashboard-stat-label">Pelanggan &amp; Petugas</div>
                <p class="dashboard-stat-value">{{ number_format($stats['total_pelanggan'] ?? 0) }}</p>
                <p class="dashboard-stat-note">{{ number_format($stats['total_petugas'] ?? 0) }} petugas operasional</p>
            </div>
            <span class="dashboard-stat-icon"><i class="bi bi-people"></i></span>
        </article>
        <article class="dashboard-stat">
            <div>
                <div class="dashboard-stat-label">Inventaris Alat</div>
                <p class="dashboard-stat-value">{{ number_format($stats['total_alat'] ?? 0) }} Jenis</p>
                <p class="dashboard-stat-note">{{ number_format($stats['total_stok'] ?? 0) }} total unit siap sewa</p>
            </div>
            <span class="dashboard-stat-icon"><i class="bi bi-backpack"></i></span>
        </article>
    </section>

    {{-- WORKSPACE UTAMA: FILTER SAMPING + PRODUCT GRID ALAT CAMPING --}}
    <div class="shoplytic-workspace mb-4">
        {{-- Panel Filter Kiri --}}
        <aside class="shoplytic-filter-card {{ $hasFilter ? '' : 'd-none d-lg-block' }}">
            <div class="filter-card-title d-flex align-items-center justify-content-between">
                <span><i class="bi bi-sliders me-1"></i> Filter Peralatan</span>
                <div class="d-flex align-items-center gap-2">
                    @if($hasFilter)
                        <a href="{{ route('admin.dashboard') }}" class="filter-reset-link">Reset</a>
                    @endif
                    <button type="button" class="btn-close d-lg-none" data-close-shop-filter aria-label="Tutup Filter"></button>
                </div>
            </div>

            <form action="{{ route('admin.dashboard') }}" method="GET" id="dashboardFilterForm">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif

                {{-- Kategori Alat --}}
                <div class="filter-group-box">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#dashFilterKategori" aria-expanded="true">
                        <span>Kategori Alat</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                    <div class="collapse show mt-2" id="dashFilterKategori">
                        <select name="kategori" class="form-select form-select-sm border-0 bg-white rounded-3 fw-semibold" onchange="this.form.submit()">
                            <option value="">Semua Kategori ({{ $priceCounts['all'] ?? 0 }})</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ (string) request('kategori') === (string) $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }} ({{ $kat->alat_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Rentang Harga Sewa / Hari --}}
                <div class="filter-group-box mb-2">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#dashFilterHarga" aria-expanded="true">
                        <span>Harga Sewa / Hari</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                </div>

                <div class="collapse show" id="dashFilterHarga">
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

                    {{-- Custom Price Range Slider --}}
                    <div class="price-slider-wrap">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-extrabold">Batas Harga :</span>
                            <span class="price-bubble mb-0" id="dashPriceBubble">Rp {{ number_format($maxSliderVal, 0, ',', '.') }}</span>
                        </div>
                        <input
                            type="range"
                            class="shop-range-input"
                            min="0"
                            max="150000"
                            step="5000"
                            value="{{ $maxSliderVal }}"
                            oninput="document.getElementById('dashMaxPriceInput').value = this.value; document.getElementById('dashPriceBubble').textContent = 'Rp ' + Number(this.value).toLocaleString('id-ID');"
                        >
                        <div class="price-minmax-row">
                            <input type="number" name="min_price" value="{{ request('min_price', 0) }}" class="price-minmax-input" placeholder="Min Rp">
                            <span class="text-muted small">-</span>
                            <input type="number" name="max_price" id="dashMaxPriceInput" value="{{ request('max_price') }}" class="price-minmax-input" placeholder="Maks Rp">
                        </div>
                    </div>
                </div>

                {{-- Kondisi Alat --}}
                <div class="filter-group-box">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#dashFilterKondisi" aria-expanded="true">
                        <span>Kondisi Fisik</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                    <div class="collapse show mt-2" id="dashFilterKondisi">
                        <select name="kondisi" class="form-select form-select-sm border-0 bg-white rounded-3 fw-semibold">
                            <option value="">Semua Kondisi</option>
                            <option value="Baik" {{ request('kondisi') === 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ request('kondisi') === 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        </select>
                    </div>
                </div>

                {{-- Status Stok --}}
                <div class="filter-group-box mb-3">
                    <button type="button" class="filter-group-header" data-bs-toggle="collapse" data-bs-target="#dashFilterStok" aria-expanded="true">
                        <span>Ketersediaan Stok</span>
                        <i class="bi bi-chevron-down filter-chevron"></i>
                    </button>
                    <div class="collapse show mt-2" id="dashFilterStok">
                        <select name="stok_status" class="form-select form-select-sm border-0 bg-white rounded-3 fw-semibold">
                            <option value="">Semua Stok</option>
                            <option value="tersedia" {{ request('stok_status') === 'tersedia' ? 'selected' : '' }}>Tersedia (&gt; 0)</option>
                            <option value="menipis" {{ request('stok_status') === 'menipis' ? 'selected' : '' }}>Stok Menipis (&lt; 7)</option>
                            <option value="habis" {{ request('stok_status') === 'habis' ? 'selected' : '' }}>Stok Habis</option>
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
            {{-- Top Subbar --}}
            <div class="shoplytic-subbar">
                <div>
                    <div class="shoplytic-breadcrumb">
                        Katalog Alat &gt; <strong>{{ $selectedKategoriObj?->nama_kategori ?? 'Semua Kategori' }}</strong>
                    </div>
                    <div class="shoplytic-count">
                        Menampilkan <strong>{{ number_format($katalogAlat->count()) }}</strong> peralatan siap kelola
                    </div>
                </div>

                <div class="shoplytic-subbar-actions">
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="subbar-search-wrap">
                        <i class="bi bi-search subbar-search-icon"></i>
                        <input type="text" name="q" value="{{ request('q') }}" class="subbar-search-input" placeholder="Cari alat...">
                    </form>

                    <button type="button" class="btn-subbar-pill btn-filter-toggle {{ $hasFilter ? 'active' : '' }}" data-toggle-shop-filter data-has-active-filter="{{ $hasFilter ? '1' : '0' }}" aria-pressed="{{ $hasFilter ? 'true' : 'false' }}" title="Filter Peralatan">
                        <i class="bi bi-funnel"></i>
                        <span>Filter Peralatan</span>
                    </button>

                    <a href="{{ route('admin.alat.create') }}" class="btn-subbar-pill">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah Alat</span>
                    </a>

                    <a href="{{ route('admin.penyewaan.create') }}" class="btn-shoplytic-lime py-2 px-3">
                        <i class="bi bi-plus-lg"></i> Buat Transaksi Sewa
                    </a>
                </div>
            </div>

            {{-- 4-Column Product Grid --}}
            <div class="shoplytic-product-grid">
                @forelse($katalogAlat as $alat)
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
                            {{ $alat->deskripsi ?: 'Perlengkapan camping kategori ' . ($alat->kategori?->nama_kategori ?? 'Outdoor') . ' dengan kondisi ' . strtolower($alat->kondisi) . '.' }}
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
                        <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                        Tidak ada peralatan yang sesuai dengan filter pencarian.
                        <div class="mt-3">
                            <a href="{{ route('admin.dashboard') }}" class="btn-subbar-pill">Reset Filter</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
    </div>

    {{-- BARIS BAWAH: TRANSAKSI TERBARU & PERINGATAN STOK --}}
    <div class="dashboard-content-grid">
        <div class="dashboard-stack">
            <section class="panel-card">
                <div class="panel-head">
                    <div>
                        <h2 class="dashboard-section-title">Penyewaan Terbaru</h2>
                        <p class="dashboard-section-caption">6 transaksi penyewaan terakhir yang tercatat di sistem.</p>
                    </div>
                    <a href="{{ route('admin.penyewaan.index') }}" class="btn-subbar-pill">Lihat Semua</a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Pelanggan</th>
                                <th>Tanggal Sewa</th>
                                <th>Status</th>
                                <th class="text-end">Total Biaya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $transaksi)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.penyewaan.show', $transaksi->id_sewa) }}" class="dashboard-item text-decoration-none text-reset">
                                            <span class="dashboard-item-icon"><i class="bi bi-person"></i></span>
                                            <span class="min-w-0">
                                                <span class="dashboard-item-name d-block">{{ $transaksi->pelanggan?->nama ?? 'Pelanggan' }}</span>
                                                <span class="dashboard-item-meta d-block">Order {{ $transaksi->id_sewa }}</span>
                                            </span>
                                        </a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($transaksi->tgl_sewa)->translatedFormat('d M Y') }}</td>
                                    <td>
                                        <span class="badge rounded-pill {{ $transaksi->status === 'Berjalan' ? 'bg-warning text-dark' : ($transaksi->status === 'Selesai' ? 'bg-success' : 'bg-secondary') }}">
                                            {{ $transaksi->status }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-bold">Rp {{ number_format($transaksi->total_biaya ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-4 text-center text-muted">Belum ada transaksi penyewaan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="dashboard-stack">
            <section class="panel-card">
                <div class="panel-head">
                    <div>
                        <h2 class="dashboard-section-title">Stok Perlu Diperiksa</h2>
                        <p class="dashboard-section-caption">Peralatan dengan sisa stok kurang dari 7 unit.</p>
                    </div>
                    <a href="{{ route('admin.alat.create') }}" class="btn-subbar-pill">+ Tambah</a>
                </div>
                <div class="dashboard-quick-links">
                    @forelse($stokMenipis->take(5) as $alat)
                        <a href="{{ route('admin.alat.edit', $alat->id_alat) }}" class="dashboard-quick-link">
                            <img src="{{ $alat->gambar_url }}" alt="" class="dashboard-item-image" onerror="this.onerror=null;this.src='{{ asset('images/default-camp.svg') }}';">
                            <span class="min-w-0 flex-grow-1">
                                <span class="dashboard-item-name d-block">{{ $alat->nama_alat }}</span>
                                <span class="dashboard-item-meta d-block">{{ $alat->kategori?->nama_kategori ?? 'Perlengkapan' }}</span>
                            </span>
                            <span class="badge rounded-pill {{ $alat->stok < 3 ? 'bg-danger' : 'bg-warning text-dark' }}">{{ $alat->stok }} unit</span>
                        </a>
                    @empty
                        <div class="text-muted small py-2"><i class="bi bi-check-circle me-1 text-success"></i> Semua stok alat mencukupi.</div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
@endsection
