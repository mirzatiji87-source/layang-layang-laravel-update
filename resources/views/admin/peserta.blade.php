@extends('layouts.app')
@section('title', 'Data Peserta - LayangFest 2026')
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
        <a href="{{ route('admin.peserta') }}" class="sidebar-item active">
            <span class="sidebar-item-icon">👥</span> Data Peserta
        </a>
        <a href="{{ route('admin.juri') }}" class="sidebar-item">
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
            <h1 class="page-title">Data Peserta</h1>
            <p class="page-sub">Kelola dan verifikasi data peserta lomba</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="content-card">
            <div class="content-card-title">
                Daftar Peserta
                <span class="badge badge-purple">{{ $peserta->count() }} peserta</span>
            </div>
            @if($peserta->isEmpty())
                <div style="text-align:center;padding:40px;color:var(--muted)">Belum ada peserta terdaftar.</div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Daerah</th>
                        <th>Desain</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peserta as $i => $p)
                    <tr>
                        <td style="color:var(--muted)">{{ $i+1 }}</td>
                        <td><div style="font-weight:700">{{ $p->name }}</div></td>
                        <td style="font-size:13px;color:var(--muted)">{{ $p->email }}</td>
                        <td>{{ $p->phone ?? '-' }}</td>
                        <td>{{ $p->region ?? '-' }}</td>
                        <td>
                            @if($p->designs->count() > 0)
                                <span class="badge badge-sky">{{ $p->designs->first()->title }}</span>
                            @else
                                <span style="color:var(--muted);font-size:12px">Belum upload</span>
                            @endif
                        </td>
                        <td>
                            @if($p->is_verified)
                                <span class="badge badge-green">✅ Verified</span>
                            @else
                                <span class="badge badge-yellow">⏳ Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-actions">
                                @if(!$p->is_verified)
                                <form method="POST" action="{{ route('admin.peserta.verify', $p->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">✓ Verify</button>
                                </form>
                                @endif
                                <form method="POST" action="{{ route('admin.peserta.delete', $p->id) }}" onsubmit="return confirm('Hapus peserta ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </main>
</div>
@endsection