@extends('layouts.app')
@section('title', 'Form Penilaian - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    input[type=range] { width:100%; height:8px; border-radius:4px; appearance:none; background:#e5e7eb; outline:none; cursor:pointer; }
    input[type=range]::-webkit-slider-thumb { appearance:none; width:22px; height:22px; border-radius:50%; background:var(--p1); border:3px solid #fff; box-shadow:0 2px 8px rgba(99,102,241,.4); cursor:pointer; }
    .range-wrapper { background:linear-gradient(135deg,#faf5ff,#eff6ff); border-radius:14px; padding:20px; margin-bottom:16px; }
    .range-label { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .range-value { font-family:'Syne',sans-serif; font-size:28px; font-weight:800; background:var(--grad-main); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
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
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px">
                <a href="{{ route('juri.desain') }}" class="btn btn-sm" style="background:#f3f4f6;color:var(--text)">← Kembali</a>
            </div>
            <h1 class="page-title">Form Penilaian</h1>
            <p class="page-sub">Berikan penilaian objektif untuk desain ini</p>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:28px">
            {{-- INFO DESAIN --}}
            <div>
                <div class="content-card">
                    <div class="content-card-title">Detail Desain</div>
                    <div style="background:linear-gradient(135deg,#ede9fe,#dbeafe);border-radius:14px;height:220px;display:flex;align-items:center;justify-content:center;margin-bottom:20px;overflow:hidden">
                        @if($design->image_path)
                            <img src="{{ asset('storage/'.$design->image_path) }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <span style="font-size:80px">🎨</span>
                        @endif
                    </div>
                    <h3 style="font-size:20px;font-weight:800;color:var(--dark);margin-bottom:8px">{{ $design->title }}</h3>
                    <p style="font-size:14px;color:var(--muted);line-height:1.7;margin-bottom:16px">{{ $design->description }}</p>
                    <div style="display:flex;gap:12px;flex-wrap:wrap">
                        <span class="badge badge-purple">👤 {{ $design->user->name }}</span>
                        <span class="badge badge-sky">📍 {{ $design->user->region ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- FORM PENILAIAN --}}
            <div>
                <div class="content-card">
                    <div class="content-card-title">Form Penilaian</div>
                    <form method="POST" action="{{ route('juri.nilai.store', $design->id) }}">
                        @csrf

                        @foreach([
                            ['orisinalitas', '🎨 Orisinalitas & Kreativitas', '30%'],
                            ['estetika', '✨ Estetika & Visual', '25%'],
                            ['budaya', '🏛️ Nilai Budaya Lokal', '25%'],
                            ['teknis', '⚙️ Teknis & Fungsional', '20%'],
                        ] as [$field, $label, $bobot])
                        <div class="range-wrapper">
                            <div class="range-label">
                                <div>
                                    <div style="font-size:14px;font-weight:800;color:var(--dark)">{{ $label }}</div>
                                    <div style="font-size:11px;color:var(--muted)">Bobot: {{ $bobot }}</div>
                                </div>
                                <div class="range-value" id="val-{{ $field }}">{{ $existingScore ? $existingScore->$field : 50 }}</div>
                            </div>
                            <input type="range" min="0" max="100"
                                value="{{ $existingScore ? $existingScore->$field : 50 }}"
                                name="{{ $field }}"
                                id="range-{{ $field }}"
                                oninput="updateVal('{{ $field }}', this.value)">
                        </div>
                        @endforeach

                        {{-- NILAI AKHIR --}}
                        <div style="background:linear-gradient(135deg,#0f0f23,#1a1a3e);border-radius:16px;padding:24px;text-align:center;margin-bottom:20px">
                            <div style="font-size:12px;font-weight:800;color:rgba(255,255,255,.5);text-transform:uppercase;letter-spacing:.8px;margin-bottom:8px">Nilai Akhir</div>
                            <div id="final-score" style="font-family:'Syne',sans-serif;font-size:56px;font-weight:800;background:linear-gradient(135deg,#fbbf24,#f97316);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">
                                {{ $existingScore ? number_format($existingScore->final_score,1) : '50.0' }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Catatan Juri (Opsional)</label>
                            <textarea name="catatan" class="form-control" placeholder="Berikan catatan atau saran untuk peserta...">{{ $existingScore ? $existingScore->catatan : '' }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:14px">
                            ✅ Simpan Penilaian
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
function updateVal(field, val) {
    document.getElementById('val-' + field).textContent = val;
    updateFinal();
}
function updateFinal() {
    const o = +document.getElementById('range-orisinalitas').value;
    const e = +document.getElementById('range-estetika').value;
    const b = +document.getElementById('range-budaya').value;
    const t = +document.getElementById('range-teknis').value;
    const final = (o * 0.30) + (e * 0.25) + (b * 0.25) + (t * 0.20);
    document.getElementById('final-score').textContent = final.toFixed(1);
}
</script>
@endpush

@endsection