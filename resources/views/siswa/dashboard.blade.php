@extends('layouts.app')

@section('title', 'Portal Siswa')
@section('meta_description', 'Portal Siswa — Lihat Nilai dan Absensi')
@section('brand_icon', '🎒')
@section('brand_subtitle', 'Portal Siswa')
@section('page_title', 'Portal Siswa')
@section('role_badge', 'Siswa')

{{-- ── Warna tema pink/rose untuk Siswa ── --}}
@section('accent',       '#db2777')
@section('accent_light', '#fce7f3')
@section('accent_mid',   '#f9a8d4')
@section('accent_dark',  '#9d174d')
@section('sidebar_bg',   '#4a0028')

@section('sidebar_nav')
    <p class="nav-section-title">Utama</p>
    <a href="{{ route('siswa.dashboard') }}" class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
        <span class="nav-icon">🏠</span> Dashboard Saya
    </a>

    <p class="nav-section-title">Akademik</p>
    <a href="{{ route('siswa.dashboard') }}#nilai" class="nav-link">
        <span class="nav-icon">📊</span> Rekap Nilai
    </a>
    <a href="{{ route('siswa.dashboard') }}#absensi" class="nav-link">
        <span class="nav-icon">📅</span> Rekap Absensi
    </a>
@endsection

@section('content')

{{-- ── Greeting ── --}}
<div style="margin-bottom:28px;">
    <h1 style="font-size:1.6rem;font-weight:800;color:#4a0028;margin-bottom:6px;">
        Halo, {{ $siswa?->nama_siswa ?? Auth::user()->name }}! 🎒
    </h1>
    <p style="color:#6b7280;font-size:.9rem;">
        @if($siswa)
            <span class="badge badge-pink">{{ $siswa->kelas?->nama_kelas ?? 'Kelas belum ditetapkan' }}</span>
            &nbsp;•&nbsp; {{ now()->isoFormat('dddd, D MMMM Y') }}
        @else
            Data Anda belum ditautkan oleh Admin. Hubungi Tata Usaha.
        @endif
    </p>
</div>

