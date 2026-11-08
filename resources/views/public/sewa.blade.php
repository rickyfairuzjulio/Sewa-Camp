@extends('layouts.public')

@section('title', 'Formulir Penyewaan - CampSewa Adventure')

@section('styles')
<style>
    .foresta-checkout-card {
        border: 1px solid #e4e6e8;
        border-radius: 18px;
        background: #ffffff;
        padding: 28px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.04);
    }

    .rental-item-row {
        padding: 14px;
        border-radius: 14px;
        background: #f6f8f8;
        border: 1px solid #e4e6e8;
    }

    .foresta-summary-sticky {
        position: sticky;
        top: 96px;
        border: 1px solid #e4e6e8;
        border-radius: 18px;
        background: #ffffff;
        padding: 24px;
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.05);
    }

    .pay-scheme-option {
        position: relative;
        display: block;
        cursor: pointer;
    }

    .pay-scheme-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .pay-scheme-card {
        padding: 16px;
        border: 2px solid #e4e6e8;
        border-radius: 14px;
        background: #ffffff;
        transition: all 0.2s ease;
        height: 100%;
    }

    .pay-scheme-option input:checked + .pay-scheme-card {
        border-color: #101010;
        background: var(--foresta-lime-soft);
        box-shadow: 0 8px 20px rgba(112, 244, 109, 0.18);
    }
</style>
@endsection

