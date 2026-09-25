<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Sistem Informasi Akademik SMK')">
    <title>@yield('title', 'SIAK SMK') — SIAK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* Role color tokens — overridden per layout */
            --accent:      @yield('accent', '#7c3aed');
            --accent-light:@yield('accent_light', '#ede9fe');
            --accent-mid:  @yield('accent_mid', '#c4b5fd');
            --accent-dark: @yield('accent_dark', '#5b21b6');
            --sidebar-bg:  @yield('sidebar_bg', '#1e1b4b');
            --sidebar-txt: #e0e7ff;
            --page-bg:     #f8f7ff;
            --card-bg:     #ffffff;
            --text-dark:   #111827;
            --text-muted:  #6b7280;
            --radius:      14px;
            --shadow-sm:   0 2px 8px rgba(0,0,0,.06);
            --shadow-md:   0 8px 24px rgba(0,0,0,.10);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--page-bg);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: transform .3s;
        }
        .sidebar-brand {
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar-brand .brand-icon {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--accent), var(--accent-mid));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            margin-bottom: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,.3);
        }
        .sidebar-brand h2 {
            color: #fff;
            font-size: .95rem;
            font-weight: 800;
            line-height: 1.3;
        }
        .sidebar-brand p {
            color: rgba(255,255,255,.45);
            font-size: .75rem;
            margin-top: 3px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 14px;
            overflow-y: auto;
        }
        .nav-section-title {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255,255,255,.3);
            padding: 0 10px;
            margin-bottom: 8px;
            margin-top: 16px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            color: var(--sidebar-txt);
            text-decoration: none;
            font-size: .875rem;
            font-weight: 500;
            margin-bottom: 2px;
            transition: background .2s, color .2s;
        }
        .nav-link .nav-icon { font-size: 1.1rem; width: 22px; text-align: center; }
        .nav-link:hover {
            background: rgba(255,255,255,.1);
            color: #fff;
        }
        .nav-link.active {
            background: linear-gradient(135deg, var(--accent), var(--accent-mid));
            color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,.25);
        }

        .sidebar-footer {
            padding: 16px 14px 24px;
            border-top: 1px solid rgba(255,255,255,.08);
        }
        .user-card {
            display: flex; align-items: center; gap: 12px;
            padding: 12px;
            background: rgba(255,255,255,.07);
            border-radius: 12px;
            margin-bottom: 10px;
        }
        .user-avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--accent), var(--accent-mid));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .85rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .user-info { overflow: hidden; }
        .user-info strong {
            display: block;
            color: #fff;
            font-size: .83rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-info span {
            font-size: .72rem;
            color: rgba(255,255,255,.4);
        }
        .btn-logout {
            width: 100%;
            padding: 9px;
            background: rgba(239,68,68,.15);
            border: 1px solid rgba(239,68,68,.25);
            border-radius: 10px;
            color: #fca5a5;
            font-family: inherit;
            font-size: .84rem;
            font-weight: 600;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 6px;
            transition: background .2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,.3); color: #fff; }

        /* ── MAIN CONTENT ── */
        .main {
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top bar */
        .topbar {
            position: sticky; top: 0; z-index: 50;
            background: rgba(248,247,255,.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #ede9fe;
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .topbar-badge {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: .78rem;
            font-weight: 700;
            background: var(--accent-light);
            color: var(--accent-dark);
        }

        /* Page content */
        .page-content {
            flex: 1;
            padding: 32px;
        }

        /* ── CARDS ── */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid #f3f4f6;
        }
        .card-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
        }
        .card-header h3 { font-size: 1rem; font-weight: 700; }
        .card-body { padding: 24px; }

        /* ── STAT CARDS ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 22px 24px;
            box-shadow: var(--shadow-sm);
            border: 1px solid #f3f4f6;
            display: flex; align-items: center; gap: 16px;
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .stat-info p { font-size: .8rem; color: var(--text-muted); font-weight: 500; }
        .stat-info strong { font-size: 1.75rem; font-weight: 800; color: var(--text-dark); }

        /* ── ALERTS ── */
        .alert {
            padding: 12px 18px;
            border-radius: 12px;
            font-size: .875rem;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex; align-items: flex-start; gap: 10px;
        }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-icon { font-size: 1.1rem; }

        /* ── TABLES ── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: var(--accent-light);
            color: var(--accent-dark);
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            padding: 12px 16px;
            text-align: left;
        }
        tbody td { padding: 13px 16px; border-bottom: 1px solid #f3f4f6; font-size: .88rem; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: #fafafa; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px;
            border-radius: 10px;
            font-family: inherit;
            font-size: .875rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: transform .15s, box-shadow .15s, opacity .15s;
        }
        .btn:hover { transform: translateY(-1px); opacity: .9; }
        .btn:active { transform: translateY(0); }
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-mid));
            color: #fff;
            box-shadow: 0 4px 12px rgba(124,58,237,.3);
        }
        .btn-danger { background: #fee2e2; color: #dc2626; }
        .btn-secondary { background: #f3f4f6; color: #374151; }
        .btn-sm { padding: 6px 12px; font-size: .8rem; border-radius: 8px; }

        /* ── BADGES ── */
        .badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: .75rem;
            font-weight: 600;
        }
        .badge-violet  { background: #ede9fe; color: #5b21b6; }
        .badge-green   { background: #d1fae5; color: #065f46; }
        .badge-pink    { background: #fce7f3; color: #9d174d; }
        .badge-sky     { background: #e0f2fe; color: #0369a1; }

        /* responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-260px); }
            .main { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ═══════════════════════════════════════════════════
     SIDEBAR
═══════════════════════════════════════════════════ --}}
<aside class="sidebar" id="sidebar" role="navigation" aria-label="Navigasi utama">

    <div class="sidebar-brand">
        <div class="brand-icon" aria-hidden="true">@yield('brand_icon', '🎓')</div>
        <h2>SIAK SMK</h2>
        <p>@yield('brand_subtitle', 'Sistem Informasi Akademik')</p>
    </div>

    <nav class="sidebar-nav">
        @yield('sidebar_nav')
    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar" aria-hidden="true">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="user-info">
                <strong>{{ Auth::user()->name }}</strong>
                <span>{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">
                <span aria-hidden="true">🚪</span> Keluar dari Sistem
            </button>
        </form>
    </div>
</aside>

{{-- ═══════════════════════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════════════════════ --}}
<main class="main" id="main-content">

    <div class="topbar">
        <span class="topbar-title">@yield('page_title', 'Dashboard')</span>
        <span class="topbar-badge">@yield('role_badge', ucfirst(Auth::user()->role))</span>
    </div>

    <div class="page-content">

        {{-- Global session alerts --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <span class="alert-icon">✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error" role="alert">
                <span class="alert-icon">⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <span class="alert-icon">⚠️</span>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        @yield('content')
    </div>
</main>

@stack('scripts')
</body>
</html>
