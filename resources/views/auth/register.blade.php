@extends('layouts.auth')

@section('title', 'Daftar Pelanggan - CampSewa')
@section('auth_eyebrow', 'Akun pelanggan')
@section('auth_heading', 'Mulai petualangan bersama CampSewa')
@section('auth_description', 'Buat akun untuk mengajukan penyewaan dan mengakses dashboard pelanggan.')
@section('auth_note', 'Lengkapi data diri untuk membuat akun pelanggan.')
@section('auth_title', 'Buat akun CampSewa')
@section('auth_intro', 'Isi data diri Anda untuk mulai menggunakan layanan CampSewa.')

@section('auth_content')
    @if($errors->any())
        <div class="alert alert-danger auth-alert" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label auth-label">Nama lengkap</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-person"></i></span>
                <input id="nama" name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" maxlength="100" autocomplete="name" placeholder="Nama lengkap" required autofocus>
            </div>
            @error('nama')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label auth-label">Alamat email</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-envelope"></i></span>
                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" maxlength="255" autocomplete="email" placeholder="nama@campsewa.com" required>
            </div>
            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label auth-label">Nomor HP / WhatsApp</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-telephone"></i></span>
                <input id="no_hp" name="no_hp" type="tel" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" maxlength="15" autocomplete="tel" placeholder="Nomor HP / WhatsApp" required>
            </div>
            @error('no_hp')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label auth-label">Alamat <span class="fw-normal text-secondary">(opsional)</span></label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-geo-alt"></i></span>
                <input id="alamat" name="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat') }}" maxlength="200" autocomplete="street-address" placeholder="Alamat Anda">
            </div>
            @error('alamat')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="no_identitas" class="form-label auth-label">Nomor identitas (KTP/KTM/SIM)</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-card-text"></i></span>
                <input id="no_identitas" name="no_identitas" type="text" class="form-control @error('no_identitas') is-invalid @enderror" value="{{ old('no_identitas') }}" maxlength="20" placeholder="Nomor identitas" required>
            </div>
            @error('no_identitas')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label auth-label">Password</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-lock"></i></span>
                <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" minlength="8" placeholder="Minimal 8 karakter" required>
            </div>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label auth-label">Konfirmasi password</label>
            <div class="input-group auth-input-group">
                <span class="input-group-text" aria-hidden="true"><i class="bi bi-lock-fill"></i></span>
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" minlength="8" placeholder="Ulangi password" required>
            </div>
        </div>

        <button type="submit" class="btn auth-submit w-100">
            <i class="bi bi-person-plus"></i> Daftar dan buka dashboard
        </button>
    </form>

    <p class="text-center small text-secondary mt-4 mb-0">
        Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Masuk</a>.
    </p>
@endsection
