<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\DetailPenyewaan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenyewaanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penyewaan::with(['pelanggan', 'petugas', 'pembayaran']);

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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tgl_mulai') && $request->filled('tgl_selesai')) {
            $query->whereBetween('tgl_sewa', [$request->tgl_mulai, $request->tgl_selesai]);
        }

        $penyewaans = $query->latest('id_sewa')->paginate(10)->withQueryString();

        return view('admin.penyewaan.index', compact('penyewaans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        $alats = Alat::where('stok', '>', 0)->with('kategori')->orderBy('nama_alat')->get();
        $petugass = Petugas::orderBy('nama_petugas')->get();

        return view('admin.penyewaan.create', compact('pelanggans', 'alats', 'petugass'));
    }

    public function store(Request $request)
    {
        $rawItems = is_array($request->input('items')) ? $request->input('items') : [];
        $filteredItems = array_values(array_filter($rawItems, function ($item) {
            return is_array($item) && ! empty($item['id_alat']);
        }));

        $request->merge([
            'pelanggan_type' => $request->input('pelanggan_type', 'existing'),
            'items' => $filteredItems,
        ]);

        $validated = $request->validate([
            'pelanggan_type' => 'required|in:existing,new',
            'id_pelanggan' => 'required_if:pelanggan_type,existing|nullable|exists:pelanggan,id_pelanggan',
            // jika pelanggan baru:
            'nama' => 'required_if:pelanggan_type,new|nullable|string|max:100',
            'no_hp' => 'required_if:pelanggan_type,new|nullable|string|max:15',
            'alamat' => 'nullable|string|max:200',
            'no_identitas' => 'required_if:pelanggan_type,new|nullable|string|max:20|unique:pelanggan,no_identitas',
            // data sewa:
            'id_petugas' => 'nullable|exists:petugas,id_petugas',
            'tgl_sewa' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after:tgl_sewa',
            'items' => 'required|array|min:1',
            'items.*.id_alat' => 'required|exists:alat,id_alat',
            'items.*.jumlah' => 'required|integer|min:1',
            // pembayaran awal opsional:
            'jumlah_bayar' => 'nullable|numeric|min:0',
            'metode_bayar' => 'required_with:jumlah_bayar|nullable|string|max:30',
        ], [
            'items.required' => 'Wajib memilih minimal satu alat camping.',
            'tgl_kembali_rencana.after' => 'Tanggal kembali harus setelah tanggal sewa.',
        ]);

        $tglMulai = Carbon::parse($validated['tgl_sewa']);
        $tglSelesai = Carbon::parse($validated['tgl_kembali_rencana']);
        $durasi = max(1, $tglMulai->diffInDays($tglSelesai));

        return DB::transaction(function () use ($validated, $durasi) {
            // 1. Tentukan ID Pelanggan
            if ($validated['pelanggan_type'] === 'new') {
                $pelanggan = Pelanggan::create([
                    'nama' => $validated['nama'],
                    'no_hp' => $validated['no_hp'],
                    'alamat' => $validated['alamat'] ?? null,
                    'no_identitas' => $validated['no_identitas'],
                ]);
                $idPelanggan = $pelanggan->id_pelanggan;
            } else {
                $idPelanggan = $validated['id_pelanggan'];
            }

            // 2. Tentukan ID Petugas
            $idPetugas = $validated['id_petugas'] ?? null;
            if (! $idPetugas && Auth::check()) {
                $user = Auth::user();
                $p = Petugas::where('username', $user->email)
                    ->orWhere('nama_petugas', $user->name)
                    ->first();
                $idPetugas = $p ? $p->id_petugas : (Petugas::first()->id_petugas ?? null);
            }

            // 3. Simpan Penyewaan
            $penyewaan = Penyewaan::create([
                'id_pelanggan' => $idPelanggan,
                'id_petugas' => $idPetugas,
                'tgl_sewa' => $validated['tgl_sewa'],
                'tgl_kembali_rencana' => $validated['tgl_kembali_rencana'],
                'tgl_kembali_aktual' => null,
                'status' => 'Berjalan',
                'total_biaya' => 0,
            ]);

            $totalBiaya = 0;

            // 4. Detail Penyewaan & Pengurangan Stok
            foreach ($validated['items'] as $item) {
                $alat = Alat::lockForUpdate()->findOrFail($item['id_alat']);

                if ($alat->stok < $item['jumlah']) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi (Sisa stok: {$alat->stok}).");
                }

                $hargaSatuan = $alat->harga_sewa_per_hari;
                $subtotal = $item['jumlah'] * $hargaSatuan * $durasi;

                DetailPenyewaan::create([
                    'id_sewa' => $penyewaan->id_sewa,
                    'id_alat' => $alat->id_alat,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal,
                ]);

                $alat->decrement('stok', $item['jumlah']);
                $totalBiaya += $subtotal;
            }

            $penyewaan->update(['total_biaya' => $totalBiaya]);

            // 5. Pembayaran awal jika ada
            if (! empty($validated['jumlah_bayar']) && $validated['jumlah_bayar'] > 0) {
                Pembayaran::create([
                    'id_sewa' => $penyewaan->id_sewa,
                    'tgl_bayar' => Carbon::today()->toDateString(),
                    'jumlah_bayar' => $validated['jumlah_bayar'],
                    'metode' => $validated['metode_bayar'] ?? 'Tunai',
                ]);
            }

            return redirect()->route('admin.penyewaan.show', $penyewaan->id_sewa)
                ->with('success', 'Transaksi penyewaan #'.$penyewaan->id_sewa.' berhasil dibuat.');
        });
    }

    public function show($id)
    {
        $penyewaan = Penyewaan::with(['pelanggan', 'petugas', 'details.alat.kategori', 'pembayaran'])->findOrFail($id);

        return view('admin.penyewaan.show', compact('penyewaan'));
    }

    public function cetak($id)
    {
        $penyewaan = Penyewaan::with(['pelanggan', 'petugas', 'details.alat', 'pembayaran'])->findOrFail($id);

        return view('admin.penyewaan.cetak', compact('penyewaan'));
    }

    public function batal($id)
    {
        $penyewaan = Penyewaan::with('details.alat', 'pembayaran')->findOrFail($id);

        if ($penyewaan->status === 'Selesai') {
            return back()->with('error', 'Transaksi yang sudah selesai tidak dapat dibatalkan.');
        }

        if ($penyewaan->pembayaran()->count() > 0) {
            return back()->with('error', 'Transaksi yang memiliki catatan pembayaran tidak dapat dibatalkan langsung. Silakan kelola pembayaran terlebih dahulu.');
        }

        DB::transaction(function () use ($penyewaan) {
            // Kembalikan stok alat
            foreach ($penyewaan->details as $detail) {
                if ($detail->alat) {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }

            $penyewaan->update(['status' => 'Dibatalkan']);
        });

        return back()->with('success', 'Transaksi penyewaan berhasil dibatalkan dan stok telah dikembalikan.');
    }
}
