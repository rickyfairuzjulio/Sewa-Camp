<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\DetailPenyewaan;
use App\Models\KategoriAlat;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function laporanAlat(Request $request)
    {
        $alats = Alat::with('kategori')
            ->withCount('detailPenyewaan')
            ->orderBy('id_kategori')
            ->get();

        $alatTerlaris = DetailPenyewaan::select('id_alat', DB::raw('SUM(jumlah) as total_disewa'))
            ->groupBy('id_alat')
            ->orderByDesc('total_disewa')
            ->with('alat.kategori')
            ->get();

        if ($request->get('export') === 'csv') {
            $terlarisMap = $alatTerlaris->pluck('total_disewa', 'id_alat');

            return $this->streamCsvDownload(
                'laporan-alat-campsewa-'.now()->format('Y-m-d').'.csv',
                ['ID Alat', 'Nama Alat', 'Kategori', 'Harga Sewa/Hari (Rp)', 'Stok Tersedia', 'Kondisi', 'Total Unit Disewa'],
                $alats->map(fn ($alat) => [
                    $alat->id_alat,
                    $alat->nama_alat,
                    $alat->kategori?->nama_kategori ?? '-',
                    (int) $alat->harga_sewa_per_hari,
                    (int) $alat->stok,
                    $alat->kondisi,
                    (int) ($terlarisMap[$alat->id_alat] ?? 0),
                ])->all()
            );
        }

        if ($request->get('cetak') == '1') {
            return view('admin.laporan.cetak_alat', compact('alats', 'alatTerlaris'));
        }

        return view('admin.laporan.alat', compact('alats', 'alatTerlaris'));
    }

    public function laporanPenyewaan(Request $request)
    {
        $tglMulai = $request->get('tgl_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tglSelesai = $request->get('tgl_selesai', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->get('status');

        $query = Penyewaan::with(['pelanggan', 'petugas', 'pembayaran'])
            ->whereBetween('tgl_sewa', [$tglMulai, $tglSelesai]);

        if (! empty($status)) {
            $query->where('status', $status);
        }

        $penyewaans = $query->orderBy('tgl_sewa', 'desc')->get();
        $totalNilaiSewa = $penyewaans->sum('total_biaya');

        if ($request->get('export') === 'csv') {
            return $this->streamCsvDownload(
                'laporan-penyewaan-campsewa-'.$tglMulai.'-sd-'.$tglSelesai.'.csv',
                ['ID Sewa', 'Pelanggan', 'No HP', 'Petugas', 'Tgl Sewa', 'Tgl Rencana Kembali', 'Status Sewa', 'Status Bayar', 'Total Biaya (Rp)', 'Total Dibayar (Rp)', 'Sisa Tagihan (Rp)'],
                $penyewaans->map(fn ($sewa) => [
                    '#'.$sewa->id_sewa,
                    $sewa->pelanggan?->nama ?? '-',
                    $sewa->pelanggan?->no_hp ?? '-',
                    $sewa->petugas?->nama_petugas ?? '-',
                    $sewa->tgl_sewa ? Carbon::parse($sewa->tgl_sewa)->format('Y-m-d') : '-',
                    $sewa->tgl_kembali_rencana ? Carbon::parse($sewa->tgl_kembali_rencana)->format('Y-m-d') : '-',
                    $sewa->status,
                    $sewa->status_pembayaran,
                    (int) $sewa->total_biaya,
                    (int) $sewa->total_dibayar,
                    (int) $sewa->sisa_tagihan,
                ])->all()
            );
        }

        if ($request->get('cetak') == '1') {
            return view('admin.laporan.cetak_penyewaan', compact('penyewaans', 'tglMulai', 'tglSelesai', 'status', 'totalNilaiSewa'));
        }

        return view('admin.laporan.penyewaan', compact('penyewaans', 'tglMulai', 'tglSelesai', 'status', 'totalNilaiSewa'));
    }

    public function laporanPembayaran(Request $request)
    {
        $tglMulai = $request->get('tgl_mulai', Carbon::now()->startOfMonth()->toDateString());
        $tglSelesai = $request->get('tgl_selesai', Carbon::now()->endOfMonth()->toDateString());
        $metode = $request->get('metode');

        $query = Pembayaran::with('penyewaan.pelanggan')
            ->whereBetween('tgl_bayar', [$tglMulai, $tglSelesai]);

        if (! empty($metode)) {
            $query->where('metode', $metode);
        }

        $pembayarans = (clone $query)->orderBy('tgl_bayar', 'desc')->get();
        $totalPendapatan = $pembayarans->sum('jumlah_bayar');

        // Rekapitulasi per metode pembayaran
        $rekapMetode = (clone $query)->reorder()
            ->select('metode', DB::raw('SUM(jumlah_bayar) as total'))
            ->groupBy('metode')
            ->get();

        if ($request->get('export') === 'csv') {
            return $this->streamCsvDownload(
                'laporan-pembayaran-campsewa-'.$tglMulai.'-sd-'.$tglSelesai.'.csv',
                ['ID Bayar', 'ID Sewa', 'Pelanggan', 'Tanggal Bayar', 'Metode Pembayaran', 'Jumlah Bayar (Rp)'],
                $pembayarans->map(fn ($bayar) => [
                    '#'.$bayar->id_bayar,
                    '#'.$bayar->id_sewa,
                    $bayar->penyewaan?->pelanggan?->nama ?? '-',
                    $bayar->tgl_bayar ? Carbon::parse($bayar->tgl_bayar)->format('Y-m-d') : '-',
                    $bayar->metode,
                    (int) $bayar->jumlah_bayar,
                ])->all()
            );
        }

        if ($request->get('cetak') == '1') {
            return view('admin.laporan.cetak_pembayaran', compact('pembayarans', 'tglMulai', 'tglSelesai', 'metode', 'totalPendapatan', 'rekapMetode'));
        }

        return view('admin.laporan.pembayaran', compact('pembayarans', 'tglMulai', 'tglSelesai', 'metode', 'totalPendapatan', 'rekapMetode'));
    }

    public function laporanBelumKembali(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $penyewaans = Penyewaan::with(['pelanggan', 'details.alat', 'pembayaran'])
            ->where('status', 'Berjalan')
            ->orderBy('tgl_kembali_rencana', 'asc')
            ->get();

        if ($request->get('export') === 'csv') {
            return $this->streamCsvDownload(
                'laporan-belum-kembali-campsewa-'.$today.'.csv',
                ['ID Sewa', 'Pelanggan', 'No HP', 'Tanggal Sewa', 'Rencana Kembali', 'Status Keterlambatan', 'Total Biaya (Rp)', 'Sisa Tagihan (Rp)'],
                $penyewaans->map(function ($sewa) use ($today) {
                    $isLate = Carbon::parse($sewa->tgl_kembali_rencana)->lt(Carbon::parse($today));

                    return [
                        '#'.$sewa->id_sewa,
                        $sewa->pelanggan?->nama ?? '-',
                        $sewa->pelanggan?->no_hp ?? '-',
                        $sewa->tgl_sewa ? Carbon::parse($sewa->tgl_sewa)->format('Y-m-d') : '-',
                        $sewa->tgl_kembali_rencana ? Carbon::parse($sewa->tgl_kembali_rencana)->format('Y-m-d') : '-',
                        $isLate ? 'Terlambat' : 'Berjalan',
                        (int) $sewa->total_biaya,
                        (int) $sewa->sisa_tagihan,
                    ];
                })->all()
            );
        }

        if ($request->get('cetak') == '1') {
            return view('admin.laporan.cetak_belum_kembali', compact('penyewaans', 'today'));
        }

        return view('admin.laporan.belum_kembali', compact('penyewaans', 'today'));
    }

    /**
     * Stream file CSV dengan UTF-8 BOM agar langsung rapi saat dibuka di Microsoft Excel.
     *
     * @param  array<int, string>  $headers
     * @param  array<int, array<int, scalar|null>>  $rows
     */
    private function streamCsvDownload(string $filename, array $headers, array $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows): void {
            $handle = fopen('php://output', 'w');
            if ($handle === false) {
                return;
            }

            // UTF-8 BOM untuk kompatibilitas Microsoft Excel
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, $headers);

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
