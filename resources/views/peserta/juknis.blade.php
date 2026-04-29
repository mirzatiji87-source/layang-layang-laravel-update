@extends('layouts.app')
@section('title', 'Juknis - LayangFest 2026')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
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
        <a href="{{ route('peserta.status') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📊</span> Status Desain
        </a>
        <a href="{{ route('peserta.juknis') }}" class="sidebar-item active">
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
            <h1 class="page-title">Petunjuk Teknis</h1>
            <p class="page-sub">Panduan lengkap untuk mengikuti lomba</p>
        </div>

        {{-- DOWNLOAD BANNER --}}
        <div style="background:var(--grad-sky);border-radius:20px;padding:32px;color:#fff;display:flex;align-items:center;gap:24px;margin-bottom:28px">
            <div style="font-size:56px;flex-shrink:0">📄</div>
            <div>
                <h3 style="font-family:'Syne',sans-serif;font-size:24px;font-weight:800;margin-bottom:8px">Juknis Lomba 2026</h3>
                <p style="opacity:.85;font-size:14px;line-height:1.6;margin-bottom:16px">Unduh petunjuk teknis lengkap berisi semua informasi yang kamu butuhkan.</p>
                <a href="#" class="btn" style="background:rgba(255,255,255,.2);color:#fff;border:1.5px solid rgba(255,255,255,.4)">⬇️ Download PDF</a>
            </div>
        </div>

        {{-- ISI JUKNIS --}}
        <div class="content-card">
            <div class="content-card-title">📋 Ringkasan Juknis</div>
            <div style="display:flex;flex-direction:column;gap:20px">
                @foreach([
                    ['var(--p1)', '1. Ketentuan Peserta', 'Peserta adalah WNI berusia min. 15 tahun, belum pernah memenangkan kompetisi serupa di tingkat nasional dalam 2 tahun terakhir.'],
                    ['var(--a1)', '2. Ketentuan Karya', 'Desain harus orisinal, belum pernah dipublikasikan, dan menggambarkan keanekaragaman budaya nusantara.'],
                    ['var(--sun)', '3. Format Pengumpulan', 'File desain dalam format JPG/PNG, resolusi minimal 2000px, ukuran max 10MB. Disertai judul dan deskripsi singkat.'],
                    ['var(--success)', '4. Proses Penilaian', 'Penilaian oleh 5 juri profesional berdasarkan 4 kriteria: Orisinalitas (30%), Estetika (25%), Nilai Budaya (25%), Teknis (20%).'],
                    ['var(--p3)', '5. Hak Cipta', 'Karya tetap menjadi milik peserta. Panitia berhak menggunakan karya untuk keperluan publikasi lomba.'],
                ] as [$color, $title, $desc])
                <div style="border-left:4px solid {{ $color }};padding-left:16px">
                    <div style="font-size:15px;font-weight:800;color:var(--dark);margin-bottom:6px">{{ $title }}</div>
                    <div style="font-size:14px;color:var(--muted);line-height:1.7">{{ $desc }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection