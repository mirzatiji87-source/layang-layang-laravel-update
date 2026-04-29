@extends('layouts.app')
@section('title', 'Penilaian Saya - LayangFest 2026')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Menu Juri</div>
        <a href="{{ route('juri.dashboard') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🏠</span> Beranda
        </a>
        <a href="{{ route('juri.desain') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🎨</span> Daftar Desain
        </a>
        <a href="{{ route('juri.penilaian') }}" class="sidebar-item active">
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
        <div class="page-header">
            <h1 class="page-title">Penilaian Saya</h1>
            <p class="page-sub">Rekap penilaian yang sudah kamu berikan</p>
        </div>

        @if($scores->isEmpty())
            <div class="content-card" style="text-align:center;padding:60px">
                <div style="font-size:64px;margin-bottom:20px">⭐</div>
                <h2 style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:var(--dark);margin-bottom:12px">Belum Ada Penilaian</h2>
                <p style="color:var(--muted);margin-bottom:24px">Kamu belum memberikan penilaian apapun.</p>
                <a href="{{ route('juri.desain') }}" class="btn btn-primary">🎨 Mulai Menilai</a>
            </div>
        @else
            <div class="content-card">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Desain</th>
                            <th>Peserta</th>
                            <th>Orisinalitas</th>
                            <th>Estetika</th>
                            <th>Budaya</th>
                            <th>Teknis</th>
                            <th>Nilai Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scores as $i => $score)
                        <tr>
                            <td style="color:var(--muted)">{{ $i+1 }}</td>
                            <td><div style="font-weight:700">{{ $score->design->title }}</div></td>
                            <td style="color:var(--muted)">{{ $score->design->user->name }}</td>
                            <td>{{ $score->orisinalitas }}</td>
                            <td>{{ $score->estetika }}</td>
                            <td>{{ $score->budaya }}</td>
                            <td>{{ $score->teknis }}</td>
                            <td>
                                <span style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;background:var(--grad-main);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">
                                    {{ number_format($score->final_score,1) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('juri.desain.detail', $score->design_id) }}" class="btn btn-secondary btn-sm">✏️ Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
</div>
@endsection