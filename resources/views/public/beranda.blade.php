@extends('layouts.public')

@section('title', 'CampSewa Adventure - Sewa Gear Outdoor Kini Lebih Mudah!')

@section('styles')
<style>
    /* =========================================================
       FORESTA HERO BANNER (block-banner-home1)
       ========================================================= */
    .foresta-hero {
        position: relative;
        min-height: 490px;
        padding: 96px 0 110px;
        display: flex;
        align-items: center;
        color: #ffffff;
        background:
            linear-gradient(95deg, rgba(10, 12, 11, 0.88) 0%, rgba(12, 16, 14, 0.72) 55%, rgba(12, 16, 14, 0.5) 100%),
            url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=2000&q=85') center 55% / cover no-repeat;
    }

    .hero-glass-panel {
        padding: 24px;
        border-radius: 22px;
        background: rgba(16, 16, 16, 0.76);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(14px);
        box-shadow: 0 24px 48px rgba(0, 0, 0, 0.35);
    }

    .step-badge-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 14px;
        background: var(--foresta-lime);
        color: #101010;
        font-size: 1.1rem;
        font-weight: 900;
    }

    .foresta-hero-subtitle {
        color: var(--foresta-lime);
        font-size: 1.25rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }

    .foresta-hero-title {
        font-size: clamp(2.35rem, 4.8vw, 3.8rem);
        font-weight: 900;
        line-height: 1.08;
        letter-spacing: -0.03em;
        margin-bottom: 20px;
        color: #ffffff;
    }

    .list-ticks-green {
        list-style: none;
        padding: 0;
        margin: 0 0 26px;
        display: flex;
        flex-wrap: wrap;
        gap: 12px 24px;
    }

    .list-ticks-green li {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.96rem;
        font-weight: 700;
        color: #ffffff;
    }

    .list-ticks-green li .tick-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 999px;
        background: var(--foresta-lime);
        color: #101010;
        font-size: 0.85rem;
    }

    /* =========================================================
       FORESTA ADVANCE SEARCH & SCHEDULE BOX (box-search-advance)
       ========================================================= */
    .box-search-advance {
        position: relative;
        z-index: 10;
        margin-top: -64px;
    }

    .box-search-shell {
        background: #ffffff;
        border: 1px solid #e4e6e8;
        border-radius: 20px;
        padding: 20px 22px;
        box-shadow: 0 22px 50px rgba(0, 0, 0, 0.12);
    }

    .search-grid-foresta {
        display: grid;
        grid-template-columns: 1fr 1.05fr 1.1fr 0.95fr 1.35fr auto;
        align-items: center;
        gap: 0;
    }

    .search-item-foresta {
        padding: 6px 16px;
        border-right: 1px solid #e8eaed;
        min-width: 0;
    }

    .search-item-foresta:last-of-type {
        border-right: 0;
    }

    .search-item-label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        margin-bottom: 4px;
        color: #6c7278;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .search-item-foresta .form-control,
    .search-item-foresta .form-select {
        border: 0;
        padding: 2px 20px 2px 0;
        background-color: transparent;
        font-size: 0.92rem;
        font-weight: 800;
        color: #101010;
        box-shadow: none;
    }

    .search-item-foresta .form-control::placeholder {
        color: #9aa0a6;
        font-weight: 600;
    }

    .btn-search-foresta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 54px;
        padding: 0 28px;
        border: 0;
        border-radius: 14px;
        background: var(--foresta-lime);
        color: #ffffff !important;
        font-size: 0.96rem;
        font-weight: 900;
        transition: all 0.2s ease;
    }

    .btn-search-foresta i {
        color: #ffffff !important;
    }

    .btn-search-foresta:hover {
        background: var(--foresta-lime-hover);
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(112, 244, 109, 0.35);
    }

    /* =========================================================
       PILIHAN BRAND & KATEGORI (background-100)
       ========================================================= */
    .section-brand-kategori {
        padding: 64px 0 56px;
        background: var(--foresta-gray-100);
        margin-top: -36px;
        padding-top: 96px;
    }

    .brand-pill-card {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 22px;
        border: 1px solid #e2e5e8;
        border-radius: 12px;
        background: #ffffff;
        color: #101010;
        font-size: 0.88rem;
        font-weight: 900;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .brand-pill-card:hover {
        border-color: #101010;
        background: #101010;
        color: var(--foresta-lime);
        transform: translateY(-2px);
    }

    .foresta-cat-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 20px;
        border: 1px solid #e2e5e8;
        border-radius: 16px;
        background: #ffffff;
        color: #101010;
        text-decoration: none;
        transition: all 0.22s ease;
        height: 100%;
    }

    .foresta-cat-card:hover {
        border-color: #101010;
        transform: translateY(-4px);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.07);
        color: #101010;
    }

    .foresta-cat-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: var(--foresta-gray-100);
        color: #101010;
        font-size: 1.35rem;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .foresta-cat-card:hover .foresta-cat-icon {
        background: var(--foresta-lime);
        color: #101010;
    }

    /* =========================================================
       TESTIMONI SECTION (card-testimonial Foresta style)
       ========================================================= */
    .section-testimonials {
        padding: 72px 0;
        background: var(--foresta-gray-100);
        border-top: 1px solid #e4e6e8;
    }

    .foresta-testimonial-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        padding: 28px;
        border: 1px solid #e4e6e8;
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.03);
    }

    .foresta-star-lime {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 5px;
        background: var(--foresta-lime);
        color: #101010;
        font-size: 0.72rem;
    }

    @media (max-width: 1199.98px) {
        .search-grid-foresta {
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }
        .search-item-foresta {
            border-right: 0;
            border-bottom: 1px solid #eef0f2;
            padding: 8px 10px;
        }
        .btn-search-foresta {
            grid-column: 1 / -1;
            width: 100%;
        }
    }

    @media (max-width: 767.98px) {
        .foresta-hero {
            padding: 78px 0 84px;
            min-height: 420px;
        }
        .foresta-hero-subtitle {
            font-size: 1.05rem;
        }
        .list-ticks-green {
            gap: 10px 16px;
            margin-bottom: 20px;
        }
        .list-ticks-green li {
            font-size: 0.86rem;
        }
        .box-search-advance {
            margin-top: -42px;
        }
        .box-search-shell {
            padding: 16px;
            border-radius: 16px;
        }
        .search-grid-foresta {
            grid-template-columns: 1fr;
        }
        .foresta-testimonial-card {
            padding: 20px;
        }
    }

    @media (max-width: 480px) {
        .foresta-hero .d-flex.flex-wrap.gap-3 > a {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
{{-- 1. CampSewa Split Hero Section --}}
<section class="foresta-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <h6 class="foresta-hero-subtitle">Eksplorasi Alam Tanpa Ribet.</h6>
                <h1 class="foresta-hero-title">
                    Sewa Gear Outdoor<br>Kini Lebih Mudah!
                </h1>
                <ul class="list-ticks-green">
                    <li>
                        <span class="tick-circle"><i class="bi bi-check-lg"></i></span>
                        Stok Real-Time ({{ number_format($stats['total_stok'], 0, ',', '.') }} Unit Siap Pakai)
                    </li>
                    <li>
                        <span class="tick-circle"><i class="bi bi-check-lg"></i></span>
                        Khusus Wilayah Semarang
                    </li>
                    <li>
                        <span class="tick-circle"><i class="bi bi-check-lg"></i></span>
                        Alat Bersih, Terawat &amp; Siap Mendaki
                    </li>
                </ul>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('public.katalog') }}" class="btn-foresta-lime px-4 py-3">
                        <i class="bi bi-grid-fill me-1"></i> Jelajahi Katalog Alat
                    </a>
                    <a href="{{ route('public.cara_sewa') }}" class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold">
                        <i class="bi bi-play-circle me-1"></i> Panduan Penyewaan
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 2. Foresta Advance Schedule + Search Box --}}
<div class="box-search-advance">
    <div class="container">
        <div class="box-search-shell">
            <form action="{{ route('public.katalog') }}" method="GET" class="search-grid-foresta" id="homeScheduleForm">
                <div class="search-item-foresta">
                    <label class="search-item-label" for="homeTglSewa">
                        <span>Tgl Ambil</span>
                        <i class="bi bi-calendar-event text-dark"></i>
                    </label>
                    <input type="date" class="form-control" id="homeTglSewa" name="tgl_sewa" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                </div>

                <div class="search-item-foresta">
                    <label class="search-item-label" for="homeDurasi">
                        <span>Durasi</span>
                        <span id="homeMaxReturnBadge" class="badge rounded-pill text-dark" style="background: var(--foresta-lime); font-size: 0.66rem;">Kembali: -</span>
                    </label>
                    <select class="form-select" id="homeDurasi" name="durasi">
                        @for($d = 1; $d <= 14; $d++)
                            <option value="{{ $d }}" {{ $d === 2 ? 'selected' : '' }}>{{ $d }} Hari</option>
                        @endfor
                    </select>
                </div>

                <div class="search-item-foresta">
                    <label class="search-item-label" for="homeKategori">
                        <span>Kategori</span>
                    </label>
                    <select class="form-select" id="homeKategori" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="search-item-foresta">
                    <label class="search-item-label" for="homeSort">
                        <span>Urutkan</span>
                    </label>
                    <select class="form-select" id="homeSort" name="sort">
                        <option value="terbaru">Terbaru</option>
                        <option value="termurah">Harga Termurah</option>
                        <option value="termahal">Harga Tertinggi</option>
                        <option value="nama_asc">Nama A–Z</option>
                    </select>
                </div>

                <div class="search-item-foresta">
                    <label class="search-item-label" for="homeQuery">
                        <span>Cari</span>
                    </label>
                    <input type="search" class="form-control" id="homeQuery" name="q" placeholder="Cari peralatan ...">
                </div>

                <div class="ps-xl-2">
                    <button type="submit" class="btn-search-foresta">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 3. Pilihan Brand & Kategori Section --}}
