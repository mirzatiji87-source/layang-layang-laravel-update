@extends('layouts.app')
@section('title', 'Dashboard Admin - LayangFest 2026')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .welcome-banner { background:linear-gradient(135deg,#0f0f23,#1a1a3e,#4c1d95); border-radius:20px; padding:32px; color:#fff; margin-bottom:28px; position:relative; overflow:hidden; }
    .welcome-banner::before { content:'🛡️'; position:absolute; right:32px; top:50%; transform:translateY(-50%); font-size:80px; opacity:.15; }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Dashboard</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item active">
            <span class="sidebar-item-icon">📊</span> Overview
        </a>
        <div class="sidebar-label">Manajemen</div>
        <a href="{{ route('admin.peserta') }}" class="sidebar-item">
            <span class="sidebar-item-icon">👥</span> Data Peserta
        </a>
        <a href="{{ route('admin.juri') }}" class="sidebar-item">
            <span class="sidebar-item-icon">⭐</span> Data Juri
        </a>
        <a href="{{ route('admin.desain') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🎨</span> Kelola Desain
        </a>
        <div class="sidebar-label">Lomba</div>
        <a href="{{ route('admin.penilaian') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📋</span> Hasil Penilaian
        </a>
        <a href="{{ route('admin.juara') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🏆</span> Tentukan Juara
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
            <div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;margin-bottom:8px">Admin Dashboard 🛡️</div>
            <div style="font-size:14px;opacity:.85;line-height:1.6">Kelola seluruh data lomba LayangFest 2026 dari sini.</div>
        </div>

        <div class="stats-grid">
            <div class="stat-card stat-card-1">
                <div class="stat-icon" style="background:#ede9fe">👥</div>
                <div class="stat-label">Total Peserta</div>
                <div class="stat-value">{{ $totalPeserta }}</div>
            </div>
            <div class="stat-card stat-card-2">
                <div class="stat-icon" style="background:#dcfce7">✅</div>
                <div class="stat-label">Terverifikasi</div>
                <div class="stat-value">{{ $verified }}</div>
            </div>
            <div class="stat-card stat-card-3">
                <div class="stat-icon" style="background:#fff7ed">🎨</div>
                <div class="stat-label">Total Desain</div>
                <div class="stat-value">{{ $totalDesain }}</div>
            </div>
            <div class="stat-card stat-card-4">
                <div class="stat-icon" style="background:#fce7f3">⭐</div>
                <div class="stat-label">Sudah Dinilai</div>
                <div class="stat-value">{{ $dinilai }}</div>
            </div>
        </div>

        {{-- STATUS LOMBA --}}
        <div class="content-card">
            <div class="content-card-title">
                Status Lomba
                @if(\Illuminate\Support\Facades\Cache::get('lomba_open', true))
                    <span class="badge badge-green">🟢 Pendaftaran Terbuka</span>
                @else
                    <span class="badge badge-red">🔴 Pendaftaran Ditutup</span>
                @endif
            </div>
            <div style="display:flex;gap:12px;flex-wrap:wrap">
                <form method="POST" action="{{ route('admin.lomba.toggle') }}" style="display:inline">
                    @csrf
                    <input type="hidden" name="status" value="buka">
                    <button type="submit" class="btn btn-success">🟢 Buka Pendaftaran</button>
                </form>
                <form method="POST" action="{{ route('admin.lomba.toggle') }}" style="display:inline">
                    @csrf
                    <input type="hidden" name="status" value="tutup">
                    <button type="submit" class="btn btn-danger">🔴 Tutup Pendaftaran</button>
                </form>
            </div>
        </div>

        {{-- PENDAFTAR TERBARU --}}
        <div class="content-card">
            <div class="content-card-title">
                Pendaftar Terbaru
                <a href="{{ route('admin.peserta') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Daerah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentPeserta as $p)
                    <tr>
                        <td><div style="font-weight:700">{{ $p->name }}</div></td>
                        <td style="color:var(--muted);font-size:13px">{{ $p->email }}</td>
                        <td>{{ $p->region ?? '-' }}</td>
                        <td>
                            @if($p->is_verified)
                                <span class="badge badge-green">✅ Verified</span>
                            @else
                                <span class="badge badge-yellow">⏳ Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(!$p->is_verified)
                            <form method="POST" action="{{ route('admin.peserta.verify', $p->id) }}" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">✓ Verify</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection