@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('meta_description', 'Panel kontrol Admin / Tata Usaha SIAK SMK')
@section('brand_icon', '🛡️')
@section('brand_subtitle', 'Panel Admin / TU')
@section('page_title', 'Dashboard Admin')
@section('role_badge', 'Admin / TU')

{{-- ── Warna tema violet/indigo untuk Admin ── --}}
@section('accent',       '#4f46e5')
@section('accent_light', '#eef2ff')
@section('accent_mid',   '#a5b4fc')
@section('accent_dark',  '#3730a3')
@section('sidebar_bg',   '#1e1b4b')

@section('sidebar_nav')
    <p class="nav-section-title">Utama</p>
    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>

    <p class="nav-section-title">Manajemen Data</p>
    <a href="{{ route('admin.siswa.index') }}" class="nav-link {{ request()->routeIs('admin.siswa*') ? 'active' : '' }}">
        <span class="nav-icon">👥</span> Data Siswa
    </a>
    <a href="{{ route('admin.guru.index') }}" class="nav-link {{ request()->routeIs('admin.guru*') ? 'active' : '' }}">
        <span class="nav-icon">👨‍🏫</span> Data Guru
    </a>
    <form method="POST" action="{{ route('logout') }}" class="mt-4">
    @csrf
    <button type="submit" class="w-full flex items-center px-4 py-3 text-red-500 hover:bg-red-50 hover:text-red-600 rounded-xl transition duration-200 font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Logout
    </button>
</form>

@endsection

@section('content')

{{-- ── Hero greeting ── --}}
<div style="margin-bottom:28px;">
    <h1 style="font-size:1.6rem;font-weight:800;color:#1e1b4b;margin-bottom:6px;">
        Selamat datang, {{ Auth::user()->name }}! 👋
    </h1>
    <p style="color:#6b7280;font-size:.9rem;">
        Berikut ringkasan data sistem per hari ini,
        <strong>{{ now()->isoFormat('dddd, D MMMM Y') }}</strong>.
    </p>
</div>

{{-- ── Stat Cards ── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#eef2ff;">👥</div>
        <div class="stat-info">
            <p>Total Siswa</p>
            <strong>{{ $totalSiswa }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#d1fae5;">👨‍🏫</div>
        <div class="stat-info">
            <p>Total Guru</p>
            <strong>{{ $totalGuru }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fce7f3;">🏫</div>
        <div class="stat-info">
            <p>Total Kelas</p>
            <strong>{{ $totalKelas }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#e0f2fe;">📚</div>
        <div class="stat-info">
            <p>Mata Pelajaran</p>
            <strong>{{ $totalMapel }}</strong>
        </div>
    </div>
</div>

{{-- ── Quick Actions ── --}}
<div class="card" style="margin-bottom:28px;">
    <div class="card-header">
        <h3>⚡ Aksi Cepat</h3>
    </div>
    <div class="card-body" style="display:flex;flex-wrap:wrap;gap:12px;">
        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
            ➕ Tambah Siswa Baru
        </a>
        <a href="{{ route('admin.guru.create') }}" class="btn btn-primary">
            ➕ Tambah Guru Baru
        </a>
        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
            📋 Lihat Semua Siswa
        </a>
        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
            📋 Lihat Semua Guru
        </a>
    </div>
</div>

{{-- ── Grafik Presensi Harian ── --}}
<div class="card">
    <div class="card-header">
        <h3>📈 Grafik Presensi Harian (Hari Ini)</h3>
    </div>
    <div class="card-body">
        <div style="display: flex; align-items: flex-end; height: 180px; gap: 20px; padding: 20px 20px 0 20px; border-bottom: 2px solid #e5e7eb;">
            <!-- Dummy Data / Placeholder for Bar Chart -->
            <div style="flex: 1; background: linear-gradient(to top, #10b981, #34d399); height: 92%; border-radius: 8px 8px 0 0; position: relative;" title="Hadir - 92%">
                <span style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: 700; font-size: 0.85rem; color: #047857;">92%</span>
            </div>
            <div style="flex: 1; background: linear-gradient(to top, #3b82f6, #60a5fa); height: 5%; border-radius: 8px 8px 0 0; position: relative;" title="Sakit - 5%">
                <span style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: 700; font-size: 0.85rem; color: #1d4ed8;">5%</span>
            </div>
            <div style="flex: 1; background: linear-gradient(to top, #f59e0b, #fbbf24); height: 2%; border-radius: 8px 8px 0 0; position: relative;" title="Izin - 2%">
                <span style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: 700; font-size: 0.85rem; color: #b45309;">2%</span>
            </div>
            <div style="flex: 1; background: linear-gradient(to top, #ef4444, #f87171); height: 1%; border-radius: 8px 8px 0 0; position: relative;" title="Alpa - 1%">
                <span style="position: absolute; top: -25px; left: 50%; transform: translateX(-50%); font-weight: 700; font-size: 0.85rem; color: #b91c1c;">1%</span>
            </div>
        </div>
        <div style="display: flex; justify-content: space-between; gap: 20px; padding: 10px 20px 0; font-size: 0.85rem; font-weight: 600; color: #6b7280; text-align: center;">
            <span style="flex: 1;">Hadir</span>
            <span style="flex: 1;">Sakit</span>
            <span style="flex: 1;">Izin</span>
            <span style="flex: 1;">Alpa</span>
        </div>
    </div>
</div>

@endsection