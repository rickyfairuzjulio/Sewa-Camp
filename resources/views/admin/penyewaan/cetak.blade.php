<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penyewaan {{ $penyewaan->id_sewa }} - CampSewa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #101010;
            --brand-dark-soft: #18191b;
            --brand-lime: #15803d; /* Warna hijau agak tua */
            --brand-lime-soft: rgba(21, 128, 61, 0.12);
            --brand-lime-border: rgba(21, 128, 61, 0.35);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --bg-page: #f8fafc;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-page);
            color: var(--text-main);
            padding: 24px 16px 40px;
            -webkit-font-smoothing: antialiased;
        }

        /* Top Action Bar (Screen Only) */
        .receipt-action-bar {
            max-width: 860px;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-action-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            color: var(--text-main);
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        }

        .btn-action-back:hover {
            background: #f1f5f9;
            color: var(--brand-dark);
            border-color: #cbd5e1;
        }

        .btn-action-print {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            background: var(--brand-dark);
            border: 1px solid var(--brand-dark);
            border-radius: 999px;
            color: #ffffff;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(16, 16, 16, 0.2);
        }

        .btn-action-print:hover {
            background: #222;
            transform: translateY(-1px);
        }

        .btn-action-print .lime-pill {
            background: var(--brand-lime);
            color: #ffffff !important;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 0.72rem;
            margin-left: 4px;
        }

        /* Main Invoice Canvas */
        .receipt-canvas {
            max-width: 860px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            overflow: hidden;
            position: relative;
        }

        /* Top Obsidian Header */
        .receipt-header-hero {
            background: var(--brand-dark);
            color: #ffffff;
            padding: 26px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 3px solid var(--brand-lime);
        }

        .receipt-brand-group {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .receipt-brand-logo {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: #000000;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .receipt-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .receipt-brand-text h1 {
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.15;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .receipt-brand-text h1 span {
            color: var(--brand-lime);
        }

        .receipt-brand-text p {
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.65);
            font-weight: 500;
            margin-top: 3px;
        }

        .receipt-doc-meta {
            text-align: right;
        }

        .receipt-doc-tag {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--brand-lime);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .receipt-doc-num {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 0.02em;
            line-height: 1.2;
        }

        .receipt-doc-date {
            font-size: 0.76rem;
            color: rgba(255, 255, 255, 0.65);
            margin-top: 2px;
        }

        /* Sub Store Metadata Strip */
        .receipt-store-strip {
            background: #f8fafc;
            border-bottom: 1px solid var(--border-color);
            padding: 10px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.72rem;
            color: var(--text-muted);
            flex-wrap: wrap;
            gap: 8px;
        }

        .receipt-store-strip span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Body */
        .receipt-body {
            padding: 28px 32px;
        }

        /* Info Grid */
        .receipt-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 24px;
        }

        .receipt-info-card {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 16px 18px;
        }

        .receipt-info-card-header {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .receipt-info-card-header i {
            color: var(--brand-dark);
            font-size: 0.9rem;
        }

        .receipt-info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            font-size: 0.82rem;
            gap: 12px;
        }

        .receipt-info-row:last-child {
            margin-bottom: 0;
        }

        .receipt-info-label {
            color: var(--text-muted);
            font-weight: 500;
            flex-shrink: 0;
        }

        .receipt-info-value {
            font-weight: 700;
            color: var(--text-main);
            text-align: right;
            word-break: break-word;
        }

        /* Status Badge */
        .receipt-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            background: var(--brand-lime-soft);
            color: #14532d;
            border: 1px solid var(--brand-lime-border);
        }

        .receipt-status-pill.status-pending {
            background: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        /* Equipment Breakdown Table */
        .receipt-table-wrap {
            margin-bottom: 24px;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            overflow: hidden;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }

        .receipt-table thead {
            background: #f1f5f9;
        }

        .receipt-table th {
            padding: 12px 14px;
            font-weight: 700;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }

        .receipt-table th.text-center { text-align: center; }
        .receipt-table th.text-end { text-align: right; }

        .receipt-table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .receipt-table tbody tr:last-child td {
            border-bottom: none;
        }

        .receipt-table tbody tr:hover {
            background: #fafafa;
        }

        .item-name {
            font-weight: 700;
            color: var(--text-main);
            display: block;
        }

        .item-sub {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        /* Financial Highlight Card */
        .receipt-total-card {
            background: var(--brand-dark);
            color: #ffffff;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 20px;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .receipt-terbilang-wrap {
            padding-right: 14px;
            border-right: 1px dashed rgba(255, 255, 255, 0.2);
        }

        .receipt-terbilang-title {
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--brand-lime);
            font-weight: 800;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .receipt-terbilang-text {
            font-size: 0.9rem;
            font-style: italic;
            font-weight: 600;
            line-height: 1.4;
            color: #ffffff;
        }

        .receipt-amount-wrap {
            text-align: right;
        }

        .receipt-amount-label {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .receipt-amount-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--brand-lime);
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .receipt-amount-sub {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 6px;
        }

        /* Summary Balance Grid */
        .receipt-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .receipt-summary-item {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 14px;
            text-align: center;
        }

        .receipt-summary-item .label {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .receipt-summary-item .val {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--text-main);
        }

        /* Footer Stamp & Signatures */
        .receipt-footer-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
            align-items: center;
        }

        .receipt-stamp-box {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            border-radius: 12px;
            background: #f0fdf4;
            border: 1px dashed #86efac;
        }

        .stamp-badge {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #22c55e;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(34, 197, 94, 0.3);
        }

        .stamp-text h4 {
            font-size: 0.78rem;
            font-weight: 800;
            color: #14532d;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .stamp-text p {
            font-size: 0.68rem;
            color: #166534;
            margin-top: 2px;
            line-height: 1.3;
        }

        .receipt-sign-box {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .receipt-sign-city {
            font-size: 0.74rem;
            color: var(--text-muted);
            margin-bottom: 3px;
        }

        .receipt-sign-title {
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: var(--text-main);
            text-transform: uppercase;
        }

        .receipt-stamp-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 190px;
            margin: 12px auto 0;
        }

        .receipt-official-stamp {
            position: absolute;
            top: -24px;
            left: 18px;
            width: 96px;
            height: 96px;
            border-radius: 50%;
            border: 2.5px dashed var(--brand-lime);
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(-14deg);
            opacity: 0.92;
            pointer-events: none;
            z-index: 2;
            background: rgba(240, 253, 244, 0.45);
            box-shadow: 0 0 0 1.5px rgba(21, 128, 61, 0.25);
        }

        .receipt-official-stamp .stamp-inner-border {
            width: 82px;
            height: 82px;
            border-radius: 50%;
            border: 1.5px solid var(--brand-lime);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2px;
        }

        .stamp-star {
            font-size: 0.54rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            color: var(--brand-lime);
            text-transform: uppercase;
            line-height: 1;
        }

        .stamp-badge-text {
            font-size: 1.15rem;
            font-weight: 900;
            letter-spacing: 0.16em;
            color: var(--brand-lime);
            text-transform: uppercase;
            line-height: 1.15;
            margin: 3px 0 2px;
            border-top: 1.5px solid var(--brand-lime);
            border-bottom: 1.5px solid var(--brand-lime);
            width: 88%;
        }

        .stamp-date {
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--brand-lime);
            line-height: 1;
        }

        .receipt-sign-line {
            width: 160px;
            height: 1px;
            background: #cbd5e1;
            margin-top: 56px;
            margin-bottom: 6px;
        }

        .receipt-sign-name {
            font-size: 0.84rem;
            font-weight: 800;
            color: var(--text-main);
            text-align: center;
        }

        .receipt-sign-role {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Legal Note */
        .receipt-legal-note {
            margin-top: 22px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.68rem;
            color: #94a3b8;
            text-align: center;
            line-height: 1.5;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                color: #000000 !important;
            }

            .receipt-action-bar,
            .no-print {
                display: none !important;
            }

            .receipt-canvas {
                max-width: 100% !important;
                border: 1px solid #d1d5db !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                margin: 0 !important;
            }

            .receipt-header-hero {
                background: #111827 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                padding: 18px 24px !important;
            }

            .receipt-body {
                padding: 20px 24px !important;
            }

            .receipt-total-card {
                background: #111827 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .receipt-amount-value {
                color: #22c55e !important;
            }

            .receipt-terbilang-title {
                color: #22c55e !important;
            }

            .receipt-stamp-box {
                background: #f0fdf4 !important;
                border: 1px dashed #22c55e !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        @media (max-width: 680px) {
            .receipt-header-hero {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
                gap: 14px;
            }

            .receipt-doc-meta {
                text-align: left;
            }

            .receipt-body {
                padding: 20px 16px;
            }

            .receipt-info-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .receipt-total-card {
                grid-template-columns: 1fr;
                gap: 16px;
                padding: 18px;
            }

            .receipt-terbilang-wrap {
                padding-right: 0;
                border-right: none;
                border-bottom: 1px dashed rgba(255, 255, 255, 0.2);
                padding-bottom: 12px;
            }

            .receipt-amount-wrap {
                text-align: left;
            }

            .receipt-summary-grid {
                grid-template-columns: 1fr;
            }

            .receipt-footer-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .receipt-sign-box {
                text-align: left;
            }
        }
    </style>
</head>
<body>

    {{-- Top Action Bar (Screen Only) --}}
    <div class="receipt-action-bar no-print">
        <a href="{{ route('admin.penyewaan.show', $penyewaan->id_sewa) }}" class="btn-action-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Transaksi
        </a>
        <div class="d-flex align-items-center gap-2">
            <button type="button" onclick="window.print()" class="btn-action-print">
                <i class="bi bi-printer-fill"></i> Cetak Nota Resmi <span class="lime-pill">PDF</span>
            </button>
        </div>
    </div>

    {{-- Main Invoice Canvas --}}
    <main class="receipt-canvas">
        {{-- Obsidian Branded Header Hero --}}
        <header class="receipt-header-hero">
            <div class="receipt-brand-group">
                <div class="receipt-brand-logo">
                    <img src="{{ asset('images/black.jpg') }}" alt="CampSewa" onerror="this.onerror=null; this.src='{{ asset('images/black.png') }}';">
                </div>
                <div class="receipt-brand-text">
                    <h1>Camp<span>Sewa</span></h1>
                    <p>Penyewaan Alat Outdoor & Camping Terpercaya</p>
                </div>
            </div>

            <div class="receipt-doc-meta">
                <div class="receipt-doc-tag">Nota Transaksi Resmi</div>
                <div class="receipt-doc-num">NOTA-{{ str_pad($penyewaan->id_sewa, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="receipt-doc-date">
                    <i class="bi bi-calendar-event me-1"></i>
                    {{ \Carbon\Carbon::parse($penyewaan->tgl_sewa)->translatedFormat('d F Y') }}
                </div>
            </div>
        </header>

        {{-- Store Metadata Strip --}}
        <div class="receipt-store-strip">
            <span><i class="bi bi-geo-alt-fill text-danger"></i> Jl. Menoreh Tengah No. 22, Sampangan, Kota Semarang</span>
            <span><i class="bi bi-whatsapp text-success"></i> +62 821-3456-7890</span>
            <span><i class="bi bi-globe text-primary"></i> www.campsewa.id</span>
        </div>

        {{-- Invoice Body --}}
        <div class="receipt-body">
            {{-- Info Cards: Pelanggan & Rental --}}
            <div class="receipt-info-grid">
                {{-- Data Pelanggan --}}
                <div class="receipt-info-card">
                    <div class="receipt-info-card-header">
                        <span>Informasi Penyewa</span>
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Nama Pelanggan</span>
                        <span class="receipt-info-value">{{ $penyewaan->pelanggan?->nama ?? '-' }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Nomor Kontak / WA</span>
                        <span class="receipt-info-value">{{ $penyewaan->pelanggan?->no_hp ?? '-' }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">No. Identitas KTP/SIM</span>
                        <span class="receipt-info-value">{{ $penyewaan->pelanggan?->no_identitas ?? '-' }}</span>
                    </div>
                    @if($penyewaan->pelanggan?->alamat)
                        <div class="receipt-info-row">
                            <span class="receipt-info-label">Alamat</span>
                            <span class="receipt-info-value">{{ $penyewaan->pelanggan->alamat }}</span>
                        </div>
                    @endif
                </div>

                {{-- Data Transaksi Sewa --}}
                <div class="receipt-info-card">
                    <div class="receipt-info-card-header">
                        <span>Detail Jadwal & Petugas</span>
                        <i class="bi bi-calendar-range-fill"></i>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Tanggal Pengambilan</span>
                        <span class="receipt-info-value">{{ \Carbon\Carbon::parse($penyewaan->tgl_sewa)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Rencana Pengembalian</span>
                        <span class="receipt-info-value">{{ \Carbon\Carbon::parse($penyewaan->tgl_kembali_rencana)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Petugas Layanan</span>
                        <span class="receipt-info-value">{{ $penyewaan->petugas?->nama_petugas ?? 'Admin CampSewa' }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Status Sewa</span>
                        <span class="receipt-info-value">
                            <span class="receipt-status-pill {{ in_array($penyewaan->status, ['Selesai', 'Aktif']) ? '' : 'status-pending' }}">
                                <i class="bi bi-shield-check"></i> {{ strtoupper($penyewaan->status) }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Equipment Breakdown Table --}}
            <div class="receipt-table-wrap">
                <table class="receipt-table">
                    <thead>
                        <tr>
                            <th style="width: 44px;" class="text-center">No</th>
                            <th>Nama Perlengkapan Outdoor</th>
                            <th class="text-center" style="width: 100px;">Jumlah</th>
                            <th class="text-end" style="width: 140px;">Tarif / Hari</th>
                            <th class="text-end" style="width: 150px;">Subtotal Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyewaan->details as $idx => $detail)
                            <tr>
                                <td class="text-center text-muted fw-semibold">{{ $idx + 1 }}</td>
                                <td>
                                    <span class="item-name">{{ $detail->alat?->nama_alat ?? '-' }}</span>
                                    <span class="item-sub">{{ $detail->alat?->kategori?->nama_kategori ?? 'Outdoor Gear' }}</span>
                                </td>
                                <td class="text-center fw-bold">{{ $detail->jumlah }} unit</td>
                                <td class="text-end text-muted">Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada rincian alat pada transaksi ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Grand Highlight Box --}}
            <div class="receipt-total-card">
                <div class="receipt-terbilang-wrap">
                    <div class="receipt-terbilang-title">
                        <i class="bi bi-chat-left-quote-fill"></i> Terbilang
                    </div>
                    <div class="receipt-terbilang-text">
                        "{{ \App\Helpers\FormatHelper::rupiahTerbilang($penyewaan->total_biaya) }}"
                    </div>
                </div>

                <div class="receipt-amount-wrap">
                    <div class="receipt-amount-label">Total Biaya Sewa</div>
                    <div class="receipt-amount-value">
                        Rp {{ number_format($penyewaan->total_biaya ?? 0, 0, ',', '.') }}
                    </div>
                    <div class="receipt-amount-sub">
                        Status Pelunasan: <strong>{{ $penyewaan->sisa_tagihan <= 0 ? 'LUNAS' : 'BELUM LUNAS' }}</strong>
                    </div>
                </div>
            </div>

            {{-- Summary Balance Grid --}}
            <div class="receipt-summary-grid">
                <div class="receipt-summary-item">
                    <div class="label">Total Biaya Sewa</div>
                    <div class="val">Rp {{ number_format($penyewaan->total_biaya ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="receipt-summary-item">
                    <div class="label">Total Telah Dibayar</div>
                    <div class="val text-primary">Rp {{ number_format($penyewaan->total_dibayar ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="receipt-summary-item">
                    <div class="label">Sisa Tagihan</div>
                    <div class="val {{ $penyewaan->sisa_tagihan <= 0 ? 'text-success' : 'text-danger' }}">
                        {{ $penyewaan->sisa_tagihan <= 0 ? 'Rp 0 (LUNAS)' : 'Rp ' . number_format($penyewaan->sisa_tagihan, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            {{-- Footer Grid: Stamp & Signatures --}}
            <div class="receipt-footer-grid">
                <div class="receipt-stamp-box">
                    <div class="stamp-badge">
                        <i class="bi bi-shield-fill-check"></i>
                    </div>
                    <div class="stamp-text">
                        <h4>VERIFIKASI SISTEM DIGITAL</h4>
                        <p>Dokumen ini adalah bukti transaksi resmi yang terdaftar pada sistem inventaris CampSewa. Harap tunjukkan dokumen ini saat pengambilan dan pengembalian unit alat.</p>
                    </div>
                </div>

                <div class="receipt-sign-box">
                    <div class="receipt-sign-city">Semarang, {{ \Carbon\Carbon::parse($penyewaan->tgl_sewa)->translatedFormat('d F Y') }}</div>
                    <div class="receipt-sign-title">Petugas Kasir CampSewa,</div>
                    <div class="receipt-stamp-container">
                        <div class="receipt-official-stamp">
                            <div class="stamp-inner-border">
                                <div class="stamp-star">★ CAMPSEWA ★</div>
                                <div class="stamp-badge-text">{{ $penyewaan->sisa_tagihan <= 0 ? 'LUNAS' : 'RESMI' }}</div>
                                <div class="stamp-date">{{ \Carbon\Carbon::parse($penyewaan->tgl_sewa)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="receipt-sign-line"></div>
                        <div class="receipt-sign-name">( {{ $penyewaan->petugas?->nama_petugas ?? auth()->user()->name ?? 'Administrator' }} )</div>
                        <div class="receipt-sign-role">ID Petugas: {{ $penyewaan->id_petugas ?? '1' }}</div>
                    </div>
                </div>
            </div>

            {{-- Legal Notice --}}
            <div class="receipt-legal-note">
                Syarat & Ketentuan: Keterlambatan pengembalian dikenakan denda sesuai tarif harian per unit. Kerusakan atau kehilangan unit menjadi tanggung jawab penyewa dan wajib diganti sesuai harga pasar.
            </div>
        </div>
    </main>

</body>
</html>
