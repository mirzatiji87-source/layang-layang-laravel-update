<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Event Layang-Layang Nusantara 2026')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --p1: #6366f1;
            --p2: #8b5cf6;
            --p3: #ec4899;
            --a1: #f97316;
            --a2: #fbbf24;
            --sky: #0ea5e9;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #0f0f23;
            --dark2: #1a1a3e;
            --text: #1e1b4b;
            --muted: #6b7280;
            --border: #e5e7eb;
            --bg: #fafafa;
            --card: #ffffff;
            --grad-main: linear-gradient(135deg, #6366f1, #8b5cf6, #ec4899);
            --grad-warm: linear-gradient(135deg, #f97316, #fbbf24);
            --grad-sky: linear-gradient(135deg, #0ea5e9, #6366f1);
            --grad-bg: linear-gradient(135deg, #faf5ff 0%, #eff6ff 50%, #fff7ed 100%);
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--grad-bg); color:var(--text); min-height:100vh; }

        /* SCROLLBAR */
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:#f1f5f9; }
        ::-webkit-scrollbar-thumb { background:var(--p1); border-radius:3px; }

        /* BUTTONS */
        .btn { display:inline-flex; align-items:center; gap:6px; padding:10px 22px; border-radius:10px; border:none; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:700; cursor:pointer; transition:all .25s; text-decoration:none; }
        .btn-primary { background:var(--grad-main); color:#fff; box-shadow:0 4px 15px rgba(99,102,241,.35); }
        .btn-primary:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(99,102,241,.45); }
        .btn-secondary { background:#fff; color:var(--p1); border:2px solid var(--p1); }
        .btn-secondary:hover { background:var(--p1); color:#fff; }
        .btn-danger { background:var(--danger); color:#fff; box-shadow:0 4px 12px rgba(239,68,68,.3); }
        .btn-success { background:var(--success); color:#fff; box-shadow:0 4px 12px rgba(34,197,94,.3); }
        .btn-warning { background:var(--warning); color:#fff; }
        .btn-warm { background:var(--grad-warm); color:#fff; box-shadow:0 4px 15px rgba(249,115,22,.35); }
        .btn-warm:hover { transform:translateY(-2px); box-shadow:0 8px 25px rgba(249,115,22,.45); }
        .btn-sm { padding:6px 14px; font-size:12px; border-radius:8px; }
        .btn-lg { padding:14px 36px; font-size:16px; border-radius:12px; }

        /* BADGES */
        .badge { display:inline-flex; align-items:center; gap:4px; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700; }
        .badge-purple { background:#ede9fe; color:#6d28d9; }
        .badge-sky { background:#dbeafe; color:#1d4ed8; }
        .badge-green { background:#dcfce7; color:#15803d; }
        .badge-yellow { background:#fef9c3; color:#92400e; }
        .badge-red { background:#fee2e2; color:#b91c1c; }
        .badge-pink { background:#fce7f3; color:#be185d; }
        .badge-grad { background:var(--grad-main); color:#fff; }

        /* FORMS */
        .form-group { margin-bottom:20px; }
        .form-group label { display:block; font-size:12px; font-weight:700; color:var(--muted); margin-bottom:8px; text-transform:uppercase; letter-spacing:.6px; }
        .form-control { width:100%; padding:12px 16px; border:2px solid var(--border); border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; color:var(--text); transition:all .2s; background:#fff; }
        .form-control:focus { outline:none; border-color:var(--p1); box-shadow:0 0 0 4px rgba(99,102,241,.1); }
        .form-control::placeholder { color:#d1d5db; }
        textarea.form-control { resize:vertical; min-height:100px; }

        /* ALERTS */
        .alert { padding:14px 18px; border-radius:10px; font-size:14px; font-weight:500; margin-bottom:16px; display:flex; align-items:center; gap:10px; }
        .alert-success { background:#dcfce7; color:#15803d; border:1.5px solid #86efac; }
        .alert-danger { background:#fee2e2; color:#b91c1c; border:1.5px solid #fca5a5; }
        .alert-info { background:#ede9fe; color:#6d28d9; border:1.5px solid #c4b5fd; }

        /* NAVBAR */
        nav { position:fixed; top:0; left:0; right:0; z-index:1000; background:rgba(15,15,35,.92); backdrop-filter:blur(20px); border-bottom:1px solid rgba(255,255,255,.06); }
        .nav-inner { max-width:1280px; margin:0 auto; padding:0 32px; height:68px; display:flex; align-items:center; justify-content:space-between; }
        .nav-logo { display:flex; align-items:center; gap:12px; text-decoration:none; }
        .nav-logo-icon { width:40px; height:40px; background:var(--grad-main); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:22px; box-shadow:0 4px 12px rgba(99,102,241,.4); }
        .nav-logo-text { font-family:'Syne',sans-serif; font-size:18px; font-weight:800; color:#fff; letter-spacing:-.3px; }
        .nav-links { display:flex; align-items:center; gap:4px; }
        .nav-link { padding:8px 16px; border-radius:8px; color:rgba(255,255,255,.65); text-decoration:none; font-size:14px; font-weight:600; transition:all .2s; }
        .nav-link:hover { color:#fff; background:rgba(255,255,255,.08); }
        .nav-user { display:flex; align-items:center; gap:12px; }
        .nav-avatar { width:36px; height:36px; border-radius:50%; background:var(--grad-main); display:flex; align-items:center; justify-content:center; color:#fff; font-weight:800; font-size:14px; box-shadow:0 4px 10px rgba(99,102,241,.4); }

        /* DASHBOARD */
        .dashboard-wrapper { display:flex; padding-top:68px; min-height:100vh; }
        .sidebar { width:270px; background:var(--dark); min-height:calc(100vh - 68px); padding:28px 16px; position:fixed; top:68px; left:0; bottom:0; overflow-y:auto; border-right:1px solid rgba(255,255,255,.04); }
        .sidebar-logo { padding:0 12px; margin-bottom:28px; }
        .sidebar-label { font-size:10px; font-weight:800; color:rgba(255,255,255,.25); text-transform:uppercase; letter-spacing:1.2px; padding:0 12px; margin-bottom:6px; margin-top:20px; }
        .sidebar-item { display:flex; align-items:center; gap:12px; padding:10px 14px; border-radius:10px; color:rgba(255,255,255,.55); text-decoration:none; font-size:14px; font-weight:600; transition:all .2s; margin-bottom:2px; }
        .sidebar-item:hover { color:#fff; background:rgba(255,255,255,.06); }
        .sidebar-item.active { color:#fff; background:linear-gradient(135deg,rgba(99,102,241,.3),rgba(139,92,246,.2)); border:1px solid rgba(99,102,241,.2); }
        .sidebar-item-icon { width:22px; text-align:center; font-size:16px; }
        .dashboard-main { margin-left:270px; padding:36px; flex:1; }
        .page-header { margin-bottom:32px; }
        .page-title { font-family:'Syne',sans-serif; font-size:34px; font-weight:800; color:var(--dark); letter-spacing:-.5px; }
        .page-sub { font-size:14px; color:var(--muted); margin-top:6px; }

        /* STAT CARDS */
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(210px,1fr)); gap:20px; margin-bottom:28px; }
        .stat-card { background:#fff; border-radius:16px; border:1px solid var(--border); padding:24px; position:relative; overflow:hidden; transition:all .2s; }
        .stat-card:hover { transform:translateY(-3px); box-shadow:0 12px 32px rgba(0,0,0,.08); }
        .stat-card::before { content:''; position:absolute; top:0; right:0; width:80px; height:80px; border-radius:50%; transform:translate(20px,-20px); opacity:.08; }
        .stat-card-1::before { background:var(--p1); }
        .stat-card-2::before { background:var(--success); }
        .stat-card-3::before { background:var(--a1); }
        .stat-card-4::before { background:var(--p3); }
        .stat-label { font-size:11px; font-weight:800; color:var(--muted); text-transform:uppercase; letter-spacing:.6px; margin-bottom:10px; }
        .stat-value { font-family:'Syne',sans-serif; font-size:38px; font-weight:800; color:var(--dark); }
        .stat-icon { position:absolute; top:20px; right:20px; width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; }

        /* CONTENT CARDS */
        .content-card { background:#fff; border-radius:18px; border:1px solid var(--border); padding:28px; margin-bottom:24px; box-shadow:0 2px 8px rgba(0,0,0,.04); }
        .content-card-title { font-size:17px; font-weight:800; color:var(--dark); margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }

        /* TABLE */
        table { width:100%; border-collapse:collapse; }
        th { padding:10px 16px; text-align:left; font-size:11px; font-weight:800; color:var(--muted); text-transform:uppercase; letter-spacing:.6px; border-bottom:2px solid var(--border); }
        td { padding:14px 16px; font-size:14px; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        tr:hover td { background:#fafafa; }
        .table-actions { display:flex; gap:6px; flex-wrap:wrap; }

        /* GLASS CARD */
        .glass { background:rgba(255,255,255,.7); backdrop-filter:blur(20px); border:1px solid rgba(255,255,255,.5); }

        /* GRADIENT TEXT */
        .grad-text { background:var(--grad-main); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
        .grad-text-warm { background:var(--grad-warm); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    </style>
    @stack('styles')
</head>
<body>

<nav>
    <div class="nav-inner">
        <a href="{{ route('landing') }}" class="nav-logo">
            <div class="nav-logo-icon">🪁</div>
            <span class="nav-logo-text">LayangFest 2026</span>
        </a>
        <div class="nav-links">
            @auth
                <div class="nav-user">
                    <span class="badge badge-grad">{{ ucfirst(auth()->user()->role) }}</span>
                    <span style="color:rgba(255,255,255,.8);font-size:14px;font-weight:600">{{ auth()->user()->name }}</span>
                    <div class="nav-avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline">
                        @csrf
                        <button type="submit" class="btn btn-sm" style="background:rgba(255,255,255,.08);color:rgba(255,255,255,.7);border:1px solid rgba(255,255,255,.1)">Keluar</button>
                    </form>
                </div>
            @else
                <a href="{{ route('landing') }}" class="nav-link">Beranda</a>
                <a href="{{ route('info') }}" class="nav-link">Info Lomba</a>
                <a href="{{ route('pengumuman') }}" class="nav-link">Pengumuman</a>
                <a href="{{ route('galeri') }}" class="nav-link">Galeri</a>
                <a href="{{ route('login') }}" class="btn btn-sm btn-primary" style="margin-left:8px">Masuk</a>
            @endauth
        </div>
    </div>
</nav>

@yield('content')

@stack('scripts')
</body>
</html>