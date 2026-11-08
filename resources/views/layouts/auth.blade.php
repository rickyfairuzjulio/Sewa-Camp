<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#101010">
    <title>@yield('title', 'Akun - CampSewa')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --camp-primary: #10384c;
            --camp-secondary: #1c5663;
            --camp-light: #61e36f;
            --camp-muted: #718087;
        }

        body {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            color: #202a30;
            background: #f1f4f4;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .auth-shell {
            display: grid;
            width: min(100%, 1060px);
            min-height: 590px;
            overflow: hidden;
            border: 1px solid rgba(16, 56, 76, 0.09);
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 24px 70px rgba(13, 36, 47, 0.16);
            grid-template-columns: 1fr 1fr;
        }

        .auth-aside {
            position: relative;
            display: flex;
            min-height: 100%;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 36px 54px;
            color: #ffffff;
            background:
                radial-gradient(ellipse at 10% 100%, rgba(97, 227, 111, 0.2), transparent 46%),
                radial-gradient(ellipse at 100% 0%, rgba(97, 227, 111, 0.14), transparent 45%),
                linear-gradient(145deg, #10384c 0%, #1c5663 58%, #28717b 100%);
        }

        .auth-aside::before,
        .auth-aside::after {
            position: absolute;
            z-index: 1;
            pointer-events: none;
            content: '';
        }

        .auth-aside::before {
            inset: auto auto -145px -116px;
            width: 360px;
            height: 360px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 50%;
            box-shadow:
                0 0 0 22px rgba(255, 255, 255, 0.035),
                0 0 0 48px rgba(255, 255, 255, 0.035);
        }

        .auth-aside::after {
            inset: 0 -1px 0 auto;
            width: 48px;
            background: radial-gradient(circle at 48px 29px, #ffffff 28px, transparent 29px) 0 0 / 48px 58px repeat-y;
        }

        .auth-brand {
            display: inline-flex;
            position: relative;
            z-index: 2;
            align-self: flex-start;
            width: fit-content;
        }

        .auth-brand img {
            display: block;
            width: 132px;
            height: auto;
        }

        .auth-aside-copy {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 390px;
            margin: auto 0;
            text-align: center;
        }

        .auth-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            color: #d5f5ff;
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .auth-aside h1 {
            margin-bottom: 14px;
            font-size: clamp(2rem, 3.2vw, 2.65rem);
            font-weight: 800;
            letter-spacing: -0.055em;
            line-height: 1.12;
        }

        .auth-aside p {
            margin-bottom: 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            line-height: 1.75;
        }

        .auth-aside-note {
            display: flex;
            position: relative;
            z-index: 2;
            align-items: center;
            gap: 9px;
            align-self: flex-start;
            margin-top: 24px;
            color: rgba(255, 255, 255, 0.82);
            font-size: 0.75rem;
            text-align: left;
        }

        .auth-aside-note i {
            color: var(--camp-light);
            font-size: 1rem;
        }

        .auth-main {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 56px clamp(36px, 6vw, 78px);
        }

        .auth-content {
            width: 100%;
            max-width: 380px;
        }

        .auth-kicker {
            margin-bottom: 9px;
            color: var(--camp-secondary);
            font-size: 0.74rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .auth-title {
            margin-bottom: 8px;
            color: #15252d;
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .auth-intro {
            margin-bottom: 30px;
            color: var(--camp-muted);
            font-size: 0.86rem;
            line-height: 1.65;
        }

        .auth-alert {
            border: 0;
            border-radius: 10px;
            font-size: 0.8rem;
        }

        .auth-label {
            margin-bottom: 8px;
            color: #35474f;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .auth-input-group {
            min-height: 43px;
            border-bottom: 1px solid #dfe7ea;
            transition: border-color 0.2s ease;
        }

        .auth-input-group .input-group-text {
            padding: 8px 10px 8px 2px;
            color: #8a9ba3;
            border: 0;
            background: transparent;
        }

        .auth-input-group .form-control {
            min-height: 42px;
            padding: 9px 8px;
            color: #25343b;
            border: 0;
            background: transparent;
            font-size: 0.83rem;
            box-shadow: none;
        }

        .auth-input-group .form-control::placeholder {
            color: #a8b2b7;
        }

        .auth-input-group:focus-within {
            border-color: var(--camp-secondary);
        }

        .auth-input-group:focus-within .input-group-text {
            color: var(--camp-secondary);
        }

        .auth-password-toggle {
            min-width: 40px;
            color: #82939a;
            border: 0;
            background: transparent;
        }

        .auth-password-toggle:hover {
            color: var(--camp-secondary);
            background: transparent;
        }

        .auth-password-group .form-control {
            border-radius: 0;
        }

        .auth-input-group:has(.form-control.is-invalid) {
            border-color: #dc3545;
        }

        .auth-checkbox {
            color: #68777e;
            font-size: 0.77rem;
        }

        .auth-checkbox .form-check-input:checked {
            border-color: var(--camp-primary);
            background-color: var(--camp-primary);
        }

        .auth-checkbox .form-check-input:focus {
            border-color: var(--camp-secondary);
            box-shadow: 0 0 0 0.2rem rgba(97, 227, 111, 0.2);
        }

        .auth-submit {
            display: flex;
            min-height: 49px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            border-radius: 999px;
            color: #092a16;
            background: var(--camp-light);
            font-size: 0.86rem;
            font-weight: 800;
            box-shadow: 0 8px 18px rgba(97, 227, 111, 0.2);
            transition: box-shadow 0.2s ease, transform 0.2s ease, background-color 0.2s ease;
        }

        .auth-submit:hover {
            color: #092a16;
            background: #43ca55;
            box-shadow: 0 10px 22px rgba(97, 227, 111, 0.28);
            transform: translateY(-2px);
        }

        .auth-home-link {
            color: var(--camp-muted);
            font-size: 0.77rem;
            text-decoration: none;
        }

        .auth-home-link:hover,
        .auth-content a {
            color: var(--camp-primary);
        }

        @media (max-width: 991.98px) {
            .auth-aside {
                padding: 28px 32px;
            }
            .auth-main {
                padding: 38px 32px;
            }
        }

        @media (max-width: 767.98px) {
            body {
                align-items: flex-start;
                padding: 16px;
            }

            .auth-shell {
                min-height: 0;
                border-radius: 17px;
                grid-template-columns: 1fr;
            }

            .auth-aside {
                min-height: 275px;
                gap: 20px;
                padding: 22px 24px;
                background-position: center;
            }

            .auth-aside::after {
                display: none;
            }

            .auth-brand {
                align-self: center;
            }

            .auth-brand img {
                width: 108px;
            }

            .auth-aside-copy {
                max-width: 440px;
                margin: auto 0 0;
            }

            .auth-eyebrow {
                margin-bottom: 7px;
                font-size: 0.65rem;
            }

            .auth-aside h1 {
                margin-bottom: 7px;
                font-size: 1.55rem;
            }

            .auth-aside p {
                font-size: 0.77rem;
            }

            .auth-aside-note {
                display: flex;
                align-self: center;
                margin-top: 0;
                font-size: 0.68rem;
            }

            .auth-main {
                padding: 30px 24px 34px;
            }

            .auth-title {
                font-size: 1.65rem;
            }

            .auth-intro {
                margin-bottom: 23px;
            }
        }

        @media (max-width: 380px) {
            body {
                padding: 10px;
            }

            .auth-aside {
                min-height: 260px;
            }

            .auth-main {
                padding-right: 18px;
                padding-left: 18px;
            }
        }
    </style>
</head>
<body>
    <main class="auth-shell">
        <aside class="auth-aside">
            <a class="auth-brand" href="{{ route('public.beranda') }}" aria-label="CampSewa, kembali ke beranda">
                <img src="{{ asset('images/putih.png') }}" alt="Sewa Camp">
            </a>

            <div class="auth-aside-copy">
                <span class="auth-eyebrow"><i class="bi bi-compass"></i> @yield('auth_eyebrow', 'Portal pengguna CampSewa')</span>
                <h1>@yield('auth_heading', 'Selamat datang di CampSewa')</h1>
                <p>@yield('auth_description', 'Masuk sebagai admin, petugas, atau pelanggan untuk mengakses layanan CampSewa.')</p>
            </div>
            <div class="auth-aside-note">
                <i class="bi bi-shield-check"></i>
                <span>@yield('auth_note', 'Akses dashboard tersedia untuk semua role.')</span>
            </div>
        </aside>

        <section class="auth-main" aria-labelledby="auth-title">
            <div class="auth-content">
                <p class="auth-kicker">Portal CampSewa</p>
                <h2 class="auth-title" id="auth-title">@yield('auth_title')</h2>
                <p class="auth-intro">@yield('auth_intro')</p>
                @yield('auth_content')
            </div>
        </section>
    </main>
    @yield('auth_scripts')
</body>
</html>
