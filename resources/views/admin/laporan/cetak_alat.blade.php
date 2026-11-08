<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Alat - CampSewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h3 class="fw-bold mb-1">Laporan Inventaris & Alat Terlaris CampSewa</h3>
    <p class="text-muted small mb-4">Dicetak pada {{ now()->translatedFormat('d M Y H:i') }}</p>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Alat</th>
                <th>Kategori</th>
                <th>Harga / Hari</th>
                <th>Stok</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($alats as $alat)
                <tr>
                    <td>{{ $alat->nama_alat }}</td>
                    <td>{{ $alat->kategori?->nama_kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($alat->harga_sewa_per_hari, 0, ',', '.') }}</td>
                    <td>{{ $alat->stok }}</td>
                    <td>{{ $alat->kondisi }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">Belum ada data alat.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