<section class="section-brand-kategori">
    <div class="container">
        <div class="row align-items-end mb-4">
            <div class="col-md-8">
                <h2 class="fw-black mb-1" style="font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 900;">Pilihan Brand &amp; Kategori</h2>
                <p class="text-secondary mb-0 fw-semibold">Dipilih dari merek terbaik untuk pengalaman terbaik di setiap pendakian.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('public.katalog') }}" class="text-dark fw-extrabold text-decoration-none">
                    Semua Peralatan <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        {{-- Outdoor Brands Strip (Foresta style) --}}
        <div class="d-flex flex-wrap gap-2 mb-4">
            @foreach(['EIGER', 'CONSINA', 'AREI OUTDOOR', 'NATUREHIKE', 'DEUTER', 'TENDAKI', 'KOVAR', 'QUECHUA'] as $brand)
                <a href="{{ route('public.katalog', ['q' => strtolower(explode(' ', $brand)[0])]) }}" class="brand-pill-card">
                    <i class="bi bi-patch-check-fill" style="color: #28a745;"></i> {{ $brand }}
                </a>
            @endforeach
        </div>

        {{-- Live Database Categories --}}
        @php
            $catIcons = [
                1 => 'bi bi-triangle-fill',
                2 => 'bi bi-backpack2-fill',
                3 => 'bi bi-moon-stars-fill',
                4 => 'bi bi-fire',
                5 => 'bi bi-lamp-fill',
            ];
        @endphp
        <div class="row g-3">
            @foreach($kategori as $kat)
                <div class="col-12 col-sm-6 col-lg-4 col-xl">
                    <a href="{{ route('public.katalog', ['kategori' => $kat->id_kategori]) }}" class="foresta-cat-card">
                        <div>
                            <div class="fw-extrabold fs-6">{{ $kat->nama_kategori }}</div>
                            <div class="text-secondary small fw-semibold">{{ $kat->alat_count }} peralatan tersedia</div>
                        </div>
                        <span class="foresta-cat-icon">
                            <i class="{{ $catIcons[$kat->id_kategori] ?? 'bi bi-compass-fill' }}"></i>
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 4. Pilihan Terbaik Minggu Ini! (Foresta Product Grid) --}}
<section class="py-5 my-2">
    <div class="container">
        <div class="row align-items-end mb-4 pb-2">
            <div class="col-md-8">
                <h2 class="mb-1" style="font-size: clamp(1.75rem, 3.2vw, 2.4rem); font-weight: 900;">Pilihan Terbaik Minggu Ini!</h2>
                <p class="text-secondary mb-0 fw-semibold">Gear Pilihan Pendaki, Siap Temani Petualanganmu.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('public.katalog') }}" class="btn-foresta-dark">
                    Lihat Lainnya <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        @if($alatUnggulan->isEmpty())
            <div class="text-center py-5 border rounded-4 bg-light">
                <i class="bi bi-backpack fs-1 text-secondary"></i>
                <h3 class="h5 fw-bold mt-3">Belum ada peralatan tersedia</h3>
                <p class="text-secondary mb-3">Silakan cek kembali katalog atau hubungi kami.</p>
                <a href="{{ route('public.kontak') }}" class="btn-foresta-dark">Hubungi Kami</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($alatUnggulan as $alat)
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
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- 4B. Alur Penyewaan Praktis (Khas CampSewa) --}}
<section class="py-5" style="background: #101010; color: #ffffff;">
    <div class="container py-2">
        <div class="row align-items-center mb-4">
            <div class="col-lg-7">
                <span class="badge rounded-pill px-3 py-2 fw-extrabold mb-2" style="background: var(--foresta-lime); color: #101010;">
                    ALUR PENYEWAAN CEPAT
                </span>
                <h2 class="fw-black mb-1 text-white" style="font-weight: 900;">3 Langkah Mudah Sewa di CampSewa</h2>
                <p class="text-white-50 mb-0">Tanpa antre lama di lokasi — pesan online, bayar DP atau lunas, lalu ambil alat di store.</p>
            </div>
            <div class="col-lg-5 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('public.cara_sewa') }}" class="btn-foresta-lime">
                    Lihat Syarat &amp; Ketentuan <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div class="step-badge-num mb-3">01</div>
                    <h5 class="fw-extrabold text-white">Pilih Alat &amp; Tanggal</h5>
                    <p class="small text-white-50 mb-0">Masukkan perlengkapan camping ke keranjang sewa dan tentukan tanggal ambil serta durasi sewa.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div class="step-badge-num mb-3">02</div>
                    <h5 class="fw-extrabold text-white">Bayar DP 50% / Penuh</h5>
                    <p class="small text-white-50 mb-0">Pilih opsi pembayaran uang muka (DP 50%) atau langsung lunas 100% menggunakan QRIS maupun DANA.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255, 255, 255, 0.12);">
                    <div class="step-badge-num mb-3">03</div>
                    <h5 class="fw-extrabold text-white">Ambil Gear &amp; Pantau Status</h5>
                    <p class="small text-white-50 mb-0">Ambil peralatan di Basecamp Ngaliyan dan pantau status peminjaman hingga pengembalian langsung dari menu Transaksi.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 5. Testimonials Section (Apa kata mereka?) --}}
