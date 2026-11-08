<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\DetailPenyewaan;
use App\Models\KategoriAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AlatController extends Controller
{
    public function index(Request $request)
    {
        $kategori = KategoriAlat::withCount('alat')->get();
        $query = Alat::with('kategori');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('nama_alat', 'like', '%'.$q.'%')
                    ->orWhere('deskripsi', 'like', '%'.$q.'%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('stok_status')) {
            if ($request->stok_status === 'tersedia') {
                $query->where('stok', '>', 0);
            } elseif ($request->stok_status === 'menipis') {
                $query->whereBetween('stok', [1, 6]);
            } elseif ($request->stok_status === 'habis') {
                $query->where('stok', '<=', 0);
            }
        }

        $priceRange = $request->get('price_range', 'all');
        if ($priceRange === 'under_25k') {
            $query->where('harga_sewa_per_hari', '<', 25000);
        } elseif ($priceRange === '25k_50k') {
            $query->whereBetween('harga_sewa_per_hari', [25000, 50000]);
        } elseif ($priceRange === '50k_75k') {
            $query->whereBetween('harga_sewa_per_hari', [50001, 75000]);
        } elseif ($priceRange === '75k_100k') {
            $query->whereBetween('harga_sewa_per_hari', [75001, 100000]);
        } elseif ($priceRange === 'above_100k') {
            $query->where('harga_sewa_per_hari', '>', 100000);
        }

        if ($request->filled('min_price')) {
            $query->where('harga_sewa_per_hari', '>=', (int) $request->min_price);
        }

        if ($request->filled('max_price') && (int) $request->max_price > 0) {
            $query->where('harga_sewa_per_hari', '<=', (int) $request->max_price);
        }

        $priceCounts = [
            'all' => Alat::count(),
            'under_25k' => Alat::where('harga_sewa_per_hari', '<', 25000)->count(),
            '25k_50k' => Alat::whereBetween('harga_sewa_per_hari', [25000, 50000])->count(),
            '50k_75k' => Alat::whereBetween('harga_sewa_per_hari', [50001, 75000])->count(),
            '75k_100k' => Alat::whereBetween('harga_sewa_per_hari', [75001, 100000])->count(),
            'above_100k' => Alat::where('harga_sewa_per_hari', '>', 100000)->count(),
        ];

        $alats = $query->latest('id_alat')->paginate(12)->withQueryString();

        return view('admin.alat.index', compact('alats', 'kategori', 'priceCounts'));
    }

    public function create()
    {
        $kategori = KategoriAlat::all();
        return view('admin.alat.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori_alat,id_kategori',
            'harga_sewa_per_hari' => 'required|numeric|min:1000',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:30',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ], [
            'nama_alat.required' => 'Nama alat wajib diisi.',
            'id_kategori.required' => 'Kategori alat wajib dipilih.',
            'harga_sewa_per_hari.required' => 'Harga sewa per hari wajib diisi.',
            'stok.required' => 'Jumlah stok wajib diisi.',
            'gambar.image' => 'File gambar harus berupa file gambar valid.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('uploads/alat');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);
            $validated['gambar'] = $filename;
        }

        Alat::create($validated);

        return redirect()->route('admin.alat.index')->with('success', 'Alat camping berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        $kategori = KategoriAlat::all();
        return view('admin.alat.edit', compact('alat', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $validated = $request->validate([
            'nama_alat' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori_alat,id_kategori',
            'harga_sewa_per_hari' => 'required|numeric|min:1000',
            'stok' => 'required|integer|min:0',
            'kondisi' => 'required|string|max:30',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('uploads/alat');
            if (!File::isDirectory($destination)) {
                File::makeDirectory($destination, 0755, true, true);
            }
            $file->move($destination, $filename);

            // Hapus gambar lama jika ada dan bukan gambar bawaan seeder
            if ($alat->gambar && File::exists(public_path('uploads/alat/' . $alat->gambar)) && !str_starts_with($alat->gambar, 'tenda_') && !str_starts_with($alat->gambar, 'carrier_')) {
                File::delete(public_path('uploads/alat/' . $alat->gambar));
            }

            $validated['gambar'] = $filename;
        }

        $alat->update($validated);

        return redirect()->route('admin.alat.index')->with('success', 'Data alat camping berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        // Periksa apakah alat memiliki riwayat transaksi penyewaan
        $inUse = DetailPenyewaan::where('id_alat', $id)->exists();
        if ($inUse) {
            return back()->with('error', 'Alat ini tidak dapat dihapus karena sudah tercatat dalam riwayat transaksi penyewaan.');
        }

        if ($alat->gambar && File::exists(public_path('uploads/alat/' . $alat->gambar))) {
            File::delete(public_path('uploads/alat/' . $alat->gambar));
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')->with('success', 'Alat camping berhasil dihapus.');
    }
}
