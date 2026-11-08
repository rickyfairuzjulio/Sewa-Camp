<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }

        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if (! $user instanceof User) {
            Auth::logout();
            abort(403, 'Akun ini tidak memiliki role yang valid.');
        }

        return $this->redirectToDashboard($user)
            ->with('success', 'Selamat datang kembali, '.$user->name.' ('.ucfirst($user->role).')!');
    }

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }

        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'no_hp' => ['required', 'string', 'max:15'],
            'alamat' => ['nullable', 'string', 'max:200'],
            'no_identitas' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.unique' => 'Email sudah terdaftar. Silakan masuk menggunakan akun Anda.',
            'no_identitas.unique' => 'Nomor identitas sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = DB::transaction(function () use ($validated): User {
            $pelanggan = Pelanggan::where('no_identitas', $validated['no_identitas'])
                ->lockForUpdate()
                ->first();

            if ($pelanggan && ($pelanggan->user_id !== null || $pelanggan->no_hp !== $validated['no_hp'])) {
                throw ValidationException::withMessages([
                    'no_identitas' => 'Nomor identitas dan nomor HP tidak cocok atau profil sudah memiliki akun.',
                ]);
            }

            $user = User::create([
                'name' => $pelanggan?->nama ?? $validated['nama'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'pelanggan',
                'no_hp' => $pelanggan?->no_hp ?? $validated['no_hp'],
            ]);

            if ($pelanggan) {
                $pelanggan->update([
                    'user_id' => $user->id,
                    'status_verifikasi' => 'belum_verifikasi',
                ]);
            } else {
                Pelanggan::create([
                    'user_id' => $user->id,
                    'nama' => $validated['nama'],
                    'no_hp' => $validated['no_hp'],
                    'alamat' => $validated['alamat'] ?? null,
                    'no_identitas' => $validated['no_identitas'],
                    'status_verifikasi' => 'belum_verifikasi',
                ]);
            }

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectToDashboard($user)
            ->with('success', 'Akun berhasil dibuat. Anda dapat menggunakan dashboard sambil menunggu verifikasi data pelanggan.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    private function redirectToDashboard(User $user): RedirectResponse
    {
        $route = match ($user->role) {
            'admin' => 'admin.dashboard',
            'petugas' => 'petugas.dashboard',
            'pelanggan' => 'pelanggan.dashboard',
            default => abort(403, 'Akun ini tidak memiliki role yang valid.'),
        };

        if ($user->role === 'pelanggan') {
            return redirect()->intended(route($route));
        }

        return redirect()->route($route);
    }
}
