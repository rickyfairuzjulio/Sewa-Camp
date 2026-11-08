<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\KategoriAlat;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriAlat::withCount('alat')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori_alat,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah terdaftar.',
        ]);

        KategoriAlat::create($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriAlat::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:50|unique:kategori_alat,nama_kategori,' . $id . ',id_kategori',
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')->with('success', 'Nama kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriAlat::findOrFail($id);

        if (Alat::where('id_kategori', $id)->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki alat camping terkait.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
