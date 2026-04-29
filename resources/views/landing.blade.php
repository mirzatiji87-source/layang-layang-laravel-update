@extends('layouts.app')
@section('title', 'Beranda - LayangFest 2026')
@section('content')

    @push('styles')
        <style>
            #hero {
                min-height: 100vh;
                background: linear-gradient(135deg, #0f0f23 0%, #1a1a3e 35%, #2d1b69 65%, #1e3a5f 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                padding-top: 68px;
                position: relative;
                overflow: hidden;
            }

            .hero-bg-orb {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                opacity: .25;
                animation: orbFloat ease-in-out infinite;
            }

            @keyframes orbFloat {

                0%,
                100% {
                    transform: translate(0, 0)
                }

                50% {
                    transform: translate(30px, -30px)
                }
            }

            .hero-content {
                text-align: center;
                max-width: 850px;
                padding: 0 32px;
                position: relative;
                z-index: 2;
            }

            .hero-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(99, 102, 241, .2);
                border: 1px solid rgba(99, 102, 241, .4);
                border-radius: 100px;
                padding: 8px 20px;
                font-size: 13px;
                font-weight: 700;
                color: #a5b4fc;
                margin-bottom: 32px;
                letter-spacing: .3px;
            }

            .hero-title {
                font-family: 'Syne', sans-serif;
                font-size: clamp(52px, 9vw, 96px);
                font-weight: 800;
                color: #fff;
                line-height: 1;
                margin-bottom: 8px;
                letter-spacing: -2px;
            }

            .hero-title-grad {
                font-family: 'Syne', sans-serif;
                font-size: clamp(52px, 9vw, 96px);
                font-weight: 800;
                background: linear-gradient(135deg, #f97316, #fbbf24, #ec4899);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                line-height: 1.1;
                margin-bottom: 24px;
                letter-spacing: -2px;
            }

            .hero-sub {
                font-size: 18px;
                color: rgba(255, 255, 255, .6);
                line-height: 1.7;
                margin-bottom: 44px;
                max-width: 580px;
                margin-left: auto;
                margin-right: auto;
                font-weight: 400;
            }

            .hero-cta {
                display: flex;
                gap: 16px;
                justify-content: center;
                flex-wrap: wrap;
            }

            .hero-stats {
                display: flex;
                gap: 0;
                justify-content: center;
                margin-top: 72px;
                background: rgba(255, 255, 255, .04);
                border: 1px solid rgba(255, 255, 255, .08);
                border-radius: 20px;
                overflow: hidden;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }

            .hero-stat {
                flex: 1;
                padding: 24px 20px;
                text-align: center;
                border-right: 1px solid rgba(255, 255, 255, .06);
            }

            .hero-stat:last-child {
                border-right: none;
            }

            .hero-stat-num {
                font-family: 'Syne', sans-serif;
                font-size: 36px;
                font-weight: 800;
                background: linear-gradient(135deg, #6366f1, #ec4899);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .hero-stat-label {
                font-size: 12px;
                color: rgba(255, 255, 255, .45);
                margin-top: 4px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .5px;
            }

            .kite-deco {
                position: absolute;
                animation: kiteDrift ease-in-out infinite;
                font-size: 36px;
                opacity: .35;
            }

            @keyframes kiteDrift {

                0%,
                100% {
                    transform: translate(0, 0) rotate(-8deg)
                }

                50% {
                    transform: translate(25px, -35px) rotate(8deg)
                }
            }

            /* FEATURES */
            .features-section {
                padding: 100px 32px;
                max-width: 1280px;
                margin: 0 auto;
            }

            .section-eyebrow {
                font-size: 12px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                color: var(--p1);
                margin-bottom: 16px;
            }

            .section-title {
                font-family: 'Syne', sans-serif;
                font-size: clamp(32px, 5vw, 52px);
                font-weight: 800;
                color: var(--dark);
                letter-spacing: -1px;
                line-height: 1.1;
                margin-bottom: 16px;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 24px;
                margin-top: 56px;
            }

            .feature-card {
                padding: 32px;
                border-radius: 20px;
                background: #fff;
                border: 1px solid var(--border);
                transition: all .3s;
                position: relative;
                overflow: hidden;
            }

            .feature-card::before {
                content: '';
                position: absolute;
                inset: 0;
                opacity: 0;
                transition: opacity .3s;
            }

            .feature-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 20px 50px rgba(0, 0, 0, .1);
            }

            .feature-card:hover::before {
                opacity: 1;
            }

            .feature-card-1::before {
                background: linear-gradient(135deg, rgba(99, 102, 241, .04), transparent);
            }

            .feature-card-2::before {
                background: linear-gradient(135deg, rgba(34, 197, 94, .04), transparent);
            }

            .feature-card-3::before {
                background: linear-gradient(135deg, rgba(251, 191, 36, .04), transparent);
            }

            .feature-icon {
                width: 56px;
                height: 56px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 28px;
                margin-bottom: 20px;
            }

            .feature-title {
                font-size: 18px;
                font-weight: 800;
                color: var(--dark);
                margin-bottom: 10px;
            }

            .feature-text {
                font-size: 14px;
                color: var(--muted);
                line-height: 1.7;
            }
        </style>
    @endpush

    <div id="hero">
        <!-- Background Orbs -->
        <div class="hero-bg-orb"
            style="width:500px;height:500px;background:#6366f1;top:-100px;left:-100px;animation-duration:8s"></div>
        <div class="hero-bg-orb"
            style="width:400px;height:400px;background:#ec4899;bottom:-80px;right:-80px;animation-duration:10s;animation-delay:-4s">
        </div>
        <div class="hero-bg-orb"
            style="width:300px;height:300px;background:#0ea5e9;top:50%;left:50%;animation-duration:7s;animation-delay:-2s">
        </div>

        <!-- Floating Kites -->
        <span class="kite-deco" style="left:8%;top:25%;animation-duration:7s">🪁</span>
        <span class="kite-deco" style="right:10%;top:20%;animation-duration:9s;animation-delay:-3s">🪁</span>
        <span class="kite-deco"
            style="left:20%;bottom:30%;animation-duration:6s;animation-delay:-1s;font-size:24px">🪁</span>
        <span class="kite-deco"
            style="right:18%;bottom:25%;animation-duration:8s;animation-delay:-5s;font-size:22px">🪁</span>

        <div class="hero-content">
            <div class="hero-eyebrow">✨ Kompetisi Nasional 2025 &nbsp;·&nbsp; Terbuka Untuk Umum</div>
            <div class="hero-title">Festival</div>
            <div class="hero-title-grad">Layang-Layang</div>
            <div class="hero-title" style="margin-bottom:24px">Nusantara</div>
            <p class="hero-sub">Wujudkan kreativitasmu dalam kompetisi desain layang-layang tingkat nasional. Total hadiah
                <strong style="color:#fbbf24">50 juta rupiah</strong> menanti kamu!</p>
            <div class="hero-cta">
                <a href="{{ route('register') }}" class="btn btn-lg btn-warm">✏️ Daftar Sekarang</a>
                <a href="{{ route('info') }}" class="btn btn-lg"
                    style="background:rgba(255,255,255,.08);color:#fff;border:1.5px solid rgba(255,255,255,.15)">ℹ️ Info
                    Lomba</a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <div class="hero-stat-num">50Jt</div>
                    <div class="hero-stat-label">Total Hadiah</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num">5</div>
                    <div class="hero-stat-label">Juri Pro</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num">30</div>
                    <div class="hero-stat-label">Hari Tersisa</div>
                </div>
                <div class="hero-stat">
                    <div class="hero-stat-num">∞</div>
                    <div class="hero-stat-label">Kreativitas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURES -->
    <div style="background:#fff">
        <div class="features-section">
            <div style="text-align:center;max-width:600px;margin:0 auto">
                <div class="section-eyebrow">Mengapa Ikut?</div>
                <h2 class="section-title">Platform Paling <span class="grad-text">Modern</span> untuk Lomba Desain</h2>
                <p style="color:var(--muted);font-size:16px;line-height:1.7">Dari pendaftaran hingga pengumuman juara, semua
                    serba digital, transparan, dan mudah.</p>
            </div>
            <div class="features-grid">
                <div class="feature-card feature-card-1">
                    <div class="feature-icon" style="background:#ede9fe">📋</div>
                    <div class="feature-title">Registrasi Mudah</div>
                    <div class="feature-text">Daftar online dalam hitungan menit. Isi form, verifikasi admin, dan langsung
                        mulai berpartisipasi.</div>
                </div>
                <div class="feature-card feature-card-2">
                    <div class="feature-icon" style="background:#dcfce7">🎨</div>
                    <div class="feature-title">Upload Desain Digital</div>
                    <div class="feature-text">Upload desain layang-layang dalam format gambar langsung dari perangkat kamu
                        kapan saja.</div>
                </div>
                <div class="feature-card feature-card-3">
                    <div class="feature-icon" style="background:#fef9c3">⭐</div>
                    <div class="feature-title">Penilaian Transparan</div>
                    <div class="feature-text">Juri profesional menilai berdasarkan 4 kriteria yang jelas dengan sistem
                        scoring otomatis.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background:#fce7f3">🏆</div>
                    <div class="feature-title">Pengumuman Real-time</div>
                    <div class="feature-text">Pantau status desain dan lihat pengumuman juara langsung di website tanpa
                        perlu menunggu.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background:#dbeafe">📄</div>
                    <div class="feature-title">Juknis Lengkap</div>
                    <div class="feature-text">Download petunjuk teknis lomba lengkap sebagai panduan membuat desain terbaik
                        kamu.</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background:#fff7ed">🖼️</div>
                    <div class="feature-title">Galeri Pemenang</div>
                    <div class="feature-text">Desain terbaik dipajang di galeri publik yang bisa dilihat seluruh pengunjung
                        website.</div>
                </div>
            </div>
        </div>
    </div>

@endsection