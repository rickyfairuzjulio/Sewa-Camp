@extends('layouts.public')

@section('title', 'Cara Sewa Perlengkapan - CampSewa Adventure')

@section('content')
<div class="container pt-4 pb-5">
    {{-- Foresta Page Header Banner --}}
    <div class="foresta-page-banner mb-4">
        <span class="foresta-banner-tag">Bantuan</span>
        <h1 class="fw-black mb-2" style="font-size: clamp(1.85rem, 3.5vw, 2.6rem); font-weight: 900;">Cara sewa perlengkapan</h1>
        <p class="mb-0 text-white-50 fw-semibold">Panduan Penyewaan Peralatan di CampSewa Adventure Semarang</p>
    </div>

    <div class="row g-4">
        {{-- Left Column (col-lg-8): Foresta 6-Step Guide + Syarat & Ketentuan --}}
        <div class="col-lg-8">
            <div class="p-4 p-md-5 rounded-4 border bg-white mb-4">
                <h2 class="h4 fw-black mb-3" style="font-weight: 900;">Panduan Penyewaan Peralatan di CampSewa</h2>
                <p class="text-secondary mb-4">
                    Selamat datang di layanan penyewaan perlengkapan outdoor CampSewa. Agar proses penyewaan berjalan lancar, aman, dan nyaman, silakan ikuti panduan berikut:
                </p>

                <div class="d-flex flex-column gap-4">
                    <div>
                        <h3 class="h6 fw-extrabold mb-1">1. Periksa Ketersediaan Peralatan</h3>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Pilih tanggal pengambilan dan durasi sewa melalui halaman <a href="{{ route('public.beranda') }}" class="fw-bold text-dark">Beranda</a> atau <a href="{{ route('public.katalog') }}" class="fw-bold text-dark">Daftar Peralatan</a> untuk memeriksa stok peralatan secara real-time.
                        </p>
                    </div>

                    <div>
                        <h3 class="h6 fw-extrabold mb-1">2. Pilih Barang &amp; Masukkan ke Keranjang / Formulir Sewa</h3>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Klik tombol <strong>+ Keranjang</strong> untuk mengumpulkan beberapa perlengkapan sekaligus, atau klik <strong>Sewa</strong> untuk langsung menuju halaman <a href="{{ route('public.sewa') }}" class="fw-bold text-dark">Formulir Penyewaan</a>.
                        </p>
                    </div>

                    <div>
                        <h3 class="h6 fw-extrabold mb-1">3. Lengkapi Identitas &amp; Lakukan Pembayaran (Midtrans / Kasir)</h3>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Isi data diri sesuai KTP/SIM/KTM aktif. Setelah nomor transaksi terbit, Anda dapat melunasi tagihan secara instan menggunakan <strong>Midtrans (QRIS, Virtual Account, GoPay, ShopeePay)</strong> maupun tunai di store.
                        </p>
                    </div>

                    <div>
                        <h3 class="h6 fw-extrabold mb-1">4. Pengambilan Peralatan di Lokasi Store</h3>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Datang ke <strong>CampSewa Store Ngaliyan Semarang</strong> sesuai jadwal pengambilan dengan membawa <strong>1 kartu identitas asli (KTP/SIM/KTM)</strong> sebagai jaminan selama masa sewa.
                        </p>
                    </div>

                    <div>
                        <h3 class="h6 fw-extrabold mb-1">5. Gunakan Peralatan dengan Tanggung Jawab</h3>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Jaga kebersihan dan keutuhan perlengkapan selama kegiatan berkemah atau mendaki. Hindari memasak di dalam tenda yang dapat merusak bahan waterproof.
                        </p>
                    </div>

                    <div>
                        <h3 class="h6 fw-extrabold mb-1">6. Pengembalian Peralatan</h3>
                        <p class="text-secondary small mb-0" style="line-height: 1.7;">
                            Kembalikan peralatan tepat waktu sesuai tanggal rencana kembali. Petugas akan memeriksa kelengkapan unit dan menyerahkan kembali kartu identitas Anda.
                        </p>
                    </div>
                </div>

                <hr class="my-4" id="syarat-ketentuan">

                <h3 class="h5 fw-black mb-3" style="font-weight: 900;">Syarat dan Ketentuan</h3>
                <ul class="small text-secondary d-flex flex-column gap-2 mb-0 ps-3">
                    <li>Wajib meninggalkan <strong>1 identitas asli aktif (KTP / SIM / KTM)</strong> yang sesuai dengan nama penyewa.</li>
                    <li>Tarif sewa dihitung per hari kalender sesuai tanggal mulai sewa dan tanggal rencana kembali.</li>
                    <li>Keterlambatan pengembalian dikenakan denda <strong>Rp 10.000 / hari</strong>.</li>
                    <li>Kerusakan atau kehilangan komponen alat menjadi tanggung jawab penyewa sesuai hasil pengecekan petugas.</li>
                </ul>
            </div>
        </div>

        {{-- Right Column (col-lg-4): Artikel Terkait & Akses Cepat Sidebar --}}
        <div class="col-lg-4">
            <div class="foresta-box-sidebar mb-4">
                <div class="foresta-box-sidebar-head">Artikel &amp; Halaman Terkait</div>
                <div class="foresta-box-sidebar-body d-flex flex-column gap-3">
                    <a href="{{ route('public.cara_sewa') }}#syarat-ketentuan" class="text-dark fw-extrabold text-decoration-none d-flex justify-content-between align-items-center">
                        <span>Syarat dan Ketentuan</span>
                        <i class="bi bi-chevron-right small text-secondary"></i>
                    </a>
                    <a href="{{ route('public.katalog') }}" class="text-dark fw-extrabold text-decoration-none d-flex justify-content-between align-items-center">
                        <span>Daftar Peralatan &amp; Harga</span>
                        <i class="bi bi-chevron-right small text-secondary"></i>
                    </a>
                    <a href="{{ route('public.sewa') }}" class="text-dark fw-extrabold text-decoration-none d-flex justify-content-between align-items-center">
                        <span>Formulir Penyewaan Online</span>
                        <i class="bi bi-chevron-right small text-secondary"></i>
                    </a>
                    <a href="{{ route('public.kontak') }}" class="text-dark fw-extrabold text-decoration-none d-flex justify-content-between align-items-center">
                        <span>Lokasi &amp; Kontak Store</span>
                        <i class="bi bi-chevron-right small text-secondary"></i>
                    </a>
                </div>
            </div>

            <div class="p-4 rounded-4 text-white" style="background: #101010;">
                <span class="foresta-banner-tag mb-2">Siap Mendaki?</span>
                <h4 class="h5 fw-extrabold mb-2">Booking Gear Sekarang</h4>
                <p class="small text-white-50 mb-3">Cek stok real-time dan amankan perlengkapan camping pilihanmu hari ini.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('public.katalog') }}" class="btn-foresta-lime justify-content-center">
                        Lihat Peralatan <i class="bi bi-arrow-right"></i>
                    </a>
                    @auth
                        @if(auth()->user()->isPelanggan())
                            <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-outline-light rounded-pill fw-bold small py-2">
                                Buka Dashboard Pelanggan
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
