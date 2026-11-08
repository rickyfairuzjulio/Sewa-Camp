<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\DetailPenyewaan;
use App\Models\KategoriAlat;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function adminDashboard(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $stats = [
            'total_pendapatan' => Pembayaran::sum('jumlah_bayar'),
            'total_sewa' => Penyewaan::count(),
            'sewa_berjalan' => Penyewaan::where('status', 'Berjalan')->count(),
            'sewa_selesai' => Penyewaan::where('status', 'Selesai')->count(),
            'sewa_terlambat' => Penyewaan::where('status', 'Berjalan')
                ->where('tgl_kembali_rencana', '<', $today)
                ->count(),
            'total_alat' => Alat::count(),
            'total_stok' => Alat::sum('stok'),
            'total_pelanggan' => Pelanggan::count(),
            'total_petugas' => Petugas::count(),
        ];

        $kategoris = KategoriAlat::withCount('alat')->orderBy('nama_kategori')->get();

        $alatQuery = Alat::with('kategori');

        if ($request->filled('q')) {
            $q = $request->q;
            $alatQuery->where(function ($sub) use ($q) {
                $sub->where('nama_alat', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori')) {
            $alatQuery->where('id_kategori', $request->kategori);
        }

        if ($request->filled('kondisi')) {
            $alatQuery->where('kondisi', $request->kondisi);
        }

        if ($request->filled('stok_status')) {
            if ($request->stok_status === 'tersedia') {
                $alatQuery->where('stok', '>', 0);
            } elseif ($request->stok_status === 'menipis') {
                $alatQuery->whereBetween('stok', [1, 6]);
            } elseif ($request->stok_status === 'habis') {
                $alatQuery->where('stok', '<=', 0);
            }
        }

        $priceRange = $request->get('price_range', 'all');
        if ($priceRange === 'under_25k') {
            $alatQuery->where('harga_sewa_per_hari', '<', 25000);
        } elseif ($priceRange === '25k_50k') {
            $alatQuery->whereBetween('harga_sewa_per_hari', [25000, 50000]);
        } elseif ($priceRange === '50k_75k') {
            $alatQuery->whereBetween('harga_sewa_per_hari', [50001, 75000]);
        } elseif ($priceRange === '75k_100k') {
            $alatQuery->whereBetween('harga_sewa_per_hari', [75001, 100000]);
        } elseif ($priceRange === 'above_100k') {
            $alatQuery->where('harga_sewa_per_hari', '>', 100000);
        }

        if ($request->filled('min_price')) {
            $alatQuery->where('harga_sewa_per_hari', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price') && (int) $request->max_price > 0) {
            $alatQuery->where('harga_sewa_per_hari', '<=', (int) $request->max_price);
        }

        $katalogAlat = $alatQuery->latest('id_alat')->get();

        $priceCounts = [
            'all' => Alat::count(),
            'under_25k' => Alat::where('harga_sewa_per_hari', '<', 25000)->count(),
            '25k_50k' => Alat::whereBetween('harga_sewa_per_hari', [25000, 50000])->count(),
            '50k_75k' => Alat::whereBetween('harga_sewa_per_hari', [50001, 75000])->count(),
            '75k_100k' => Alat::whereBetween('harga_sewa_per_hari', [75001, 100000])->count(),
            'above_100k' => Alat::where('harga_sewa_per_hari', '>', 100000)->count(),
        ];

        $stokMenipis = Alat::with('kategori')
            ->where('stok', '<', 7)
            ->orderBy('stok')
            ->get();

        $alatTerlaris = DetailPenyewaan::select('id_alat', DB::raw('SUM(jumlah) as total_disewa'))
            ->groupBy('id_alat')
            ->orderByDesc('total_disewa')
            ->with('alat.kategori')
            ->take(5)
            ->get();

        $transaksiTerbaru = Penyewaan::with(['pelanggan', 'petugas'])
            ->latest('id_sewa')
            ->take(6)
            ->get();

        $monthExpression = DB::getDriverName() === 'sqlite'
            ? "strftime('%Y-%m', tgl_bayar)"
            : 'DATE_FORMAT(tgl_bayar, "%Y-%m")';

        $pendapatanBulanan = Pembayaran::select(
            DB::raw($monthExpression.' as bulan'),
            DB::raw('SUM(jumlah_bayar) as total')
        )
            ->groupBy('bulan')
            ->orderBy('bulan', 'desc')
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'kategoris',
            'katalogAlat',
            'priceCounts',
            'stokMenipis',
            'alatTerlaris',
            'transaksiTerbaru',
            'pendapatanBulanan'
        ));
    }

    public function petugasDashboard()
    {
        $today = Carbon::today()->toDateString();

        $stats = [
            'sewa_berjalan' => Penyewaan::where('status', 'Berjalan')->count(),
            'perlu_kembali_hari_ini' => Penyewaan::where('status', 'Berjalan')
                ->whereDate('tgl_kembali_rencana', $today)
                ->count(),
            'terlambat' => Penyewaan::where('status', 'Berjalan')
                ->where('tgl_kembali_rencana', '<', $today)
                ->count(),
            'total_alat' => Alat::count(),
        ];

        $perluKembali = Penyewaan::with(['pelanggan', 'details.alat'])
            ->where('status', 'Berjalan')
            ->orderBy('tgl_kembali_rencana', 'asc')
            ->take(10)
            ->get();

        return view('petugas.dashboard', compact('stats', 'perluKembali'));
    }

    public function pelangganDashboard()
    {
        $user = auth()->user();
        $pelanggan = $user && $user->pelanggan ? $user->pelanggan : null;
        $isVerified = $pelanggan?->status_verifikasi === 'terverifikasi';

        $stats = [
            'total_sewa' => $pelanggan ? Penyewaan::where('id_pelanggan', $pelanggan->id_pelanggan)->count() : 0,
            'sewa_berjalan' => $pelanggan ? Penyewaan::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('status', 'Berjalan')->count() : 0,
            'sewa_selesai' => $isVerified ? Penyewaan::where('id_pelanggan', $pelanggan->id_pelanggan)
                ->where('status', 'Selesai')->count() : 0,
            'total_pembayaran' => $pelanggan ? Pembayaran::whereHas('penyewaan', function ($query) use ($pelanggan) {
                $query->where('id_pelanggan', $pelanggan->id_pelanggan);
            })->sum('jumlah_bayar') : 0,
        ];

        $riwayatSewa = $pelanggan
            ? Penyewaan::with(['details.alat', 'pembayaran'])
                ->where('id_pelanggan', $pelanggan->id_pelanggan)
                ->when(! $isVerified, fn ($query) => $query->where('status', '!=', 'Selesai'))
                ->latest('id_sewa')
                ->get()
            : collect();

        $profil = $pelanggan ?? new \stdClass;

        return view('pelanggan.dashboard', compact('stats', 'riwayatSewa', 'profil'));
    }

    public function updatePelangganProfil(Request $request)
    {
        $user = $request->user();
        $pelanggan = $user?->pelanggan;

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'no_hp' => ['required', 'string', 'max:15'],
            'alamat' => ['nullable', 'string', 'max:200'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        $user->update([
            'name' => $validated['nama'],
            'no_hp' => $validated['no_hp'],
            ...(! empty($validated['password']) ? ['password' => Hash::make($validated['password'])] : []),
        ]);

        if ($pelanggan) {
            $pelanggan->update([
                'nama' => $validated['nama'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'] ?? $pelanggan->alamat,
            ]);
        }

        return redirect()->route('pelanggan.dashboard', ['tab' => 'pengaturan'])
            ->with('success', 'Pengaturan akun Anda berhasil disimpan.');
    }

    public function upgradeMember(Request $request)
    {
        $user = $request->user();
        $pelanggan = $user?->pelanggan;

        if ($pelanggan && $pelanggan->status_verifikasi === 'belum_verifikasi') {
            return redirect()->route('pelanggan.dashboard', ['tab' => 'member'])
                ->with('success', 'Permintaan Upgrade & Verifikasi Member Prioritas telah dikirim ke Admin Store.');
        }

        return redirect()->route('pelanggan.dashboard', ['tab' => 'member'])
            ->with('success', 'Status Member Outdoor Anda sudah aktif!');
    }

    public function batalSewaPelanggan(Request $request, Penyewaan $penyewaan)
    {
        $user = $request->user();
        $pelanggan = $user?->pelanggan;

        if (! $pelanggan || (int) $penyewaan->id_pelanggan !== (int) $pelanggan->id_pelanggan) {
            abort(403, 'Anda tidak memiliki akses ke transaksi ini.');
        }

        if ($penyewaan->status !== 'Berjalan') {
            return back()->with('error', 'Hanya pesanan yang masih berjalan yang dapat dibatalkan.');
        }

        if ($penyewaan->pembayaran()->count() > 0) {
            return back()->with('error', 'Pesanan yang sudah memiliki pembayaran tidak dapat dibatalkan mandiri. Silakan hubungi admin store.');
        }

        DB::transaction(function () use ($penyewaan) {
            $penyewaan->load('details.alat');

            foreach ($penyewaan->details as $detail) {
                if ($detail->alat) {
                    $detail->alat->increment('stok', $detail->jumlah);
                }
            }

            $penyewaan->update(['status' => 'Dibatalkan']);
        });

        return back()->with('success', 'Pesanan sewa #'.$penyewaan->id_sewa.' berhasil dibatalkan dan stok alat telah dikembalikan.');
    }
}
