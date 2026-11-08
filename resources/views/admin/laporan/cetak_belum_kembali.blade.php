<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Belum Kembali - CampSewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h3 class="fw-bold mb-1">Laporan Penyewaan Belum Kembali CampSewa</h3>
    <p class="text-muted small mb-4">Tanggal Cetak: {{ \Carbon\Carbon::parse($today)->translatedFormat('d M Y') }}</p>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>ID Sewa</th>
                <th>Pelanggan</th>
                <th>Tgl Sewa</th>
                <th>Rencana Kembali</th>
                <th>Status</th>
                <th class="text-end">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penyewaans as $sewa)
                @php
                    $isLate = \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->lt(\Carbon\Carbon::parse($today));
                @endphp
                <tr>
                    <td>{{ $sewa->id_sewa }}</td>
                    <td>{{ $sewa->pelanggan?->nama ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($sewa->tgl_sewa)->translatedFormat('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($sewa->tgl_kembali_rencana)->translatedFormat('d M Y') }}</td>
                    <td>{{ $isLate ? 'Terlambat' : 'Berjalan' }}</td>
                    <td class="text-end">Rp {{ number_format($sewa->total_biaya ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Tidak ada penyewaan yang belum kembali.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

