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

{{-- ── Info Box ── --}}
<div class="card">
    <div class="card-header">
        <h3>ℹ️ Informasi Sistem</h3>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;">
            <div style="padding:14px;background:#f9fafb;border-radius:10px;border:1px solid #e5e7eb;">
                <p style="font-size:.78rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Laravel</p>
                <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">v{{ app()->version() }}</p>
            </div>
            <div style="padding:14px;background:#f9fafb;border-radius:10px;border:1px solid #e5e7eb;">
                <p style="font-size:.78rem;color:#6b7280;font-weight:600;text-transform:uppercase;">PHP</p>
                <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">v{{ PHP_VERSION }}</p>
            </div>
            <div style="padding:14px;background:#f9fafb;border-radius:10px;border:1px solid #e5e7eb;">
                <p style="font-size:.78rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Status Server</p>
                <p style="font-weight:700;color:#16a34a;margin-top:4px;">🟢 Online</p>
            </div>
        </div>
    </div>
</div>

@endsection