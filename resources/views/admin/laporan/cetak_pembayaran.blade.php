<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Pembayaran - CampSewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h3 class="fw-bold mb-1">Laporan Pendapatan & Pembayaran CampSewa</h3>
    <p class="text-muted small mb-4">Periode: {{ $tglMulai }} s/d {{ $tglSelesai }} · Total Pendapatan: Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>ID Bayar</th>
                <th>ID Sewa</th>
                <th>Pelanggan</th>
                <th>Tanggal</th>
                <th>Metode</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pembayarans as $bayar)
                <tr>
                    <td>{{ $bayar->id_bayar }}</td>
                    <td>{{ $bayar->id_sewa }}</td>
                    <td>{{ $bayar->penyewaan?->pelanggan?->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($bayar->tgl_bayar)->translatedFormat('d M Y') }}</td>
                    <td>{{ $bayar->metode }}</td>
                    <td class="text-end">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Belum ada data pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

