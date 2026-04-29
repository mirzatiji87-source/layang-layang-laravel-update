@extends('layouts.app')
@section('title', 'Hasil Penilaian - LayangFest 2026')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
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
        <a href="{{ route('admin.penilaian') }}" class="sidebar-item active">
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
        <div class="page-header">
            <h1 class="page-title">Hasil Penilaian</h1>
            <p class="page-sub">Rekap nilai dari seluruh juri</p>
        </div>

        <div class="content-card">
            <div class="content-card-title">Ranking Desain</div>
            @if($designs->isEmpty())
                <div style="text-align:center;padding:40px;color:var(--muted)">Belum ada penilaian.</div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Desain</th>
                        <th>Peserta</th>
                        <th>Jml Juri</th>
                        <th>Nilai Akhir</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($designs as $i => $d)
                    @php $score = $d->scores->avg('final_score'); @endphp
                    <tr>
                        <td>
                            <strong style="font-family:'Syne',sans-serif;font-size:22px;color:{{ $i==0 ? '#d97706' : ($i==1 ? '#94a3b8' : ($i==2 ? '#f97316' : 'var(--muted)')) }}">
                                {{ $i==0 ? '🥇' : ($i==1 ? '🥈' : ($i==2 ? '🥉' : '#'.($i+1))) }}
                            </strong>
                        </td>
                        <td><div style="font-weight:700">{{ $d->title }}</div></td>
                        <td>{{ $d->user->name }}</td>
                        <td><span class="badge badge-sky">{{ $d->scores->count() }} juri</span></td>
                        <td>
                            <span style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;background:var(--grad-main);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">
                                {{ $score ? number_format($score,1) : '-' }}
                            </span>
                        </td>
                        <td>
                            @if($d->image_path)
                                <a href="{{ asset('storage/'.$d->image_path) }}" target="_blank" class="btn btn-secondary btn-sm">👁️ Lihat</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </main>
</div>
@endsection