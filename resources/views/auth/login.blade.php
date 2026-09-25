<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Akademik — Login">
    <title>Login — SIAK SMK</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --lavender:     #ede9fe;
            --lavender-mid: #c4b5fd;
            --violet:       #7c3aed;
            --violet-dark:  #5b21b6;
            --rose:         #fce7f3;
            --sky:          #e0f2fe;
            --mint:         #d1fae5;
            --text-dark:    #1e1b4b;
            --text-mid:     #4c1d95;
            --text-muted:   #6b7280;
            --white:        #ffffff;
            --card-bg:      rgba(255,255,255,0.85);
            --shadow:       0 20px 60px rgba(124,58,237,.15);
            --radius:       20px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f3e8ff 0%, #fce7f3 35%, #e0f2fe 70%, #d1fae5 100%);
            position: relative;
            overflow: hidden;
        }

        /* Pastel floating blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            pointer-events: none;
        }
        body::before {
            width: 500px; height: 500px;
            background: radial-gradient(circle, #c4b5fd, #fbcfe8);
            top: -150px; left: -100px;
            animation: float1 8s ease-in-out infinite alternate;
        }
        body::after {
            width: 400px; height: 400px;
            background: radial-gradient(circle, #a5f3fc, #bbf7d0);
            bottom: -100px; right: -100px;
            animation: float2 10s ease-in-out infinite alternate;
        }
        @keyframes float1 { to { transform: translate(40px, 30px) scale(1.1); } }
        @keyframes float2 { to { transform: translate(-30px, -40px) scale(1.08); } }

        /* ── Card ── */
        .card {
            position: relative;
            z-index: 10;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 48px 44px;
            width: 100%;
            max-width: 440px;
            animation: slideUp .5s cubic-bezier(.22,.68,0,1.2) both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ── Logo Area ── */
        .logo-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 32px;
        }
        .logo-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--violet), #a855f7);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 28px;
            box-shadow: 0 8px 24px rgba(124,58,237,.35);
            margin-bottom: 16px;
        }
        .logo-wrap h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            text-align: center;
        }
        .logo-wrap p {
            font-size: .875rem;
            color: var(--text-muted);
            margin-top: 4px;
            text-align: center;
        }

        /* ── Alerts ── */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: .85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-weight: 500;
        }
        .alert-error   { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }

        /* ── Form ── */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: .8rem;
            font-weight: 700;
            color: var(--text-mid);
            margin-bottom: 6px;
            letter-spacing: .4px;
            text-transform: uppercase;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            opacity: .5;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 13px 16px 13px 42px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            font-family: inherit;
            font-size: .95rem;
            color: var(--text-dark);
            background: rgba(255,255,255,.7);
            transition: border-color .2s, box-shadow .2s, background .2s;
            outline: none;
        }
        .form-input::placeholder { color: #9ca3af; }
        .form-input:focus {
            border-color: var(--violet);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(124,58,237,.12);
        }
        .form-input.is-error { border-color: #f87171; box-shadow: 0 0 0 3px rgba(248,113,113,.1); }

        /* toggle password */
        .toggle-pwd {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            font-size: 1.1rem; opacity: .45;
            transition: opacity .2s;
        }
        .toggle-pwd:hover { opacity: .9; }

        /* ── Remember row ── */
        .row-remember {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
        }
        .check-label {
            display: flex; align-items: center; gap: 8px;
            font-size: .87rem; color: var(--text-muted); cursor: pointer; user-select: none;
        }
        .check-label input[type="checkbox"] { accent-color: var(--violet); width: 16px; height: 16px; }

        /* ── Submit button ── */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--violet), #a855f7);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: .3px;
            box-shadow: 0 6px 20px rgba(124,58,237,.35);
            transition: transform .15s, box-shadow .15s;
            position: relative;
            overflow: hidden;
        }
        .btn-submit::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255,255,255,0);
            transition: background .2s;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 10px 28px rgba(124,58,237,.4); }
        .btn-submit:hover::after { background: rgba(255,255,255,.08); }
        .btn-submit:active { transform: translateY(1px); }

        /* ── Badge roles ── */
        .roles-hint {
            margin-top: 28px;
            padding: 16px;
            background: rgba(237,233,254,.6);
            border-radius: 12px;
            border: 1px dashed var(--lavender-mid);
        }
        .roles-hint p {
            font-size: .78rem;
            font-weight: 700;
            color: var(--text-mid);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }
        .role-badges { display: flex; gap: 8px; flex-wrap: wrap; }
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: .78rem;
            font-weight: 600;
        }
        .badge-admin  { background: #ede9fe; color: #5b21b6; }
        .badge-guru   { background: #d1fae5; color: #065f46; }
        .badge-siswa  { background: #fce7f3; color: #9d174d; }

        /* ── Footer ── */
        .card-footer {
            margin-top: 24px;
            text-align: center;
            font-size: .8rem;
            color: var(--text-muted);
        }
    </style>
</head>
<body>

<div class="card" role="main">

    <!-- Logo & Header -->
    <div class="logo-wrap">
        <div class="logo-icon" aria-hidden="true">🎓</div>
        <h1>Sistem Informasi Akademik</h1>
        <p>SMK — Siswa, Nilai &amp; Absensi</p>
    </div>

    <!-- Alert Error -->
    @if ($errors->any())
        <div class="alert alert-error" role="alert">
            <span class="alert-icon">⚠️</span>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <!-- Alert Session Success (setelah logout) -->
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            <span class="alert-icon">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Form Login -->
    <form id="login-form" action="{{ route('login.post') }}" method="POST" novalidate>
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <div class="input-wrap">
                <span class="input-icon">✉️</span>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                    placeholder="nama@sekolah.sch.id"
                    autocomplete="email"
                    autofocus
                    required
                >
            </div>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <div class="input-wrap">
                <span class="input-icon">🔒</span>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="••••••••"
                    autocomplete="current-password"
                    required
                >
                <button
                    type="button"
                    class="toggle-pwd"
                    id="toggle-pwd"
                    aria-label="Tampilkan password"
                >👁️</button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="row-remember">
            <label class="check-label" for="remember">
                <input type="checkbox" id="remember" name="remember" value="1">
                Ingat saya
            </label>
        </div>

        <!-- Submit -->
        <button type="submit" id="btn-login" class="btn-submit">
            Masuk ke Sistem
        </button>
    </form>

    <!-- Role Hint -->
    <div class="roles-hint" aria-label="Informasi role">
        <p>Hak Akses Sistem</p>
        <div class="role-badges">
            <span class="badge badge-admin">Admin / TU</span>
            <span class="badge badge-guru">Guru</span>
            <span class="badge badge-siswa">Siswa</span>
        </div>
    </div>

    <p class="card-footer">&copy; {{ date('Y') }} SIAK SMK — Sistem Informasi Akademik</p>
</div>

<script>
    // Toggle show/hide password
    document.getElementById('toggle-pwd').addEventListener('click', function () {
        const pwd = document.getElementById('password');
        const isHidden = pwd.type === 'password';
        pwd.type = isHidden ? 'text' : 'password';
        this.textContent = isHidden ? '🙈' : '👁️';
        this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
    });

    // Loading state saat submit
    document.getElementById('login-form').addEventListener('submit', function () {
        const btn = document.getElementById('btn-login');
        btn.disabled = true;
        btn.textContent = 'Memproses…';
    });
</script>

</body>
</html>