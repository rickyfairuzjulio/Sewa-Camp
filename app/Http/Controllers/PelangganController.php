<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Penyewaan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::withCount('penyewaan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                    ->orWhere('no_hp', 'like', "%{$q}%")
                    ->orWhere('no_identitas', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status_verifikasi')) {
            $query->where('status_verifikasi', $request->status_verifikasi);
        }

        $pelanggans = $query->latest('id_pelanggan')->paginate(10)->withQueryString();

        return view('admin.pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string|max:200',
            'no_identitas' => 'required|string|max:20|unique:pelanggan,no_identitas',
        ], [
            'nama.required' => 'Nama pelanggan wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_identitas.required' => 'Nomor Identitas wajib diisi.',
            'no_identitas.unique' => 'Nomor Identitas sudah terdaftar pada sistem.',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with(['user', 'penyewaan' => function ($q) {
            $q->latest('id_sewa');
        }, 'penyewaan.details.alat', 'penyewaan.pembayaran'])->findOrFail($id);

        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    public function verify(Pelanggan $pelanggan): RedirectResponse
    {
        abort_unless(auth()->user()?->isAdmin(), 403, 'Hanya administrator yang dapat memverifikasi akun pelanggan.');

        if ($pelanggan->isBlocked()) {
            return back()->with('error', 'Pelanggan yang diblokir tidak dapat diverifikasi.');
        }

        $pelanggan->update(['status_verifikasi' => 'terverifikasi']);

        return back()->with('success', 'Status Member & identitas pelanggan '.$pelanggan->nama.' berhasil diverifikasi.');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string|max:200',
            'no_identitas' => 'required|string|max:20|unique:pelanggan,no_identitas,' . $id . ',id_pelanggan',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        if (Penyewaan::where('id_pelanggan', $id)->exists()) {
            return back()->with('error', 'Pelanggan tidak dapat dihapus karena memiliki riwayat transaksi penyewaan.');
        }

        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