@section('content')
<div class="container pt-4 pb-5">
    <div class="foresta-page-banner mb-4">
        <span class="foresta-banner-tag">Checkout Sewa</span>
        <h1 class="fw-black mb-2" style="font-size: clamp(1.85rem, 3.5vw, 2.6rem); font-weight: 900;">Formulir penyewaan</h1>
        <p class="mb-0 text-white-50 fw-semibold">Lengkapi data identitas, pilih peralatan, dan tentukan opsi Bayar DP 50% atau Bayar Penuh</p>
    </div>

    @if($alatList->isEmpty())
        <div class="foresta-checkout-card text-center py-5">
            <i class="bi bi-backpack fs-1 text-secondary"></i>
            <h2 class="h4 fw-extrabold mt-3">Belum ada peralatan yang tersedia</h2>
            <p class="text-secondary">Silakan periksa katalog kembali atau hubungi kami untuk informasi stok.</p>
            <a href="{{ route('public.kontak') }}" class="btn-foresta-dark">Hubungi Kami</a>
        </div>
    @else
        @php
            $formItems = old('items', [[]]);
            $defaultStart = old('tgl_sewa', $prefillTglSewa ?? now()->toDateString());
            $defaultEnd = old('tgl_kembali_rencana', $prefillTglKembali ?? now()->addDay()->toDateString());
        @endphp
        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <form id="rental-checkout-form" action="{{ route('public.sewa.simpan') }}" method="POST" class="foresta-checkout-card">
                    @csrf
                    <div class="d-flex flex-wrap justify-content-between align-items-center pb-3 mb-4 border-bottom">
                        <div>
                            <h2 class="h5 fw-extrabold mb-1">1. Identitas &amp; Jadwal Penyewa</h2>
                            <p class="small text-secondary mb-0">Pastikan nomor identitas (KTP/SIM/KTM) dan nomor WhatsApp aktif.</p>
                        </div>
                        @auth
                            <span class="badge rounded-pill text-dark px-3 py-2 fw-extrabold" style="background: var(--foresta-lime);">
                                <i class="bi bi-person-check-fill me-1"></i> Terhubung Akun Member
                            </span>
                        @endauth
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="rental-name" class="form-label fw-extrabold small">Nama lengkap</label>
                            <input id="rental-name" class="form-control @error('nama') is-invalid @enderror" type="text" name="nama" value="{{ old('nama', $pelanggan?->nama ?? auth()->user()?->name) }}" maxlength="100" autocomplete="name" placeholder="Nama sesuai KTP/KTM/SIM" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rental-phone" class="form-label fw-extrabold small">Nomor HP / WhatsApp</label>
                            <input id="rental-phone" class="form-control @error('no_hp') is-invalid @enderror" type="tel" name="no_hp" value="{{ old('no_hp', $pelanggan?->no_hp ?? auth()->user()?->no_hp) }}" maxlength="15" autocomplete="tel" placeholder="0812xxxxxxxx" required>
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rental-identity" class="form-label fw-extrabold small">Nomor identitas (KTP/KTM/SIM)</label>
                            <input id="rental-identity" class="form-control @error('no_identitas') is-invalid @enderror" type="text" name="no_identitas" value="{{ old('no_identitas', $pelanggan?->no_identitas) }}" maxlength="20" placeholder="Nomor KTP / KTM / SIM" required>
                            @error('no_identitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rental-address" class="form-label fw-extrabold small">Alamat domisili <span class="text-secondary fw-normal">(opsional)</span></label>
                            <input id="rental-address" class="form-control @error('alamat') is-invalid @enderror" type="text" name="alamat" value="{{ old('alamat', $pelanggan?->alamat) }}" maxlength="200" autocomplete="street-address" placeholder="Alamat lengkap di Semarang / sekitarnya">
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rental-start" class="form-label fw-extrabold small">Tanggal ambil (mulai sewa)</label>
                            <input id="rental-start" class="form-control fw-bold @error('tgl_sewa') is-invalid @enderror" type="date" name="tgl_sewa" value="{{ $defaultStart }}" min="{{ now()->toDateString() }}" required>
                            @error('tgl_sewa')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rental-end" class="form-label fw-extrabold small">Tanggal rencana pengembalian</label>
                            <input id="rental-end" class="form-control fw-bold @error('tgl_kembali_rencana') is-invalid @enderror" type="date" name="tgl_kembali_rencana" value="{{ $defaultEnd }}" min="{{ now()->addDay()->toDateString() }}" required>
                            @error('tgl_kembali_rencana')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                        <div>
                            <h2 class="h5 fw-extrabold mb-1">2. Daftar Peralatan yang Disewa</h2>
                            <p class="small text-secondary mb-0">Pilih satu atau beberapa peralatan sekaligus dalam satu pesanan.</p>
                        </div>
                        <button type="button" id="add-rental-item" class="btn-foresta-dark py-2 px-3 small">
                            <i class="bi bi-plus-lg"></i> Tambah Alat
                        </button>
                    </div>

                    <div id="rental-items" class="d-flex flex-column gap-3">
                        @foreach($formItems as $index => $formItem)
                            <div class="row g-2 align-items-end rental-item-row">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold" for="rental-item-{{ $index }}">Pilih peralatan</label>
                                    <select id="rental-item-{{ $index }}" class="form-select fw-semibold" name="items[{{ $index }}][id_alat]" required>
                                        <option value="">-- Pilih peralatan outdoor --</option>
                                        @foreach($alatList as $alat)
                                            <option value="{{ $alat->id_alat }}"
                                                    data-stock="{{ $alat->stok }}"
                                                    data-price="{{ $alat->harga_sewa_per_hari }}"
                                                    data-name="{{ $alat->nama_alat }}"
                                                    {{ (string) old('items.' . $index . '.id_alat', $selectedAlat?->id_alat) === (string) $alat->id_alat ? 'selected' : '' }}>
                                                {{ $alat->nama_alat }} — Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}/hari (Stok: {{ $alat->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8 col-md-3">
                                    <label class="form-label small fw-bold" for="rental-quantity-{{ $index }}">Jumlah unit</label>
                                    <input id="rental-quantity-{{ $index }}" class="form-control fw-bold" type="number" name="items[{{ $index }}][jumlah]" value="{{ old('items.' . $index . '.jumlah', 1) }}" min="1" max="{{ $alatList->max('stok') }}" required>
                                </div>
                                <div class="col-4 col-md-1">
                                    <button type="button" class="btn btn-outline-danger w-100 remove-rental-item" aria-label="Hapus perlengkapan" {{ count($formItems) === 1 ? 'disabled' : '' }}>
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('items')<div class="text-danger small mt-2">{{ $message }}</div>@enderror

                    <hr class="my-4">
                    <div class="mb-4">
                        <h2 class="h5 fw-extrabold mb-1">3. Pilih Opsi Pembayaran (DP atau Bayar Penuh)</h2>
                        <p class="small text-secondary mb-3">Pilih apakah Anda ingin membayar uang muka (DP 50%) terlebih dahulu atau langsung melunasi 100%.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="pay-scheme-option">
                                    <input type="radio" name="skema_bayar" value="dp" {{ old('skema_bayar') === 'dp' ? 'checked' : '' }}>
                                    <div class="pay-scheme-card">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-extrabold">Bayar DP (50%)</span>
                                            <span class="badge rounded-pill bg-dark text-white">Booking Cepat</span>
                                        </div>
                                        <p class="small text-secondary mb-2">Bayar 50% sekarang via Midtrans, sisa 50% dilunasi saat ambil barang di store.</p>
                                        <div class="fw-black fs-5" id="scheme-dp-amount" style="font-weight: 900;">Rp 0</div>
                                    </div>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="pay-scheme-option">
                                    <input type="radio" name="skema_bayar" value="penuh" {{ old('skema_bayar', 'penuh') !== 'dp' ? 'checked' : '' }}>
                                    <div class="pay-scheme-card">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-extrabold">Bayar Penuh (100%)</span>
                                            <span class="badge rounded-pill text-dark fw-extrabold" style="background: var(--foresta-lime);">Langsung Lunas</span>
                                        </div>
                                        <p class="small text-secondary mb-2">Lunasi 100% tagihan sekarang via Midtrans tanpa sisa tagihan saat pengambilan.</p>
                                        <div class="fw-black fs-5" id="scheme-full-amount" style="font-weight: 900;">Rp 0</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-foresta-lime w-100 py-3 fs-6 justify-content-center">
                        <i class="bi bi-check2-circle fs-5"></i> Kirim Pengajuan Sewa &amp; Lanjut Pembayaran
                    </button>
                </form>
            </div>

            <div class="col-lg-4">
                <aside class="foresta-summary-sticky">
                    <h3 class="h6 fw-extrabold text-uppercase mb-3">Ringkasan Pesanan</h3>
                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-secondary fw-semibold">Durasi Sewa</span>
                        <strong id="summary-duration">1 Hari</strong>
                    </div>
                    <div class="d-flex justify-content-between small mb-3">
                        <span class="text-secondary fw-semibold">Jumlah Jenis Alat</span>
                        <strong id="summary-items-count">1 Alat</strong>
                    </div>
                    <hr>
                    <div id="summary-item-list" class="d-flex flex-column gap-2 small mb-3">
                        <div class="text-secondary">Pilih peralatan untuk melihat rincian biaya.</div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-secondary small">Total Biaya Sewa</span>
                        <strong id="summary-total" class="fs-5 fw-extrabold">Rp 0</strong>
                    </div>
                    <div class="p-3 rounded-4 mb-3" style="background: var(--foresta-lime); color: #101010;">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small fw-extrabold" id="summary-pay-now-label">Bayar Sekarang (Penuh 100%)</span>
                            <strong id="summary-pay-now" class="fs-4 fw-black" style="font-weight: 900;">Rp 0</strong>
                        </div>
                        <div class="small fw-semibold mt-1" id="summary-remaining-note">Sisa tagihan: Rp 0 (Lunas)</div>
                    </div>
                    <div class="p-3 rounded-4 border small text-secondary" style="background: #f2f4f4;">
                        <div class="fw-extrabold text-dark mb-1"><i class="bi bi-shield-check me-1"></i> Midtrans Payment Gateway</div>
                        <div>Mendukung pembayaran <strong>DP 50%</strong> maupun <strong>Bayar Penuh 100%</strong> via <strong>QRIS</strong> dan <strong>DANA</strong>.</div>
                    </div>
                </aside>
            </div>
        </div>

        <template id="rental-item-template">
            <div class="row g-2 align-items-end rental-item-row">
                <div class="col-md-8">
                    <label class="form-label small fw-bold">Pilih peralatan</label>
                    <select class="form-select fw-semibold" data-field="id_alat" required>
                        <option value="">-- Pilih peralatan outdoor --</option>
                        @foreach($alatList as $alat)
                            <option value="{{ $alat->id_alat }}"
                                    data-stock="{{ $alat->stok }}"
                                    data-price="{{ $alat->harga_sewa_per_hari }}"
                                    data-name="{{ $alat->nama_alat }}">
                                {{ $alat->nama_alat }} — Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}/hari (Stok: {{ $alat->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-8 col-md-3">
                    <label class="form-label small fw-bold">Jumlah unit</label>
                    <input class="form-control fw-bold" type="number" data-field="jumlah" value="1" min="1" required>
                </div>
                <div class="col-4 col-md-1">
                    <button type="button" class="btn btn-outline-danger w-100 remove-rental-item" aria-label="Hapus perlengkapan">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </template>
    @endif
</div>
@endsection

@section('scripts')
<script>
    (function () {
        const rentalStartDate = document.getElementById('rental-start');
        const rentalEndDate = document.getElementById('rental-end');
        const rentalItems = document.getElementById('rental-items');
        const rentalItemTemplate = document.getElementById('rental-item-template');
        const addRentalItemButton = document.getElementById('add-rental-item');

        const summaryDuration = document.getElementById('summary-duration');
        const summaryItemsCount = document.getElementById('summary-items-count');
        const summaryItemList = document.getElementById('summary-item-list');
        const summaryTotal = document.getElementById('summary-total');
        const summaryPayNowLabel = document.getElementById('summary-pay-now-label');
        const summaryPayNow = document.getElementById('summary-pay-now');
        const summaryRemainingNote = document.getElementById('summary-remaining-note');
        const schemeDpAmount = document.getElementById('scheme-dp-amount');
        const schemeFullAmount = document.getElementById('scheme-full-amount');

        let nextRentalItemIndex = {{ count($formItems ?? []) }};

        function calculateDurationDays() {
            if (!rentalStartDate?.value || !rentalEndDate?.value) {
                return 1;
            }
            const start = new Date(`${rentalStartDate.value}T00:00:00`);
            const end = new Date(`${rentalEndDate.value}T00:00:00`);
            const diff = Math.round((end - start) / (1000 * 60 * 60 * 24));
            return Math.max(1, diff);
        }

        function updateSummary() {
            if (!rentalItems || !summaryTotal) {
                return;
            }
            const days = calculateDurationDays();
            summaryDuration.textContent = `${days} Hari`;

            const rows = rentalItems.querySelectorAll('.rental-item-row');
            let grandTotal = 0;
            let selectedCount = 0;
            const lines = [];

            rows.forEach((row) => {
                const select = row.querySelector('select');
                const qtyInput = row.querySelector('input[type="number"]');
                const opt = select?.selectedOptions[0];
                const price = Number(opt?.dataset.price || 0);
                const name = opt?.dataset.name || '';
                const qty = Math.max(1, Number(qtyInput?.value || 1));

                if (price > 0 && name) {
                    selectedCount += 1;
                    const sub = price * qty * days;
                    grandTotal += sub;
                    lines.push(`
                        <div class="d-flex justify-content-between gap-2">
                            <span>${name} <span class="text-secondary">(${qty}x · ${days} hr)</span></span>
                            <strong class="text-nowrap">Rp ${sub.toLocaleString('id-ID')}</strong>
                        </div>
                    `);
                }
            });

            const dpAmount = Math.ceil(grandTotal * 0.5);
            const selectedScheme = document.querySelector('input[name="skema_bayar"]:checked')?.value || 'penuh';

            summaryItemsCount.textContent = `${selectedCount} Alat`;
            summaryItemList.innerHTML = lines.length
                ? lines.join('')
                : '<div class="text-secondary">Pilih peralatan untuk melihat rincian biaya.</div>';
            summaryTotal.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');

            if (schemeDpAmount) schemeDpAmount.textContent = 'Rp ' + dpAmount.toLocaleString('id-ID');
            if (schemeFullAmount) schemeFullAmount.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');

            if (selectedScheme === 'dp') {
                if (summaryPayNowLabel) summaryPayNowLabel.textContent = 'Bayar Sekarang (DP 50%)';
                if (summaryPayNow) summaryPayNow.textContent = 'Rp ' + dpAmount.toLocaleString('id-ID');
                if (summaryRemainingNote) summaryRemainingNote.textContent = 'Sisa pelunasan di store: Rp ' + Math.max(0, grandTotal - dpAmount).toLocaleString('id-ID');
            } else {
                if (summaryPayNowLabel) summaryPayNowLabel.textContent = 'Bayar Sekarang (Penuh 100%)';
                if (summaryPayNow) summaryPayNow.textContent = 'Rp ' + grandTotal.toLocaleString('id-ID');
                if (summaryRemainingNote) summaryRemainingNote.textContent = 'Sisa tagihan: Rp 0 (Langsung Lunas)';
            }

            const removeButtons = rentalItems.querySelectorAll('.remove-rental-item');
            removeButtons.forEach((btn) => {
                btn.disabled = rows.length === 1;
            });
        }

        document.querySelectorAll('input[name="skema_bayar"]').forEach((radio) => {
            radio.addEventListener('change', updateSummary);
        });

        function createRowWithValues(alatId, qty, index) {
            const row = rentalItemTemplate.content.firstElementChild.cloneNode(true);
            row.querySelectorAll('[data-field]').forEach((field) => {
                field.name = `items[${index}][${field.dataset.field}]`;
            });
            const sel = row.querySelector('select');
            const inp = row.querySelector('input[type="number"]');
            if (sel) sel.value = String(alatId);
            if (inp) inp.value = String(qty || 1);
            return row;
        }

        const hasSelectedAlat = @json((bool) $selectedAlat);
        const hasOldItems = @json(old('items') !== null);
        if (!hasSelectedAlat && !hasOldItems && window.CampSewaCart && rentalItems && rentalItemTemplate) {
            const cartItems = window.CampSewaCart.getCart();
            if (cartItems.length > 0) {
                rentalItems.innerHTML = '';
                nextRentalItemIndex = 0;
                cartItems.forEach((ci) => {
                    const newRow = createRowWithValues(ci.id, ci.qty, nextRentalItemIndex);
                    rentalItems.appendChild(newRow);
                    nextRentalItemIndex += 1;
                });
            }
        }

        if (rentalStartDate && rentalEndDate) {
            rentalStartDate.addEventListener('change', () => {
                const startDate = new Date(`${rentalStartDate.value}T00:00:00`);
                startDate.setDate(startDate.getDate() + 1);
                const minimumEndDate = [
                    startDate.getFullYear(),
                    String(startDate.getMonth() + 1).padStart(2, '0'),
                    String(startDate.getDate()).padStart(2, '0'),
                ].join('-');

                rentalEndDate.min = minimumEndDate;
                if (rentalEndDate.value && rentalEndDate.value < minimumEndDate) {
                    rentalEndDate.value = minimumEndDate;
                }
                updateSummary();
            });

            rentalEndDate.addEventListener('change', updateSummary);
        }

        if (rentalItems && rentalItemTemplate && addRentalItemButton) {
            addRentalItemButton.addEventListener('click', () => {
                const rentalItem = rentalItemTemplate.content.firstElementChild.cloneNode(true);
                rentalItem.querySelectorAll('[data-field]').forEach((field) => {
                    field.name = `items[${nextRentalItemIndex}][${field.dataset.field}]`;
                });
                nextRentalItemIndex += 1;
                rentalItems.appendChild(rentalItem);
                updateSummary();
            });

            rentalItems.addEventListener('click', (event) => {
                const removeButton = event.target.closest('.remove-rental-item');
                if (removeButton && rentalItems.querySelectorAll('.rental-item-row').length > 1) {
                    removeButton.closest('.rental-item-row').remove();
                    updateSummary();
                }
            });

            rentalItems.addEventListener('change', (event) => {
                if (event.target.matches('select[name$="[id_alat]"]')) {
                    const selectedOption = event.target.selectedOptions[0];
                    const quantityInput = event.target.closest('.rental-item-row').querySelector('input[name$="[jumlah]"]');
                    if (selectedOption?.dataset.stock) {
                        quantityInput.max = selectedOption.dataset.stock;
                        quantityInput.value = Math.min(Number(quantityInput.value), Number(selectedOption.dataset.stock));
                    }
                }
                updateSummary();
            });

            rentalItems.addEventListener('input', updateSummary);
            updateSummary();
        }
    })();
</script>
@endsection
