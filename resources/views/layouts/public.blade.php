<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#101010">
    <title>@yield('title', 'CampSewa Adventure - Sewa Alat Camping & Outdoor Semarang')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --foresta-lime: #16a34a; /* Warna hijau agak tua / forest emerald green */
            --foresta-lime-hover: #15803d;
            --foresta-lime-soft: #f0fdf4;
            --foresta-dark: #101010;
            --foresta-black: #0a0a0a;
            --foresta-gray-100: #f2f4f4;
            --foresta-gray-200: #e4e6e8;
            --foresta-gray-600: #5e6267;
            --camp-primary: #101010;
            --camp-secondary: #1e2420;
            --camp-light: #16a34a;
            --camp-accent: #15803d;
            --camp-border: #e4e6e8;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: #101010;
            background: #ffffff;
            font-family: 'Urbanist', 'Plus Jakarta Sans', sans-serif;
            overflow-x: hidden;
        }

        /* =========================================================
           FORESTA HEADER & STICKY TOPBAR
           ========================================================= */
        .foresta-header {
            position: sticky;
            top: 0;
            z-index: 1030;
            background: #141716 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.35);
            transition: background-color 0.25s ease, box-shadow 0.25s ease;
        }

        .foresta-header--overlay {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            background: #141716 !important;
        }

        .foresta-header--overlay .foresta-topbar,
        .foresta-header--overlay .foresta-navbar {
            border-bottom-color: rgba(255, 255, 255, 0.1);
        }

        .foresta-header--scrolled {
            background: #141716 !important;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.5) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14) !important;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            display: none;
            -webkit-appearance: none;
        }

        .foresta-topbar {
            padding: 8px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.82rem;
            color: #ffffff;
        }

        .foresta-topbar a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .foresta-topbar a:hover {
            color: var(--foresta-lime);
        }

        .btn-topbar-lime {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 12px;
            border-radius: 999px;
            background: var(--foresta-lime);
            color: #ffffff !important;
            font-size: 0.76rem;
            font-weight: 800;
            text-decoration: none;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .btn-topbar-lime:hover {
            background: var(--foresta-lime-hover);
            color: #ffffff !important;
            transform: translateX(2px);
        }

        .foresta-navbar {
            padding: 13px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .foresta-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .foresta-brand img {
            height: 44px;
            width: auto;
            transform: scale(1.3);
            transform-origin: left center;
        }

        .foresta-nav-link {
            padding: 8px 18px !important;
            color: #f8fafc !important;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 999px;
            transition: color 0.2s ease, background-color 0.2s ease;
        }

        .foresta-nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.14) !important;
        }

        .foresta-nav-link.active {
            color: #ffffff !important;
            background: #16a34a !important;
            box-shadow: 0 2px 10px rgba(22, 163, 74, 0.45);
        }

        .foresta-dropdown-menu {
            min-width: 240px;
            padding: 10px;
            border: 1px solid #e4e6e8;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.16);
        }

        .foresta-dropdown-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 14px;
            border-radius: 10px;
            color: #101010;
            font-size: 0.9rem;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 0.18s ease, color 0.18s ease;
        }

        .foresta-dropdown-item:hover {
            background: var(--foresta-gray-100);
            color: #000000;
        }

        .btn-foresta-cart {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            padding: 0;
            border: 0;
            border-radius: 12px;
            background: #ffffff;
            color: #101010;
            font-size: 1.25rem;
            text-decoration: none;
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .btn-foresta-cart:hover {
            background: #f2f4f4;
            color: #101010;
            transform: translateY(-1px);
        }

        .cart-badge-count {
            position: absolute;
            top: -5px;
            right: -5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 21px;
            height: 21px;
            padding: 0 5px;
            border-radius: 999px;
            background: #de3545;
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 800;
            border: 2px solid #ffffff;
            line-height: 1;
        }

        /* Foresta User Dropdown (matches screenshot) */
        .foresta-user-trigger {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 16px;
            border: 1px solid rgba(74, 222, 128, 0.4);
            border-radius: 999px;
            background: rgba(22, 163, 74, 0.16);
            color: #4ade80 !important;
            font-size: 0.95rem;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .foresta-user-trigger:hover,
        .foresta-user-trigger:focus {
            background: rgba(22, 163, 74, 0.3);
            color: #ffffff !important;
            border-color: rgba(74, 222, 128, 0.7);
        }

        .foresta-user-trigger::after {
            display: none !important;
        }

        .foresta-user-menu {
            min-width: 245px;
            margin-top: 12px !important;
            padding: 18px 22px;
            border: 0;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
        }

        .foresta-user-menu::before {
            content: '';
            position: absolute;
            top: -7px;
            right: 42px;
            width: 14px;
            height: 14px;
            background: #ffffff;
            transform: rotate(45deg);
        }

        .foresta-user-menu-upgrade {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0 14px;
            margin-bottom: 6px;
            border-bottom: 1px solid #f0f2f4;
            color: #202224;
            font-size: 0.96rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            text-decoration: none;
            transition: color 0.18s ease;
        }

        .foresta-user-menu-upgrade:hover {
            color: #28a745;
        }

        .foresta-user-menu-link {
            display: block;
            width: 100%;
            padding: 10px 0;
            border: 0;
            background: transparent;
            color: #26292c;
            font-size: 1.02rem;
            font-weight: 500;
            text-align: left;
            text-decoration: none;
            transition: color 0.18s ease, transform 0.18s ease;
        }

        .foresta-user-menu-link:hover {
            color: #000000;
            font-weight: 700;
            transform: translateX(3px);
        }

        /* =========================================================
           FORESTA BUTTONS & UTILITIES
           ========================================================= */
        .btn-camp-primary,
        .btn-foresta-lime {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            border: 0;
            border-radius: 999px;
            background: var(--foresta-lime);
            color: #ffffff !important;
            font-weight: 800;
            font-size: 0.94rem;
            text-decoration: none;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.22);
            transition: transform 0.2s ease, background-color 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-camp-primary i,
        .btn-foresta-lime i,
        .btn-camp-primary span,
        .btn-foresta-lime span {
            color: #ffffff !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.22);
        }

        .btn-camp-primary:hover,
        .btn-foresta-lime:hover {
            background: var(--foresta-lime-hover);
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(112, 244, 109, 0.32);
        }

        .btn-camp-primary:hover i,
        .btn-foresta-lime:hover i {
            color: #ffffff !important;
        }

        .btn-foresta-dark,
        .btn-camp-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            border: 1.5px solid #101010;
            border-radius: 999px;
            background: #101010;
            color: #ffffff !important;
            font-weight: 800;
            font-size: 0.92rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-foresta-dark:hover,
        .btn-camp-outline:hover {
            background: var(--foresta-lime);
            border-color: var(--foresta-lime);
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        .btn-foresta-dark:hover i,
        .btn-camp-outline:hover i {
            color: #ffffff !important;
        }

        .btn-foresta-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border: 1.5px solid #d7dbdf;
            border-radius: 999px;
            background: #ffffff;
            color: #101010;
            font-weight: 800;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-foresta-outline:hover {
            border-color: #101010;
            background: #101010;
            color: #ffffff;
        }

        /* =========================================================
           CAMPSEWA PRODUCT CARD (.card-journey-small)
           ========================================================= */
        .card-journey-small {
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #dfe6e3;
            border-radius: 20px;
            background: #ffffff;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(15, 36, 31, 0.04);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .card-journey-small:hover {
            transform: translateY(-6px);
            border-color: #183830;
            box-shadow: 0 18px 36px rgba(15, 36, 31, 0.12);
        }

        .card-journey-small .card-image {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            background: #f1f5f3;
            overflow: hidden;
            display: block;
        }

        .card-journey-small .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.35s ease;
        }

        .card-journey-small:hover .card-image img {
            transform: scale(1.06);
        }

        .card-journey-badge-cat {
            position: absolute;
            top: 12px;
            left: 12px;
            padding: 5px 12px;
            border-radius: 8px;
            background: rgba(15, 36, 31, 0.86);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
        }

        .card-journey-badge-stock {
            position: absolute;
            top: 12px;
            right: 12px;
            padding: 5px 11px;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 800;
        }

        .card-journey-badge-stock.ready {
            background: var(--foresta-lime);
            color: #ffffff;
        }

        .card-journey-badge-stock.empty {
            background: #fee2e2;
            color: #991b1b;
        }

        .card-journey-small .card-info {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 18px 16px 16px;
            text-align: center;
        }

        .card-journey-small .card-title a {
            color: #101010;
            font-size: 1.05rem;
            font-weight: 800;
            line-height: 1.38;
            text-decoration: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 2.85rem;
            transition: color 0.2s ease;
        }

        .card-journey-small .card-title a:hover {
            color: #2f9e2c;
        }

        .card-journey-small .card-price {
            margin-top: 6px;
            margin-bottom: 14px;
            font-size: 1.05rem;
            font-weight: 800;
            color: #101010;
        }

        .card-journey-small .card-price span {
            color: #6c7278;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .card-journey-actions {
            margin-top: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .btn-card-cart {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 8px 10px;
            border: 1.5px solid #e2e5e9;
            border-radius: 10px;
            background: #ffffff;
            color: #101010;
            font-size: 0.8rem;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-card-cart:hover {
            border-color: #101010;
            background: #101010;
            color: #ffffff;
        }

        .btn-card-sewa {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 8px 10px;
            border: 1.5px solid var(--foresta-lime);
            border-radius: 10px;
            background: var(--foresta-lime);
            color: #ffffff !important;
            font-size: 0.8rem;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-card-sewa i {
            color: #ffffff !important;
        }

        .btn-card-sewa:hover {
            background: var(--foresta-lime-hover);
            border-color: var(--foresta-lime-hover);
            color: #ffffff !important;
        }

        .btn-card-sewa:hover i {
            color: #ffffff !important;
        }

        /* =========================================================
           FORESTA INNER PAGE BANNER (.foresta-page-banner)
           ========================================================= */
        .foresta-page-banner {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            padding: 58px 28px;
            text-align: center;
            color: #ffffff;
            background:
                linear-gradient(180deg, rgba(12, 14, 13, 0.68) 0%, rgba(12, 14, 13, 0.82) 100%),
                url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=1800&q=80') center/cover no-repeat;
        }

        .foresta-banner-tag {
            display: inline-block;
            margin-bottom: 10px;
            padding: 5px 14px;
            border-radius: 999px;
            background: var(--foresta-lime);
            color: #ffffff;
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .foresta-box-sidebar {
            border: 1px solid #e4e6e8;
            border-radius: 16px;
            background: #ffffff;
            overflow: hidden;
        }

        .foresta-box-sidebar-head {
            padding: 18px 22px;
            border-bottom: 1px solid #e4e6e8;
            font-size: 1.05rem;
            font-weight: 800;
            color: #101010;
        }

        .foresta-box-sidebar-body {
            padding: 20px 22px;
        }

        .pagination {
            gap: 6px;
            margin-bottom: 0;
            flex-wrap: wrap;
        }

        .pagination .page-item .page-link {
            border-radius: 11px !important;
            border: 1px solid #e4e6e8;
            background: #ffffff;
            color: #101010;
            font-size: 0.84rem;
            font-weight: 800;
            padding: 8px 14px;
            box-shadow: none;
        }

        .pagination .page-item.active .page-link {
            background: var(--foresta-lime);
            border-color: var(--foresta-lime);
            color: #ffffff !important;
        }

        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
        }

        /* =========================================================
           FORESTA FOOTER
           ========================================================= */
        .foresta-footer {
            margin-top: auto;
            padding: 64px 0 28px;
            background: #0d0d0d;
            color: #b4b8bc;
        }

        .foresta-footer h6 {
            margin-bottom: 18px;
            color: #ffffff;
            font-size: 1rem;
            font-weight: 800;
        }

        .foresta-footer ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .foresta-footer ul li {
            margin-bottom: 10px;
        }

        .foresta-footer a {
            color: #b4b8bc;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .foresta-footer a:hover {
            color: var(--foresta-lime);
        }

        .foresta-social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff !important;
            font-size: 1rem;
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .foresta-social-btn:hover {
            background: var(--foresta-lime);
            color: #ffffff !important;
            transform: translateY(-2px);
        }

        .foresta-support-pill {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 991.98px) {
            .foresta-navbar .navbar-collapse {
                margin-top: 12px;
                padding: 16px;
                border-radius: 14px;
                background: #161817;
                border: 1px solid rgba(255, 255, 255, 0.12);
            }

            .foresta-dropdown-menu {
                background: #202321;
                border-color: rgba(255, 255, 255, 0.1);
                box-shadow: none;
            }

            .foresta-dropdown-item {
                color: #ffffff;
            }
        }

        /* Sticky Bottom App Bar for Mobile Handphone (< 768px) */
        .foresta-mobile-bottom-nav {
            display: none;
        }

        @media (max-width: 767.98px) {
            body {
                padding-bottom: 68px;
            }

            .foresta-page-banner {
                padding: 38px 18px;
                border-radius: 14px;
            }

            .foresta-footer {
                padding: 44px 0 24px;
            }

            .foresta-mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1035;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                background: rgba(16, 16, 16, 0.96);
                backdrop-filter: blur(12px);
                border-top: 1px solid rgba(255, 255, 255, 0.12);
                padding: 6px 4px calc(6px + env(safe-area-inset-bottom, 0px));
                box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.2);
            }

            .foresta-mobile-nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2px;
                color: rgba(255, 255, 255, 0.7);
                text-decoration: none;
                font-size: 0.66rem;
                font-weight: 700;
                padding: 4px 2px;
                border: 0;
                background: transparent;
            }

            .foresta-mobile-nav-item i {
                font-size: 1.15rem;
                line-height: 1;
            }

            .foresta-mobile-nav-item.active,
            .foresta-mobile-nav-item:hover {
                color: var(--foresta-lime);
            }
        }

        @media (max-width: 575.98px) {
            .card-journey-small .card-image {
                height: 165px;
            }

            .card-journey-small .card-info {
                padding: 14px;
            }

            .btn-foresta-lime,
            .btn-foresta-dark {
                padding: 11px 18px;
                font-size: 0.88rem;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    @php
        $navCategories = \Illuminate\Support\Facades\Cache::remember('nav_categories', 1800, function () {
            try {
                return \App\Models\KategoriAlat::orderBy('id_kategori')->get();
            } catch (\Throwable $e) {
                return collect();
            }
        });
        $totalAlatHeader = \Illuminate\Support\Facades\Cache::remember('nav_total_alat', 1800, function () {
            try {
                return max(1, \App\Models\Alat::count());
            } catch (\Throwable $e) {
                return 10;
            }
        });
    @endphp

    <header id="forestaHeader" class="foresta-header {{ request()->routeIs('public.beranda') ? 'foresta-header--overlay' : '' }}">
        <nav class="navbar navbar-expand-lg foresta-navbar">
            <div class="container">
                <a class="foresta-brand" href="{{ route('public.beranda') }}" aria-label="CampSewa Adventure">
                    <img src="{{ asset('images/putih.png') }}" alt="CampSewa Adventure">
                </a>

                <div class="d-flex align-items-center gap-3 order-lg-3">
                    @auth
                        <div class="dropdown">
                            <button class="foresta-user-trigger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span>{{ Str::lower(explode(' ', trim(auth()->user()->name))[0]) }}</span>
                                <i class="bi bi-chevron-down small" style="font-size: 0.8rem;"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end foresta-user-menu">
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="foresta-user-menu-upgrade">
                                        PANEL ADMIN
                                    </a>
                                    <a href="{{ route('admin.penyewaan.index') }}" class="foresta-user-menu-link">Transaksi</a>
                                    <a href="{{ route('admin.alat.index') }}" class="foresta-user-menu-link">Kelola Alat</a>
                                @elseif(auth()->user()->isPetugas())
                                    <a href="{{ route('petugas.dashboard') }}" class="foresta-user-menu-upgrade">
                                        PANEL PETUGAS
                                    </a>
                                    <a href="{{ route('admin.penyewaan.index') }}" class="foresta-user-menu-link">Transaksi</a>
                                    <a href="{{ route('admin.pengembalian.index') }}" class="foresta-user-menu-link">Pengembalian</a>
                                @else
                                    <a href="{{ route('pelanggan.dashboard', ['tab' => 'member']) }}" class="foresta-user-menu-upgrade">
                                        UPGRADE MEMBER
                                    </a>
                                    <a href="{{ route('pelanggan.dashboard') }}" class="foresta-user-menu-link">Transaksi</a>
                                    <a href="{{ route('pelanggan.dashboard', ['tab' => 'pengaturan']) }}" class="foresta-user-menu-link">Pengaturan</a>
                                @endif
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="foresta-user-menu-link">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="foresta-nav-link">Masuk</a>
                    @endauth

                    <button type="button" class="btn-foresta-cart" data-bs-toggle="offcanvas" data-bs-target="#RentalCartDrawer" aria-controls="RentalCartDrawer" title="Keranjang Sewa">
                        <i class="bi bi-cart2"></i>
                        <span id="cartCountBadge" class="cart-badge-count">0</span>
                    </button>

                    <button class="navbar-toggler border-0 text-white p-1 ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#forestaNavbarContent" aria-controls="forestaNavbarContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="bi bi-list fs-2"></i>
                    </button>
                </div>

                <div class="collapse navbar-collapse order-lg-2" id="forestaNavbarContent">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1">
                        <li class="nav-item">
                            <a class="nav-link foresta-nav-link {{ request()->routeIs('public.beranda') ? 'active' : '' }}" href="{{ route('public.beranda') }}">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link foresta-nav-link dropdown-toggle {{ request()->routeIs('public.katalog') ? 'active' : '' }}" href="{{ route('public.katalog') }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Kategori
                            </a>
                            <ul class="dropdown-menu foresta-dropdown-menu">
                                @foreach($navCategories as $navKat)
                                    <li>
                                        <a class="foresta-dropdown-item" href="{{ route('public.katalog', ['kategori' => $navKat->id_kategori]) }}">
                                            <span>{{ $navKat->nama_kategori }}</span>
                                            <i class="bi bi-chevron-right small text-muted"></i>
                                        </a>
                                    </li>
                                @endforeach
                                @if($navCategories->isNotEmpty())
                                    <li><hr class="dropdown-divider my-1"></li>
                                @endif
                                <li>
                                    <a class="foresta-dropdown-item fw-extrabold" href="{{ route('public.katalog') }}">
                                        <span>Semua Peralatan</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link foresta-nav-link {{ request()->routeIs('public.cara_sewa') ? 'active' : '' }}" href="{{ route('public.cara_sewa') }}">Cara Sewa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link foresta-nav-link {{ request()->routeIs('public.kontak') ? 'active' : '' }}" href="{{ route('public.kontak') }}">Kontak</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    @if(session('success') || session('error') || $errors->any())
        <div class="container {{ request()->routeIs('public.beranda') ? 'mt-5 pt-5 position-relative' : 'mt-3' }}" style="z-index: 20;">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 rounded-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill fs-5"></i>
                    <div class="fw-semibold">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 rounded-4 border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                    <div class="fw-semibold">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm" role="alert">
                    <h6 class="fw-bold mb-1"><i class="bi bi-x-circle me-1"></i> Terdapat kesalahan pengisian formulir:</h6>
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    @endif

    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- Offcanvas Keranjang Sewa (Foresta Adventure Cart Flow) --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="RentalCartDrawer" aria-labelledby="RentalCartDrawerLabel" style="width: min(400px, 92vw);">
        <div class="offcanvas-header border-bottom py-3 px-4">
            <h5 class="offcanvas-title fw-extrabold d-flex align-items-center gap-2" id="RentalCartDrawerLabel">
                <i class="bi bi-bag-check-fill"></i> Keranjang Sewa Gear
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-4">
            <div class="p-3 rounded-4 mb-3" style="background: #f2f4f4;">
                <div class="row g-2">
                    <div class="col-7">
                        <label class="form-label small fw-bold mb-1 text-secondary">Tgl Ambil</label>
                        <input type="date" id="drawerTglSewa" class="form-control form-control-sm fw-bold border-0" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-5">
                        <label class="form-label small fw-bold mb-1 text-secondary">Durasi</label>
                        <select id="drawerDurasi" class="form-select form-select-sm fw-bold border-0">
                            @for($d = 1; $d <= 14; $d++)
                                <option value="{{ $d }}" {{ $d === 2 ? 'selected' : '' }}>{{ $d }} Hari</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top small">
                    <span class="text-secondary">Maks. Pengembalian:</span>
                    <strong id="drawerTglKembaliText">-</strong>
                </div>
            </div>

            <div id="rentalCartItemsList" class="flex-grow-1 overflow-auto pe-1">
                <div class="text-center py-5 text-secondary">
                    <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                    <p class="fw-bold mb-1 text-dark">Keranjang sewa masih kosong</p>
                    <p class="small mb-0">Pilih peralatan dari katalog untuk mulai menyewa.</p>
                </div>
            </div>

            <div class="border-top pt-3 mt-3">
                <div class="d-flex justify-content-between align-items-center mb-1 small text-secondary">
                    <span>Subtotal / Hari</span>
                    <strong id="drawerSubtotalPerDay" class="text-dark">Rp 0</strong>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold">Estimasi Total Sewa</span>
                    <span id="drawerGrandTotal" class="fs-5 fw-extrabold text-dark">Rp 0</span>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" id="btnProceedCheckout" class="btn-foresta-lime w-100 py-3 justify-content-center">
                        Lanjut ke Formulir Sewa <i class="bi bi-arrow-right"></i>
                    </button>
                    <button type="button" id="btnClearRentalCart" class="btn btn-sm btn-link text-danger text-decoration-none fw-bold">
                        Kosongkan Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="foresta-footer">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('public.beranda') }}" class="d-inline-block mb-3">
                        <img src="{{ asset('images/putih.png') }}" alt="CampSewa Adventure" style="height: 40px; width: auto;">
                    </a>
                    <p class="small mb-3">
                        Pusat penyewaan perlengkapan camping, hiking, dan ekspedisi outdoor di Semarang dengan stok real-time dan pembayaran online Midtrans.
                    </p>
                    <div class="d-flex flex-column gap-2 small">
                        <div><i class="bi bi-geo-alt-fill me-2" style="color: var(--foresta-lime);"></i> Jl. Prof. Hamka No. 12, Ngaliyan, Kota Semarang</div>
                        <div><i class="bi bi-clock-fill me-2" style="color: var(--foresta-lime);"></i> Setiap Hari: 08.00 - 21.00 WIB</div>
                        <div><i class="bi bi-envelope-fill me-2" style="color: var(--foresta-lime);"></i> info@campsewa.com</div>
                    </div>
                </div>

                <div class="col-6 col-lg-2 col-md-6">
                    <h6>Informasi</h6>
                    <ul>
                        <li><a href="{{ route('public.cara_sewa') }}">Cara Sewa</a></li>
                        <li><a href="{{ route('public.cara_sewa') }}#syarat-ketentuan">Syarat dan Ketentuan</a></li>
                        <li><a href="{{ route('public.katalog') }}">Daftar Peralatan</a></li>
                        <li><a href="{{ route('public.sewa') }}">Formulir Penyewaan</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2 col-md-6">
                    <h6>Tentang</h6>
                    <ul>
                        <li><a href="{{ route('public.kontak') }}">Tentang CampSewa</a></li>
                        <li><a href="{{ route('public.kontak') }}">Kontak &amp; Lokasi</a></li>
                        @auth
                            <li><a href="{{ route('pelanggan.dashboard') }}">Dashboard Member</a></li>
                        @else
                            <li><a href="{{ route('login') }}">Masuk Akun</a></li>
                            <li><a href="{{ route('register') }}">Daftar Member</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h6>Layanan &amp; Pembayaran</h6>
                    <p class="small mb-3">Mendukung pembayaran instan via Midtrans (QRIS, Virtual Account, E-Wallet) maupun pembayaran di lokasi store.</p>
                    <div class="foresta-support-pill mb-3">
                        <i class="bi bi-whatsapp fs-3" style="color: var(--foresta-lime);"></i>
                        <div>
                            <div class="small text-white-50">Butuh bantuan? Hubungi kami</div>
                            <a href="tel:081234567890" class="fw-extrabold fs-6" style="color: var(--foresta-lime);">0812-3456-7890</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ route('public.kontak') }}" class="foresta-social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="{{ route('public.kontak') }}" class="foresta-social-btn" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                        <a href="{{ route('public.kontak') }}" class="foresta-social-btn" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="border-top border-secondary border-opacity-25 pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small">
                <div>&copy; {{ date('Y') }} <strong class="text-white">CampSewa Adventure</strong>. Hak cipta dilindungi.</div>
                <div>Sistem Informasi Penyewaan Alat Camping &amp; Outdoor</div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            const STORAGE_KEY = 'campsewa_rental_cart_v1';
            const SCHEDULE_KEY = 'campsewa_rental_schedule_v1';
            const SEWA_BASE_URL = @json(route('public.sewa'));
            const IS_AUTHENTICATED = @json(auth()->check());
            const LOGIN_URL = @json(route('login'));

            // Sticky header scroll effect
            const headerEl = document.getElementById('forestaHeader');
            window.addEventListener('scroll', function () {
                if (!headerEl) return;
                if (window.scrollY > 40) {
                    headerEl.classList.add('foresta-header--scrolled');
                } else {
                    headerEl.classList.remove('foresta-header--scrolled');
                }
            });

            // Klik kolom tanggal langsung membuka kalender (ikon bawaan disembunyikan)
            document.querySelectorAll('input[type="date"]').forEach(function (input) {
                input.addEventListener('click', function () {
                    if (typeof input.showPicker === 'function') {
                        try { input.showPicker(); } catch (e) {}
                    }
                });
            });

            function getCart() {
                try {
                    return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
                } catch (e) {
                    return [];
                }
            }

            function saveCart(items) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
                renderCart();
            }

            function getSchedule() {
                try {
                    const saved = JSON.parse(localStorage.getItem(SCHEDULE_KEY) || '{}');
                    return {
                        tgl_sewa: saved.tgl_sewa || new Date().toISOString().slice(0, 10),
                        durasi: parseInt(saved.durasi || 2, 10)
                    };
                } catch (e) {
                    return { tgl_sewa: new Date().toISOString().slice(0, 10), durasi: 2 };
                }
            }

            function saveSchedule(tglSewa, durasi) {
                localStorage.setItem(SCHEDULE_KEY, JSON.stringify({ tgl_sewa: tglSewa, durasi: parseInt(durasi || 2, 10) }));
            }

            function formatRupiah(num) {
                return 'Rp ' + Math.round(num || 0).toLocaleString('id-ID');
            }

            function computeReturnDate(startStr, durasiDays) {
                const d = new Date(startStr + 'T00:00:00');
                if (isNaN(d.getTime())) return '-';
                d.setDate(d.getDate() + parseInt(durasiDays || 1, 10));
                return d.toISOString().slice(0, 10);
            }

            const drawerTglSewa = document.getElementById('drawerTglSewa');
            const drawerDurasi = document.getElementById('drawerDurasi');
            const drawerTglKembaliText = document.getElementById('drawerTglKembaliText');

            function syncScheduleInputs() {
                const sched = getSchedule();
                if (drawerTglSewa && sched.tgl_sewa) drawerTglSewa.value = sched.tgl_sewa;
                if (drawerDurasi && sched.durasi) drawerDurasi.value = sched.durasi;
                if (drawerTglKembaliText && drawerTglSewa && drawerDurasi) {
                    drawerTglKembaliText.textContent = computeReturnDate(drawerTglSewa.value, drawerDurasi.value);
                }
            }

            if (drawerTglSewa && drawerDurasi) {
                drawerTglSewa.addEventListener('change', function () {
                    saveSchedule(drawerTglSewa.value, drawerDurasi.value);
                    renderCart();
                });
                drawerDurasi.addEventListener('change', function () {
                    saveSchedule(drawerTglSewa.value, drawerDurasi.value);
                    renderCart();
                });
            }

            function renderCart() {
                syncScheduleInputs();
                const items = getCart();
                const badge = document.getElementById('cartCountBadge');
                const listEl = document.getElementById('rentalCartItemsList');
                const subDayEl = document.getElementById('drawerSubtotalPerDay');
                const grandEl = document.getElementById('drawerGrandTotal');
                const durasi = drawerDurasi ? parseInt(drawerDurasi.value || 2, 10) : 2;

                const totalQty = items.reduce((acc, it) => acc + (parseInt(it.qty, 10) || 1), 0);
                if (badge) badge.textContent = totalQty;

                if (!listEl) return;

                if (items.length === 0) {
                    listEl.innerHTML = `
                        <div class="text-center py-5 text-secondary">
                            <i class="bi bi-cart-x fs-1 d-block mb-2"></i>
                            <p class="fw-bold mb-1 text-dark">Keranjang sewa masih kosong</p>
                            <p class="small mb-0">Klik tombol <strong>+ Keranjang</strong> pada kartu peralatan untuk menambahkan.</p>
                        </div>
                    `;
                    if (subDayEl) subDayEl.textContent = 'Rp 0';
                    if (grandEl) grandEl.textContent = 'Rp 0';
                    return;
                }

                let subtotalDay = 0;
                listEl.innerHTML = items.map((item, idx) => {
                    const lineDay = (item.price || 0) * (item.qty || 1);
                    subtotalDay += lineDay;
                    return `
                        <div class="d-flex align-items-center justify-content-between gap-2 py-2 border-bottom">
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-bold small text-truncate">${item.name}</div>
                                <div class="text-secondary" style="font-size: 0.76rem;">${formatRupiah(item.price)} / hari</div>
                            </div>
                            <div class="d-flex align-items-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-dark py-0 px-2" data-cart-dec="${idx}">-</button>
                                <span class="fw-bold small px-1">${item.qty}</span>
                                <button type="button" class="btn btn-sm btn-outline-dark py-0 px-2" data-cart-inc="${idx}">+</button>
                                <button type="button" class="btn btn-sm text-danger py-0 px-1" data-cart-del="${idx}"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                    `;
                }).join('');

                if (subDayEl) subDayEl.textContent = formatRupiah(subtotalDay);
                if (grandEl) grandEl.textContent = formatRupiah(subtotalDay * durasi) + ' (' + durasi + ' hari)';
            }

            document.addEventListener('click', function (e) {
                if (IS_AUTHENTICATED) return;
                const cartTrigger = e.target.closest('[data-bs-target="#RentalCartDrawer"]');
                if (cartTrigger) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = SEWA_BASE_URL;
                }
            }, true);

            document.addEventListener('click', function (e) {
                const addBtn = e.target.closest('[data-add-to-cart]');
                if (addBtn) {
                    e.preventDefault();
                    const id = parseInt(addBtn.getAttribute('data-id'), 10);
                    if (!IS_AUTHENTICATED) {
                        window.location.href = SEWA_BASE_URL + '?alat_id=' + id;
                        return;
                    }
                    const name = addBtn.getAttribute('data-name');
                    const price = parseFloat(addBtn.getAttribute('data-price') || '0');
                    const maxStok = parseInt(addBtn.getAttribute('data-stok') || '99', 10);

                    const cart = getCart();
                    const existing = cart.find(i => i.id === id);
                    if (existing) {
                        existing.qty = Math.min(maxStok, (existing.qty || 1) + 1);
                    } else {
                        cart.push({ id, name, price, qty: 1, max: maxStok });
                    }
                    saveCart(cart);

                    const drawerEl = document.getElementById('RentalCartDrawer');
                    if (drawerEl && window.bootstrap) {
                        window.bootstrap.Offcanvas.getOrCreateInstance(drawerEl).show();
                    }
                    return;
                }

                const incBtn = e.target.closest('[data-cart-inc]');
                if (incBtn) {
                    const idx = parseInt(incBtn.getAttribute('data-cart-inc'), 10);
                    const cart = getCart();
                    if (cart[idx]) {
                        cart[idx].qty = Math.min(cart[idx].max || 99, cart[idx].qty + 1);
                        saveCart(cart);
                    }
                    return;
                }

                const decBtn = e.target.closest('[data-cart-dec]');
                if (decBtn) {
                    const idx = parseInt(decBtn.getAttribute('data-cart-dec'), 10);
                    const cart = getCart();
                    if (cart[idx]) {
                        if (cart[idx].qty > 1) {
                            cart[idx].qty -= 1;
                        } else {
                            cart.splice(idx, 1);
                        }
                        saveCart(cart);
                    }
                    return;
                }

                const delBtn = e.target.closest('[data-cart-del]');
                if (delBtn) {
                    const idx = parseInt(delBtn.getAttribute('data-cart-del'), 10);
                    const cart = getCart();
                    cart.splice(idx, 1);
                    saveCart(cart);
                }
            });

            const clearBtn = document.getElementById('btnClearRentalCart');
            if (clearBtn) {
                clearBtn.addEventListener('click', function () {
                    saveCart([]);
                });
            }

            const proceedBtn = document.getElementById('btnProceedCheckout');
            if (proceedBtn) {
                proceedBtn.addEventListener('click', function () {
                    const sched = getSchedule();
                    const tglKembali = computeReturnDate(sched.tgl_sewa, sched.durasi);
                    const params = new URLSearchParams({
                        tgl_sewa: sched.tgl_sewa,
                        tgl_kembali_rencana: tglKembali,
                        durasi: sched.durasi,
                        from_cart: '1'
                    });
                    window.location.href = SEWA_BASE_URL + '?' + params.toString();
                });
            }

            window.CampSewaCart = {
                getCart,
                saveCart,
                getSchedule,
                saveSchedule,
                computeReturnDate
            };

            renderCart();
        })();
    </script>

    {{-- Dropdown kustom (menggantikan tampilan select bawaan browser) --}}
    <style>
        .camp-select { position: relative; display: block; width: 100%; }
        .camp-select.w-auto { display: inline-block; width: auto; }
        .camp-select-btn {
            width: 100%;
            text-align: left;
            cursor: pointer;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .camp-select-menu {
            position: fixed;
            z-index: 2000;
            display: none;
            max-height: 340px;
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
            margin: 0;
            padding: 10px 8px;
            list-style: none;
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.22);
        }
        .camp-select-menu::-webkit-scrollbar {
            width: 6px;
        }
        .camp-select-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        .camp-select-menu::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }
        .camp-select-menu::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .camp-select-menu.show { display: block; }
        .camp-select-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 11px 14px;
            border-radius: 12px;
            color: #101010;
            font-size: 0.98rem;
            font-weight: 800;
            text-transform: none;
            letter-spacing: 0;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }
        .camp-select-option i { color: #9aa0a6; font-size: 0.8rem; }
        .camp-select-option:hover { background: #f2f4f4; }
        .camp-select-option.selected { background: #eafee9; }
        .camp-select-option.selected i { color: #101010; }
    </style>
    <script>
        (function () {
            const selector = '.search-item-foresta select, .katalog-filter-box select, #drawerDurasi';
            const instances = [];
            let openMenu = null;

            function closeMenu(e) {
                if (e) {
                    if (openMenu && (openMenu === e.target || openMenu.contains(e.target))) {
                        return;
                    }
                    if (e.target && e.target.closest && e.target.closest('.camp-select-btn')) {
                        return;
                    }
                }
                if (openMenu) {
                    openMenu.classList.remove('show');
                    openMenu = null;
                }
            }

            function enhance(select) {
                if (select.dataset.campEnhanced) return;
                select.dataset.campEnhanced = '1';

                const wrap = document.createElement('div');
                wrap.className = 'camp-select' + (select.classList.contains('w-auto') ? ' w-auto' : '');

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = select.className + ' camp-select-btn';
                btn.id = select.id ? select.id + '_btn' : '';
                if (!btn.id) btn.removeAttribute('id');

                const menu = document.createElement('ul');
                menu.className = 'camp-select-menu';

                select.parentNode.insertBefore(wrap, select);
                wrap.appendChild(select);
                wrap.appendChild(btn);
                document.body.appendChild(menu);
                select.style.display = 'none';

                menu.addEventListener('click', function (e) {
                    e.stopPropagation();
                });

                function label() {
                    const opt = select.options[select.selectedIndex];
                    btn.textContent = opt ? opt.textContent.trim() : '';
                }

                function build() {
                    menu.innerHTML = '';
                    Array.from(select.options).forEach(function (opt) {
                        const li = document.createElement('li');
                        const selected = opt.value === select.value;
                        li.className = 'camp-select-option' + (selected ? ' selected' : '');
                        li.innerHTML = '<span></span>' + (selected ? '<i class="bi bi-check-lg"></i>' : '');
                        li.firstChild.textContent = opt.textContent.trim();
                        li.addEventListener('click', function () {
                            const changed = select.value !== opt.value;
                            select.value = opt.value;
                            label();
                            closeMenu();
                            if (changed) {
                                select.dispatchEvent(new Event('change', { bubbles: true }));
                            }
                        });
                        menu.appendChild(li);
                    });
                }

                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (openMenu === menu) { closeMenu(); return; }
                    closeMenu();
                    build();
                    const r = btn.getBoundingClientRect();
                    menu.style.minWidth = Math.max(r.width, 200) + 'px';
                    menu.style.left = Math.min(r.left, window.innerWidth - Math.max(r.width, 200) - 12) + 'px';
                    const below = window.innerHeight - r.bottom;
                    menu.style.maxHeight = Math.max(160, Math.min(340, below - 16)) + 'px';
                    menu.style.top = (r.bottom + 6) + 'px';
                    menu.classList.add('show');
                    openMenu = menu;
                    const sel = menu.querySelector('.selected');
                    if (sel) sel.scrollIntoView({ block: 'nearest' });
                });

                select.addEventListener('change', label);
                label();
                instances.push({ select: select, label: label });
            }

            function init() {
                document.querySelectorAll(selector).forEach(enhance);
            }

            document.addEventListener('click', closeMenu);
            window.addEventListener('resize', closeMenu);
            window.addEventListener('scroll', function (e) {
                if (openMenu && e.target && (openMenu === e.target || openMenu.contains(e.target))) {
                    return;
                }
                closeMenu();
            }, true);
            document.addEventListener('DOMContentLoaded', init);
            if (document.readyState !== 'loading') init();

            // Sinkronkan label bila nilai select diubah lewat skrip lain
            setInterval(function () {
                instances.forEach(function (i) { i.label(); });
            }, 400);
        })();
    </script>

    {{-- Interactive Midtrans Snap Sandbox Modal (Fallback & Local Simulator) --}}
    <div class="modal fade" id="MidtransSnapModal" tabindex="-1" aria-labelledby="MidtransSnapModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
            <div class="modal-content border-0 rounded-4 overflow-hidden shadow-lg">
                <div class="p-3 text-white d-flex justify-content-between align-items-center" style="background: #0d2644;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge rounded-pill" style="background: var(--foresta-lime); color: #ffffff; font-weight: 900;">MIDTRANS</span>
                        <span class="fw-bold small" id="MidtransSnapModalLabel">CampSewa Adventure Store</span>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="p-3 border-bottom d-flex justify-content-between align-items-center" style="background: #f4f7fb;">
                    <div>
                        <div class="text-secondary" style="font-size: 0.72rem;" id="snapModalTypeLabel">Total Pembayaran</div>
                        <div class="fs-4 fw-black text-dark" id="snapModalAmount" style="font-weight: 900;">Rp 0</div>
                    </div>
                    <div class="text-end">
                        <div class="text-secondary" style="font-size: 0.7rem;">Order ID</div>
                        <div class="small fw-bold text-dark" id="snapModalOrderId">-</div>
                    </div>
                </div>

                <div class="modal-body p-3">
                    <div class="p-3 rounded-3 mb-3 border border-warning" style="background: #fffbeb;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-extrabold text-dark" style="font-size: 0.78rem;">
                                <i class="bi bi-plug-fill text-warning me-1"></i> Hubungkan ke Dashboard Midtrans Asli
                            </span>
                            <a href="https://dashboard.sandbox.midtrans.com/settings/config_info" target="_blank" rel="noopener" class="badge bg-dark text-white text-decoration-none">
                                Buka Access Keys <i class="bi bi-box-arrow-up-right"></i>
                            </a>
                        </div>
                        <div class="text-secondary mb-2" style="font-size: 0.72rem; line-height: 1.35;">
                            Di file <code>.env</code> saat ini masih tertulis <code>M145570215-DEFAULT-PAYMENT-CLIENT</code> (itu adalah ID Merchant, bukan Server Key). Tempel <strong>Server Key</strong> asli (diawali <code>SB-Mid-server-...</code> atau <code>Mid-server-...</code>) di bawah agar langsung nyambung ke akun Midtrans kamu:
                        </div>
                        <div class="input-group input-group-sm">
                            <input type="text" id="inputMidtransServerKey" class="form-control font-monospace" placeholder="SB-Mid-server-... atau Mid-server-...">
                            <button type="button" id="btnSaveMidtransKey" class="btn btn-dark fw-bold">
                                Hubungkan
                            </button>
                        </div>
                        <div id="midtransKeyFeedback" class="small fw-bold mt-1 d-none" style="font-size: 0.72rem;"></div>
                    </div>

                    <div class="small fw-extrabold text-secondary mb-2">Atau Lanjutkan dengan Simulator Lokal:</div>
                    <div class="d-flex flex-column gap-2 mb-3" id="snapChannelList">
                        <label class="p-2 px-3 rounded-3 border d-flex align-items-center justify-content-between cursor-pointer" style="cursor: pointer;">
                            <span class="d-flex align-items-center gap-2 fw-bold small">
                                <input type="radio" name="snap_channel" value="QRIS" checked>
                                <i class="bi bi-qr-code-scan fs-5 text-primary"></i>
                                QRIS (Semua E-Wallet &amp; M-Banking)
                            </span>
                            <span class="badge bg-light text-dark border">QRIS</span>
                        </label>
                        <label class="p-2 px-3 rounded-3 border d-flex align-items-center justify-content-between" style="cursor: pointer;">
                            <span class="d-flex align-items-center gap-2 fw-bold small">
                                <input type="radio" name="snap_channel" value="DANA">
                                <i class="bi bi-wallet2 fs-5 text-info"></i>
                                DANA E-Wallet
                            </span>
                            <span class="badge bg-light text-dark border">DANA</span>
                        </label>
                    </div>

                    <div class="p-3 rounded-3 border text-center bg-light mb-3">
                        <i class="bi bi-qr-code" style="font-size: 4.5rem; color: #101010;"></i>
                        <div class="small fw-bold text-dark mt-1">Scan QRIS atau Klik Konfirmasi Bayar</div>
                        <div class="text-secondary" style="font-size: 0.74rem;">Midtrans Sandbox Payment Simulator</div>
                    </div>

                    <button type="button" id="btnConfirmSnapSim" class="btn-foresta-lime w-100 py-3 justify-content-center">
                        <i class="bi bi-shield-check"></i> Bayar &amp; Konfirmasi Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.CampSewaMidtrans = {
            openModal: function (data, confirmUrl, tipeBayar, onDone) {
                const modalEl = document.getElementById('MidtransSnapModal');
                if (!modalEl || !window.bootstrap) return;

                const amountEl = document.getElementById('snapModalAmount');
                const orderEl = document.getElementById('snapModalOrderId');
                const typeEl = document.getElementById('snapModalTypeLabel');
                const confirmBtn = document.getElementById('btnConfirmSnapSim');

                const gross = parseInt(data.gross_amount || 0, 10);
                if (amountEl) amountEl.textContent = 'Rp ' + gross.toLocaleString('id-ID');
                if (orderEl) orderEl.textContent = data.order_id || '-';
                if (typeEl) {
                    typeEl.textContent = tipeBayar === 'dp'
                        ? 'Pembayaran Uang Muka (DP 50%)'
                        : 'Pembayaran Penuh / Pelunasan (100%)';
                }

                const bsModal = window.bootstrap.Modal.getOrCreateInstance(modalEl);
                bsModal.show();

                if (confirmBtn) {
                    const newBtn = confirmBtn.cloneNode(true);
                    confirmBtn.parentNode.replaceChild(newBtn, confirmBtn);

                    newBtn.addEventListener('click', async function () {
                        newBtn.disabled = true;
                        newBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memverifikasi Pembayaran...';
                        const currentHref = window.location.href;
                        if (typeof onDone === 'function') {
                            await onDone();
                        }
                        if (window.location.href === currentHref) {
                            window.location.reload();
                        }
                    });
                }

                const saveKeyBtn = document.getElementById('btnSaveMidtransKey');
                const serverKeyInput = document.getElementById('inputMidtransServerKey');
                const feedbackEl = document.getElementById('midtransKeyFeedback');
                if (saveKeyBtn && serverKeyInput) {
                    const newSaveBtn = saveKeyBtn.cloneNode(true);
                    saveKeyBtn.parentNode.replaceChild(newSaveBtn, saveKeyBtn);

                    newSaveBtn.addEventListener('click', async function () {
                        const val = (serverKeyInput.value || '').trim();
                        if (!val) return;
                        newSaveBtn.disabled = true;
                        newSaveBtn.textContent = 'Menyimpan...';
                        if (feedbackEl) feedbackEl.classList.add('d-none');

                        try {
                            const res = await fetch('{{ route('midtrans.save_keys') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                },
                                body: JSON.stringify({ server_key: val })
                            });
                            const json = await res.json();
                            if (!res.ok || !json.success) {
                                throw new Error(json.message || 'Gagal menyimpan Server Key.');
                            }
                            if (feedbackEl) {
                                feedbackEl.textContent = json.message;
                                feedbackEl.className = 'small fw-bold mt-1 text-success';
                            }
                            setTimeout(() => window.location.reload(), 600);
                        } catch (e) {
                            if (feedbackEl) {
                                feedbackEl.textContent = e.message;
                                feedbackEl.className = 'small fw-bold mt-1 text-danger';
                            }
                            newSaveBtn.disabled = false;
                            newSaveBtn.textContent = 'Hubungkan';
                        }
                    });
                }
            }
        };

        // Custom Confirmation Modal for Pelanggan / Public Forms
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('campPublicConfirmModal');
            if (!modalEl || typeof bootstrap === 'undefined') return;

            const confirmModal = new bootstrap.Modal(modalEl);
            const msgEl = document.getElementById('campPublicConfirmMsg');
            const acceptBtn = document.getElementById('campPublicConfirmAccept');
            let pendingForm = null;

            document.querySelectorAll('form[onsubmit*="confirm("]').forEach(function (form) {
                const rawAttr = form.getAttribute('onsubmit') || '';
                const match = rawAttr.match(/confirm\(['"](.+?)['"]\)/);
                const message = match ? match[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

                form.removeAttribute('onsubmit');
                form.dataset.confirmMessage = message;

                form.addEventListener('submit', function (e) {
                    if (form.dataset.confirmed === 'true') return true;
                    e.preventDefault();
                    pendingForm = form;
                    if (msgEl) msgEl.textContent = form.dataset.confirmMessage;
                    confirmModal.show();
                });
            });

            if (acceptBtn) {
                acceptBtn.addEventListener('click', function () {
                    if (pendingForm) {
                        pendingForm.dataset.confirmed = 'true';
                        confirmModal.hide();
                        pendingForm.submit();
                    }
                });
            }
        });
    </script>

    {{-- Sticky Mobile Bottom Navigation Bar (< 768px) --}}
    <nav class="foresta-mobile-bottom-nav" aria-label="Navigasi Mobile">
        <a href="{{ route('public.beranda') }}" class="foresta-mobile-nav-item {{ request()->routeIs('public.beranda') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i>
            <span>Beranda</span>
        </a>
        <a href="{{ route('public.katalog') }}" class="foresta-mobile-nav-item {{ request()->routeIs('public.katalog', 'public.detail') ? 'active' : '' }}">
            <i class="bi bi-grid-fill"></i>
            <span>Katalog</span>
        </a>
        <button type="button" class="foresta-mobile-nav-item" data-bs-toggle="offcanvas" data-bs-target="#RentalCartDrawer">
            <i class="bi bi-cart-fill"></i>
            <span>Keranjang</span>
        </button>
        <a href="{{ route('public.cara_sewa') }}" class="foresta-mobile-nav-item {{ request()->routeIs('public.cara_sewa') ? 'active' : '' }}">
            <i class="bi bi-journal-check"></i>
            <span>Cara Sewa</span>
        </a>
        @auth
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isPetugas() ? route('petugas.dashboard') : route('pelanggan.dashboard')) }}" class="foresta-mobile-nav-item {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Akun</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="foresta-mobile-nav-item">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Masuk</span>
            </a>
        @endauth
    </nav>

    {{-- Custom Confirmation Modal for Public / Pelanggan Pages --}}
    <div class="modal fade" id="campPublicConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content border-0 rounded-4 p-4 text-center shadow-lg">
                <div class="mx-auto mb-3 d-inline-flex align-items-center justify-content-center rounded-4" style="width: 54px; height: 54px; background: #fee2e2; color: #dc2626; font-size: 1.4rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <h5 class="fw-extrabold mb-2 text-dark">Konfirmasi Tindakan</h5>
                <p class="text-secondary small mb-4" id="campPublicConfirmMsg">Apakah Anda yakin ingin melanjutkan?</p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold border" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" id="campPublicConfirmAccept">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>

    @yield('scripts')
</body>
</html>
