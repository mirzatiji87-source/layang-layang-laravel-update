@extends('layouts.app')
@section('title', 'Upload Desain - LayangFest 2026')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .upload-area { border:2.5px dashed #c4b5fd; border-radius:16px; padding:48px; text-align:center; cursor:pointer; transition:all .3s; background:linear-gradient(135deg,#faf5ff,#eff6ff); }
    .upload-area:hover { border-color:var(--p1); background:linear-gradient(135deg,#ede9fe,#dbeafe); transform:scale(1.01); }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Menu Utama</div>
        <a href="{{ route('peserta.dashboard') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🏠</span> Beranda
        </a>
        <a href="{{ route('peserta.upload') }}" class="sidebar-item active">
            <span class="sidebar-item-icon">⬆️</span> Upload Desain
        </a>
        <a href="{{ route('peserta.status') }}" class="sidebar-item">
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
            <h1 class="page-title">Upload Desain</h1>
            <p class="page-sub">Upload karya layang-layang terbaik kamu</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">❌ {{ $errors->first() }}</div>
        @endif

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:28px">
            {{-- FORM --}}
            <div class="content-card">
                <div class="content-card-title">Form Upload Desain</div>
                <form method="POST" action="{{ route('peserta.upload.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Judul Karya</label>
                        <input type="text" name="title" class="form-control" placeholder="Nama karya layang-layang kamu" value="{{ old('title', $design->title ?? '') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi Karya</label>
                        <textarea name="description" class="form-control" placeholder="Ceritakan tentang karya dan inspirasi kamu..." required>{{ old('description', $design->description ?? '') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Upload Gambar Desain</label>
                        <div class="upload-area" onclick="document.getElementById('file-input').click()">
                            <div style="font-size:48px;margin-bottom:12px">🖼️</div>
                            <div style="font-size:16px;font-weight:800;color:var(--dark);margin-bottom:6px">Klik untuk upload gambar</div>
                            <div style="font-size:13px;color:var(--muted)">JPG, PNG · Maksimal 10MB</div>
                        </div>
                        <input type="file" id="file-input" name="image" accept="image/*" style="display:none" onchange="previewImage(event)" {{ $design ? '' : 'required' }}>
                        <div id="file-name" style="margin-top:8px;font-size:13px;color:var(--muted)"></div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                        ⬆️ {{ $design ? 'Perbarui Desain' : 'Upload Desain' }}
                    </button>
                </form>
            </div>

            {{-- PREVIEW --}}
            <div>
                <div class="content-card">
                    <div class="content-card-title">Preview</div>
                    <div id="preview-container">
                        @if($design && $design->image_path)
                            <img src="{{ asset('storage/'.$design->image_path) }}" style="width:100%;height:260px;object-fit:cover;border-radius:12px;border:2px solid var(--border)">
                            <div style="margin-top:12px;padding:10px 14px;background:var(--grad-bg);border-radius:8px;font-size:13px;color:var(--muted)">
                                📌 Desain saat ini: <strong>{{ $design->title }}</strong>
                            </div>
                        @else
                            <div id="preview-placeholder" style="height:260px;background:linear-gradient(135deg,#faf5ff,#eff6ff);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:8px;border:2px dashed #c4b5fd">
                                <span style="font-size:48px">🖼️</span>
                                <span style="font-size:14px;color:var(--muted)">Preview gambar muncul di sini</span>
                            </div>
                        @endif
                        <img id="preview-img" src="" style="width:100%;height:260px;object-fit:cover;border-radius:12px;border:2px solid var(--border);display:none;margin-top:0">
                    </div>
                </div>

                <div class="content-card" style="margin-top:20px">
                    <div class="content-card-title">📋 Panduan Upload</div>
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach(['Format JPG atau PNG','Resolusi minimal 2000 x 2000 px','Ukuran file maksimal 10MB','Karya orisinal dan belum pernah dilombakan','Tidak mengandung unsur SARA'] as $i => $rule)
                        <div style="display:flex;align-items:center;gap:10px;font-size:13px;color:var(--muted)">
                            <span style="width:20px;height:20px;border-radius:50%;background:{{ $i < 4 ? 'var(--grad-main)' : '#fee2e2' }};display:flex;align-items:center;justify-content:center;color:#fff;font-size:10px;font-weight:800;flex-shrink:0">{{ $i < 4 ? '✓' : '✗' }}</span>
                            {{ $rule }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
function previewImage(e) {
    const file = e.target.files[0];
    if (!file) return;
    document.getElementById('file-name').textContent = '📎 ' + file.name + ' (' + (file.size/1024/1024).toFixed(2) + ' MB)';
    const reader = new FileReader();
    reader.onload = (ev) => {
        document.getElementById('preview-placeholder') && (document.getElementById('preview-placeholder').style.display = 'none');
        const img = document.getElementById('preview-img');
        img.src = ev.target.result;
        img.style.display = 'block';
    };
    reader.readAsDataURL(file);
}
</script>
@endpush

@endsection