<section class="section-testimonials">
    <div class="container">
        <div class="mb-4 pb-2">
            <span class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white border fw-extrabold small mb-2">
                <span class="rounded-circle d-inline-block" style="width: 8px; height: 8px; background: var(--foresta-lime);"></span>
                Testimoni
            </span>
            <h2 class="mb-0" style="font-size: clamp(1.75rem, 3.2vw, 2.35rem); font-weight: 900;">Apa kata mereka?</h2>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="foresta-testimonial-card">
                    <h5 class="fw-extrabold mb-2">Tempat Sewa Alat Outdoor Terbaik</h5>
                    <p class="text-secondary small mb-4 flex-grow-1">
                        "Menyewa tenda dome dan carrier di sini benar-benar memuaskan! Barangnya bersih, wangi, dan kualitasnya sangat terawat. Cocok banget buat pendakian Gunung Prau &amp; Merbabu."
                    </p>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                        <div>
                            <div class="fw-extrabold small">Dimas Anjay Mabar</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">Ngaliyan, Semarang</div>
                        </div>
                        <div class="d-flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <span class="foresta-star-lime"><i class="bi bi-star-fill"></i></span>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="foresta-testimonial-card">
                    <h5 class="fw-extrabold mb-2">Pelayanan Ramah dan Cepat</h5>
                    <p class="text-secondary small mb-4 flex-grow-1">
                        "Pelayanannya juara! Booking lewat website langsung keluar rincian biaya dan bisa bayar pakai QRIS Midtrans. Pas ambil di store Ngaliyan barang sudah disiapkan."
                    </p>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                        <div>
                            <div class="fw-extrabold small">Anap</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">Jatisari, Semarang</div>
                        </div>
                        <div class="d-flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <span class="foresta-star-lime"><i class="bi bi-star-fill"></i></span>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="foresta-testimonial-card">
                    <h5 class="fw-extrabold mb-2">Harga Terjangkau, Kualitas Mantap</h5>
                    <p class="text-secondary small mb-4 flex-grow-1">
                        "Harga sewanya ramah di kantong mahasiswa UIN Walisongo, tapi kualitas sleeping bag, kompor, dan nesting yang disewakan benar-benar standar ekspedisi!"
                    </p>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                        <div>
                            <div class="fw-extrabold small">Fajar Sadboy</div>
                            <div class="text-secondary" style="font-size: 0.75rem;">Mijen, Semarang</div>
                        </div>
                        <div class="d-flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <span class="foresta-star-lime"><i class="bi bi-star-fill"></i></span>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    (function () {
        const tglInput = document.getElementById('homeTglSewa');
        const durasiSelect = document.getElementById('homeDurasi');
        const badgeEl = document.getElementById('homeMaxReturnBadge');

        function updateHomeSchedule() {
            if (!tglInput || !durasiSelect || !window.CampSewaCart) return;
            const retDate = window.CampSewaCart.computeReturnDate(tglInput.value, durasiSelect.value);
            if (badgeEl) badgeEl.textContent = 'Kembali: ' + retDate;
            window.CampSewaCart.saveSchedule(tglInput.value, durasiSelect.value);
        }

        if (tglInput && durasiSelect && window.CampSewaCart) {
            const saved = window.CampSewaCart.getSchedule();
            if (saved.tgl_sewa) tglInput.value = saved.tgl_sewa;
            if (saved.durasi) durasiSelect.value = saved.durasi;
            updateHomeSchedule();

            tglInput.addEventListener('change', updateHomeSchedule);
            durasiSelect.addEventListener('change', updateHomeSchedule);
        }
    })();
</script>
@endsection
