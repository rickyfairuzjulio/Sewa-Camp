@extends('layouts.auth')

@section('title', 'Masuk - CampSewa')
@section('auth_title', 'Masuk ke akun Anda')
@section('auth_intro', 'Gunakan email dan password akun Anda.')

@section('auth_content')
    @if(session('success'))
        <div class="alert alert-success auth-alert" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger auth-alert" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger auth-alert" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label auth-label">Alamat email</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-envelope"></i></span>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="nama@campsewa.com"
                    autocomplete="username"
                    required
                    autofocus
                >
            </div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label auth-label">Password</label>
            <div class="input-group auth-input-group auth-password-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-lock"></i></span>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
                <button class="btn auth-password-toggle" type="button" id="toggle-password" aria-label="Tampilkan password" aria-pressed="false">
                    <i class="bi bi-eye" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div class="form-check auth-checkbox">
                <input type="checkbox" name="remember" class="form-check-input" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <a href="{{ route('public.beranda') }}" class="auth-home-link">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke beranda
            </a>
        </div>

        <button type="submit" class="btn auth-submit w-100">
            <i class="bi bi-box-arrow-in-right"></i> Masuk ke sistem
        </button>
    </form>

    <p class="text-center small text-secondary mt-4 mb-0">
        Pelanggan belum punya akun?
        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Daftar di sini</a>.
    </p>
@endsection

@section('auth_scripts')
    <script>
        const passwordInput = document.getElementById('password');
        const passwordToggle = document.getElementById('toggle-password');

        passwordToggle.addEventListener('click', () => {
            const isPasswordHidden = passwordInput.type === 'password';

            passwordInput.type = isPasswordHidden ? 'text' : 'password';
            passwordToggle.setAttribute('aria-pressed', String(isPasswordHidden));
            passwordToggle.setAttribute('aria-label', isPasswordHidden ? 'Sembunyikan password' : 'Tampilkan password');
            passwordToggle.querySelector('i').className = isPasswordHidden ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>
@endsection
