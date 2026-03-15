@extends('layouts.app')
@section('title', 'Info Lomba - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .page-hero { min-height:38vh; background:linear-gradient(135deg,#0f0f23,#1a1a3e,#2d1b69); display:flex; align-items:center; justify-content:center; padding-top:68px; position:relative; overflow:hidden; }
    .page-hero-orb { position:absolute; border-radius:50%; filter:blur(80px); opacity:.2; }
    .info-section { max-width:1200px; margin:0 auto; padding:80px 32px; }
    .info-grid { display:grid; grid-template-columns:2fr 1fr; gap:40px; align-items:start; }
    .timeline { position:relative; padding-left:36px; }
    .timeline::before { content:''; position:absolute; left:12px; top:0; bottom:0; width:2px; background:linear-gradient(to bottom,var(--p1),var(--p3)); border-radius:2px; }
    .timeline-item { position:relative; margin-bottom:32px; }
    .timeline-dot { position:absolute; left:-29px; top:4px; width:16px; height:16px; border-radius:50%; background:var(--grad-main); border:3px solid #fff; box-shadow:0 0 0 3px rgba(99,102,241,.3); }
    .timeline-date { font-size:12px; font-weight:800; color:var(--p1); text-transform:uppercase; letter-spacing:.8px; margin-bottom:4px; }
    .timeline-title { font-size:16px; font-weight:800; color:var(--dark); margin-bottom:4px; }
    .timeline-desc { font-size:13px; color:var(--muted); line-height:1.6; }
    .criteria-item { display:flex; justify-content:space-between; align-items:center; padding:12px 16px; background:var(--grad-bg); border-radius:10px; margin-bottom:8px; border:1px solid var(--border); }
    .prize-card { border-radius:16px; padding:20px; margin-bottom:12px; }
    .juknis-banner { background:var(--grad-sky); border-radius:20px; padding:32px; color:#fff; display:flex; align-items:center; gap:24px; margin-top:24px; }
    @media(max-width:900px) { .info-grid{grid-template-columns:1fr;} }
</style>
@endpush

<div class="page-hero">
    <div class="page-hero-orb" style="width:400px;height:400px;background:#6366f1;top:-100px;left:-100px"></div>
    <div class="page-hero-orb" style="width:300px;height:300px;background:#ec4899;bottom:-80px;right:-80px"></div>
    <div style="text-align:center;position:relative;z-index:2;padding:60px 32px">
        <div style="font-size:52px;margin-bottom:16px">📋</div>
        <h1 style="font-family:'Syne',sans-serif;font-size:clamp(40px,7vw,72px);font-weight:800;color:#fff;letter-spacing:-2px;margin-bottom:12px">Info Lomba</h1>
        <p style="font-size:16px;color:rgba(255,255,255,.55)">Panduan lengkap Festival Layang-Layang Nusantara 2025</p>
    </div>
</div>

<div class="info-section">
    <div class="info-grid">

        {{-- KIRI --}}
        <div>
            {{-- Tentang Lomba --}}
            <div class="content-card">
                <h3 style="font-family:'Syne',sans-serif;font-size:24px;font-weight:800;margin-bottom:16px;color:var(--dark)">Tentang Lomba</h3>
                <p style="color:var(--muted);line-height:1.8;margin-bottom:12px">Festival Layang-Layang Nusantara 2025 merupakan ajang kompetisi desain layang-layang tingkat nasional yang diselenggarakan untuk melestarikan dan mengembangkan seni budaya layang-layang di Indonesia.</p>
                <p style="color:var(--muted);line-height:1.8">Peserta diundang untuk merancang layang-layang dengan kreativitas tinggi, menggabungkan unsur tradisional dan modern dalam sebuah karya yang memukau.</p>
            </div>

            {{-- Kriteria Penilaian --}}
            <div class="content-card" style="margin-top:24px">
                <h3 style="font-family:'Syne',sans-serif;font-size:24px;font-weight:800;margin-bottom:20px;color:var(--dark)">Kriteria Penilaian</h3>
                <div class="criteria-item">
                    <span style="font-size:14px;font-weight:700">🎨 Orisinalitas & Kreativitas</span>
                    <span class="badge badge-purple">30 poin</span>
                </div>
                <div class="criteria-item">
                    <span style="font-size:14px;font-weight:700">✨ Estetika & Keindahan Visual</span>
                    <span class="badge badge-sky">25 poin</span>
                </div>
                <div class="criteria-item">
                    <span style="font-size:14px;font-weight:700">🏛️ Nilai Budaya Lokal</span>
                    <span class="badge badge-yellow">25 poin</span>
                </div>
                <div class="criteria-item">
                    <span style="font-size:14px;font-weight:700">⚙️ Teknis & Fungsionalitas</span>
                    <span class="badge badge-green">20 poin</span>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="content-card" style="margin-top:24px">
                <h3 style="font-family:'Syne',sans-serif;font-size:24px;font-weight:800;margin-bottom:24px;color:var(--dark)">Timeline Lomba</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">01 Jan – 28 Feb 2025</div>
                        <div class="timeline-title">Pendaftaran Peserta</div>
                        <div class="timeline-desc">Registrasi akun dan upload desain layang-layang</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">01 – 15 Mar 2025</div>
                        <div class="timeline-title">Proses Penilaian</div>
                        <div class="timeline-desc">Juri menilai seluruh desain yang masuk</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-date">20 Mar 2025</div>
                        <div class="timeline-title">Pengumuman Finalis</div>
                        <div class="timeline-desc">Pengumuman 10 besar finalis lomba</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot" style="background:var(--grad-warm)"></div>
                        <div class="timeline-date" style="color:var(--a1)">25 Mar 2025</div>
                        <div class="timeline-title">🏆 Pengumuman Juara</div>
                        <div class="timeline-desc">Juara 1, 2, dan 3 diumumkan secara resmi</div>
                    </div>
                </div>
            </div>

            {{-- Download Juknis --}}
            <div class="juknis-banner">
                <div style="font-size:52px;flex-shrink:0">📄</div>
                <div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:22px;font-weight:800;margin-bottom:8px">Petunjuk Teknis (Juknis)</h3>
                    <p style="opacity:.85;font-size:14px;line-height:1.6;margin-bottom:16px">Unduh juknis lengkap berisi panduan format desain, syarat peserta, aturan lomba, dan ketentuan penilaian.</p>
                    <a href="#" class="btn" style="background:rgba(255,255,255,.2);color:#fff;border:1.5px solid rgba(255,255,255,.4)">⬇️ Download PDF</a>
                </div>
            </div>
        </div>

        {{-- KANAN --}}
        <div>
            {{-- Hadiah --}}
            <div class="content-card">
                <h3 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;margin-bottom:20px;color:var(--dark)">🏆 Hadiah</h3>
                <div class="prize-card" style="background:linear-gradient(135deg,#fef9c3,#fef08a);border:1px solid #fde047">
                    <div style="font-size:11px;font-weight:800;color:#854d0e;text-transform:uppercase;letter-spacing:.8px">Juara 1</div>
                    <div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:#78350f">Rp 25.000.000</div>
                    <div style="font-size:12px;color:#92400e;margin-top:4px">+ Piala + Sertifikat</div>
                </div>
                <div class="prize-card" style="background:linear-gradient(135deg,#f1f5f9,#e2e8f0);border:1px solid #cbd5e1">
                    <div style="font-size:11px;font-weight:800;color:#475569;text-transform:uppercase;letter-spacing:.8px">Juara 2</div>
                    <div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:#334155">Rp 15.000.000</div>
                    <div style="font-size:12px;color:#64748b;margin-top:4px">+ Piala + Sertifikat</div>
                </div>
                <div class="prize-card" style="background:linear-gradient(135deg,#fff7ed,#fed7aa);border:1px solid #fdba74">
                    <div style="font-size:11px;font-weight:800;color:#c2410c;text-transform:uppercase;letter-spacing:.8px">Juara 3</div>
                    <div style="font-family:'Syne',sans-serif;font-size:28px;font-weight:800;color:#9a3412">Rp 10.000.000</div>
                    <div style="font-size:12px;color:#c2410c;margin-top:4px">+ Piala + Sertifikat</div>
                </div>
            </div>

            {{-- Syarat --}}
            <div class="content-card" style="margin-top:24px">
                <h3 style="font-family:'Syne',sans-serif;font-size:20px;font-weight:800;margin-bottom:20px;color:var(--dark)">📋 Syarat Peserta</h3>
                <div style="display:flex;flex-direction:column;gap:10px">
                    @foreach(['Warga Negara Indonesia','Usia minimal 15 tahun','Desain orisinal karya sendiri','Format JPG/PNG min. 2000px','Maksimal 1 karya per peserta','Ukuran file max 10MB'] as $syarat)
                    <div style="display:flex;align-items:center;gap:10px;font-size:14px;color:var(--muted)">
                        <span style="width:22px;height:22px;border-radius:50%;background:var(--grad-main);display:flex;align-items:center;justify-content:center;color:#fff;font-size:11px;font-weight:800;flex-shrink:0">✓</span>
                        {{ $syarat }}
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('register') }}" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:24px">Daftar Sekarang →</a>
            </div>
        </div>

    </div>
</div>

@endsection