@extends('layouts.app')

@section('title', 'Dashboard Guru')
@section('meta_description', 'Portal Guru — Kelola Nilai Siswa')
@section('brand_icon', '👨‍🏫')
@section('brand_subtitle', 'Portal Guru')
@section('page_title', 'Dashboard Guru')
@section('role_badge', 'Guru')

{{-- ── Warna tema hijau emerald untuk Guru ── --}}
@section('accent',       '#059669')
@section('accent_light', '#d1fae5')
@section('accent_mid',   '#6ee7b7')
@section('accent_dark',  '#047857')
@section('sidebar_bg',   '#022c22')

@section('sidebar_nav')
    <p class="nav-section-title">Utama</p>
    <a href="{{ route('guru.dashboard') }}" class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>

    <p class="nav-section-title">Akademik</p>
    <a href="{{ route('guru.nilai.index') }}" class="nav-link {{ request()->routeIs('guru.nilai*') ? 'active' : '' }}">
        <span class="nav-icon">📝</span> Kelola Nilai Siswa
    </a>
    <a href="{{ route('guru.nilai.create') }}" class="nav-link">
        <span class="nav-icon">➕</span> Input Nilai Baru
    </a>
@endsection

@section('content')

{{-- ── Greeting ── --}}
<div style="margin-bottom:28px;">
    <h1 style="font-size:1.6rem;font-weight:800;color:#022c22;margin-bottom:6px;">
        Halo, {{ $guru?->nama_guru ?? Auth::user()->name }}! 👋
    </h1>
    <p style="color:#6b7280;font-size:.9rem;">
        @if($guru)
            <span style="font-weight:600;">NIP: {{ $guru->nama_guru }}</span> •
            {{ now()->isoFormat('dddd, D MMMM Y') }}
        @else
            Data profil guru belum dilengkapi oleh Admin.
        @endif
    </p>
</div>

{{-- ── Stat Cards ── --}}
<div class="stats-grid" style="margin-bottom:28px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#d1fae5;">📝</div>
        <div class="stat-info">
            <p>Total Nilai Diinput</p>
            <strong>{{ $jumlahNilai }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fce7f3;">📅</div>
        <div class="stat-info">
            <p>Tanggal Hari Ini</p>
            <strong style="font-size:1.1rem;">{{ now()->format('d M Y') }}</strong>
        </div>
    </div>
</div>

{{-- ── Aksi Utama ── --}}
<div class="card" style="margin-bottom:28px;">
    <div class="card-header">
        <h3>📚 Menu Akademik</h3>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;">

            {{-- Input Nilai --}}
            <a href="{{ route('guru.nilai.create') }}" style="text-decoration:none;">
                <div style="padding:20px;background:linear-gradient(135deg,#d1fae5,#a7f3d0);
                     border-radius:14px;border:1px solid #6ee7b7;
                     transition:transform .2s,box-shadow .2s;cursor:pointer;"
                     onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(5,150,105,.2)'"
                     onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <div style="font-size:2rem;margin-bottom:10px;">✏️</div>
                    <h4 style="font-size:.95rem;font-weight:700;color:#065f46;margin-bottom:4px;">Input Nilai Baru</h4>
                    <p style="font-size:.8rem;color:#047857;">Tambah nilai tugas, UTS, dan UAS siswa</p>
                </div>
            </a>

            {{-- Lihat Semua Nilai --}}
            <a href="{{ route('guru.nilai.index') }}" style="text-decoration:none;">
                <div style="padding:20px;background:linear-gradient(135deg,#e0f2fe,#bae6fd);
                     border-radius:14px;border:1px solid #7dd3fc;
                     transition:transform .2s,box-shadow .2s;cursor:pointer;"
                     onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(14,165,233,.2)'"
                     onmouseout="this.style.transform='';this.style.boxShadow=''">
                    <div style="font-size:2rem;margin-bottom:10px;">📊</div>
                    <h4 style="font-size:.95rem;font-weight:700;color:#0c4a6e;margin-bottom:4px;">Rekap Nilai</h4>
                    <p style="font-size:.8rem;color:#0369a1;">Lihat dan kelola seluruh nilai yang telah diinput</p>
                </div>
            </a>

        </div>
    </div>
</div>

{{-- ── Info Profil Guru ── --}}
@if($guru)
<div class="card">
    <div class="card-header">
        <h3>👤 Profil Saya</h3>
    </div>
    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;">
            <div style="padding:14px;background:#f9fafb;border-radius:10px;">
                <p style="font-size:.75rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Nama Guru</p>
                <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ $guru->nama_guru }}</p>
            </div>
            <div style="padding:14px;background:#f9fafb;border-radius:10px;">
                <p style="font-size:.75rem;color:#6b7280;font-weight:600;text-transform:uppercase;">NIP</p>
                <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ $guru->nip }}</p>
            </div>
            <div style="padding:14px;background:#f9fafb;border-radius:10px;">
                <p style="font-size:.75rem;color:#6b7280;font-weight:600;text-transform:uppercase;">No. HP</p>
                <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ $guru->no_hp ?? '—' }}</p>
            </div>
            <div style="padding:14px;background:#f9fafb;border-radius:10px;">
                <p style="font-size:.75rem;color:#6b7280;font-weight:600;text-transform:uppercase;">Email</p>
                <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</div>
@endif

@endsection