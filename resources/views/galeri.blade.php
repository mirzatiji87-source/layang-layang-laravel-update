@extends('layouts.app')
@section('title', 'Galeri Desain - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .page-hero { min-height:35vh; background:linear-gradient(135deg,#0f0f23,#1a1a3e,#1e3a5f); display:flex; align-items:center; justify-content:center; padding-top:68px; position:relative; overflow:hidden; }
    .page-hero-orb { position:absolute; border-radius:50%; filter:blur(80px); opacity:.2; }
    .gallery-section { max-width:1280px; margin:0 auto; padding:80px 32px; }
    .gallery-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(260px,1fr)); gap:24px; }
    .gallery-card { background:#fff; border-radius:20px; overflow:hidden; border:1px solid var(--border); transition:all .3s; }
    .gallery-card:hover { transform:translateY(-6px); box-shadow:0 20px 50px rgba(0,0,0,.1); }
    .gallery-img { width:100%; height:220px; object-fit:cover; display:flex; align-items:center; justify-content:center; font-size:64px; }
    .gallery-info { padding:20px; }
    .gallery-name { font-size:16px; font-weight:800; color:var(--dark); margin-bottom:4px; }
    .gallery-peserta { font-size:13px; color:var(--muted); margin-bottom:12px; }
</style>
@endpush

<div class="page-hero">
    <div class="page-hero-orb" style="width:400px;height:400px;background:#0ea5e9;top:-100px;left:-100px"></div>
    <div class="page-hero-orb" style="width:300px;height:300px;background:#6366f1;bottom:-80px;right:-80px"></div>
    <div style="text-align:center;position:relative;z-index:2;padding:60px 32px">
        <div style="font-size:52px;margin-bottom:16px">🖼️</div>
        <h1 style="font-family:'Syne',sans-serif;font-size:clamp(40px,7vw,72px);font-weight:800;color:#fff;letter-spacing:-2px;margin-bottom:12px">Galeri Desain</h1>
        <p style="font-size:16px;color:rgba(255,255,255,.55)">Koleksi desain layang-layang terbaik peserta LayangFest 2025</p>
    </div>
</div>

<div class="gallery-section">
    @php
        $designs = \App\Models\Design::where('status','approved')->with('user','scores')->get();
        $winners = \Illuminate\Support\Facades\Cache::get('juara_published')
            ? $designs->sortByDesc(fn($d) => $d->scores->avg('final_score'))->take(3)->pluck('id')->toArray()
            : [];
    @endphp

    @if($designs->isEmpty())
        <div style="text-align:center;padding:80px 0">
            <div style="font-size:64px;margin-bottom:20px">🎨</div>
            <h2 style="font-family:'Syne',sans-serif;font-size:32px;font-weight:800;color:var(--dark);margin-bottom:12px">Belum Ada Desain</h2>
            <p style="color:var(--muted)">Belum ada desain yang disetujui untuk ditampilkan.</p>
        </div>
    @else
        <div class="gallery-grid">
            @foreach($designs as $design)
            @php $score = $design->scores->avg('final_score'); $winnerIdx = array_search($design->id, $winners); @endphp
            <div class="gallery-card">
                <div class="gallery-img" style="background:linear-gradient(135deg,#ede9fe,#dbeafe)">🎨</div>
                <div class="gallery-info">
                    @if($winnerIdx !== false)
                        <div style="margin-bottom:8px">
                            <span class="badge {{ $winnerIdx==0 ? 'badge-yellow' : ($winnerIdx==1 ? 'badge-sky' : 'badge-red') }}">
                                {{ $winnerIdx==0 ? '🥇 Juara 1' : ($winnerIdx==1 ? '🥈 Juara 2' : '🥉 Juara 3') }}
                            </span>
                        </div>
                    @endif
                    <div class="gallery-name">{{ $design->title }}</div>
                    <div class="gallery-peserta">👤 {{ $design->user->name }} · {{ $design->user->region ?? '-' }}</div>
                    @if($score)
                        <span class="badge badge-purple">⭐ {{ number_format($score,1) }}</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection