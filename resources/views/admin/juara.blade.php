@extends('layouts.app')
@section('title', 'Tentukan Juara - LayangFest 2026')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .podium-preview { background:linear-gradient(135deg,#0f0f23,#1a1a3e); border-radius:20px; padding:28px; color:#fff; }
    .podium-item { display:flex; align-items:center; gap:16px; padding:16px; border-radius:12px; margin-bottom:12px; background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.08); }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Dashboard</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
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
        <a href="{{ route('admin.juara') }}" class="sidebar-item active">
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
        <div class="page-header">
            <h1 class="page-title">Tentukan Juara</h1>
            <p class="page-sub">Publikasikan pengumuman juara berdasarkan nilai tertinggi</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if($designs->isEmpty())
            <div class="content-card" style="text-align:center;padding:60px">
                <div style="font-size:64px;margin-bottom:20px">⭐</div>
                <h2 style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:var(--dark);margin-bottom:12px">Belum Ada Penilaian</h2>
                <p style="color:var(--muted);margin-bottom:24px">Minta juri untuk melakukan penilaian terlebih dahulu.</p>
                <a href="{{ route('admin.penilaian') }}" class="btn btn-primary">📋 Lihat Penilaian</a>
            </div>
        @else
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
                {{-- RANKING --}}
                <div class="content-card">
                    <div class="content-card-title">🏆 Ranking Saat Ini</div>
                    <table>
                        <thead>
                            <tr><th>Rank</th><th>Desain</th><th>Peserta</th><th>Nilai</th></tr>
                        </thead>
                        <tbody>
                            @foreach($designs as $i => $d)
                            <tr style="{{ $i < 3 ? 'background:linear-gradient(to right,rgba(251,191,36,.05),transparent)' : '' }}">
                                <td>
                                    <strong style="font-size:20px">{{ $i==0 ? '🥇' : ($i==1 ? '🥈' : ($i==2 ? '🥉' : '#'.($i+1))) }}</strong>
                                </td>
                                <td><div style="font-weight:700">{{ $d->title }}</div></td>
                                <td style="color:var(--muted)">{{ $d->user->name }}</td>
                                <td>
                                    <strong style="font-family:'Syne',sans-serif;font-size:18px;background:var(--grad-main);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">
                                        {{ number_format($d->scores->avg('final_score'),1) }}
                                    </strong>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PUBLISH --}}
                <div>
                    <div class="podium-preview" style="margin-bottom:20px">
                        <div style="font-size:14px;font-weight:800;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.8px;margin-bottom:16px">Pratinjau Juara</div>
                        @foreach($designs->take(3) as $i => $d)
                        <div class="podium-item">
                            <span style="font-size:28px">{{ $i==0 ? '🥇' : ($i==1 ? '🥈' : '🥉') }}</span>
                            <div style="flex:1">
                                <div style="font-weight:800;font-size:15px">{{ $d->title }}</div>
                                <div style="font-size:12px;opacity:.6">{{ $d->user->name }}</div>
                            </div>
                            <div style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#fbbf24">
                                {{ number_format($d->scores->avg('final_score'),1) }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="content-card">
                        <div class="content-card-title">Publikasikan</div>
                        @if(\Illuminate\Support\Facades\Cache::get('juara_published'))
                            <div class="alert alert-success">✅ Juara sudah dipublikasikan!</div>
                            <a href="{{ route('pengumuman') }}" class="btn btn-secondary" style="width:100%;justify-content:center" target="_blank">👁️ Lihat Pengumuman</a>
                        @else
                            <p style="color:var(--muted);font-size:14px;line-height:1.7;margin-bottom:20px">Setelah dipublikasikan, hasil juara akan tampil di halaman pengumuman dan bisa dilihat semua orang.</p>
                            <form method="POST" action="{{ route('admin.juara.publish') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg" style="width:100%;justify-content:center" onclick="return confirm('Publikasikan juara sekarang?')">
                                    🏆 Publikasikan Juara Sekarang
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </main>
</div>
@endsection