<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="Sat, 01 Jan 2000 00:00:00 GMT">
    <title>Panel de Administración — AddedUT</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'><rect width='32' height='32' rx='8' fill='%23002D62'/><text x='50%25' y='54%25' dominant-baseline='middle' text-anchor='middle' font-family='Inter,sans-serif' font-weight='900' font-size='20' fill='%2300A86B'>A</text></svg>">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --blue-dark:  #002D62;
            --blue-mid:   #004C99;
            --green:      #00A86B;
            --red:        #E74C3C;
            --glass:      rgba(255,255,255,0.06);
            --glass-hover:rgba(255,255,255,0.10);
            --border:     rgba(255,255,255,0.08);
            --text:       #fff;
            --text-muted: rgba(255,255,255,0.6);
        }

        html, body { height: 100%; font-family: 'Inter', sans-serif; }

        body {
            background: linear-gradient(135deg, rgba(0,45,98,0.92), rgba(0,76,153,0.80)),
                        url('{{ asset("imagenes/background.jpg") }}') center/cover no-repeat fixed;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        /* ── INPUTS ── */
        input, select, textarea {
            color: #000 !important;
            background: #f1f5f9 !important;
            border: 1px solid #d1d5db !important;
            border-radius: .5rem;
            padding: .45rem .65rem;
        }
        .main label { color: #fff !important; font-weight: 600; }
        .modal-content label { color: #374151 !important; font-weight: 600; }

        /* ── MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center;
            z-index: 999;
        }
        .modal-content {
            background: #fff; color: #000;
            border-radius: 1rem; padding: 1.7rem;
            max-width: 480px; width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            animation: scaleIn .18s ease-out;
        }
        @keyframes scaleIn {
            from { transform: scale(0.85); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        /* ── LAYOUT ── */
        .app-wrapper { min-height: 100vh; display: flex; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 15rem;
            background: linear-gradient(180deg, rgba(0,10,40,0.90), rgba(0,20,60,0.82));
            backdrop-filter: blur(12px);
            border-right: 1px solid var(--border);
            box-shadow: 4px 0 20px rgba(0,0,0,0.4);
            position: fixed; left: 0; top: 0; bottom: 0;
            z-index: 40;
            transition: transform .28s ease;
            display: flex; flex-direction: column;
        }

        .sidebar-brand {
            padding: 1.2rem 1rem 1rem;
            border-bottom: 1px solid var(--border);
            display: flex; flex-direction: row; align-items: center;
        }

        .sidebar-nav { padding: .75rem .6rem; flex: 1; overflow-y: auto; }

        .nav-label {
            font-size: .65rem; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--text-muted);
            padding: .8rem .75rem .3rem;
        }

        .sidebar-nav a {
            display: flex; align-items: center; gap: .7rem;
            padding: .6rem .85rem; border-radius: .6rem;
            color: rgba(255,255,255,0.80); text-decoration: none;
            font-weight: 600; font-size: .875rem;
            margin: .15rem 0;
            transition: background .2s, color .2s;
        }
        .sidebar-nav a .nav-icon { width: 18px; height: 18px; flex-shrink: 0; }
        .sidebar-nav a:hover { background: var(--glass-hover); color: #fff; }
        .sidebar-nav a.active {
            background: rgba(0,168,107,0.18);
            color: #5dffc0;
            border-left: 3px solid var(--green);
            padding-left: calc(.85rem - 3px);
        }

        .sidebar-footer {
            padding: .75rem .6rem 1rem;
            border-top: 1px solid var(--border);
        }
        .sidebar-footer button {
            width: 100%; display: flex; align-items: center; gap: .7rem;
            padding: .6rem .85rem; border-radius: .6rem;
            background: rgba(231,76,60,0.12); border: none; cursor: pointer;
            color: #ff8a80; font-weight: 600; font-size: .875rem;
            transition: background .2s;
        }
        .sidebar-footer button:hover { background: rgba(231,76,60,0.25); }

        /* ── MAIN ── */
        .main {
            flex: 1;
            margin-left: 15rem;
            transition: margin-left .28s ease;
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        body.sidebar-collapsed .sidebar { transform: translateX(-100%); }
        body.sidebar-collapsed .main { margin-left: 0; }

        /* ── TOPBAR ── */
        .topbar {
            position: sticky; top: 0; z-index: 30;
            background: rgba(0,20,60,0.75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: .75rem 1.75rem;
            display: flex; align-items: center; justify-content: space-between; gap: 1rem;
        }

        .topbar-left { display: flex; align-items: center; gap: 1rem; }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }

        .toggle-btn {
            background: var(--glass); border: 1px solid var(--border);
            color: #fff; padding: 7px 9px; border-radius: 8px;
            cursor: pointer; display: flex; align-items: center;
            transition: background .2s;
        }
        .toggle-btn:hover { background: var(--glass-hover); }

        /* ── NOTIF CAMPANA ESTILO NETFLIX ── */
        .notif-wrapper { position: relative; }
        .notif-trigger {
            background: var(--glass); border: 1px solid var(--border);
            color: #fff; width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; position: relative; transition: background .2s;
        }
        .notif-trigger:hover { background: var(--glass-hover); }
        .notif-count {
            position: absolute; top: -4px; right: -4px;
            background: var(--red); color: #fff;
            font-size: 10px; font-weight: 800;
            width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid rgba(0,20,60,0.9);
        }

        /* Panel estilo Netflix */
        .notif-panel {
            position: absolute; top: calc(100% + 12px); right: 0;
            width: 360px;
            background: rgba(15, 20, 45, 0.92);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 14px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.7);
            display: none; z-index: 1000;
            overflow: hidden;
            animation: slideDown .2s ease-out;
        }
        .notif-panel.active { display: block; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .notif-panel-header {
            padding: 14px 16px 10px;
            font-weight: 800; font-size: .95rem; color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex; justify-content: space-between; align-items: center;
        }
        .notif-panel-header a {
            font-size: .75rem; color: var(--green); font-weight: 600;
            text-decoration: none;
        }

        .notif-list { max-height: 380px; overflow-y: auto; }
        .notif-list::-webkit-scrollbar { width: 4px; }
        .notif-list::-webkit-scrollbar-track { background: transparent; }
        .notif-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }

        .notif-row {
            display: flex; gap: 12px; align-items: flex-start;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            cursor: pointer;
            transition: background .2s;
        }
        .notif-row:hover { background: rgba(255,255,255,0.06); }
        .notif-row.unread { background: rgba(0,168,107,0.07); }
        .notif-row.unread:hover { background: rgba(0,168,107,0.12); }

        .notif-row-icon {
            width: 42px; height: 42px; border-radius: 10px;
            background: rgba(255,255,255,0.08);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 1.1rem;
        }
        .notif-row-body { flex: 1; min-width: 0; }
        .notif-row-title { font-size: .83rem; font-weight: 700; color: #fff; margin-bottom: 2px; }
        .notif-row-msg { font-size: .77rem; color: rgba(255,255,255,0.6); line-height: 1.4; }
        .notif-row-time { font-size: .7rem; color: rgba(255,255,255,0.35); margin-top: 4px; }
        .notif-unread-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: var(--green); flex-shrink: 0; margin-top: 6px;
        }

        .notif-empty {
            padding: 30px; text-align: center;
            color: rgba(255,255,255,0.4); font-size: .85rem;
        }

        /* ── PAGE CONTENT ── */
        .page-content { padding: 2rem 1.75rem; flex: 1; }

        /* ── CARDS ── */
        .card {
            background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.02));
            border: 1px solid var(--border);
            backdrop-filter: blur(6px);
            padding: 1.25rem;
            border-radius: .9rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            color: #fff;
        }
        .card h3 { font-size: .9rem; font-weight: 700; color: rgba(255,255,255,0.7); }
        .card .big { font-size: 2.5rem; font-weight: 800; margin-top: .5rem; }

        /* ── ALERTS ── */
        .alert-success {
            background: rgba(0,168,107,0.15); border: 1px solid rgba(0,168,107,0.3);
            color: #5dffc0; padding: .85rem 1.2rem; border-radius: .6rem;
            margin-bottom: 1rem; display: flex; align-items: center; gap: .6rem;
            font-size: .875rem; font-weight: 600;
        }
        .alert-error {
            background: rgba(231,76,60,0.15); border: 1px solid rgba(231,76,60,0.3);
            color: #ff8a80; padding: .85rem 1.2rem; border-radius: .6rem;
            margin-bottom: 1rem; font-size: .875rem; font-weight: 600;
        }

        [x-cloak] { display: none !important; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            body:not(.sidebar-collapsed) .sidebar { transform: translateX(0); }
            .main { margin-left: 0; }
            .page-content { padding: 1rem; }
        }
    </style>
</head>

<body class="{{ session('sidebar_collapsed') ? 'sidebar-collapsed' : '' }}">
@php
    $adminUser = App\Models\User::find(auth()->id());
    $fotoAdmin = $adminUser && !empty($adminUser->foto)
        ? asset('storage/' . $adminUser->foto)
        : 'https://ui-avatars.com/api/?name=' . urlencode($adminUser->nombre ?? 'Admin') . '&background=002D62&color=fff&size=64';
@endphp

<div id="app" class="app-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div style="display:flex; align-items:center; gap:.55rem;">
                <div style="width:36px; height:36px; border-radius:8px;
                            background:linear-gradient(135deg,#002D62,#1e3a8a);
                            display:flex; align-items:center; justify-content:center;
                            flex-shrink:0; box-shadow:0 2px 8px rgba(0,0,0,.3);">
                    <span style="font-family:Inter,sans-serif; font-weight:900; font-size:1.15rem;
                                 color:#00A86B; line-height:1;">A</span>
                </div>
                <div style="line-height:1.2;">
                    <div style="font-size:.95rem; font-weight:900; color:#fff; letter-spacing:.01em;">
                        Added<span style="color:#00A86B;">UT</span>
                    </div>
                    <div style="font-size:.62rem; color:var(--text-muted); font-weight:600; letter-spacing:.08em; text-transform:uppercase;">
                        Panel Admin
                    </div>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-label">General</div>

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i data-feather="grid" class="nav-icon"></i> Dashboard
            </a>

            <a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                <i data-feather="users" class="nav-icon"></i> Usuarios
            </a>

            <a href="{{ route('eventos.index') }}" class="{{ request()->routeIs('eventos.*') ? 'active' : '' }}">
                <i data-feather="layers" class="nav-icon"></i> Talleres
            </a>

            <a href="{{ route('inscripciones.index') }}" class="{{ request()->routeIs('inscripciones.*') ? 'active' : '' }}">
                <i data-feather="clipboard" class="nav-icon"></i> Inscripciones
            </a>

            <div class="nav-label">Comunicación</div>

            <a href="{{ route('notificaciones.index') }}" class="{{ request()->routeIs('notificaciones.*') ? 'active' : '' }}">
                <i data-feather="bell" class="nav-icon"></i> Notificaciones
                @if($adminUser && $adminUser->unreadNotifications->count() > 0)
                    <span style="margin-left:auto; background:var(--red); color:#fff; font-size:.65rem; font-weight:800; padding:2px 7px; border-radius:20px;">
                        {{ $adminUser->unreadNotifications->count() }}
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.noticias.index') }}" class="{{ request()->routeIs('admin.noticias.*') ? 'active' : '' }}">
                <i data-feather="rss" class="nav-icon"></i> Foro de Noticias
            </a>

            <div class="nav-label">Análisis</div>

            <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <i data-feather="bar-chart-2" class="nav-icon"></i> Reportes
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i data-feather="log-out" style="width:16px;height:16px;"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">
            <div class="topbar-left">
                <button class="toggle-btn" id="btnToggle">
                    <i data-feather="menu" style="width:18px;height:18px;"></i>
                </button>
            </div>

            <div class="topbar-right">

                <!-- CAMPANA ESTILO NETFLIX -->
                <div class="notif-wrapper">
                    <button class="notif-trigger" id="adminNotifBtn">
                        <i data-feather="bell" style="width:18px;height:18px;"></i>
                        @if($adminUser && $adminUser->unreadNotifications->count() > 0)
                            <span class="notif-count">{{ $adminUser->unreadNotifications->count() }}</span>
                        @endif
                    </button>

                    <div class="notif-panel" id="adminNotifPanel">
                        <div class="notif-panel-header">
                            <span>🔔 Notificaciones</span>
                            <a href="{{ route('notificaciones.index') }}">Ver todas</a>
                        </div>
                        <div class="notif-list">
                            @if($adminUser)
                                @forelse($adminUser->unreadNotifications->take(8) as $notif)
                                    @php
                                        $tipo  = $notif->data['tipo'] ?? 'info';
                                        $icono = match($tipo) {
                                            'inscripcion' => '✅',
                                            'baja'        => '❌',
                                            'like'        => '❤️',
                                            'cambio'      => '🕐',
                                            'noticia'     => '📰',
                                            default       => '🔔',
                                        };
                                    @endphp
                                    <div class="notif-row unread">
                                        <div class="notif-row-icon">{{ $icono }}</div>
                                        <div class="notif-row-body">
                                            <div class="notif-row-title">{{ $notif->data['titulo'] ?? '' }}</div>
                                            <div class="notif-row-msg">{{ $notif->data['mensaje'] ?? '' }}</div>
                                            <div class="notif-row-time">{{ $notif->created_at->diffForHumans() }}</div>
                                        </div>
                                        <div class="notif-unread-dot"></div>
                                    </div>
                                @empty
                                    <div class="notif-empty">
                                        <div style="font-size:1.5rem; margin-bottom:6px;">🔕</div>
                                        Sin notificaciones nuevas
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- CONTENT -->
        <div class="page-content">

            @if(session('success'))
                <div class="alert-success">
                    <i data-feather="check-circle" style="width:16px;height:16px;"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <strong>Error:</strong>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();

        // Toggle sidebar
        const btn  = document.getElementById('btnToggle');
        const body = document.body;

        if (window.innerWidth < 768) body.classList.add('sidebar-collapsed');

        btn.addEventListener('click', () => body.classList.toggle('sidebar-collapsed'));

        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) body.classList.add('sidebar-collapsed');
            else body.classList.remove('sidebar-collapsed');
        });

        // Campana notificaciones
        const notifBtn   = document.getElementById('adminNotifBtn');
        const notifPanel = document.getElementById('adminNotifPanel');
        let leidas = false;

        if (notifBtn && notifPanel) {
            notifBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                notifPanel.classList.toggle('active');
                feather.replace();

                if (notifPanel.classList.contains('active') && !leidas) {
                    leidas = true;
                    fetch('{{ route("notificaciones.markAllRead") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    }).then(function () {
                        const badge = document.querySelector('.notif-count');
                        if (badge) badge.remove();
                        document.querySelectorAll('.notif-unread-dot').forEach(d => d.remove());
                        document.querySelectorAll('.notif-row.unread').forEach(r => r.classList.remove('unread'));
                    });
                }
            });

            document.addEventListener('click', function (e) {
                if (!notifPanel.contains(e.target) && e.target !== notifBtn) {
                    notifPanel.classList.remove('active');
                }
            });
        }
    });
    
    window.addEventListener('pageshow', function (e) {
        if (e.persisted || (window.performance && window.performance.getEntriesByType('navigation')[0]?.type === 'back_forward')) {
                window.location.reload();
            }
    });
</script>
</body>
</html>
