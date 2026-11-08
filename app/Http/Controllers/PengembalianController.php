<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Penyewaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $query = Penyewaan::with(['pelanggan', 'details.alat', 'pembayaran'])
            ->where('status', 'Berjalan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('id_sewa', $q)
                    ->orWhereHas('pelanggan', function ($p) use ($q) {
                        $p->where('nama', 'like', "%{$q}%")
                            ->orWhere('no_hp', 'like', "%{$q}%");
                    });
            });
        }

        if ($request->filled('filter')) {
            if ($request->filter === 'terlambat') {
                $query->where('tgl_kembali_rencana', '<', $today);
            } elseif ($request->filter === 'hari_ini') {
                $query->whereDate('tgl_kembali_rencana', $today);
            }
        }

        $penyewaans = $query->orderBy('tgl_kembali_rencana', 'asc')->paginate(10)->withQueryString();

        return view('admin.pengembalian.index', compact('penyewaans'));
    }

    public function proses($id)
    {
        $penyewaan = Penyewaan::with(['pelanggan', 'details.alat', 'pembayaran'])->findOrFail($id);

        if ($penyewaan->status === 'Selesai') {
            return redirect()->route('admin.pengembalian.index')
                ->with('info', 'Transaksi penyewaan ini sudah selesai dikembalikan sebelumnya.');
        }

        $tglRencana = Carbon::parse($penyewaan->tgl_kembali_rencana);
        $tglAktual = Carbon::today();
        $terlambatHari = max(0, $tglAktual->diffInDays($tglRencana, false) * -1);

        // Standar denda keterlambatan: Rp 10.000 / hari
        $dendaPerHari = 10000;
        $estimasiDenda = $terlambatHari * $dendaPerHari;

        return view('admin.pengembalian.proses', compact('penyewaan', 'terlambatHari', 'estimasiDenda', 'tglAktual'));
    }

    public function simpan(Request $request, $id)
    {
        $penyewaan = Penyewaan::with('details.alat')->findOrFail($id);

        if ($penyewaan->status === 'Selesai') {
            return redirect()->route('admin.penyewaan.show', $penyewaan->id_sewa)
                ->with('info', 'Transaksi ini sudah selesai diproses pengembaliannya.');
        }

        $validated = $request->validate([
            'tgl_kembali_aktual' => 'required|date',
            'denda' => 'nullable|numeric|min:0',
            'kondisi_alat' => 'nullable|array',
            'kondisi_alat.*' => 'nullable|string|max:30',
        ], [
            'tgl_kembali_aktual.required' => 'Tanggal pengembalian aktual wajib diisi.',
        ]);

        return DB::transaction(function () use ($validated, $penyewaan) {
            // 1. Kembalikan stok setiap alat dan update kondisi jika dicatat
            foreach ($penyewaan->details as $detail) {
                if ($detail->alat) {
                    $alat = Alat::lockForUpdate()->find($detail->id_alat);
                    if ($alat) {
                        $alat->increment('stok', $detail->jumlah);

                        // Update kondisi alat jika dipilih petugas
                        if (isset($validated['kondisi_alat'][$alat->id_alat])) {
                            $alat->update(['kondisi' => $validated['kondisi_alat'][$alat->id_alat]]);
                        }
                    }
                }
            }

            // 2. Tambahkan denda ke total biaya jika ada
            $denda = floatval($validated['denda'] ?? 0);
            $totalBiayaBaru = $penyewaan->total_biaya + $denda;

            // 3. Update status transaksi sewa menjadi 'Selesai'
            $penyewaan->update([
                'tgl_kembali_aktual' => $validated['tgl_kembali_aktual'],
                'status' => 'Selesai',
                'total_biaya' => $totalBiayaBaru,
            ]);

            // 4. Perbarui statistik pelanggan bila kolom tersedia
            if ($penyewaan->pelanggan) {
                if (Schema::hasColumn('pelanggan', 'total_transaksi_selesai')) {
                    $penyewaan->pelanggan->increment('total_transaksi_selesai');
                }

                $isLate = Carbon::parse($validated['tgl_kembali_aktual'])->gt(Carbon::parse($penyewaan->tgl_kembali_rencana));
                if ($isLate && Schema::hasColumn('pelanggan', 'jumlah_terlambat')) {
                    $penyewaan->pelanggan->increment('jumlah_terlambat');
                }
            }

            return redirect()->route('admin.penyewaan.show', $penyewaan->id_sewa)
                ->with('success', 'Pengembalian alat camping berhasil diproses. Stok alat telah dikembalikan ke sistem.');
        });
    }
}
