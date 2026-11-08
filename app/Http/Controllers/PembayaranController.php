<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penyewaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['penyewaan.pelanggan']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('id_sewa', $q)
                  ->orWhereHas('penyewaan.pelanggan', function ($p) use ($q) {
                      $p->where('nama', 'like', "%{$q}%");
                  });
            });
        }

        if ($request->filled('metode')) {
            $query->where('metode', $request->metode);
        }

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_bayar', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $totalPenerimaan = (clone $query)->sum('jumlah_bayar');
        $pembayarans = $query->latest('id_bayar')->paginate(10)->withQueryString();

        return view('admin.pembayaran.index', compact('pembayarans', 'totalPenerimaan'));
    }

    public function create(Request $request)
    {
        $selectedSewa = null;
        if ($request->filled('id_sewa')) {
            $selectedSewa = Penyewaan::with('pelanggan', 'pembayaran')->find($request->id_sewa);
        }

        // Ambil sewa yang masih ada sisa tagihan
        $penyewaans = Penyewaan::with(['pelanggan', 'pembayaran'])
            ->where('status', '!=', 'Dibatalkan')
            ->get()
            ->filter(function ($s) {
                return $s->sisa_tagihan > 0;
            });

        return view('admin.pembayaran.create', compact('penyewaans', 'selectedSewa'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_sewa' => 'required|exists:penyewaan,id_sewa',
            'tgl_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:1000',
            'metode' => 'required|string|max:30',
        ], [
            'id_sewa.required' => 'Pilih transaksi penyewaan yang akan dibayar.',
            'jumlah_bayar.required' => 'Jumlah pembayaran wajib diisi.',
            'metode.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        $sewa = Penyewaan::findOrFail($validated['id_sewa']);

        if ($validated['jumlah_bayar'] > $sewa->sisa_tagihan) {
            return back()->with('error', 'Jumlah bayar (Rp ' . number_format($validated['jumlah_bayar'], 0, ',', '.') . ') melebihi sisa tagihan (Rp ' . number_format($sewa->sisa_tagihan, 0, ',', '.') . ').')
                         ->withInput();
        }

        DB::transaction(function () use ($validated) {
            Pembayaran::create($validated);
        });

        return redirect()->route('admin.penyewaan.show', $sewa->id_sewa)
            ->with('success', 'Pembayaran sebesar Rp ' . number_format($validated['jumlah_bayar'], 0, ',', '.') . ' berhasil dicatat.');
    }

    public function cetakKuitansi($id)
    {
        $bayar = Pembayaran::with([
            'penyewaan.pelanggan',
            'penyewaan.petugas',
            'penyewaan.details.alat',
            'penyewaan.pembayaran',
        ])->findOrFail($id);

        return view('admin.pembayaran.kuitansi', compact('bayar'));
    }

    public function destroy($id)
    {
        $bayar = Pembayaran::findOrFail($id);
        $idSewa = $bayar->id_sewa;
        $bayar->delete();

        return redirect()->route('admin.penyewaan.show', $idSewa)
            ->with('success', 'Catatan pembayaran berhasil dihapus.');
    }
}
