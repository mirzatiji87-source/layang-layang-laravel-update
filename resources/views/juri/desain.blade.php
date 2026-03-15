@extends('layouts.app')
@section('title', 'Daftar Desain - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .design-card { background:#fff; border-radius:16px; border:1px solid var(--border); padding:20px; display:flex; gap:16px; align-items:flex-start; transition:all .2s; margin-bottom:16px; }
    .design-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(0,0,0,.08); }
    .design-thumb { width:80px; height:80px; border-radius:12px; background:linear-gradient(135deg,#ede9fe,#dbeafe); display:flex; align-items:center; justify-content:center; font-size:36px; flex-shrink:0; overflow:hidden; }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Menu Juri</div>
        <a href="{{ route('juri.dashboard') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🏠</span> Beranda
        </a>
        <a href="{{ route('juri.desain') }}" class="sidebar-item active">
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
        <div class="page-header">
            <h1 class="page-title">Daftar Desain</h1>
            <p class="page-sub">Klik "Nilai" untuk membuka form penilaian</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if($designs->isEmpty())
            <div class="content-card" style="text-align:center;padding:60px">
                <div style="font-size:64px;margin-bottom:20px">🎨</div>
                <h2 style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:var(--dark);margin-bottom:12px">Belum Ada Desain</h2>
                <p style="color:var(--muted)">Belum ada desain yang disetujui admin untuk dinilai.</p>
            </div>
        @else
            @foreach($designs as $design)
            @php $sudah = in_array($design->id, $sudahDinilai); @endphp
            <div class="design-card">
                <div class="design-thumb">
                    @if($design->image_path)
                        <img src="{{ asset('storage/'.$design->image_path) }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                        🎨
                    @endif
                </div>
                <div style="flex:1">
                    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap">
                        <div>
                            <div style="font-size:16px;font-weight:800;color:var(--dark);margin-bottom:4px">{{ $design->title }}</div>
                            <div style="font-size:13px;color:var(--muted);margin-bottom:8px">👤 {{ $design->user->name }} · {{ $design->user->region ?? '-' }}</div>
                            <div style="font-size:13px;color:var(--muted);line-height:1.5">{{ Str::limit($design->description, 100) }}</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;flex-shrink:0">
                            @if($sudah)
                                <span class="badge badge-green">✅ Sudah Dinilai</span>
                            @else
                                <span class="badge badge-yellow">⏳ Belum Dinilai</span>
                            @endif
                            <a href="{{ route('juri.desain.detail', $design->id) }}" class="btn btn-primary btn-sm">
                                {{ $sudah ? '✏️ Edit Nilai' : '⭐ Beri Nilai' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </main>
</div>
@endsection