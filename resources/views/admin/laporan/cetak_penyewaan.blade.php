<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Penyewaan - CampSewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h3 class="fw-bold mb-1">Laporan Transaksi Penyewaan CampSewa</h3>
    <p class="text-muted small mb-4">Periode: {{ $tglMulai }} s/d {{ $tglSelesai }} · Total Nilai Sewa: Rp {{ number_format($totalNilaiSewa ?? 0, 0, ',', '.') }}</p>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>ID Sewa</th>
                <th>Pelanggan</th>
                <th>Tanggal Sewa</th>
                <th>Status</th>
                <th class="text-end">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penyewaans as $sewa)
                <tr>
                    <td>{{ $sewa->id_sewa }}</td>
                    <td>{{ $sewa->pelanggan?->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($sewa->tgl_sewa)->translatedFormat('d M Y') }}</td>
                    <td>{{ $sewa->status }}</td>
                    <td class="text-end">Rp {{ number_format($sewa->total_biaya ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

