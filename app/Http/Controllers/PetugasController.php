<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = Petugas::withCount('penyewaan');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where('nama_petugas', 'like', "%{$q}%")
                  ->orWhere('username', 'like', "%{$q}%")
                  ->orWhere('no_hp', 'like', "%{$q}%");
        }

        $petugasList = $query->latest('id_petugas')->paginate(10)->withQueryString();

        return view('admin.petugas.index', compact('petugasList'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_petugas' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'username' => 'required|string|max:30|unique:petugas,username|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'username.regex' => 'Username hanya boleh berisi huruf, angka, dan underscore.',
            'username.unique' => 'Username sudah digunakan.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        DB::transaction(function () use ($validated) {
            Petugas::create([
                'nama_petugas' => $validated['nama_petugas'],
                'no_hp' => $validated['no_hp'] ?? null,
                'username' => $validated['username'],
            ]);

            User::create([
                'name' => $validated['nama_petugas'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'petugas',
            ]);
        });

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas baru beserta akun login berhasil dibuat.');
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        $user = User::where('email', $petugas->username . '@campsewa.test')
                    ->orWhere('name', $petugas->nama_petugas)
                    ->first();

        return view('admin.petugas.edit', compact('petugas', 'user'));
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);

        $validated = $request->validate([
            'nama_petugas' => 'required|string|max:100',
            'no_hp' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($validated, $petugas) {
            $petugas->update([
                'nama_petugas' => $validated['nama_petugas'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);

            if (!empty($validated['password'])) {
                $user = User::where('email', $petugas->username . '@campsewa.test')
                            ->orWhere('name', $petugas->nama_petugas)
                            ->first();
                if ($user) {
                    $user->update(['password' => Hash::make($validated['password'])]);
                }
            }
        });

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);

        if (Penyewaan::where('id_petugas', $id)->exists()) {
            return back()->with('error', 'Petugas tidak dapat dihapus karena tercatat dalam riwayat transaksi penyewaan.');
        }

        $user = User::where('email', $petugas->username . '@campsewa.test')
                    ->orWhere('name', $petugas->nama_petugas)
                    ->first();
        if ($user) {
            $user->delete();
        }

        $petugas->delete();

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil dihapus.');
    }
}
