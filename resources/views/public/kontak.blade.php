@extends('layouts.public')

@section('title', 'Kontak CampSewa - CampSewa Adventure')

@section('content')
<div class="container pt-4 pb-5">
    {{-- Foresta Page Header Banner --}}
    <div class="foresta-page-banner mb-4">
        <span class="foresta-banner-tag">Hubungi Kami</span>
        <h1 class="fw-black mb-2" style="font-size: clamp(1.85rem, 3.5vw, 2.6rem); font-weight: 900;">Kontak CampSewa</h1>
        <p class="mb-0 text-white-50 fw-semibold">Layanan informasi stok, reservasi peralatan, dan lokasi pengambilan di Semarang</p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="p-4 rounded-4 border bg-white h-100">
                <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 48px; height: 48px; background: var(--foresta-lime); color: #101010;">
                    <i class="bi bi-geo-alt-fill fs-4"></i>
                </div>
                <h2 class="h5 fw-extrabold mb-2">Lokasi Store &amp; Basecamp</h2>
                <p class="text-secondary small mb-2">Jl. Prof. Hamka No. 12, Ngaliyan, Kota Semarang, Jawa Tengah</p>
                <span class="badge bg-light text-dark border">Dekat Kampus UIN Walisongo Semarang</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 rounded-4 border bg-white h-100">
                <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 48px; height: 48px; background: var(--foresta-lime); color: #101010;">
                    <i class="bi bi-whatsapp fs-4"></i>
                </div>
                <h2 class="h5 fw-extrabold mb-2">Telepon &amp; WhatsApp</h2>
                <p class="text-secondary small mb-2">Respon cepat untuk konsultasi perlengkapan gunung &amp; cek ketersediaan stok:</p>
                <a href="tel:081234567890" class="fs-5 fw-black text-dark text-decoration-none" style="font-weight: 900;">0812-3456-7890</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="p-4 rounded-4 border bg-white h-100">
                <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 48px; height: 48px; background: var(--foresta-lime); color: #101010;">
                    <i class="bi bi-clock-fill fs-4"></i>
                </div>
                <h2 class="h5 fw-extrabold mb-2">Jam Operasional</h2>
                <p class="text-secondary small mb-2">Pengambilan dan pengembalian peralatan dilayani setiap hari:</p>
                <strong class="d-block text-dark">Senin – Minggu: 08.00 – 21.00 WIB</strong>
            </div>
        </div>
    </div>

    <div class="p-4 p-lg-5 rounded-4 text-white" style="background: #101010;">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <span class="foresta-banner-tag mb-2">Siap Menjelajah, Tanpa Ribet</span>
                <h3 class="h3 fw-black mb-2" style="font-weight: 900;">Sewa Gear Outdoor Sekarang</h3>
                <p class="text-white-50 mb-0">
                    Pilih peralatan langsung dari katalog online, masukkan ke keranjang sewa, dan bayar praktis via Midtrans atau di lokasi store.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end d-flex flex-wrap justify-content-lg-end gap-2">
                <a href="{{ route('public.katalog') }}" class="btn-foresta-lime">
                    Lihat Peralatan <i class="bi bi-arrow-right"></i>
                </a>
                <a href="{{ route('public.sewa') }}" class="btn btn-outline-light rounded-pill fw-extrabold px-4 py-2">
                    Formulir Sewa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
