<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\DetailPenyewaan;
use App\Models\KategoriAlat;
use App\Models\Pelanggan;
use App\Models\Penyewaan;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function beranda()
    {
        $kategori = KategoriAlat::withCount('alat')->get();
        $alatUnggulan = Alat::with('kategori')
            ->where('stok', '>', 0)
            ->latest('id_alat')
            ->take(12)
            ->get();

        $stats = [
            'total_alat' => Alat::count(),
            'total_stok' => Alat::sum('stok'),
            'total_pelanggan' => Pelanggan::count(),
            'total_sewa' => Penyewaan::count(),
        ];

        return view('public.beranda', compact('kategori', 'alatUnggulan', 'stats'));
    }

    public function katalog(Request $request)
    {
        $kategori = KategoriAlat::all();
        $query = Alat::with('kategori');

        // Pencarian nama alat
        if ($request->filled('q')) {
            $query->where('nama_alat', 'like', '%'.$request->q.'%');
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter kondisi
        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter ketersediaan stok
        if ($request->filled('stok') && $request->stok == 'tersedia') {
            $query->where('stok', '>', 0);
        }

        // Urutan
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('harga_sewa_per_hari', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga_sewa_per_hari', 'desc');
                break;
            case 'nama_asc':
                $query->orderBy('nama_alat', 'asc');
                break;
            default:
                $query->latest('id_alat');
                break;
        }

        $alats = $query->paginate(12)->withQueryString();

        return view('public.katalog', compact('alats', 'kategori'));
    }

    public function detailAlat($id)
    {
        $alat = Alat::with('kategori')->findOrFail($id);
        $terkait = Alat::with('kategori')
            ->where('id_kategori', $alat->id_kategori)
            ->where('id_alat', '!=', $alat->id_alat)
            ->take(5)
            ->get();

        if ($terkait->count() < 4) {
            $tambahan = Alat::with('kategori')
                ->where('id_alat', '!=', $alat->id_alat)
                ->whereNotIn('id_alat', $terkait->pluck('id_alat'))
                ->take(5 - $terkait->count())
                ->get();
            $terkait = $terkait->concat($tambahan);
        }

        return view('public.detail', compact('alat', 'terkait'));
    }

    public function caraSewa()
    {
        return view('public.cara_sewa');
    }

    public function kontak()
    {
        return view('public.kontak');
    }

    public function formPermintaanSewa(Request $request)
    {
        $alatList = Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->get();
        $pelanggan = $request->user()?->pelanggan;
        $selectedAlat = null;
        if ($request->filled('alat_id')) {
            $selectedAlat = Alat::find($request->alat_id);
        }

        $prefillTglSewa = $request->filled('tgl_sewa')
            ? $request->string('tgl_sewa')->toString()
            : date('Y-m-d');

        $durasi = max(1, min(30, (int) $request->input('durasi', 2)));
        $prefillTglKembali = $request->filled('tgl_kembali_rencana')
            ? $request->string('tgl_kembali_rencana')->toString()
            : Carbon::parse($prefillTglSewa)->addDays($durasi)->toDateString();

        return view('public.sewa', compact(
            'alatList',
            'pelanggan',
            'selectedAlat',
            'prefillTglSewa',
            'prefillTglKembali',
            'durasi'
        ));
    }

    public function simpanPermintaanSewa(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string|max:200',
            'no_identitas' => 'required|string|max:20',
            'tgl_sewa' => 'required|date|after_or_equal:today',
            'tgl_kembali_rencana' => 'required|date|after:tgl_sewa',
            'items' => 'required|array|min:1',
            'items.*.id_alat' => 'required|exists:alat,id_alat',
            'items.*.jumlah' => 'required|integer|min:1',
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',
            'no_hp.required' => 'Nomor WhatsApp / HP wajib diisi.',
            'no_identitas.required' => 'Nomor Identitas (KTP/KTM/SIM) wajib diisi.',
            'tgl_sewa.required' => 'Tanggal mulai sewa wajib dipilih.',
            'tgl_sewa.after_or_equal' => 'Tanggal sewa tidak boleh sebelum hari ini.',
            'tgl_kembali_rencana.required' => 'Tanggal kembali wajib dipilih.',
            'tgl_kembali_rencana.after' => 'Tanggal kembali harus setelah tanggal mulai sewa.',
            'items.required' => 'Pilih minimal satu alat camping untuk disewa.',
        ]);

        $tglMulai = Carbon::parse($validated['tgl_sewa']);
        $tglSelesai = Carbon::parse($validated['tgl_kembali_rencana']);
        $durasi = max(1, $tglMulai->diffInDays($tglSelesai));

        $user = $request->user();

        return DB::transaction(function () use ($validated, $durasi, $user) {
            $pelanggan = $user?->isPelanggan() ? $user->pelanggan : null;

            if (! $pelanggan) {
                $pelanggan = Pelanggan::updateOrCreate(
                    ['no_identitas' => $validated['no_identitas']],
                    [
                        'nama' => $validated['nama'],
                        'no_hp' => $validated['no_hp'],
                        'alamat' => $validated['alamat'] ?? null,
                    ]
                );
            }

            $defaultPetugas = Petugas::first();
            $idPetugas = $defaultPetugas ? $defaultPetugas->id_petugas : null;

            $penyewaan = Penyewaan::create([
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'id_petugas' => $idPetugas,
                'tgl_sewa' => $validated['tgl_sewa'],
                'tgl_kembali_rencana' => $validated['tgl_kembali_rencana'],
                'tgl_kembali_aktual' => null,
                'status' => 'Berjalan',
                'total_biaya' => 0,
            ]);

            $totalBiaya = 0;

            foreach ($validated['items'] as $item) {
                $alat = Alat::lockForUpdate()->findOrFail($item['id_alat']);

                if ($alat->stok < $item['jumlah']) {
                    throw new \Exception("Stok alat '{$alat->nama_alat}' tidak mencukupi (Tersisa: {$alat->stok}).");
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

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permintaan penyewaan Anda berhasil dibuat dengan nomor transaksi #'.$penyewaan->id_sewa.'!',
                    'id_sewa' => $penyewaan->id_sewa,
                    'redirect_url' => route('public.sewa.sukses', $penyewaan->id_sewa),
                    'token_url' => route('public.sewa.midtrans.token', $penyewaan->id_sewa),
                    'confirm_url' => route('public.sewa.midtrans.confirm', $penyewaan->id_sewa),
                    'skema_bayar' => request('skema_bayar', 'penuh'),
                    'total_biaya' => $totalBiaya,
                ]);
            }

            return redirect()->route('public.sewa.sukses', $penyewaan->id_sewa)
                ->with('auto_midtrans', true)
                ->with('skema_bayar', request('skema_bayar', 'penuh'))
                ->with('success', 'Permintaan penyewaan Anda berhasil dibuat dengan nomor transaksi #'.$penyewaan->id_sewa.'!');
        });
    }

    public function sewaSukses($id)
    {
        $sewa = Penyewaan::with(['pelanggan', 'details.alat', 'pembayaran'])->findOrFail($id);

        return view('public.sewa_sukses', compact('sewa'));
    }
}
