<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Kelola - CampSewa')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=2">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --shop-bg: #f3f5f7;
            --shop-card: #ffffff;
            --shop-soft: #f6f8fa;
            --shop-border: #e4e8ec;
            --shop-text: #111827;
            --shop-muted: #64748b;
            --shop-dark: #111827;
            --shop-dark-hover: #1e293b;
            --shop-lime: #16a34a; /* Warna hijau agak tua / forest emerald green */
            --shop-lime-hover: #15803d;
            --shop-lime-soft: #f0fdf4;
            --shop-lime-border: #86efac;
            --shop-green-text: #166534;
            --dashboard-green: #16a34a;
            --dashboard-green-deep: #14532d;
            --dashboard-green-soft: #f0fdf4;
            --dashboard-line: #e4e8ec;
            --dashboard-text: #111827;
            --dashboard-muted: #64748b;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--shop-bg);
            color: var(--shop-text);
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            width: 100%;
            min-height: 100vh;
            padding: 18px 20px;
        }

        /* Floating Left Sidebar with Smooth Internal Scroll */
        #sidebar {
            width: 262px;
            height: calc(100vh - 36px);
            max-height: calc(100vh - 36px);
            background: var(--shop-card);
            border: 1px solid var(--shop-border);
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(16, 16, 16, 0.04);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding: 20px 14px 16px;
            position: sticky;
            top: 18px;
            z-index: 1000;
            overflow: hidden;
        }

        .shop-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 2px 10px 16px;
            margin-bottom: 4px;
            border-bottom: 1px solid var(--shop-border);
            text-decoration: none;
            flex-shrink: 0;
        }

        .shop-brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #101010;
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .shop-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .shop-brand-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--shop-text);
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        .shop-brand-sub {
            display: block;
            font-size: 0.66rem;
            font-weight: 800;
            color: var(--shop-green-text);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-top: 2px;
        }

        /* Scrollable Menu Area inside Sidebar */
        .shop-sidebar-scroll {
            flex: 1 1 auto;
            min-height: 0;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 4px 4px 10px 2px;
        }

        .shop-sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .shop-sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .shop-sidebar-scroll::-webkit-scrollbar-thumb {
            background: #d5dcd5;
            border-radius: 999px;
        }

        .shop-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #9aa59a;
        }

        .shop-nav-section-label {
            font-size: 0.66rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #939c96;
            padding: 12px 12px 5px;
        }

        .shop-nav-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .shop-nav-link {
            width: 100%;
            border: 0;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 13px;
            color: #4f5853;
            font-size: 0.86rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.18s ease;
            position: relative;
            cursor: pointer;
            text-align: left;
        }

        .shop-nav-link-left {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            min-width: 0;
        }

        .shop-nav-link i.nav-icon {
            font-size: 1rem;
            width: 20px;
            text-align: center;
            color: #6c7570;
            transition: color 0.18s ease;
        }

        .shop-nav-link .chevron-icon {
            font-size: 0.75rem;
            color: #8c9690;
            transition: transform 0.2s ease;
        }

        .shop-nav-link[aria-expanded="true"] .chevron-icon {
            transform: rotate(180deg);
            color: var(--shop-text);
        }

        .shop-nav-link:hover {
            background: var(--shop-soft);
            color: var(--shop-text);
        }

        .shop-nav-link:hover i.nav-icon {
            color: var(--shop-text);
        }

        .shop-nav-link.active-group,
        .shop-nav-link.active {
            background: var(--shop-soft);
            color: var(--shop-text);
            font-weight: 800;
        }

        .shop-nav-link.active-group::before,
        .shop-nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 7px;
            bottom: 7px;
            width: 4px;
            border-radius: 0 6px 6px 0;
            background: var(--shop-lime);
        }

        .shop-nav-link.active-group i.nav-icon,
        .shop-nav-link.active i.nav-icon {
            color: var(--shop-text);
        }

        .shop-submenu {
            list-style: none;
            padding: 4px 0 6px 14px;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .shop-sublink {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: 10px;
            color: #64748b;
            font-size: 0.81rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.16s ease;
        }

        .shop-sublink:hover {
            color: var(--shop-text);
            background: var(--shop-soft);
        }

        .shop-sublink.active {
            background: var(--shop-lime-soft);
            color: var(--shop-text);
            font-weight: 800;
        }

        .shop-sidebar-bottom {
            flex-shrink: 0;
            padding-top: 10px;
            border-top: 1px solid var(--shop-border);
            margin-top: 6px;
        }

        .shop-logout-btn {
            width: 100%;
            border: 0;
            background: #fff5f5;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            border-radius: 12px;
            color: #dc2626;
            font-size: 0.85rem;
            font-weight: 700;
            text-align: left;
            transition: all 0.18s ease;
            margin-top: 4px;
        }

        .shop-logout-btn:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Main Area */
        #content {
            flex-grow: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        /* Floating Top Header Card */
        .top-navbar {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid var(--shop-border);
            border-radius: 22px;
            padding: 14px 22px;
            box-shadow: 0 8px 24px rgba(16, 16, 16, 0.04);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: nowrap;
            position: sticky;
            top: 14px;
            z-index: 1020;
            transition: all 0.2s ease;
        }

        .top-navbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            flex: 1 1 auto;
        }

        .top-sidebar-toggle {
            width: 38px;
            height: 38px;
            min-width: 38px;
            padding: 0;
            border-radius: 12px;
            border: 1px solid var(--shop-border);
            background: var(--shop-soft);
            color: var(--shop-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            line-height: 1;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.18s ease;
        }

        .top-sidebar-toggle:hover {
            background: var(--shop-dark);
            color: var(--shop-lime);
            border-color: var(--shop-dark);
        }

        .top-sidebar-toggle:active {
            transform: scale(0.94);
        }

        .top-title-wrap {
            min-width: 0;
            flex: 1 1 auto;
        }

        .top-title-wrap h1,
        .top-title-wrap h5 {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--shop-text);
            margin: 0;
            letter-spacing: -0.02em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.25;
        }

        .top-title-wrap p {
            margin: 2px 0 0;
            font-size: 0.76rem;
            color: var(--shop-muted);
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .top-search-form {
            flex: 0 1 360px;
            position: relative;
        }

        .top-search-input {
            width: 100%;
            height: 42px;
            padding: 8px 18px 8px 42px;
            border-radius: 999px;
            border: 1px solid var(--shop-border);
            background: var(--shop-soft);
            color: var(--shop-text);
            font-size: 0.84rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .top-search-input:focus {
            outline: none;
            background: #ffffff;
            border-color: var(--shop-dark);
            box-shadow: 0 0 0 3px rgba(112, 244, 109, 0.22);
        }

        .top-search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c7570;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .top-right-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
            margin-left: auto;
        }

        .top-icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--shop-border);
            background: var(--shop-soft);
            color: var(--shop-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 0.95rem;
            position: relative;
            transition: all 0.18s ease;
        }

        .top-icon-circle:hover {
            background: var(--shop-dark);
            color: var(--shop-lime);
            border-color: var(--shop-dark);
        }

        .top-icon-circle .notif-dot {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--shop-lime);
            border: 1.5px solid #ffffff;
        }

        .top-profile-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 5px 14px 5px 6px;
            border-radius: 999px;
            border: 1px solid var(--shop-border);
            background: var(--shop-soft);
            text-decoration: none;
            color: var(--shop-text);
            transition: all 0.18s ease;
        }

        .top-profile-pill:hover {
            border-color: var(--shop-dark);
            background: #ffffff;
        }

        .top-profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--shop-lime);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
        }

        .top-profile-info {
            line-height: 1.15;
            text-align: left;
        }

        .top-profile-name {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--shop-text);
            display: block;
        }

        .top-profile-role {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--shop-muted);
            display: block;
        }

        .main-container {
            flex-grow: 1;
            min-width: 0;
        }

        /* Modern Flash Alert Banner */
        .camp-flash-alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 18px;
            border: 1px solid var(--shop-border);
            background: #ffffff;
            box-shadow: 0 10px 26px rgba(16, 16, 16, 0.05);
            margin-bottom: 18px;
        }

        .camp-flash-alert.success {
            border-left: 5px solid #22c55e;
        }

        .camp-flash-alert.error {
            border-left: 5px solid #ef4444;
        }

        .camp-flash-alert.info {
            border-left: 5px solid #3b82f6;
        }

        .camp-flash-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .camp-flash-alert.success .camp-flash-icon {
            background: var(--shop-lime-soft);
            color: #16a34a;
        }

        .camp-flash-alert.error .camp-flash-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .camp-flash-alert.info .camp-flash-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        /* Shoplytic Workspace (Filter Sidebar + Product Grid) */
        .shoplytic-workspace {
            display: grid;
            grid-template-columns: 276px minmax(0, 1fr);
            gap: 20px;
            align-items: start;
            transition: all 0.22s ease;
        }

        .shoplytic-workspace.filter-collapsed {
            grid-template-columns: minmax(0, 1fr);
        }

        .shoplytic-workspace.filter-collapsed .shoplytic-filter-card {
            display: none;
        }

        .shoplytic-filter-card {
            background: var(--shop-card);
            border: 1px solid var(--shop-border);
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(16, 16, 16, 0.03);
            transition: box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .shoplytic-filter-card.filter-highlight {
            border-color: var(--shop-dark);
            box-shadow: 0 0 0 4px rgba(112, 244, 109, 0.35), 0 12px 28px rgba(16, 16, 16, 0.08);
        }

        .filter-card-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 14px;
            border-bottom: 1px solid var(--shop-border);
        }

        .filter-card-title span {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--shop-text);
        }

        .filter-reset-link {
            font-size: 0.75rem;
            font-weight: 700;
            color: #dc2626;
            text-decoration: none;
        }

        .filter-reset-link:hover {
            text-decoration: underline;
        }

        .filter-group-box {
            background: var(--shop-soft);
            border: 1px solid var(--shop-border);
            border-radius: 14px;
            padding: 12px 14px;
            margin-bottom: 12px;
        }

        .filter-group-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            border: 0;
            background: transparent;
            padding: 0;
            text-align: left;
            font-size: 0.84rem;
            font-weight: 800;
            color: var(--shop-text);
            cursor: pointer;
        }

        .filter-group-header .filter-chevron {
            font-size: 0.78rem;
            color: #5e6762;
            transition: transform 0.2s ease;
        }

        .filter-group-header[aria-expanded="true"] .filter-chevron {
            transform: rotate(180deg);
        }

        .filter-price-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 12px 0 16px;
            padding: 0 2px;
        }

        .filter-check-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 6px 8px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            color: #4f5853;
            cursor: pointer;
            user-select: none;
            transition: background 0.15s ease;
        }

        .filter-check-item:hover {
            background: var(--shop-soft);
        }

        .filter-check-left {
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .filter-check-item input {
            display: none;
        }

        .filter-check-box {
            width: 18px;
            height: 18px;
            border-radius: 6px;
            border: 1.5px solid #cbd2cc;
            background: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: transparent;
            font-size: 0.72rem;
            transition: all 0.16s ease;
            flex-shrink: 0;
        }

        .filter-check-item input:checked + .filter-check-box {
            background: var(--shop-lime);
            border-color: #4ade80;
            color: #ffffff;
        }

        .filter-check-item input:checked ~ .filter-check-label {
            color: var(--shop-text);
            font-weight: 800;
        }

        .filter-count-pill {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--shop-muted);
            background: #eef1ee;
            padding: 2px 8px;
            border-radius: 999px;
        }

        .price-slider-wrap {
            padding: 12px 14px;
            background: var(--shop-soft);
            border: 1px solid var(--shop-border);
            border-radius: 14px;
            margin-bottom: 12px;
        }

        .price-bubble {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 999px;
            background: var(--shop-lime);
            color: #ffffff !important;
            font-size: 0.74rem;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .shop-range-input {
            width: 100%;
            accent-color: #22c55e;
            cursor: pointer;
        }

        .price-minmax-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .price-minmax-input {
            width: 100%;
            padding: 7px 10px;
            border-radius: 10px;
            border: 1px solid var(--shop-border);
            background: #ffffff;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--shop-text);
            text-align: center;
        }

        /* Primary CTA Buttons Matching Landing Page (#70f46d & #101010) */
        .btn-shoplytic-lime,
        .btn-shoplytic-orange {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: 999px;
            border: 0;
            background: var(--shop-lime);
            color: #ffffff !important;
            font-size: 0.85rem;
            font-weight: 800;
            text-decoration: none;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.22);
            box-shadow: 0 6px 16px rgba(22, 163, 74, 0.25);
            transition: all 0.18s ease;
        }

        .btn-shoplytic-lime i,
        .btn-shoplytic-orange i,
        .btn-shoplytic-lime span,
        .btn-shoplytic-orange span {
            color: #ffffff !important;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.22);
        }

        .btn-shoplytic-lime:hover,
        .btn-shoplytic-orange:hover {
            background: var(--shop-lime-hover);
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.35);
        }

        .btn-shoplytic-lime:hover i,
        .btn-shoplytic-orange:hover i,
        .btn-shoplytic-lime:hover span,
        .btn-shoplytic-orange:hover span {
            color: #ffffff !important;
        }

        .btn-shoplytic-dark {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 999px;
            border: 1px solid var(--shop-border);
            background: #ffffff;
            color: var(--shop-text);
            font-size: 0.84rem;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.18s ease;
        }

        .btn-shoplytic-dark:hover {
            background: var(--shop-soft);
            border-color: #cbd5e1;
            color: var(--shop-text);
            transform: translateY(-1px);
        }

        .shoplytic-main-panel {
            background: var(--shop-card);
            border: 1px solid var(--shop-border);
            border-radius: 22px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(16, 16, 16, 0.03);
        }

        .shoplytic-subbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding-bottom: 16px;
            margin-bottom: 18px;
            border-bottom: 1px solid var(--shop-border);
        }

        .shoplytic-breadcrumb {
            font-size: 0.8rem;
            color: var(--shop-muted);
            font-weight: 600;
        }

        .shoplytic-breadcrumb strong {
            color: var(--shop-text);
            font-weight: 800;
        }

        .shoplytic-count {
            font-size: 0.75rem;
            color: var(--shop-muted);
            margin-top: 2px;
        }

        .shoplytic-count strong {
            color: var(--shop-text);
        }

        .shoplytic-subbar-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .subbar-search-wrap {
            position: relative;
            width: 220px;
        }

        .subbar-search-input {
            width: 100%;
            height: 38px;
            padding: 6px 14px 6px 36px;
            border-radius: 999px;
            border: 1px solid var(--shop-border);
            background: var(--shop-soft);
            font-size: 0.82rem;
            color: var(--shop-text);
        }

        .subbar-search-input:focus {
            outline: none;
            border-color: var(--shop-dark);
            background: #ffffff;
        }

        .subbar-search-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.82rem;
            color: var(--shop-muted);
        }

        .btn-subbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 38px;
            padding: 0 16px;
            border-radius: 999px;
            border: 1px solid var(--shop-border);
            background: #ffffff;
            color: var(--shop-text);
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.16s ease;
        }

        .btn-subbar-pill:hover,
        .btn-subbar-pill.active {
            border-color: var(--shop-dark);
            color: var(--shop-dark);
            background: var(--shop-lime-soft);
        }

        /* Filter Button in Subbar */
        .btn-filter-toggle {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            user-select: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-filter-toggle.active {
            border-color: var(--shop-lime-border);
            background: var(--shop-lime-soft);
            color: var(--shop-green-text);
        }

        /* Adaptive Product Grid & Cards */
        .shoplytic-product-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            width: 100%;
            min-width: 0;
        }

        .shoplytic-product-card {
            background: #ffffff;
            border: 1px solid var(--shop-border);
            border-radius: 18px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            min-width: 0;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .shoplytic-product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 28px rgba(16, 16, 16, 0.07);
            border-color: #c7d0c7;
        }

        .shoplytic-img-box {
            height: 180px;
            border-radius: 14px;
            background: #f8faf9;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            margin-bottom: 12px;
            padding: 10px;
            box-sizing: border-box;
        }

        .shoplytic-img-box img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            transition: transform 0.25s ease;
        }

        .shoplytic-product-card:hover .shoplytic-img-box img {
            transform: scale(1.04);
        }

        .shoplytic-stock-chip {
            position: absolute;
            top: 10px;
            left: 10px;
            max-width: calc(100% - 20px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.94);
            color: var(--shop-text);
            font-size: 0.68rem;
            font-weight: 800;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(4px);
            z-index: 2;
        }

        .shoplytic-stock-chip.low {
            background: #dc2626;
            color: #ffffff;
        }

        .shoplytic-cat-chip {
            position: absolute;
            bottom: 8px;
            left: 8px;
            max-width: calc(100% - 16px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 3px 9px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.92);
            color: var(--shop-text);
            font-size: 0.66rem;
            font-weight: 700;
            z-index: 2;
        }

        .shoplytic-product-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: var(--shop-text);
            margin: 0 0 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            min-width: 0;
        }

        .shoplytic-product-desc {
            font-size: 0.74rem;
            color: var(--shop-muted);
            line-height: 1.4;
            margin: 0 0 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.8em;
            word-break: break-word;
        }

        .shoplytic-product-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            padding-top: 8px;
            border-top: 1px solid #f0f2f0;
            min-width: 0;
            width: 100%;
            box-sizing: border-box;
        }

        .shoplytic-price-wrap {
            min-width: 0;
            flex: 1 1 auto;
        }

        .shoplytic-price {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--shop-text);
            white-space: nowrap;
        }

        .shoplytic-price small {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--shop-muted);
        }

        .shoplytic-card-actions {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-width: 0;
            flex-shrink: 0;
        }

        .shoplytic-action-form {
            display: inline-flex;
            margin: 0;
            padding: 0;
            min-width: 0;
        }

        .shoplytic-icon-btn {
            height: 34px;
            padding: 0 12px;
            border-radius: 9px;
            border: 1px solid var(--shop-border);
            background: #ffffff;
            color: var(--shop-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 0.76rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.16s ease;
            cursor: pointer;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .shoplytic-icon-btn:hover {
            border-color: #cbd5e1;
            background: var(--shop-soft);
            color: var(--shop-text);
        }

        .shoplytic-icon-btn.btn-edit-action {
            background: var(--shop-soft);
            border-color: var(--shop-border);
            color: var(--shop-text);
        }

        .shoplytic-icon-btn.btn-edit-action:hover {
            background: var(--shop-dark);
            border-color: var(--shop-dark);
            color: var(--shop-lime);
            box-shadow: 0 4px 12px rgba(17, 24, 39, 0.15);
        }

        .shoplytic-icon-btn.btn-edit-action:active {
            transform: scale(0.96);
        }

        .shoplytic-icon-btn.btn-delete-action {
            background: #fef2f2;
            border-color: #fecaca;
            color: #dc2626;
        }

        .shoplytic-icon-btn.btn-delete-action:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
        }

        .shoplytic-icon-btn.btn-delete-action:active {
            transform: scale(0.96);
        }

        .shoplytic-icon-btn.primary-action {
            background: var(--shop-lime-soft);
            border-color: var(--shop-lime-border);
            color: var(--shop-dark);
        }

        .shoplytic-icon-btn.primary-action:hover {
            background: var(--shop-lime);
            border-color: var(--shop-lime);
            color: var(--shop-dark);
            box-shadow: 0 4px 12px rgba(112, 244, 109, 0.35);
        }

        .shoplytic-icon-btn.primary-action:active {
            transform: scale(0.96);
        }

        /* Compact KPI Strip & Cards */
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .dashboard-stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 18px 20px;
            border: 1px solid var(--shop-border);
            border-radius: 20px;
            background: var(--shop-card);
            box-shadow: 0 6px 20px rgba(16, 16, 16, 0.025);
            transition: transform 0.18s ease;
        }

        .dashboard-stat:hover {
            transform: translateY(-2px);
        }

        .dashboard-stat-label {
            margin-bottom: 4px;
            color: var(--shop-muted);
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .dashboard-stat-value {
            margin: 0;
            color: var(--shop-text);
            font-size: 1.38rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .dashboard-stat-note {
            margin: 4px 0 0;
            color: var(--shop-muted);
            font-size: 0.73rem;
            font-weight: 600;
        }

        .dashboard-stat-icon {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            border-radius: 14px;
            background: var(--shop-lime-soft);
            color: var(--shop-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.18rem;
        }

        .card-panel,
        .panel-card {
            background: var(--shop-card);
            border: 1px solid var(--shop-border);
            border-radius: 22px;
            box-shadow: 0 8px 24px rgba(16, 16, 16, 0.03);
            overflow: hidden;
        }

        .panel-card {
            padding: 20px;
        }

        .panel-card .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .dashboard-section-title {
            margin: 0;
            font-size: 1rem;
            font-weight: 800;
            color: var(--shop-text);
        }

        .dashboard-section-caption {
            margin: 2px 0 0;
            font-size: 0.76rem;
            color: var(--shop-muted);
        }

        .card-panel .card-header {
            background: #ffffff;
            border-bottom: 1px solid var(--shop-border);
            padding: 16px 22px;
            font-weight: 800;
            color: var(--shop-text);
            font-size: 0.96rem;
        }

        .card-panel .card-body {
            padding: 20px 22px;
        }

        .card-panel .table th {
            padding: 13px 18px;
            background: #f8faf8;
            font-size: 0.76rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--shop-muted);
            border-bottom: 1px solid var(--shop-border);
        }

        .card-panel .table td {
            padding: 14px 18px;
            font-size: 0.86rem;
            border-bottom: 1px solid #f0f2f0;
        }

        .card-panel .table tr:last-child td {
            border-bottom: 0;
        }

        .btn-camp {
            background: var(--shop-lime);
            color: #ffffff !important;
            border: 1px solid var(--shop-lime);
            font-weight: 800;
            border-radius: 999px;
            padding: 8px 18px;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.22);
            transition: all 0.18s ease;
        }

        .btn-camp i,
        .btn-camp span {
            color: #ffffff !important;
        }

        .btn-camp:hover {
            background: var(--shop-lime-hover);
            border-color: var(--shop-lime-hover);
            color: #ffffff !important;
        }

        .btn-camp:hover i,
        .btn-camp:hover span {
            color: #ffffff !important;
        }

        /* Verified Badge & Table Action Buttons (Matching Ref) */
        .badge.bg-success,
        .badge-verified {
            background-color: #166534 !important;
            color: #ffffff !important;
            font-weight: 700;
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 0.74rem;
            letter-spacing: 0.02em;
        }

        .btn-table-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 12px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
            line-height: 1.25;
            background: #ffffff;
        }

        .btn-table-detail {
            border: 1px solid #d1d5db;
            color: #4b5563;
        }

        .btn-table-detail:hover {
            border-color: #9ca3af;
            color: #111827;
            background: #f8fafc;
        }

        .btn-table-edit {
            border: 1px solid #3b82f6;
            color: #2563eb;
        }

        .btn-table-edit:hover {
            border-color: #1d4ed8;
            background: #eff6ff;
            color: #1d4ed8;
        }

        .btn-table-delete {
            border: 1px solid #fca5a5;
            color: #ef4444;
            background: #ffffff;
        }

        .btn-table-delete:hover {
            border-color: #ef4444;
            background: #fef2f2;
            color: #dc2626;
        }

        .btn-wa-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 2px 7px;
            border: 1px solid #16a34a;
            color: #16a34a;
            border-radius: 6px;
            font-size: 0.85rem;
            background: #ffffff;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-wa-icon:hover {
            background: #16a34a;
            color: #ffffff !important;
        }

        .dashboard-content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.65fr) minmax(260px, 0.95fr);
            gap: 18px;
            margin-top: 20px;
        }

        .dashboard-stack {
            display: grid;
            gap: 18px;
        }

        .dashboard-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-item-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--shop-lime-soft);
            color: var(--shop-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dashboard-item-image {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            object-fit: cover;
            background: var(--shop-soft);
        }

        .dashboard-item-name {
            font-weight: 700;
            font-size: 0.84rem;
            color: var(--shop-text);
        }

        .dashboard-item-meta {
            font-size: 0.72rem;
            color: var(--shop-muted);
        }

        .dashboard-quick-links {
            display: grid;
            gap: 10px;
        }

        .dashboard-quick-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: 14px;
            border: 1px solid var(--shop-border);
            background: #ffffff;
            color: var(--shop-text);
            text-decoration: none;
            font-size: 0.84rem;
            transition: all 0.16s ease;
        }

        .dashboard-quick-link:hover {
            border-color: var(--shop-dark);
            background: var(--shop-lime-soft);
            color: var(--shop-text);
        }

        /* Clean Bootstrap 5 Pagination Styling Across All Dashboards */
        .pagination {
            gap: 6px;
            margin-bottom: 0;
            flex-wrap: wrap;
        }

        .pagination .page-item .page-link {
            border-radius: 11px !important;
            border: 1px solid var(--shop-border);
            background: #ffffff;
            color: var(--shop-text);
            font-size: 0.82rem;
            font-weight: 700;
            padding: 8px 14px;
            box-shadow: none;
            transition: all 0.16s ease;
        }

        .pagination .page-item .page-link:hover {
            background: var(--shop-lime-soft);
            border-color: var(--shop-dark);
            color: var(--shop-dark);
        }

        .pagination .page-item.active .page-link {
            background: var(--shop-lime);
            border-color: var(--shop-lime);
            color: #ffffff !important;
        }

        .pagination .page-item.disabled .page-link {
            background: #f5f7f5;
            color: #a0a8a2;
            border-color: var(--shop-border);
        }

        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
        }

        /* Custom Confirmation Modal */
        .camp-modal-content {
            border: 0;
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(16, 16, 16, 0.22);
            overflow: hidden;
        }

        .camp-modal-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: var(--shop-lime-soft);
            color: var(--shop-text);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 14px;
        }

        .camp-modal-icon.danger {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ========================================================
           RESPONSIVE BREAKPOINTS (DESKTOP, LAPTOP, TABLET, MOBILE)
           ======================================================== */

        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        body.drawer-locked {
            overflow: hidden !important;
        }

        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(16, 16, 16, 0.52);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            z-index: 1045;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .sidebar-backdrop.show {
            display: block;
            opacity: 1;
        }

        .shoplytic-filter-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(16, 16, 16, 0.52);
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
            z-index: 1059;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .shoplytic-filter-backdrop.show {
            display: block;
            opacity: 1;
        }

        .admin-mobile-bottom-nav {
            display: none;
        }

        .modal-dialog {
            max-width: min(410px, calc(100vw - 24px));
            margin: 0.75rem auto;
        }

        /* --------------------------------------------------------
           1. BREAKPOINT >= 1200px: DESKTOP
           -------------------------------------------------------- */
        @media (min-width: 1200px) {
            .shoplytic-workspace {
                grid-template-columns: 276px minmax(0, 1fr);
                gap: 20px;
            }

            .shoplytic-product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 16px;
            }

            .shoplytic-workspace.filter-collapsed .shoplytic-product-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (min-width: 1440px) {
            .shoplytic-product-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 16px;
            }

            .shoplytic-workspace.filter-collapsed .shoplytic-product-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        /* --------------------------------------------------------
           2. BREAKPOINT 992px - 1199.98px: LAPTOP KECIL
           -------------------------------------------------------- */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .wrapper {
                padding: 14px 16px;
                gap: 16px;
            }

            #sidebar {
                width: 240px;
            }

            .shoplytic-workspace {
                grid-template-columns: 250px minmax(0, 1fr);
                gap: 16px;
            }

            .shoplytic-product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }

            .shoplytic-workspace.filter-collapsed .shoplytic-product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }
        }

        /* --------------------------------------------------------
           PORTABLE DEVICES (< 992px: TABLET & MOBILE SHARED RULES)
           -------------------------------------------------------- */
        @media (max-width: 991.98px) {
            body {
                padding-bottom: 74px;
            }

            .wrapper {
                flex-direction: column;
                padding: 12px;
                gap: 14px;
                max-width: 100%;
                overflow-x: hidden;
            }

            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: min(286px, 86vw);
                height: 100vh;
                max-height: 100vh;
                border-radius: 0 24px 24px 0;
                z-index: 1055;
                transform: translateX(-105%);
                transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            }

            #sidebar.mobile-open {
                transform: translateX(0);
            }

            #content {
                width: 100%;
                max-width: 100%;
                min-width: 0;
            }

            .top-navbar {
                position: sticky;
                top: 8px;
                z-index: 1020;
                flex-wrap: nowrap;
                padding: 12px 16px;
                gap: 12px;
                border-radius: 18px;
                box-shadow: 0 10px 28px rgba(16, 16, 16, 0.08);
                background: rgba(255, 255, 255, 0.95);
                max-width: 100%;
            }

            .admin-mobile-bottom-nav {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 1030;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                background: rgba(17, 24, 39, 0.96);
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                border-top: 1px solid rgba(255, 255, 255, 0.12);
                padding: 6px 4px calc(6px + env(safe-area-inset-bottom, 0px));
                box-shadow: 0 -8px 24px rgba(0, 0, 0, 0.2);
            }

            .admin-mobile-nav-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2px;
                color: rgba(255, 255, 255, 0.65);
                text-decoration: none;
                font-size: 0.68rem;
                font-weight: 700;
                padding: 5px 2px;
                border: 0;
                background: transparent;
                cursor: pointer;
                transition: all 0.15s ease;
            }

            .admin-mobile-nav-item i {
                font-size: 1.18rem;
                line-height: 1;
            }

            .admin-mobile-nav-item.active,
            .admin-mobile-nav-item:hover {
                color: var(--shop-lime);
            }

            .shoplytic-workspace {
                grid-template-columns: 1fr;
                gap: 16px;
                width: 100%;
            }

            /* Responsive Filter Drawer (< 992px) */
            .shoplytic-filter-card {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                width: min(340px, 88vw);
                height: 100vh;
                max-height: 100vh;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                overscroll-behavior: contain;
                z-index: 1060;
                background: #ffffff;
                border-radius: 20px 0 0 20px;
                border: 0;
                box-shadow: -10px 0 34px rgba(16, 16, 16, 0.22);
                transform: translateX(105%);
                transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1);
                padding: 20px;
                display: block !important;
            }

            .shoplytic-filter-card.drawer-open {
                transform: translateX(0) !important;
            }

            .shoplytic-main-panel {
                width: 100%;
                max-width: 100%;
                min-width: 0;
                box-sizing: border-box;
            }

            /* Dedicated Rows for Price & Actions to Guarantee Zero Overflow */
            .shoplytic-product-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
                padding-top: 8px;
            }

            .shoplytic-price-wrap {
                width: 100%;
                display: flex;
                align-items: baseline;
                justify-content: space-between;
            }

            .shoplytic-price {
                font-size: 0.95rem;
            }

            .shoplytic-card-actions {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .shoplytic-action-form {
                display: flex;
                width: 100%;
                margin: 0;
            }

            .shoplytic-card-actions > .shoplytic-icon-btn,
            .shoplytic-action-form > .shoplytic-icon-btn {
                width: 100%;
                height: 38px;
                font-size: 0.78rem;
                border-radius: 10px;
                justify-content: center;
            }

            .dashboard-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .dashboard-content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* --------------------------------------------------------
           3. BREAKPOINT 768px - 991.98px: TABLET
           -------------------------------------------------------- */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .shoplytic-product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }

            .shoplytic-img-box {
                height: 165px;
            }

            .top-title-wrap h1 {
                font-size: 1.15rem;
            }

            .top-title-wrap p {
                font-size: 0.76rem;
            }

            .shoplytic-subbar-actions {
                flex-wrap: wrap;
                gap: 10px;
            }
        }

        @media (min-width: 860px) and (max-width: 991.98px) {
            .shoplytic-product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 14px;
            }
        }

        /* --------------------------------------------------------
           4. BREAKPOINT 576px - 767.98px: MOBILE BESAR
           -------------------------------------------------------- */
        @media (min-width: 576px) and (max-width: 767.98px) {
            .wrapper {
                padding: 10px;
            }

            .top-navbar {
                padding: 10px 14px;
                gap: 10px;
            }

            .top-title-wrap h1 {
                font-size: 1.05rem;
            }

            .top-title-wrap p {
                display: none !important;
            }

            .top-profile-info {
                display: none !important;
            }

            .top-profile-pill {
                padding: 3px 8px 3px 3px;
                gap: 5px;
            }

            .top-profile-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .shoplytic-product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .shoplytic-img-box {
                height: 150px;
            }

            .shoplytic-subbar {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .shoplytic-subbar-actions {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .subbar-search-wrap {
                flex: 1 1 100%;
                width: 100%;
            }

            .shoplytic-subbar-actions .btn-subbar-pill {
                flex: 1 1 auto;
                height: 38px;
                justify-content: center;
            }

            .shoplytic-subbar-actions .btn-shoplytic-lime {
                flex: 1 1 auto;
                height: 38px;
                justify-content: center;
            }
        }

        /* --------------------------------------------------------
           5. BREAKPOINT < 576px: MOBILE KECIL (320px - 575.98px)
           -------------------------------------------------------- */
        @media (max-width: 575.98px) {
            .wrapper {
                padding: 8px;
                gap: 10px;
            }

            .top-navbar {
                position: sticky;
                top: 6px;
                z-index: 1020;
                padding: 8px 12px;
                gap: 8px;
                border-radius: 14px;
                background: rgba(255, 255, 255, 0.96);
            }

            .top-navbar-left {
                gap: 8px;
            }

            .top-sidebar-toggle {
                width: 34px;
                height: 34px;
                min-width: 34px;
                border-radius: 9px;
                font-size: 1.15rem;
            }

            .top-title-wrap h1,
            .top-title-wrap h5 {
                font-size: 0.95rem;
            }

            .top-title-wrap p {
                display: none !important;
            }

            .top-profile-info {
                display: none !important;
            }

            .top-profile-pill {
                padding: 2px 6px 2px 2px;
                gap: 4px;
            }

            .top-profile-avatar {
                width: 30px;
                height: 30px;
                font-size: 0.78rem;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .shoplytic-subbar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding-bottom: 12px;
                margin-bottom: 14px;
            }

            .shoplytic-subbar-actions {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .subbar-search-wrap {
                grid-column: 1 / -1;
                width: 100%;
            }

            .subbar-search-input {
                width: 100%;
                height: 40px;
            }

            .shoplytic-subbar-actions .btn-subbar-pill {
                width: 100%;
                height: 40px;
                justify-content: center;
                text-align: center;
                font-size: 0.78rem;
                padding: 0 8px;
                white-space: nowrap;
            }

            .shoplytic-subbar-actions .btn-shoplytic-lime {
                grid-column: 1 / -1;
                width: 100%;
                height: 42px;
                justify-content: center;
                font-size: 0.82rem;
                padding: 0 16px;
                white-space: nowrap;
            }

            .shoplytic-subbar-actions .btn-filter-toggle:only-of-type:not(:has(~ a.btn-subbar-pill)) {
                grid-column: 1 / -1;
            }

            .shoplytic-product-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .shoplytic-img-box {
                height: 180px;
            }

            .shoplytic-product-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding-top: 10px;
            }

            .shoplytic-card-actions {
                width: 100%;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .shoplytic-action-form {
                display: flex;
                width: 100%;
                margin: 0;
            }

            .shoplytic-card-actions > .shoplytic-icon-btn,
            .shoplytic-action-form > .shoplytic-icon-btn {
                width: 100%;
                height: 40px;
                font-size: 0.8rem;
                border-radius: 10px;
                justify-content: center;
            }

            .card-panel .card-header,
            .card-panel .card-body,
            .panel-card,
            .shoplytic-main-panel,
            .shoplytic-filter-card {
                padding: 14px;
                border-radius: 16px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

@php
    $isProductSection = request()->routeIs('admin.dashboard', 'admin.alat.*', 'admin.kategori.*');
    $isSewaSection = request()->routeIs('admin.penyewaan.*');
    $isBayarSection = request()->routeIs('admin.pembayaran.*');
    $isKembaliSection = request()->routeIs('admin.pengembalian.*');
    $isPelangganSection = request()->routeIs('admin.pelanggan.*');
    $isPetugasSection = request()->routeIs('admin.petugas.*');
    $isLaporanSection = request()->routeIs('admin.laporan.*');
@endphp

<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<div class="shoplytic-filter-backdrop" id="filterBackdrop"></div>

<div class="wrapper">
    <!-- Floating Sidebar with Internal Scroll & Interactive Collapsible Menus -->
    <nav id="sidebar">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('public.beranda') }}" class="shop-brand flex-grow-1 border-0 pb-0 mb-0">
                <span class="shop-brand-icon">
                    <img src="{{ asset('images/black.jpg') }}" alt="CampSewa" onerror="this.onerror=null; this.src='{{ asset('images/black.png') }}';">
                </span>
                <div>
                    <span class="shop-brand-title">CampSewa</span>
                    <span class="shop-brand-sub">{{ auth()->user()->isAdmin() ? 'Admin Panel' : 'Panel Petugas' }}</span>
                </div>
            </a>
            <button type="button" class="btn btn-sm btn-light rounded-circle d-lg-none" id="sidebarCloseBtn" aria-label="Tutup Menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <hr class="my-2 opacity-25">

        <div class="shop-sidebar-scroll">
            <div class="shop-nav-section-label">Menu Utama</div>
            <ul class="shop-nav-list">
                @if(auth()->user()->isAdmin())
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="shop-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="shop-nav-link-left">
                                <i class="bi bi-grid nav-icon"></i>
                                <span>Overview Dashboard</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <button
                            type="button"
                            class="shop-nav-link {{ $isProductSection ? 'active-group' : '' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuKatalogAlat"
                            aria-expanded="{{ $isProductSection ? 'true' : 'false' }}"
                        >
                            <span class="shop-nav-link-left">
                                <i class="bi bi-backpack nav-icon"></i>
                                <span>Katalog &amp; Alat</span>
                            </span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                        <div class="collapse {{ $isProductSection ? 'show' : '' }}" id="menuKatalogAlat">
                            <ul class="shop-submenu">
                                <li>
                                    <a href="{{ route('admin.alat.index') }}" class="shop-sublink {{ request()->routeIs('admin.alat.index') ? 'active' : '' }}">
                                        <span>Katalog Alat</span>
                                        <i class="bi bi-grid-3x3-gap small"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.kategori.index') }}" class="shop-sublink {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                                        <span>Kategori Alat</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @elseif(auth()->user()->isPetugas())
                    <li>
                        <a href="{{ route('petugas.dashboard') }}" class="shop-nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
                            <span class="shop-nav-link-left">
                                <i class="bi bi-grid nav-icon"></i>
                                <span>Overview Petugas</span>
                            </span>
                        </a>
                    </li>
                @endif

                @if(auth()->user()->isAdmin() || auth()->user()->isPetugas())
                    <div class="shop-nav-section-label">Operasional Sewa</div>

                    {{-- Transaksi Sewa --}}
                    <li>
                        <button
                            type="button"
                            class="shop-nav-link {{ $isSewaSection ? 'active-group' : '' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuTransaksiSewa"
                            aria-expanded="{{ $isSewaSection ? 'true' : 'false' }}"
                        >
                            <span class="shop-nav-link-left">
                                <i class="bi bi-bag-check nav-icon"></i>
                                <span>Transaksi Sewa</span>
                            </span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                        <div class="collapse {{ $isSewaSection ? 'show' : '' }}" id="menuTransaksiSewa">
                            <ul class="shop-submenu">
                                <li>
                                    <a href="{{ route('admin.penyewaan.index') }}" class="shop-sublink {{ request()->routeIs('admin.penyewaan.*') ? 'active' : '' }}">
                                        <span>Semua Transaksi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Pembayaran --}}
                    <li>
                        <button
                            type="button"
                            class="shop-nav-link {{ $isBayarSection ? 'active-group' : '' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuPembayaran"
                            aria-expanded="{{ $isBayarSection ? 'true' : 'false' }}"
                        >
                            <span class="shop-nav-link-left">
                                <i class="bi bi-receipt nav-icon"></i>
                                <span>Pembayaran</span>
                            </span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                        <div class="collapse {{ $isBayarSection ? 'show' : '' }}" id="menuPembayaran">
                            <ul class="shop-submenu">
                                <li>
                                    <a href="{{ route('admin.pembayaran.index') }}" class="shop-sublink {{ request()->routeIs('admin.pembayaran.index') ? 'active' : '' }}">
                                        <span>Riwayat Pembayaran</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- Pengembalian --}}
                    <li>
                        <a href="{{ route('admin.pengembalian.index') }}" class="shop-nav-link {{ $isKembaliSection ? 'active' : '' }}">
                            <span class="shop-nav-link-left">
                                <i class="bi bi-arrow-return-left nav-icon"></i>
                                <span>Pengembalian Alat</span>
                            </span>
                        </a>
                    </li>

                    {{-- Data Pelanggan --}}
                    <li>
                        <button
                            type="button"
                            class="shop-nav-link {{ $isPelangganSection ? 'active-group' : '' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuPelanggan"
                            aria-expanded="{{ $isPelangganSection ? 'true' : 'false' }}"
                        >
                            <span class="shop-nav-link-left">
                                <i class="bi bi-person-vcard nav-icon"></i>
                                <span>Data Pelanggan</span>
                            </span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                        <div class="collapse {{ $isPelangganSection ? 'show' : '' }}" id="menuPelanggan">
                            <ul class="shop-submenu">
                                <li>
                                    <a href="{{ route('admin.pelanggan.index') }}" class="shop-sublink {{ request()->routeIs('admin.pelanggan.index') && !request('status_verifikasi') ? 'active' : '' }}">
                                        <span>Semua Pelanggan</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.pelanggan.index', ['status_verifikasi' => 'belum_verifikasi']) }}" class="shop-sublink {{ request('status_verifikasi') === 'belum_verifikasi' ? 'active' : '' }}">
                                        <span>Verifikasi Member</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    @if(auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('admin.petugas.index') }}" class="shop-nav-link {{ $isPetugasSection ? 'active' : '' }}">
                                <span class="shop-nav-link-left">
                                    <i class="bi bi-people nav-icon"></i>
                                    <span>Data Petugas</span>
                                </span>
                            </a>
                        </li>
                    @endif

                    {{-- Pusat Laporan --}}
                    <li>
                        <button
                            type="button"
                            class="shop-nav-link {{ $isLaporanSection ? 'active-group' : '' }}"
                            data-bs-toggle="collapse"
                            data-bs-target="#menuLaporan"
                            aria-expanded="{{ $isLaporanSection ? 'true' : 'false' }}"
                        >
                            <span class="shop-nav-link-left">
                                <i class="bi bi-bar-chart-line nav-icon"></i>
                                <span>Pusat Laporan</span>
                            </span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                        <div class="collapse {{ $isLaporanSection ? 'show' : '' }}" id="menuLaporan">
                            <ul class="shop-submenu">
                                <li>
                                    <a href="{{ route('admin.laporan.alat') }}" class="shop-sublink {{ request()->routeIs('admin.laporan.alat') ? 'active' : '' }}">
                                        <span>Laporan Alat</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.laporan.penyewaan') }}" class="shop-sublink {{ request()->routeIs('admin.laporan.penyewaan') ? 'active' : '' }}">
                                        <span>Laporan Penyewaan</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.laporan.pembayaran') }}" class="shop-sublink {{ request()->routeIs('admin.laporan.pembayaran') ? 'active' : '' }}">
                                        <span>Laporan Pembayaran</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.laporan.belum_kembali') }}" class="shop-sublink {{ request()->routeIs('admin.laporan.belum_kembali') ? 'active' : '' }}">
                                        <span>Belum Kembali</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif
            </ul>
        </div>

        <div class="shop-sidebar-bottom">
            <ul class="shop-nav-list">
                <li>
                    <a href="{{ route('public.beranda') }}" target="_blank" class="shop-nav-link py-2">
                        <span class="shop-nav-link-left">
                            <i class="bi bi-box-arrow-up-right nav-icon"></i>
                            <span>Lihat Landing Page</span>
                        </span>
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="shop-logout-btn">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar / Log Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div id="content">
        <!-- Floating Top Header Card -->
        <header class="top-navbar">
            <div class="top-navbar-left">
                <button class="top-sidebar-toggle d-lg-none" id="sidebarToggle" type="button" aria-label="Buka Menu Navigasi">
                    <i class="bi bi-list"></i>
                </button>
                <div class="top-title-wrap">
                    <h1>@yield('page_title', 'Dashboard Admin')</h1>
                    <p class="d-none d-md-block">@yield('page_subtitle', 'Kelola inventaris peralatan camping, harga sewa, dan transaksi penyewaan.')</p>
                </div>
            </div>

            <div class="top-right-actions">
                <div class="dropdown">
                    <button class="top-profile-pill dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="top-profile-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </span>
                        <span class="top-profile-info">
                            <span class="top-profile-name">{{ \Illuminate\Support\Str::words(auth()->user()->name, 2, '') }}</span>
                            <span class="top-profile-role">{{ ucfirst(auth()->user()->role) }}</span>
                        </span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-4 mt-2">
                        <li>
                            <div class="dropdown-item-text">
                                <small class="text-muted">Masuk sebagai:</small><br>
                                <strong>{{ auth()->user()->email }}</strong>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> Keluar / Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Body Container -->
        <main class="main-container">
            @if(session('success'))
                <div class="camp-flash-alert success alert alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <span class="camp-flash-icon"><i class="bi bi-check-lg"></i></span>
                        <div>
                            <div class="fw-extrabold small text-uppercase" style="letter-spacing: 0.04em; color: var(--shop-green-text);">Berhasil</div>
                            <div class="fw-semibold text-dark">{{ session('success') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close position-static" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="camp-flash-alert error alert alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <span class="camp-flash-icon"><i class="bi bi-exclamation-triangle-fill"></i></span>
                        <div>
                            <div class="fw-extrabold small text-uppercase text-danger" style="letter-spacing: 0.04em;">Perhatian</div>
                            <div class="fw-semibold text-dark">{{ session('error') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close position-static" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="camp-flash-alert info alert alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <span class="camp-flash-icon"><i class="bi bi-info-circle-fill"></i></span>
                        <div>
                            <div class="fw-extrabold small text-uppercase text-primary" style="letter-spacing: 0.04em;">Informasi</div>
                            <div class="fw-semibold text-dark">{{ session('info') }}</div>
                        </div>
                    </div>
                    <button type="button" class="btn-close position-static" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="camp-flash-alert error alert alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start gap-3">
                        <span class="camp-flash-icon"><i class="bi bi-x-circle-fill"></i></span>
                        <div>
                            <div class="fw-extrabold small text-uppercase text-danger mb-1">Periksa Kembali Formulir</div>
                            <ul class="mb-0 ps-3 small fw-semibold text-dark">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <button type="button" class="btn-close position-static" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Custom Modern Confirmation Modal (Replaces Browser Native confirm()) -->
<div class="modal fade" id="campConfirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 410px;">
        <div class="modal-content camp-modal-content p-4 text-center">
            <div class="mx-auto camp-modal-icon danger" id="campConfirmIcon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h5 class="fw-extrabold mb-2" style="color: var(--shop-text);" id="campConfirmTitle">Konfirmasi Tindakan</h5>
            <p class="text-secondary small mb-4" id="campConfirmMessage">Apakah Anda yakin ingin melanjutkan tindakan ini?</p>
            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn-subbar-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger rounded-pill px-4 fw-bold" id="campConfirmAcceptBtn">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Sticky Mobile Bottom Navigation Bar for Admin/Petugas (< 992px) --}}
<nav class="admin-mobile-bottom-nav d-lg-none" aria-label="Navigasi Cepat Admin">
    @php
        $isPetugas = auth()->user()?->isPetugas();
        $dashRoute = $isPetugas ? route('petugas.dashboard') : route('admin.dashboard');
        $alatRoute = route('admin.alat.index');
        $sewaRoute = route('admin.penyewaan.index');
        $bayarRoute = route('admin.pembayaran.index');
    @endphp

    <a href="{{ $dashRoute }}" class="admin-mobile-nav-item {{ request()->routeIs('admin.dashboard', 'petugas.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="{{ $alatRoute }}" class="admin-mobile-nav-item {{ request()->routeIs('admin.alat.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i>
        <span>Alat</span>
    </a>

    <a href="{{ $sewaRoute }}" class="admin-mobile-nav-item {{ request()->routeIs('admin.penyewaan.*') ? 'active' : '' }}">
        <i class="bi bi-bag-check"></i>
        <span>Sewa</span>
    </a>

    <a href="{{ $bayarRoute }}" class="admin-mobile-nav-item {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i>
        <span>Bayar</span>
    </a>

    <button type="button" class="admin-mobile-nav-item border-0 bg-transparent" id="mobileBottomMenuBtn" aria-label="Buka Menu Lengkap">
        <i class="bi bi-grid-fill"></i>
        <span>Menu</span>
    </button>
</nav>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggleBtn = document.getElementById('sidebarToggle');
    const bottomMenuBtn = document.getElementById('mobileBottomMenuBtn');
    const closeBtn = document.getElementById('sidebarCloseBtn');
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');

    function toggleMobileSidebar() {
        if (!sidebar) return;
        sidebar.classList.toggle('mobile-open');
        if (backdrop) {
            backdrop.classList.toggle('show', sidebar.classList.contains('mobile-open'));
        }
    }

    function closeMobileSidebar() {
        if (sidebar) sidebar.classList.remove('mobile-open');
        if (backdrop) backdrop.classList.remove('show');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', toggleMobileSidebar);
    }
    if (bottomMenuBtn) {
        bottomMenuBtn.addEventListener('click', toggleMobileSidebar);
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', closeMobileSidebar);
    }
    if (backdrop) {
        backdrop.addEventListener('click', closeMobileSidebar);
    }

    // Intercept native onsubmit="return confirm('...')" forms and replace with sleek Bootstrap Modal
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('campConfirmModal');
        if (!modalEl || typeof bootstrap === 'undefined') {
            return;
        }

        const confirmModal = new bootstrap.Modal(modalEl);
        const msgEl = document.getElementById('campConfirmMessage');
        const acceptBtn = document.getElementById('campConfirmAcceptBtn');
        let pendingForm = null;

        document.querySelectorAll('form[onsubmit*="confirm("]').forEach(function (form) {
            const rawAttr = form.getAttribute('onsubmit') || '';
            const match = rawAttr.match(/confirm\(['"](.+?)['"]\)/);
            const message = match ? match[1] : 'Apakah Anda yakin ingin melanjutkan tindakan ini?';

            form.removeAttribute('onsubmit');
            form.dataset.confirmMessage = message;

            form.addEventListener('submit', function (e) {
                if (form.dataset.confirmed === 'true') {
                    return true;
                }
                e.preventDefault();
                pendingForm = form;
                if (msgEl) {
                    msgEl.textContent = form.dataset.confirmMessage;
                }
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

        // Modern Collapsible Sidebar / Drawer Filter Logic
        function setFilterState(btn, isOn) {
            const workspace = btn.closest('.shoplytic-workspace') || document.querySelector('.shoplytic-workspace');
            if (!workspace) return;
            const filterCard = workspace.querySelector('.shoplytic-filter-card');
            const filterBackdrop = document.getElementById('filterBackdrop');

            if (window.innerWidth < 992) {
                if (filterCard) {
                    const willOpen = isOn;
                    filterCard.classList.toggle('drawer-open', willOpen);
                    if (filterBackdrop) {
                        filterBackdrop.classList.toggle('show', willOpen);
                    }
                    document.body.classList.toggle('drawer-locked', willOpen);
                    btn.classList.toggle('active', willOpen);
                    btn.setAttribute('aria-pressed', willOpen ? 'true' : 'false');
                }
            } else {
                workspace.classList.toggle('filter-collapsed', !isOn);
                btn.classList.toggle('active', isOn);
                btn.setAttribute('aria-pressed', isOn ? 'true' : 'false');
                if (filterCard && isOn) {
                    filterCard.classList.add('filter-highlight');
                    setTimeout(function () {
                        filterCard.classList.remove('filter-highlight');
                    }, 900);
                }
            }
        }

        function closeMobileFilterDrawer() {
            const filterCard = document.querySelector('.shoplytic-filter-card');
            const filterBackdrop = document.getElementById('filterBackdrop');
            if (filterCard) {
                filterCard.classList.remove('drawer-open');
            }
            if (filterBackdrop) {
                filterBackdrop.classList.remove('show');
            }
            document.body.classList.remove('drawer-locked');
            document.querySelectorAll('[data-toggle-shop-filter]').forEach(function (btn) {
                const hasActiveFilter = btn.dataset.hasActiveFilter === '1';
                btn.classList.toggle('active', hasActiveFilter);
                btn.setAttribute('aria-pressed', 'false');
            });
        }

        // Initialize state on page load based on current screen & visibility
        document.querySelectorAll('[data-toggle-shop-filter]').forEach(function (btn) {
            const workspace = btn.closest('.shoplytic-workspace') || document.querySelector('.shoplytic-workspace');
            if (workspace) {
                const hasActiveFilter = btn.dataset.hasActiveFilter === '1';
                if (window.innerWidth < 992) {
                    btn.classList.toggle('active', hasActiveFilter);
                    btn.setAttribute('aria-pressed', 'false');
                } else {
                    const isVisible = !workspace.classList.contains('filter-collapsed');
                    btn.classList.toggle('active', hasActiveFilter || isVisible);
                    btn.setAttribute('aria-pressed', isVisible ? 'true' : 'false');
                }
            }

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                if (window.innerWidth < 992) {
                    const filterCard = document.querySelector('.shoplytic-filter-card');
                    const isDrawerOpen = filterCard ? filterCard.classList.contains('drawer-open') : false;
                    setFilterState(btn, !isDrawerOpen);
                } else {
                    const isCollapsed = workspace.classList.contains('filter-collapsed');
                    setFilterState(btn, isCollapsed);
                }
            });
        });

        // Close button inside filter card header on mobile
        document.querySelectorAll('[data-close-shop-filter]').forEach(function (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                closeMobileFilterDrawer();
            });
        });

        // Backdrop click closes filter drawer
        const filterBackdrop = document.getElementById('filterBackdrop');
        if (filterBackdrop) {
            filterBackdrop.addEventListener('click', closeMobileFilterDrawer);
        }

        // Escape key closes open drawers
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeMobileFilterDrawer();
                closeMobileSidebar();
            }
        });

        // Window resize resets mobile drawers when scaling back to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                closeMobileFilterDrawer();
                closeMobileSidebar();
            }
        });
    });
</script>
@yield('scripts')
</body>
</html>