@if($siswa)

    {{-- ── Stat Cards ── --}}
    <div class="stats-grid" style="margin-bottom:28px;">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce7f3;">📝</div>
            <div class="stat-info">
                <p>Total Nilai Tersedia</p>
                <strong>{{ $nilais->count() }}</strong>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#d1fae5;">📅</div>
            <div class="stat-info">
                <p>Total Absensi</p>
                <strong>{{ $absensis->count() }}</strong>
            </div>
        </div>
        @php
            $hadirCount = $absensis->where('status', 'hadir')->count();
            $totalCount = $absensis->count();
            $persenHadir = $totalCount > 0 ? round(($hadirCount / $totalCount) * 100, 1) : 100;
        @endphp
        <div class="stat-card">
            <div class="stat-icon" style="background:#e0f2fe;">✅</div>
            <div class="stat-info">
                <p>Persentase Kehadiran</p>
                <strong style="color: {{ $persenHadir >= 75 ? '#059669' : '#dc2626' }}">{{ $persenHadir }}%</strong>
            </div>
        </div>
    </div>

    {{-- ── Biodata Siswa ── --}}
    <div class="card" style="margin-bottom:28px;">
        <div class="card-header">
            <h3>👤 Biodata Siswa</h3>
            <span class="badge badge-pink">{{ $siswa->jenis_kelamin === 'L' ? '🙋‍♂️ Laki-laki' : '🙋‍♀️ Perempuan' }}</span>
        </div>
        <div class="card-body">
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:14px;">
                <div style="padding:14px;background:#fdf2f8;border-radius:10px;border-left:3px solid #f9a8d4;">
                    <p style="font-size:.75rem;color:#9d174d;font-weight:700;text-transform:uppercase;">NIS</p>
                    <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ $siswa->nis }}</p>
                </div>
                <div style="padding:14px;background:#fdf2f8;border-radius:10px;border-left:3px solid #f9a8d4;">
                    <p style="font-size:.75rem;color:#9d174d;font-weight:700;text-transform:uppercase;">NISN</p>
                    <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ $siswa->nisn }}</p>
                </div>
                <div style="padding:14px;background:#fdf2f8;border-radius:10px;border-left:3px solid #f9a8d4;">
                    <p style="font-size:.75rem;color:#9d174d;font-weight:700;text-transform:uppercase;">Nama Lengkap</p>
                    <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ $siswa->nama_siswa }}</p>
                </div>
                <div style="padding:14px;background:#fdf2f8;border-radius:10px;border-left:3px solid #f9a8d4;">
                    <p style="font-size:.75rem;color:#9d174d;font-weight:700;text-transform:uppercase;">Kelas</p>
                    <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">
                        {{ $siswa->kelas?->nama_kelas ?? '—' }}
                        @if($siswa->kelas?->jurusan)
                            <span style="font-weight:500;color:#6b7280;font-size:.85rem;">
                                ({{ $siswa->kelas->jurusan }})
                            </span>
                        @endif
                    </p>
                </div>
                <div style="padding:14px;background:#fdf2f8;border-radius:10px;border-left:3px solid #f9a8d4;">
                    <p style="font-size:.75rem;color:#9d174d;font-weight:700;text-transform:uppercase;">Email</p>
                    <p style="font-weight:700;color:#1e1b4b;margin-top:4px;">{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Tabel Rekap Nilai ── --}}
    <div class="card" style="margin-bottom:28px;" id="nilai">
        <div class="card-header">
            <h3>📊 Rekap Nilai Akademik</h3>
            <span style="font-size:.78rem;color:#6b7280;">30% Tugas + 30% UTS + 40% UAS</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <th style="text-align:center;">Tugas (30%)</th>
                        <th style="text-align:center;">UTS (30%)</th>
                        <th style="text-align:center;">UAS (40%)</th>
                        <th style="text-align:center;">Nilai Akhir</th>
                        <th style="text-align:center;">Predikat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilais as $n)
                    @php
                        $na = $n->nilai_akhir;
                        $predikat = match(true) {
                            $na >= 90 => ['A', '#059669', '#d1fae5'],
                            $na >= 80 => ['B', '#2563eb', '#dbeafe'],
                            $na >= 70 => ['C', '#d97706', '#fef3c7'],
                            $na >= 60 => ['D', '#dc2626', '#fee2e2'],
                            default   => ['E', '#7f1d1d', '#fef2f2'],
                        };
                    @endphp
                    <tr>
                        <td>
                            <div style="font-weight:600;color:#1e1b4b;">
                                {{ $n->mataPelajaran?->nama_mapel ?? $n->mapel ?? '—' }}
                            </div>
                            @if($n->mataPelajaran?->kode_mapel)
                                <div style="font-size:.75rem;color:#9ca3af;">{{ $n->mataPelajaran->kode_mapel }}</div>
                            @endif
                        </td>
                        <td style="text-align:center;">{{ number_format($n->nilai_tugas, 0) }}</td>
                        <td style="text-align:center;">{{ number_format($n->nilai_uts, 0) }}</td>
                        <td style="text-align:center;">{{ number_format($n->nilai_uas, 0) }}</td>
                        <td style="text-align:center;">
                            <span style="font-size:1.1rem;font-weight:800;
                                color:{{ $predikat[1] }};">
                                {{ number_format($na, 2) }}
                            </span>
                        </td>
                        <td style="text-align:center;">
                            <span style="padding:4px 12px;border-radius:20px;font-weight:700;font-size:.78rem;
                                background:{{ $predikat[2] }};color:{{ $predikat[1] }};">
                                {{ $predikat[0] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align:center;padding:32px;color:#9ca3af;">
                            📭 Belum ada nilai yang diinput oleh guru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Tabel Absensi ── --}}
    <div class="card" id="absensi">
        <div class="card-header">
            <h3>📅 Rekap Absensi</h3>
            @php
                $hadirCount  = $absensis->where('status','hadir')->count();
                $sakitCount  = $absensis->where('status','sakit')->count();
                $izinCount   = $absensis->where('status','izin')->count();
                $alpaCount   = $absensis->where('status','alpa')->count();
            @endphp
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="badge badge-green">✅ Hadir: {{ $hadirCount }}</span>
                <span class="badge badge-sky">🤒 Sakit: {{ $sakitCount }}</span>
                <span class="badge badge-violet">📋 Izin: {{ $izinCount }}</span>
                <span style="padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;
                    background:#fee2e2;color:#dc2626;">
                    ❌ Alpa: {{ $alpaCount }}
                </span>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th style="text-align:center;">Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensis->sortByDesc('tanggal')->take(20) as $a)
                    @php
                        $statusStyle = match($a->status) {
                            'hadir' => ['✅ Hadir', '#059669', '#d1fae5'],
                            'sakit' => ['🤒 Sakit', '#0369a1', '#e0f2fe'],
                            'izin'  => ['📋 Izin',  '#4f46e5', '#eef2ff'],
                            'alpa'  => ['❌ Alpa',  '#dc2626', '#fee2e2'],
                            default => [$a->status, '#374151', '#f3f4f6'],
                        };
                    @endphp
                    <tr>
                        <td style="font-weight:500;">
                            {{ \Carbon\Carbon::parse($a->tanggal)->isoFormat('dddd, D MMMM Y') }}
                        </td>
                        <td style="text-align:center;">
                            <span style="padding:4px 12px;border-radius:20px;font-weight:700;font-size:.8rem;
                                background:{{ $statusStyle[2] }};color:{{ $statusStyle[1] }};">
                                {{ $statusStyle[0] }}
                            </span>
                        </td>
                        <td style="color:#6b7280;font-size:.875rem;">
                            {{ $a->keterangan ?? '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center;padding:32px;color:#9ca3af;">
                            📭 Belum ada catatan absensi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            @if($absensis->count() > 20)
                <div style="padding:14px 20px;text-align:center;color:#9ca3af;font-size:.8rem;">
                    Menampilkan 20 dari {{ $absensis->count() }} data terbaru.
                </div>
            @endif
        </div>
    </div>

@else
    {{-- Data siswa belum dikaitkan --}}
    <div style="text-align:center;padding:60px 24px;">
        <div style="font-size:4rem;margin-bottom:16px;">🔗</div>
        <h2 style="font-size:1.3rem;font-weight:700;color:#4a0028;margin-bottom:8px;">
            Data Belum Ditautkan
        </h2>
        <p style="color:#6b7280;font-size:.9rem;max-width:400px;margin:0 auto;">
            Akun Anda belum dihubungkan dengan data siswa. Silakan hubungi
            <strong>Admin / Tata Usaha</strong> untuk mengaitkan data Anda.
        </p>
    </div>
@endif

@endsection