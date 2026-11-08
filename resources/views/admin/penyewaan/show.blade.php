@extends('layouts.admin')

@section('title', 'Detail Penyewaan #' . $penyewaan->id_sewa)
@section('page_title', 'Detail Penyewaan #' . $penyewaan->id_sewa)
@section('page_subtitle', 'Rincian informasi penyewa, daftar peralatan yang disewa, serta riwayat pembayaran.')

@section('content')
    <div id="midtrans-admin-alert" class="alert d-none rounded-4 border-0 mb-3" role="alert"></div>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
        <a href="{{ route('admin.penyewaan.index') }}" class="btn-subbar-pill">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Transaksi
        </a>
        <div class="d-flex flex-wrap gap-2">
            @if($penyewaan->pelanggan?->whatsappUrl())
                @php
                    $waText = 'Halo Kak ' . $penyewaan->pelanggan->nama . ', ini dari Admin CampSewa terkait transaksi sewa #' . $penyewaan->id_sewa . ' (Tgl Kembali: ' . \Carbon\Carbon::parse($penyewaan->tgl_kembali_rencana)->translatedFormat('d M Y') . ', Sisa Tagihan: Rp ' . number_format($penyewaan->sisa_tagihan, 0, ',', '.') . ').';
                @endphp
                <a href="{{ $penyewaan->pelanggan->whatsappUrl($waText) }}" target="_blank" class="btn-subbar-pill text-success border-success-subtle">
                    <i class="bi bi-whatsapp"></i> Chat WhatsApp
                </a>
            @endif
            <a href="{{ route('admin.penyewaan.cetak', $penyewaan->id_sewa) }}" target="_blank" class="btn-subbar-pill">
                <i class="bi bi-printer"></i> Cetak Nota
            </a>
            @if($penyewaan->sisa_tagihan > 0 && $penyewaan->status !== 'Dibatalkan')
                <a href="{{ route('admin.pembayaran.create', ['id_sewa' => $penyewaan->id_sewa]) }}" class="btn-shoplytic-dark py-2 px-3">
                    <i class="bi bi-cash-coin"></i> Catat Pembayaran
                </a>
                <button
                    type="button"
                    id="admin-midtrans-btn"
                    class="btn-shoplytic-lime py-2 px-3"
                    data-url="{{ route('admin.pembayaran.midtrans.token', $penyewaan->id_sewa) }}"
                >
                    <i class="bi bi-credit-card"></i> Bayar via Midtrans
                </button>
            @endif
            @if($penyewaan->status === 'Berjalan')
                <a href="{{ route('admin.pengembalian.proses', $penyewaan->id_sewa) }}" class="btn btn-warning rounded-pill fw-bold btn-sm px-3 d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-return-left"></i> Proses Pengembalian
                </a>
                @if($penyewaan->pembayaran->isEmpty())
                    <form action="{{ route('admin.penyewaan.batal', $penyewaan->id_sewa) }}" method="POST" onsubmit="return confirm('Batalkan transaksi penyewaan {{ $penyewaan->id_sewa }} dan kembalikan stok alat?')">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger rounded-pill fw-bold btn-sm px-3">
                            <i class="bi bi-x-circle me-1"></i> Batalkan
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-4">
            <div class="card-panel mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Informasi Transaksi</span>
                    <span class="badge rounded-pill {{ $penyewaan->status === 'Berjalan' ? 'bg-warning text-dark' : ($penyewaan->status === 'Selesai' ? 'bg-success' : 'bg-danger') }} px-3 py-2">
                        {{ $penyewaan->status }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                            <span class="text-secondary small fw-semibold">ID Transaksi</span>
                            <span class="fw-extrabold">{{ $penyewaan->id_sewa }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-start pb-2 border-bottom">
                            <span class="text-secondary small fw-semibold">Pelanggan</span>
                            <div class="text-end">
                                <div class="fw-bold">{{ $penyewaan->pelanggan?->nama ?? '-' }}</div>
                                <div class="small text-secondary">{{ $penyewaan->pelanggan?->no_hp ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                            <span class="text-secondary small fw-semibold">Petugas Melayani</span>
                            <span class="fw-semibold">{{ $penyewaan->petugas?->nama_petugas ?? '-' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                            <span class="text-secondary small fw-semibold">Tanggal Sewa</span>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($penyewaan->tgl_sewa)->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                            <span class="text-secondary small fw-semibold">Rencana Kembali</span>
                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($penyewaan->tgl_kembali_rencana)->translatedFormat('d M Y') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary small fw-semibold">Kembali Aktual</span>
                            <span class="fw-semibold">{{ $penyewaan->tgl_kembali_aktual ? \Carbon\Carbon::parse($penyewaan->tgl_kembali_aktual)->translatedFormat('d M Y') : '-' }}</span>
                        </div>
                    </div>

                    <div class="p-3 rounded-4 mt-4" style="background: #f5f7f5; border: 1px solid #e3e7e3;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-secondary fw-semibold">Total Biaya Sewa</span>
                            <span class="fw-extrabold">Rp {{ number_format($penyewaan->total_biaya ?? 0, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small text-secondary fw-semibold">Total Dibayar</span>
                            <span class="fw-bold text-success">Rp {{ number_format($penyewaan->total_dibayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top mb-2">
                            <span class="small fw-extrabold">Sisa Tagihan</span>
                            <span class="fs-6 fw-extrabold {{ $penyewaan->sisa_tagihan > 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($penyewaan->sisa_tagihan, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="small text-secondary fw-semibold">Status Pembayaran</span>
                            <span class="badge rounded-pill {{ $penyewaan->status_pembayaran === 'Lunas' ? 'bg-success' : ($penyewaan->status_pembayaran === 'Sebagian' ? 'bg-info text-dark' : 'bg-secondary') }} px-3 py-1">
                                {{ $penyewaan->status_pembayaran }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card-panel mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Detail Peralatan Disewa</span>
                    <span class="badge rounded-pill bg-dark text-white px-3 py-1">Durasi {{ $penyewaan->durasi_hari }} Hari</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Alat</th>
                                    <th>Jumlah</th>
                                    <th>Harga / Hari</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penyewaan->details as $detail)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $detail->alat?->nama_alat ?? '-' }}</div>
                                            <div class="small text-muted">{{ $detail->alat?->kategori?->nama_kategori ?? '' }}</div>
                                        </td>
                                        <td><span class="badge bg-light text-dark border">{{ $detail->jumlah }} unit</span></td>
                                        <td>Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-end fw-extrabold">Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted py-4">Belum ada detail alat.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-panel">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Riwayat Pembayaran</span>
                    @if($penyewaan->sisa_tagihan > 0 && $penyewaan->status !== 'Dibatalkan')
                        <a href="{{ route('admin.pembayaran.create', ['id_sewa' => $penyewaan->id_sewa]) }}" class="btn btn-sm btn-camp">+ Catat Bayar</a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID Bayar</th>
                                    <th>Tanggal</th>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penyewaan->pembayaran as $bayar)
                                    <tr>
                                        <td class="fw-bold">{{ $bayar->id_bayar }}</td>
                                        <td>{{ \Carbon\Carbon::parse($bayar->tgl_bayar)->translatedFormat('d M Y') }}</td>
                                        <td><span class="badge rounded-pill bg-light text-dark border px-3 py-1">{{ $bayar->metode }}</span></td>
                                        <td class="fw-extrabold text-success">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td class="text-end">
                                            <div class="d-inline-flex gap-2">
                                                <a href="{{ route('admin.pembayaran.kuitansi', $bayar->id_bayar) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                                    <i class="bi bi-printer me-1"></i> Kuitansi
                                                </a>
                                                <form action="{{ route('admin.pembayaran.destroy', $bayar->id_bayar) }}" method="POST" onsubmit="return confirm('Hapus catatan pembayaran {{ $bayar->id_bayar }} sebesar Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }} ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                        <i class="bi bi-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada pembayaran tercatat.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if(config('services.midtrans.client_key'))
        <script src="{{ config('services.midtrans.snap_js_url') }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @endif
    <script>
        const adminMidtransBtn = document.getElementById('admin-midtrans-btn');
        if (adminMidtransBtn) {
            adminMidtransBtn.addEventListener('click', async () => {
                const alertBox = document.getElementById('midtrans-admin-alert');
                adminMidtransBtn.disabled = true;

                try {
                    const response = await fetch(adminMidtransBtn.dataset.url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({}),
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal membuat transaksi Midtrans.');
                    }

                    const confirmUrl = @json(route('public.sewa.midtrans.confirm', $penyewaan->id_sewa));

                    if (!data.simulation && window.snap && data.token) {
                        window.snap.pay(data.token, {
                            onSuccess: async function () {
                                await fetch(confirmUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({ order_id: data.order_id, gross_amount: data.gross_amount, tipe_bayar: 'penuh' }),
                                });
                                window.location.reload();
                            },
                            onPending: function () { window.location.reload(); },
                            onError: function () { adminMidtransBtn.disabled = false; },
                            onClose: function () { adminMidtransBtn.disabled = false; }
                        });
                    } else {
                        if (confirm('Midtrans Sandbox (' + data.order_id + ') — Konfirmasi pembayaran sebesar Rp ' + Number(data.gross_amount || 0).toLocaleString('id-ID') + '?')) {
                            await fetch(confirmUrl, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                },
                                body: JSON.stringify({ order_id: data.order_id, gross_amount: data.gross_amount, tipe_bayar: 'penuh' }),
                            });
                            window.location.reload();
                        } else {
                            adminMidtransBtn.disabled = false;
                        }
                    }
                } catch (error) {
                    if (alertBox) {
                        alertBox.className = 'alert alert-danger rounded-4 border-0 mb-3';
                        alertBox.textContent = error.message;
                    }
                    adminMidtransBtn.disabled = false;
                }
            });
        }
    </script>
@endsection
