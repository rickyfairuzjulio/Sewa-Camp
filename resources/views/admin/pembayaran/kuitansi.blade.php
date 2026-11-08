<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Pembayaran {{ $bayar->id_bayar }} - CampSewa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #101010;
            --brand-dark-soft: #18191b;
            --brand-green: #15803d; /* Warna hijau agak tua / forest green */
            --brand-green-rich: #16a34a;
            --brand-green-deep: #166534;
            --brand-green-soft: rgba(21, 128, 61, 0.08);
            --brand-green-border: rgba(21, 128, 61, 0.25);
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
            max-width: 840px;
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
            background: var(--brand-green);
            border: 1px solid var(--brand-green);
            border-radius: 999px;
            color: #ffffff !important;
            font-size: 0.85rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(21, 128, 61, 0.3);
        }

        .btn-action-print:hover {
            background: var(--brand-green-deep);
            border-color: var(--brand-green-deep);
            transform: translateY(-1px);
        }

        .btn-action-print .pill-doc {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 0.72rem;
            margin-left: 4px;
        }

        /* Main Receipt Sheet */
        .receipt-canvas {
            max-width: 840px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 10px 32px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            position: relative;
        }

        /* Top Obsidian Header */
        .receipt-header-hero {
            background: var(--brand-dark);
            color: #ffffff;
            padding: 26px 32px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 3.5px solid var(--brand-green);
        }

        .receipt-brand-group {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .receipt-brand-logo {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            background: #000000;
            border: 1.5px solid rgba(255, 255, 255, 0.15);
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 2px;
        }

        .receipt-brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .receipt-brand-text h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
            color: #ffffff;
        }

        .receipt-brand-tagline {
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            color: #4ade80;
            text-transform: uppercase;
            margin-top: 3px;
        }

        .receipt-brand-address {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.72);
            margin-top: 6px;
            line-height: 1.35;
        }

        .receipt-brand-contact {
            font-size: 0.72rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 2px;
        }

        .receipt-doc-meta {
            text-align: right;
        }

        .receipt-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--brand-green);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            padding: 4px 14px;
            border-radius: 999px;
            margin-bottom: 8px;
            box-shadow: 0 2px 8px rgba(21, 128, 61, 0.4);
        }

        .receipt-header-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            color: #ffffff;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .receipt-header-meta-list {
            margin-top: 8px;
            font-size: 0.74rem;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.5;
        }

        .receipt-header-meta-list strong {
            color: #ffffff;
            font-family: 'Space Grotesk', sans-serif;
            letter-spacing: 0.02em;
        }

        /* Body */
        .receipt-body {
            padding: 28px 32px 32px;
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

        .badge-method-box {
            display: inline-block;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 0.74rem;
            font-weight: 800;
            color: #1e293b;
        }

        .badge-status-sewa {
            display: inline-block;
            background: #e2e8f0;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            color: #334155;
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
            background: #111827;
            color: #ffffff;
        }

        .receipt-table th {
            padding: 12px 14px;
            font-weight: 800;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
            background: #fbfcfd;
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

        /* Financial Highlight Box */
        .receipt-total-card {
            background: var(--brand-dark);
            color: #ffffff;
            border-radius: 16px;
            padding: 22px 26px;
            margin-bottom: 24px;
            display: grid;
            grid-template-columns: 1.35fr 1fr;
            gap: 20px;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .receipt-terbilang-wrap {
            padding-right: 18px;
            border-right: 1px dashed rgba(255, 255, 255, 0.2);
        }

        .receipt-amount-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.75);
            font-weight: 800;
            margin-bottom: 4px;
        }

        .receipt-amount-value {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.15rem;
            font-weight: 800;
            color: #4ade80;
            letter-spacing: -0.02em;
            line-height: 1.1;
            margin-bottom: 8px;
        }

        .receipt-terbilang-text {
            font-size: 0.82rem;
            font-style: italic;
            font-weight: 600;
            line-height: 1.4;
            color: rgba(255, 255, 255, 0.9);
        }

        .receipt-financial-summary {
            display: flex;
            flex-direction: column;
            gap: 8px;
            font-size: 0.82rem;
        }

        .receipt-financial-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: rgba(255, 255, 255, 0.75);
            gap: 12px;
        }

        .receipt-financial-row strong {
            color: #ffffff;
            font-weight: 700;
            font-family: 'Space Grotesk', sans-serif;
        }

        .receipt-financial-row.highlight-lunas strong {
            color: #4ade80;
            font-weight: 800;
        }

        /* Footer Grid: Terms & Official Stamp */
        .receipt-footer-grid {
            display: grid;
            grid-template-columns: 1.25fr 1fr;
            gap: 24px;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
            align-items: flex-start;
        }

        .receipt-terms-box {
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .receipt-terms-box .terms-title {
            font-size: 0.76rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .receipt-terms-box .terms-title i {
            color: var(--brand-green);
        }

        .receipt-terms-box .terms-list {
            margin: 0;
            padding-left: 18px;
            font-size: 0.72rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .receipt-terms-box .terms-list li {
            margin-bottom: 4px;
        }

        .receipt-terms-box .terms-list li:last-child {
            margin-bottom: 0;
        }

        /* Cashier Sign & Stamp */
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

        /* Circular Green Stamp (Stempel) */
        .receipt-official-stamp {
            position: absolute;
            top: -24px;
            left: 18px;
            width: 96px;
            height: 96px;
            border-radius: 50%;
            border: 2.5px dashed var(--brand-green);
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
            border: 1.5px solid var(--brand-green);
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
            color: var(--brand-green);
            text-transform: uppercase;
            line-height: 1;
        }

        .stamp-badge-text {
            font-size: 1.15rem;
            font-weight: 900;
            letter-spacing: 0.16em;
            color: var(--brand-green);
            text-transform: uppercase;
            line-height: 1.15;
            margin: 3px 0 2px;
            border-top: 1.5px solid var(--brand-green);
            border-bottom: 1.5px solid var(--brand-green);
            width: 88%;
        }

        .stamp-date {
            font-size: 0.58rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            color: var(--brand-green);
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

        /* Bottom Notice */
        .receipt-legal-note {
            margin-top: 26px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
            font-size: 0.72rem;
            color: #94a3b8;
            text-align: center;
            line-height: 1.5;
            font-weight: 500;
        }

        /* Print Media Styles */
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
                padding: 20px 26px !important;
            }

            .receipt-table thead {
                background: #111827 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .receipt-body {
                padding: 22px 26px !important;
            }

            .receipt-total-card {
                background: #111827 !important;
                color: #ffffff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .receipt-official-stamp {
                border-color: #15803d !important;
                background: rgba(240, 253, 244, 0.45) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .receipt-official-stamp .stamp-inner-border,
            .stamp-star,
            .stamp-badge-text,
            .stamp-date {
                color: #15803d !important;
                border-color: #15803d !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
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

            .receipt-footer-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .receipt-sign-box {
                text-align: center;
            }
        }
    </style>
</head>
<body>

    {{-- Top Action Bar (Screen Only) --}}
    <div class="receipt-action-bar no-print">
        <a href="{{ route('admin.penyewaan.show', $bayar->id_sewa) }}" class="btn-action-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Transaksi
        </a>
        <div class="d-flex align-items-center gap-2">
            <button type="button" onclick="window.print()" class="btn-action-print">
                <i class="bi bi-printer-fill"></i> Cetak Kuitansi Resmi <span class="pill-doc">PDF</span>
            </button>
        </div>
    </div>

    {{-- Main Receipt Canvas --}}
    <main class="receipt-canvas">
        {{-- Obsidian Branded Header Hero --}}
        <header class="receipt-header-hero">
            <div class="receipt-brand-group">
                <div class="receipt-brand-logo">
                    <img src="{{ asset('images/black.jpg') }}" alt="CampSewa" onerror="this.onerror=null; this.src='{{ asset('images/black.png') }}';">
                </div>
                <div class="receipt-brand-text">
                    <h1>CampSewa</h1>
                    <div class="receipt-brand-tagline">ADVENTURE OUTDOOR GEAR</div>
                    <div class="receipt-brand-address">Jl. Menoreh Raya No. 42, Sampangan, Kota Semarang</div>
                    <div class="receipt-brand-contact">+62 812-3456-7890 • www.campsewa.id</div>
                </div>
            </div>

            <div class="receipt-doc-meta">
                <div class="receipt-header-badge">
                    <i class="bi bi-check-circle-fill"></i> LUNAS / TERVERIFIKASI
                </div>
                <div class="receipt-header-title">KUITANSI PEMBAYARAN</div>
                <div class="receipt-header-meta-list">
                    <div>No. Kuitansi: <strong>KW-{{ str_pad($bayar->id_bayar, 5, '0', STR_PAD_LEFT) }}</strong></div>
                    <div>No. Sewa: <strong>SEWA-{{ $bayar->id_sewa }}</strong></div>
                    <div>Tanggal: <strong>{{ \Carbon\Carbon::parse($bayar->tgl_bayar)->translatedFormat('d F Y') }}</strong></div>
                </div>
            </div>
        </header>

        {{-- Receipt Content Body --}}
        <div class="receipt-body">
            {{-- Info Cards: Pelanggan & Penyewaan --}}
            <div class="receipt-info-grid">
                {{-- Info Pelanggan --}}
                <div class="receipt-info-card">
                    <div class="receipt-info-card-header">
                        <span>DITERIMA DARI (PENYEWA)</span>
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Nama Lengkap</span>
                        <span class="receipt-info-value">{{ $bayar->penyewaan?->pelanggan?->nama ?? '-' }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">No. Telepon / WA</span>
                        <span class="receipt-info-value">{{ $bayar->penyewaan?->pelanggan?->no_hp ?? '-' }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">No. Identitas</span>
                        <span class="receipt-info-value">{{ $bayar->penyewaan?->pelanggan?->no_identitas ?? '-' }}</span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Alamat</span>
                        <span class="receipt-info-value">{{ $bayar->penyewaan?->pelanggan?->alamat ?? 'Semarang' }}</span>
                    </div>
                </div>

                {{-- Detail Sewa --}}
                <div class="receipt-info-card">
                    <div class="receipt-info-card-header">
                        <span>DETAIL PEMBAYARAN</span>
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Metode Bayar</span>
                        <span class="receipt-info-value">
                            <span class="badge-method-box">{{ $bayar->metode }}</span>
                        </span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Periode Sewa</span>
                        <span class="receipt-info-value">
                            {{ \Carbon\Carbon::parse($bayar->penyewaan?->tgl_sewa)->format('d M') }} – {{ \Carbon\Carbon::parse($bayar->penyewaan?->tgl_kembali_rencana)->format('d M Y') }} ({{ $bayar->penyewaan ? \Carbon\Carbon::parse($bayar->penyewaan->tgl_sewa)->diffInDays(\Carbon\Carbon::parse($bayar->penyewaan->tgl_kembali_rencana)) ?: 1 : 1 }} Hari)
                        </span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Status Sewa</span>
                        <span class="receipt-info-value">
                            <span class="badge-status-sewa">{{ ucwords(str_replace('_', ' ', $bayar->penyewaan?->status ?? 'berjalan')) }}</span>
                        </span>
                    </div>
                    <div class="receipt-info-row">
                        <span class="receipt-info-label">Petugas Kasir</span>
                        <span class="receipt-info-value">{{ $bayar->penyewaan?->petugas?->nama_petugas ?? auth()->user()->name ?? 'Administrator' }}</span>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Perlengkapan yang Disewa --}}
            @if($bayar->penyewaan && $bayar->penyewaan->details && $bayar->penyewaan->details->isNotEmpty())
                <div class="receipt-table-wrap">
                    <table class="receipt-table">
                        <thead>
                            <tr>
                                <th style="width: 44px;" class="text-center">#</th>
                                <th>PERLENGKAPAN OUTDOOR DISEWA</th>
                                <th class="text-center" style="width: 90px;">JUMLAH</th>
                                <th class="text-end" style="width: 120px;">TARIF / HARI</th>
                                <th class="text-center" style="width: 90px;">DURASI</th>
                                <th class="text-end" style="width: 130px;">SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $durasiHari = $bayar->penyewaan ? \Carbon\Carbon::parse($bayar->penyewaan->tgl_sewa)->diffInDays(\Carbon\Carbon::parse($bayar->penyewaan->tgl_kembali_rencana)) ?: 1 : 1;
                            @endphp
                            @foreach($bayar->penyewaan->details as $idx => $detail)
                                <tr>
                                    <td class="text-center text-muted fw-semibold">{{ $idx + 1 }}</td>
                                    <td>
                                        <span class="item-name">{{ $detail->alat?->nama_alat ?? 'Alat Camping' }}</span>
                                        <span class="item-sub">{{ $detail->alat?->kategori?->nama_kategori ?? 'Outdoor Gear' }}</span>
                                    </td>
                                    <td class="text-center fw-bold">{{ $detail->jumlah }} Unit</td>
                                    <td class="text-end text-muted">Rp {{ number_format($detail->harga_satuan ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-center text-muted">{{ $durasiHari }} Hari</td>
                                    <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- Grand Highlight Box --}}
            <div class="receipt-total-card">
                <div class="receipt-terbilang-wrap">
                    <div class="receipt-amount-title">JUMLAH DIBAYAR PADA KUITANSI INI</div>
                    <div class="receipt-amount-value">
                        Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}
                    </div>
                    <div class="receipt-terbilang-text">
                        Terbilang: # {{ \App\Helpers\FormatHelper::rupiahTerbilang($bayar->jumlah_bayar) }} #
                    </div>
                </div>

                <div class="receipt-financial-summary">
                    <div class="receipt-financial-row">
                        <span>Total Biaya Sewa:</span>
                        <strong>Rp {{ number_format($bayar->penyewaan->total_biaya ?? 0, 0, ',', '.') }}</strong>
                    </div>
                    <div class="receipt-financial-row">
                        <span>Total Sudah Masuk:</span>
                        <strong>Rp {{ number_format($bayar->penyewaan->total_dibayar ?? 0, 0, ',', '.') }}</strong>
                    </div>
                    <div class="receipt-financial-row highlight-lunas">
                        <span>Sisa Tagihan:</span>
                        <strong>{{ $bayar->penyewaan?->sisa_tagihan <= 0 ? 'Rp 0' : 'Rp ' . number_format($bayar->penyewaan->sisa_tagihan, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </div>

            {{-- Footer Grid: Terms & Official Stamp --}}
            <div class="receipt-footer-grid">
                <div class="receipt-terms-box">
                    <div class="terms-title"><i class="bi bi-shield-check"></i> Ketentuan Bukti Pembayaran:</div>
                    <ol class="terms-list">
                        <li>Kuitansi ini merupakan bukti pembayaran resmi yang sah dari <strong>CampSewa Adventure</strong>.</li>
                        <li>Wajib ditunjukkan saat pengambilan & pengecekan perlengkapan outdoor di basecamp.</li>
                        <li>Penyewa bertanggung jawab penuh menjaga keutuhan & kebersihan perlengkapan selama masa sewa.</li>
                    </ol>
                </div>

                <div class="receipt-sign-box">
                    <div class="receipt-sign-city">Semarang, {{ \Carbon\Carbon::parse($bayar->tgl_bayar)->translatedFormat('d F Y') }}</div>
                    <div class="receipt-sign-title">PETUGAS KASIR / OPERASIONAL</div>
                    <div class="receipt-stamp-container">
                        {{-- Circular Official Stamp (Stempel Resmi CampSewa) --}}
                        <div class="receipt-official-stamp">
                            <div class="stamp-inner-border">
                                <div class="stamp-star">★ CAMPSEWA ★</div>
                                <div class="stamp-badge-text">LUNAS</div>
                                <div class="stamp-date">{{ \Carbon\Carbon::parse($bayar->tgl_bayar)->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        <div class="receipt-sign-line"></div>
                        <div class="receipt-sign-name">( {{ $bayar->penyewaan?->petugas?->nama_petugas ?? auth()->user()->name ?? 'Administrator' }} )</div>
                    </div>
                </div>
            </div>

            {{-- Legal Note --}}
            <div class="receipt-legal-note">
                Salam Lestari! • Terima kasih telah mempercayakan petualangan Anda bersama <strong>CampSewa Adventure</strong>.
            </div>
        </div>
    </main>

</body>
</html>