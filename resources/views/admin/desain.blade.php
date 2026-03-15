@extends('layouts.app')
@section('title', 'Kelola Desain - LayangFest 2025')
@section('content')

@push('styles')
<style>
    .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
    .design-thumb { width:60px; height:60px; border-radius:10px; background:linear-gradient(135deg,#ede9fe,#dbeafe); display:flex; align-items:center; justify-content:center; font-size:28px; overflow:hidden; flex-shrink:0; }
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
        <a href="{{ route('admin.juri') }}" class="sidebar-item">
            <span class="sidebar-item-icon">⭐</span> Data Juri
        </a>
        <a href="{{ route('admin.desain') }}" class="sidebar-item active">
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
            <h1 class="page-title">Kelola Desain</h1>
            <p class="page-sub">Review dan approve/reject desain peserta</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        <div class="content-card">
            <div class="content-card-title">
                Semua Desain
                <span class="badge badge-purple">{{ $designs->count() }} desain</span>
            </div>
            @if($designs->isEmpty())
                <div style="text-align:center;padding:40px;color:var(--muted)">Belum ada desain yang diupload.</div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Desain</th>
                        <th>Peserta</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($designs as $d)
                    @php $score = $d->scores->avg('final_score'); @endphp
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px">
                                <div class="design-thumb">
                                    @if($d->image_path)
                                        <img src="{{ asset('storage/'.$d->image_path) }}" style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        🎨
                                    @endif
                                </div>
                                <div style="font-weight:700">{{ $d->title }}</div>
                            </div>
                        </td>
                        <td>{{ $d->user->name }}</td>
                        <td style="font-size:13px;color:var(--muted)">{{ $d->created_at->format('d M Y') }}</td>
                        <td>
                            @if($d->status == 'pending')
                                <span class="badge badge-yellow">⏳ Pending</span>
                            @elseif($d->status == 'approved')
                                <span class="badge badge-green">✅ Approved</span>
                            @else
                                <span class="badge badge-red">❌ Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($score)
                                <strong style="color:var(--p1)">{{ number_format($score,1) }}</strong>
                            @else
                                <span style="color:var(--muted)">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="table-actions">
                                @if($d->status == 'pending')
                                <form method="POST" action="{{ route('admin.desain.approve', $d->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">✓ Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.desain.reject', $d->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">✗ Reject</button>
                                </form>
                                @endif
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