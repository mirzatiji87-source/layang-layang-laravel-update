@extends('layouts.app')
@section('title', 'Dashboard Peserta - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .welcome-banner { background:linear-gradient(135deg,#6366f1,#8b5cf6,#ec4899); border-radius:20px; padding:32px; color:#fff; margin-bottom:28px; position:relative; overflow:hidden; }
    .welcome-banner::before { content:'🪁'; position:absolute; right:32px; top:50%; transform:translateY(-50%); font-size:80px; opacity:.2; }
    .welcome-title { font-family:'Syne',sans-serif; font-size:28px; font-weight:800; margin-bottom:8px; }
    .welcome-sub { font-size:14px; opacity:.85; line-height:1.6; }
</style>
@endpush

<div class="dashboard-wrapper">
    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-label">Menu Utama</div>
        <a href="{{ route('peserta.dashboard') }}" class="sidebar-item active">
            <span class="sidebar-item-icon">🏠</span> Beranda
        </a>
        <a href="{{ route('peserta.upload') }}" class="sidebar-item">
            <span class="sidebar-item-icon">⬆️</span> Upload Desain
        </a>
        <a href="{{ route('peserta.status') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📊</span> Status Desain
        </a>
        <a href="{{ route('peserta.juknis') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📄</span> Juknis
        </a>
        <div class="sidebar-label">Lomba</div>
        <a href="{{ route('info') }}" class="sidebar-item">
            <span class="sidebar-item-icon">ℹ️</span> Info Lomba
        </a>
        <a href="{{ route('pengumuman') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🏆</span> Pengumuman
        </a>
        <div style="margin-top:auto;padding-top:32px">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
                    <span class="sidebar-item-icon">🚪</span> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="dashboard-main">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="welcome-banner">
            <div class="welcome-title">Halo, {{ auth()->user()->name }}! 👋</div>
            <div class="welcome-sub">Selamat datang di dashboard peserta LayangFest 2025.<br>Upload desain terbaikmu dan raih hadiah 25 juta rupiah!</div>
        </div>

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card stat-card-1">
                <div class="stat-icon" style="background:#ede9fe">🎨</div>
                <div class="stat-label">Status Desain</div>
                <div class="stat-value" style="font-size:18px;margin-top:8px">
                    @if($design)
                        @if($design->status == 'pending')
                            <span class="badge badge-yellow">⏳ Pending</span>
                        @elseif($design->status == 'approved')
                            <span class="badge badge-green">✅ Disetujui</span>
                        @else
                            <span class="badge badge-red">❌ Ditolak</span>
                        @endif
                    @else
                        <span class="badge badge-purple">Belum Upload</span>
                    @endif
                </div>
            </div>
            <div class="stat-card stat-card-2">
                <div class="stat-icon" style="background:#dcfce7">⭐</div>
                <div class="stat-label">Nilai Akhir</div>
                <div class="stat-value">{{ $finalScore ? number_format($finalScore,1) : '-' }}</div>
            </div>
            <div class="stat-card stat-card-3">
                <div class="stat-icon" style="background:#fff7ed">✅</div>
                <div class="stat-label">Verifikasi Akun</div>
                <div class="stat-value" style="font-size:18px;margin-top:8px">
                    @if(auth()->user()->is_verified)
                        <span class="badge badge-green">✅ Terverifikasi</span>
                    @else
                        <span class="badge badge-yellow">⏳ Menunggu</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- INFO AKUN --}}
        <div class="content-card">
            <div class="content-card-title">Informasi Akun</div>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px">
                @foreach([
                    ['Nama', auth()->user()->name],
                    ['Email', auth()->user()->email],
                    ['Telepon', auth()->user()->phone ?? '-'],
                    ['Asal Daerah', auth()->user()->region ?? '-'],
                ] as [$label, $value])
                <div>
                    <div style="font-size:11px;font-weight:800;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;margin-bottom:6px">{{ $label }}</div>
                    <div style="font-size:15px;font-weight:700;color:var(--dark)">{{ $value }}</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- PENGUMUMAN --}}
        <div class="content-card">
            <div class="content-card-title">📢 Pengumuman</div>
            <div class="alert alert-info">🔔 Pendaftaran dibuka hingga 28 Februari 2025. Segera upload desain terbaik Anda!</div>
            <div class="alert" style="background:#fef9c3;color:#92400e;border:1.5px solid #fde047">⏰ Penilaian dimulai 1 Maret 2025. Pastikan desain sudah terupload sebelum batas waktu.</div>
        </div>

        {{-- QUICK ACTIONS --}}
        <div class="content-card">
            <div class="content-card-title">⚡ Aksi Cepat</div>
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                <a href="{{ route('peserta.upload') }}" class="btn btn-primary">⬆️ Upload Desain</a>
                <a href="{{ route('peserta.status') }}" class="btn btn-secondary">📊 Cek Status</a>
                <a href="{{ route('peserta.juknis') }}" class="btn" style="background:#f3f4f6;color:var(--text)">📄 Download Juknis</a>
                <a href="{{ route('pengumuman') }}" class="btn" style="background:#f3f4f6;color:var(--text)">🏆 Pengumuman</a>
            </div>
        </div>
    </main>
</div>

@endsection