@extends('layouts.app')
@section('title', 'Status Desain - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .score-bar { height:8px; border-radius:4px; background:#e5e7eb; overflow:hidden; margin-top:8px; }
    .score-bar-fill { height:100%; border-radius:4px; background:var(--grad-main); transition:width .8s ease; }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Menu Utama</div>
        <a href="{{ route('peserta.dashboard') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🏠</span> Beranda
        </a>
        <a href="{{ route('peserta.upload') }}" class="sidebar-item">
            <span class="sidebar-item-icon">⬆️</span> Upload Desain
        </a>
        <a href="{{ route('peserta.status') }}" class="sidebar-item active">
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

    <main class="dashboard-main">
        <div class="page-header">
            <h1 class="page-title">Status Desain</h1>
            <p class="page-sub">Pantau status dan penilaian desain kamu</p>
        </div>

        @if(!$design)
            <div class="content-card" style="text-align:center;padding:60px">
                <div style="font-size:64px;margin-bottom:20px">📂</div>
                <h2 style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:var(--dark);margin-bottom:12px">Belum Ada Desain</h2>
                <p style="color:var(--muted);margin-bottom:24px">Kamu belum mengupload desain. Upload sekarang untuk berpartisipasi!</p>
                <a href="{{ route('peserta.upload') }}" class="btn btn-primary btn-lg">⬆️ Upload Desain Sekarang</a>
            </div>
        @else
            {{-- DETAIL DESAIN --}}
            <div class="content-card">
                <div style="display:flex;gap:24px;align-items:flex-start;flex-wrap:wrap">
                    <div style="width:200px;height:180px;border-radius:14px;overflow:hidden;flex-shrink:0;background:linear-gradient(135deg,#ede9fe,#dbeafe);display:flex;align-items:center;justify-content:center">
                        @if($design->image_path)
                            <img src="{{ asset('storage/'.$design->image_path) }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <span style="font-size:64px">🎨</span>
                        @endif
                    </div>
                    <div style="flex:1">
                        <h2 style="font-family:'Syne',sans-serif;font-size:24px;font-weight:800;color:var(--dark);margin-bottom:8px">{{ $design->title }}</h2>
                        <p style="color:var(--muted);font-size:14px;line-height:1.7;margin-bottom:20px">{{ $design->description }}</p>
                        <div style="display:flex;gap:20px;flex-wrap:wrap">
                            <div>
                                <div style="font-size:11px;font-weight:800;color:var(--muted);text-transform:uppercase;margin-bottom:6px">Status</div>
                                @if($design->status == 'pending')
                                    <span class="badge badge-yellow">⏳ Menunggu Review</span>
                                @elseif($design->status == 'approved')
                                    <span class="badge badge-green">✅ Disetujui</span>
                                @else
                                    <span class="badge badge-red">❌ Ditolak</span>
                                @endif
                            </div>
                            <div>
                                <div style="font-size:11px;font-weight:800;color:var(--muted);text-transform:uppercase;margin-bottom:6px">Disubmit</div>
                                <div style="font-weight:700">{{ $design->created_at->format('d M Y') }}</div>
                            </div>
                            <div>
                                <div style="font-size:11px;font-weight:800;color:var(--muted);text-transform:uppercase;margin-bottom:6px">Nilai Akhir</div>
                                <div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;background:var(--grad-main);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">
                                    {{ $finalScore ? number_format($finalScore,1) : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETAIL NILAI --}}
            @if($scores && $scores->count() > 0)
            <div class="content-card">
                <div class="content-card-title">Detail Penilaian</div>
                @php
                    $avgOri = $scores->avg('orisinalitas');
                    $avgEst = $scores->avg('estetika');
                    $avgBud = $scores->avg('budaya');
                    $avgTek = $scores->avg('teknis');
                @endphp
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:28px">
                    @foreach([
                        ['🎨 Orisinalitas', $avgOri, '30%', '#ede9fe'],
                        ['✨ Estetika', $avgEst, '25%', '#dbeafe'],
                        ['🏛️ Budaya', $avgBud, '25%', '#fef9c3'],
                        ['⚙️ Teknis', $avgTek, '20%', '#dcfce7'],
                    ] as [$label, $val, $bobot, $bg])
                    <div style="background:{{ $bg }};border-radius:14px;padding:20px;text-align:center">
                        <div style="font-size:13px;font-weight:700;color:var(--muted);margin-bottom:8px">{{ $label }}</div>
                        <div style="font-family:'Syne',sans-serif;font-size:32px;font-weight:800;color:var(--dark)">{{ number_format($val,1) }}</div>
                        <div style="font-size:11px;color:var(--muted);margin-top:4px">Bobot {{ $bobot }}</div>
                        <div class="score-bar"><div class="score-bar-fill" style="width:{{ $val }}%"></div></div>
                    </div>
                    @endforeach
                </div>

                {{-- Catatan Juri --}}
                @foreach($scores as $score)
                @if($score->catatan)
                <div style="background:var(--grad-bg);border-radius:12px;padding:16px;margin-bottom:10px;border:1px solid var(--border)">
                    <div style="font-size:12px;font-weight:800;color:var(--p1);margin-bottom:6px">💬 Catatan dari {{ $score->juri->name }}</div>
                    <div style="font-size:14px;color:var(--muted);font-style:italic">"{{ $score->catatan }}"</div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        @endif
    </main>
</div>
@endsection