@extends('layouts.app')
@section('title', 'Dashboard Juri - LayangFest 2026')
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
        <a href="{{ route('juri.dashboard') }}" class="sidebar-item active">🏠 Beranda</a>
        <a href="{{ route('juri.desain') }}" class="sidebar-item">🎨 Daftar Desain</a>
        <a href="{{ route('juri.penilaian') }}" class="sidebar-item">⭐ Penilaian Saya</a>

        <div style="margin-top:auto;padding-top:32px">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-item" style="width:100%;background:none;border:none;cursor:pointer;text-align:left">
                    🚪 Keluar
                </button>
            </form>
        </div>
    </aside>

    <main class="dashboard-main">

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        {{-- WELCOME --}}
        <div class="welcome-banner">
            <div style="font-size:28px;font-weight:800;margin-bottom:8px">
                Halo, {{ auth()->user()->name }}! ⭐
            </div>
            <div style="font-size:14px;opacity:.85;line-height:1.6">
                Selamat datang di dashboard juri LayangFest 2026.
            </div>
        </div>

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card">📋 <div>Total Desain</div><b>{{ $totalDesain }}</b></div>
            <div class="stat-card">✅ <div>Sudah Dinilai</div><b>{{ $sudahDinilai }}</b></div>
            <div class="stat-card">⏳ <div>Belum Dinilai</div><b>{{ $belumDinilai }}</b></div>
        </div>

        {{-- PROGRESS --}}
        <div class="content-card">
            <div class="content-card-title">Progress Penilaian</div>

            @php
                $pct = $totalDesain > 0 ? round(($sudahDinilai/$totalDesain)*100) : 0;
            @endphp

            <div style="display:flex;justify-content:space-between;margin-bottom:10px">
                <span>{{ $sudahDinilai }} / {{ $totalDesain }} dinilai</span>
                <b>{{ $pct }}%</b>
            </div>

            <div style="height:12px;background:#e5e7eb;border-radius:6px;overflow:hidden">
                <div style="width:{{ $pct }}%;height:100%;background:linear-gradient(90deg,#0ea5e9,#1e3a5f)"></div>
            </div>
        </div>

        {{-- INFO --}}
        <div class="content-card">
            <div class="content-card-title">📢 Informasi Penilaian</div>
            <div class="alert alert-info">
                Selesaikan penilaian sebelum <b>15 Maret 2026</b>
            </div>
        </div>

        {{-- LIST DESAIN --}}
        <div class="content-card">
            <div class="content-card-title">📂 Daftar Desain Peserta</div>

            @if(isset($desain) && $desain->count() > 0)

                @foreach($desain as $d)
                    <div style="display:flex;gap:16px;align-items:center;margin-bottom:16px;padding:12px;border:1px solid #eee;border-radius:12px">

                        <img src="{{ asset('storage/' . $d->image_path) }}"
                             style="width:100px;height:100px;object-fit:cover;border-radius:10px">

                        <div>
                            <div style="font-weight:700">
                                {{ $d->user->name ?? 'Tanpa Nama' }}
                            </div>
                            <div style="font-size:13px;color:gray">
                                {{ $d->title ?? 'Tanpa Judul' }}
                            </div>
                        </div>

                    </div>
                @endforeach

            @else
                <div style="color:gray">Belum ada desain yang diupload.</div>
            @endif

        </div>

    </main>
</div>
@endsection