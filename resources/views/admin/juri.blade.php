@extends('layouts.app')
@section('title', 'Data Juri - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
</style>
@endpush

<div class="dashboard-wrapper">
    <aside class="sidebar">
        <div class="sidebar-label">Dashboard</div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📊</span> Overview
        </a>
        <div class="sidebar-label">Manajemen</div>
        <a href="{{ route('admin.peserta') }}" class="sidebar-item">
            <span class="sidebar-item-icon">👥</span> Data Peserta
        </a>
        <a href="{{ route('admin.juri') }}" class="sidebar-item active">
            <span class="sidebar-item-icon">⭐</span> Data Juri
        </a>
        <a href="{{ route('admin.desain') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🎨</span> Kelola Desain
        </a>
        <div class="sidebar-label">Lomba</div>
        <a href="{{ route('admin.penilaian') }}" class="sidebar-item">
            <span class="sidebar-item-icon">📋</span> Hasil Penilaian
        </a>
        <a href="{{ route('admin.juara') }}" class="sidebar-item">
            <span class="sidebar-item-icon">🏆</span> Tentukan Juara
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
            <h1 class="page-title">Data Juri</h1>
            <p class="page-sub">Kelola akun juri lomba</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div style="display:grid;grid-template-columns:2fr 1fr;gap:24px;align-items:start">
            <div class="content-card">
                <div class="content-card-title">
                    Daftar Juri
                    <span class="badge badge-purple">{{ $juris->count() }} juri</span>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Penilaian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($juris as $i => $j)
                        <tr>
                            <td style="color:var(--muted)">{{ $i+1 }}</td>
                            <td><div style="font-weight:700">{{ $j->name }}</div></td>
                            <td style="font-size:13px;color:var(--muted)">{{ $j->email }}</td>
                            <td><span class="badge badge-sky">{{ $j->scores->count() }} penilaian</span></td>
                            <td>
                                <form method="POST" action="{{ route('admin.juri.delete', $j->id) }}" onsubmit="return confirm('Hapus juri ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- FORM TAMBAH JURI --}}
            <div class="content-card">
                <div class="content-card-title">+ Tambah Juri</div>
                <form method="POST" action="{{ route('admin.juri.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nama Juri</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="email@contoh.com" required>
                    </div>
                    <div class="form-group">
                        <label>Keahlian</label>
                        <input type="text" name="expertise" class="form-control" placeholder="Contoh: Seniman Nasional">
                    </div>
                    <div class="alert alert-info">🔑 Password default: <strong>password</strong></div>
                    <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">+ Tambah Juri</button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection