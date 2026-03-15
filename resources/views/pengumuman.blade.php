@extends('layouts.app')
@section('title', 'Pengumuman Juara - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .page-hero { min-height:40vh; background:linear-gradient(135deg,#0f0f23,#1a1a3e,#2d1b69); display:flex; align-items:center; justify-content:center; padding-top:68px; position:relative; overflow:hidden; }
    .page-hero-orb { position:absolute; border-radius:50%; filter:blur(80px); opacity:.2; }
    .page-hero-content { text-align:center; position:relative; z-index:2; padding:60px 32px; }
    .page-hero-title { font-family:'Syne',sans-serif; font-size:clamp(40px,7vw,72px); font-weight:800; color:#fff; letter-spacing:-2px; margin-bottom:12px; }
    .page-hero-sub { font-size:16px; color:rgba(255,255,255,.55); font-weight:500; }
    .winners-section { max-width:1100px; margin:0 auto; padding:80px 32px; }
    .podium-grid { display:grid; grid-template-columns:1fr 1.15fr 1fr; gap:20px; align-items:end; margin-bottom:60px; }
    .winner-card { border-radius:24px; padding:36px 28px; text-align:center; color:#fff; position:relative; overflow:hidden; transition:all .3s; }
    .winner-card:hover { transform:translateY(-8px); }
    .winner-card-1 { background:linear-gradient(135deg,#78350f,#b45309,#d97706); box-shadow:0 20px 60px rgba(251,191,36,.3); }
    .winner-card-2 { background:linear-gradient(135deg,#1e293b,#334155,#475569); box-shadow:0 16px 40px rgba(0,0,0,.3); }
    .winner-card-3 { background:linear-gradient(135deg,#7c2d12,#9a3412,#c2410c); box-shadow:0 16px 40px rgba(249,115,22,.25); }
    .winner-crown { font-size:48px; display:block; margin-bottom:12px; }
    .winner-rank { font-size:11px; font-weight:800; text-transform:uppercase; letter-spacing:1.5px; opacity:.7; margin-bottom:8px; }
    .winner-name { font-family:'Syne',sans-serif; font-size:22px; font-weight:800; margin-bottom:4px; }
    .winner-design { font-size:13px; opacity:.65; margin-bottom:20px; }
    .winner-emoji { font-size:72px; background:rgba(255,255,255,.08); border-radius:16px; padding:20px; display:block; margin:0 auto 16px; width:fit-content; }
    .winner-score { font-family:'Syne',sans-serif; font-size:48px; font-weight:800; }
    .winner-score-label { font-size:11px; opacity:.55; text-transform:uppercase; letter-spacing:.8px; margin-top:4px; }
    .pending-state { text-align:center; padding:100px 32px; }
    .pending-icon { font-size:80px; margin-bottom:24px; display:block; }
    .pending-title { font-family:'Syne',sans-serif; font-size:40px; font-weight:800; color:var(--dark); margin-bottom:12px; letter-spacing:-1px; }
    .pending-sub { font-size:16px; color:var(--muted); max-width:480px; margin:0 auto 36px; line-height:1.7; }
    .countdown-card { background:#fff; border-radius:20px; border:1px solid var(--border); padding:32px; max-width:360px; margin:0 auto; box-shadow:0 8px 32px rgba(0,0,0,.06); }
    @media(max-width:768px) { .podium-grid{grid-template-columns:1fr;} }
</style>
@endpush

<div class="page-hero">
    <div class="page-hero-orb" style="width:400px;height:400px;background:#6366f1;top:-100px;left:-100px"></div>
    <div class="page-hero-orb" style="width:300px;height:300px;background:#ec4899;bottom:-80px;right:-80px"></div>
    <div class="page-hero-content">
        <div style="font-size:56px;margin-bottom:16px">🏆</div>
        <h1 class="page-hero-title">Pengumuman Juara</h1>
        <p class="page-hero-sub">Festival Layang-Layang Nusantara 2025</p>
        @if(\Illuminate\Support\Facades\Cache::get('juara_published'))
            <span class="badge badge-green" style="margin-top:16px;font-size:13px;padding:8px 20px">✅ Pengumuman Resmi</span>
        @else
            <span class="badge badge-yellow" style="margin-top:16px;font-size:13px;padding:8px 20px">⏳ Penilaian Berlangsung</span>
        @endif
    </div>
</div>

<div class="winners-section">
    @if(\Illuminate\Support\Facades\Cache::get('juara_published'))
        @php
            $winners = \App\Models\Design::where('status','approved')
                ->with('user','scores')
                ->get()
                ->sortByDesc(fn($d) => $d->scores->avg('final_score'))
                ->take(3)
                ->values();
        @endphp

        @if($winners->count() > 0)
        <div style="text-align:center;margin-bottom:56px">
            <div style="font-family:'Syne',sans-serif;font-size:42px;font-weight:800;color:var(--dark);letter-spacing:-1px;margin-bottom:12px">
                🎉 Selamat kepada Para <span class="grad-text">Pemenang!</span>
            </div>
            <p style="color:var(--muted);font-size:16px">Festival Layang-Layang Nusantara 2025</p>
        </div>

        <div class="podium-grid">
            {{-- JUARA 2 --}}
            @if(isset($winners[1]))
            <div class="winner-card winner-card-2" style="margin-bottom:0">
                <span class="winner-crown">🥈</span>
                <div class="winner-rank">Juara 2</div>
                <div class="winner-name">{{ $winners[1]->user->name }}</div>
                <div class="winner-design">{{ $winners[1]->title }}</div>
                <span class="winner-emoji">🎨</span>
                <div class="winner-score">{{ number_format($winners[1]->scores->avg('final_score'),1) }}</div>
                <div class="winner-score-label">Nilai Akhir</div>
            </div>
            @endif

            {{-- JUARA 1 --}}
            @if(isset($winners[0]))
            <div class="winner-card winner-card-1">
                <span class="winner-crown">👑</span>
                <div class="winner-rank" style="color:#fde68a">Juara 1</div>
                <div class="winner-name" style="font-size:26px">{{ $winners[0]->user->name }}</div>
                <div class="winner-design">{{ $winners[0]->title }}</div>
                <span class="winner-emoji" style="font-size:88px">🏆</span>
                <div class="winner-score" style="font-size:56px;color:#fde68a">{{ number_format($winners[0]->scores->avg('final_score'),1) }}</div>
                <div class="winner-score-label">Nilai Akhir</div>
            </div>
            @endif

            {{-- JUARA 3 --}}
            @if(isset($winners[2]))
            <div class="winner-card winner-card-3" style="margin-bottom:0">
                <span class="winner-crown">🥉</span>
                <div class="winner-rank">Juara 3</div>
                <div class="winner-name">{{ $winners[2]->user->name }}</div>
                <div class="winner-design">{{ $winners[2]->title }}</div>
                <span class="winner-emoji">🎭</span>
                <div class="winner-score">{{ number_format($winners[2]->scores->avg('final_score'),1) }}</div>
                <div class="winner-score-label">Nilai Akhir</div>
            </div>
            @endif
        </div>

        <div style="text-align:center;margin-top:48px">
            <a href="{{ route('galeri') }}" class="btn btn-lg btn-primary">🖼️ Lihat Galeri Desain</a>
        </div>
        @endif

    @else
    <div class="pending-state">
        <span class="pending-icon">⏳</span>
        <h2 class="pending-title">Penilaian Sedang Berlangsung</h2>
        <p class="pending-sub">Juri sedang menilai seluruh desain yang masuk. Pengumuman juara akan diterbitkan setelah proses selesai.</p>
        <div class="countdown-card">
            <div style="font-size:13px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px">Estimasi Pengumuman</div>
            <div style="font-family:'Syne',sans-serif;font-size:32px;font-weight:800;background:var(--grad-main);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">25 Maret 2025</div>
            <div style="margin-top:20px">
                <a href="{{ route('info') }}" class="btn btn-primary" style="width:100%;justify-content:center">ℹ️ Lihat Info Lomba</a>
            </div>
        </div>
    </div>
    @endif
</div>

@endsection