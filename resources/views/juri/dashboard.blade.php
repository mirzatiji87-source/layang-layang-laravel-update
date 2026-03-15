@extends('layouts.app')
@section('title', 'Dashboard Juri - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .welcome-banner { background:linear-gradient(135deg,#0f172a,#1e3a5f,#0ea5e9); border-radius:20px; padding:32px; color:#fff; margin-bottom:28px; position:relative; overflow:hidden; }
    .welcome-banner::before { content:'⭐'; position:absolute; right:32px; top:50%; transform:translateY(-50%); font-size:80px; opacity:.15; }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Menu Juri</div>
        <a href="{{ route('juri.dashboard') }}" class="sidebar-item active">
            <span class="sidebar-item-icon">🏠</span> Beranda
        </a>
        <a href="{{ route('juri.desain') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🎨</span> Daftar Desain
        </a>
        <a href="{{ route('juri.penilaian') }}" class="sidebar-item">
            <span class="sidebar-item-icon">⭐</span> Penilaian Saya
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

    <main class="dashboard-main">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="welcome-banner">
            <div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;margin-bottom:8px">Halo, {{ auth()->user()->name }}! ⭐</div>
            <div style="font-size:14px;opacity:.85;line-height:1.6">Selamat datang di dashboard juri LayangFest 2025.<br>Selesaikan penilaian sebelum 15 Maret 2025.</div>
        </div>

        <div class="stats-grid">
            <div class="stat-card stat-card-1">
                <div class="stat-icon" style="background:#dbeafe">📋</div>
                <div class="stat-label">Total Desain</div>
                <div class="stat-value">{{ $totalDesain }}</div>
            </div>
            <div class="stat-card stat-card-2">
                <div class="stat-icon" style="background:#dcfce7">✅</div>
                <div class="stat-label">Sudah Dinilai</div>
                <div class="stat-value">{{ $sudahDinilai }}</div>
            </div>
            <div class="stat-card stat-card-3">
                <div class="stat-icon" style="background:#fff7ed">⏳</div>
                <div class="stat-label">Belum Dinilai</div>
                <div class="stat-value">{{ $belumDinilai }}</div>
            </div>
        </div>

        {{-- PROGRESS --}}
        <div class="content-card">
            <div class="content-card-title">Progress Penilaian</div>
            @php $pct = $totalDesain > 0 ? round(($sudahDinilai/$totalDesain)*100) : 0; @endphp
            <div style="display:flex;justify-content:space-between;margin-bottom:10px">
                <span style="font-size:14px;color:var(--muted)">{{ $sudahDinilai }} dari {{ $totalDesain }} desain dinilai</span>
                <span style="font-size:14px;font-weight:800;color:var(--p1)">{{ $pct }}%</span>
            </div>
            <div style="height:12px;background:#e5e7eb;border-radius:6px;overflow:hidden">
                <div style="height:100%;width:{{ $pct }}%;background:var(--grad-main);border-radius:6px;transition:width 1s ease"></div>
            </div>
        </div>

        <div class="content-card">
            <div class="content-card-title">📢 Informasi Penilaian</div>
            <div class="alert alert-info">📋 Mohon selesaikan penilaian sebelum <strong>15 Maret 2025</strong>. Hubungi admin jika ada kendala.</div>
            <div style="display:flex;gap:12px;margin-top:8px">
                <a href="{{ route('juri.desain') }}" class="btn btn-primary">🎨 Mulai Menilai</a>
                <a href="{{ route('juri.penilaian') }}" class="btn btn-secondary">📊 Lihat Penilaian Saya</a>
            </div>
        </div>
    </main>
</div>
@endsection