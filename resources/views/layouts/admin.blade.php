<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'AddedUT - Admin') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --azul: #004aad;
            --celeste: #00bcd4;
            --amarillo: #ffdd57;
            --glass: rgba(255,255,255,0.08);
            --glass-strong: rgba(255,255,255,0.12);
        }

        html,body,#app { height: 100%; }

        /* Fondo */
        body {
            background: linear-gradient(135deg, rgba(0,74,173,0.90), rgba(0,188,212,0.70)),
                        url('{{ asset("imagenes/background.jpg") }}') center/cover no-repeat fixed;
            color: #fff;
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
        }

        input, select, textarea {
            color: #000 !important;
            background: #f1f5f9 !important; /* gris claro */
            border: 1px solid #d1d5db !important;
            border-radius: .5rem;
            padding: .45rem .65rem;
        }

        /* Labels blancos SOLO fuera del modal (en la página principal) */
        .main label {
            color: #fff !important;
            font-weight: 600;
        }
        /* Dentro del modal los labels son oscuros para leerse sobre fondo blanco */
        .modal-content label {
            color: #374151 !important;
            font-weight: 600;
        }

        /* Overlay del modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(3px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }

        /* Contenido del modal */
        .modal-content {
            background: #ffffff;
            color: #000;
            border-radius: 1rem;
            padding: 1.7rem;
            max-width: 480px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
            animation: scaleIn .18s ease-out;
        }

        @keyframes scaleIn {
            from { transform: scale(0.85); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }
        /* ----------------------------------------------------- */

        .app-wrapper { min-height:100vh; display:flex; }

        /* SIDEBAR */
        .sidebar {
            width: 16rem; 
            background: linear-gradient(180deg, rgba(3,10,39,0.85), rgba(0,20,52,0.75));
            backdrop-filter: blur(6px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.5);
            transform: translateX(0);
            transition: transform .28s ease, width .25s ease;
            z-index: 40;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
        }

        .sidebar .brand { padding:1.25rem; border-bottom: 1px solid rgba(255,255,255,0.05); text-align:center; }
        .sidebar .brand h1 { font-size:1.125rem; font-weight:700; color:#fff; }
        .sidebar nav { padding:0.75rem; margin-top:0.5rem; }

        .sidebar a {
            display:flex;
            align-items:center;
            gap:.75rem;
            padding:.6rem .9rem;
            border-radius:.6rem;
            color: rgba(255,255,255,0.92);
            text-decoration:none;
            font-weight:600;
            margin: .25rem 0;
        }
        .sidebar a .icon { font-size:1.05rem; opacity:0.95; }
        .sidebar a:hover { background: var(--glass-strong); color: #fff; }
        .sidebar a.active { background: rgba(255,255,255,0.09); box-shadow: inset 0 1px 0 rgba(255,255,255,0.03); }

        /* MAIN */
        .main {
            flex:1;
            margin-left: 16rem;
            transition: margin-left .28s ease;
            padding: 2.25rem;
            min-height: 100vh;
        }

        body.sidebar-collapsed .sidebar { transform: translateX(-100%); }
        body.sidebar-collapsed .main { margin-left: 0; }

        .topbar {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:1rem;
            margin-bottom:1.25rem;
        }

        /* Cards */
        .card {
            background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.02));
            border: 1px solid rgba(255,255,255,0.04);
            backdrop-filter: blur(6px);
            padding:1.25rem;
            border-radius: .9rem;
            box-shadow: 0 8px 30px rgba(2,6,23,0.45);
            color: #fff;
        }
        .card h3 { font-size:1rem; font-weight:700; color: #e6eefc; }
        .card .big { font-size:2.5rem; font-weight:800; margin-top:.6rem; }

        @media (max-width: 768px) {
            .sidebar { position: fixed; transform: translateX(-100%); }
            body:not(.sidebar-collapsed) .sidebar { transform: translateX(0); }
            .main { margin-left:0; padding:1rem; }
        }
    </style>
    <style>
    [x-cloak] { 
        display: none !important; 
    }
</style>
</head>

<body class="{{ (session('sidebar_collapsed') ? 'sidebar-collapsed' : '') }}">

<div id="app" class="app-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar" aria-label="Sidebar">
        <div class="brand">
            <img src="{{ asset('imagenes/logo.png') }}" alt="logo" style="max-width:140px; display:block; margin:0 auto 8px;">
            <div style="opacity:.9; font-size:.85rem;">AddedUT</div>
        </div>

        <nav>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="icon">📊</span> Dashboard
            </a>

            <a href="{{ route('usuarios.index') }}" class="{{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                <span class="icon">👥</span> Usuarios
            </a>

            <a href="{{ route('eventos.index') }}" class="{{ request()->routeIs('eventos.*') ? 'active' : '' }}">
                <span class="icon">🎉</span> Talleres
            </a>

            <a href="{{ route('inscripciones.index') }}" class="{{ request()->routeIs('inscripciones.*') ? 'active' : '' }}">
                <span class="icon">📝</span> Inscripciones
            </a>

            <a href="{{ route('notificaciones.index') }}" class="{{ request()->routeIs('notificaciones.*') ? 'active' : '' }}">
                <span class="icon">🔔</span> Notificaciones
            </a>

            <a href="{{ route('admin.noticias.index') }}" class="{{ request()->routeIs('noticias.*') ? 'active' : '' }}">
                <span class="icon">📰</span> Foro de Noticias
            </a>

            <a href="{{ route('reportes.index') }}" class="{{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <span class="icon">📑</span> Reportes
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin-top: .6rem; padding: .6rem;">
                @csrf
                <button type="submit" class="card" style="width:100%; text-align:left; display:flex; align-items:center; gap:.6rem; background:rgba(255,0,0,0.12);">
                    🚪 Cerrar sesión
                </button>
            </form>
        </nav>
    </aside>

    <!-- MAIN -->
    <main class="main" role="main">

        <div class="topbar">
            <div class="left">
                <button id="btnToggle" aria-label="Toggle menu"
                    style="background:rgba(255,255,255,0.06); border:none; color:#fff; padding:8px 10px; border-radius:8px; cursor:pointer;">
                    ☰
                </button>
            </div>

            <div class="right" style="display:flex; gap:1rem; align-items:center;">
                <div style="text-align:right;">
                    <div style="font-weight:700;">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div style="font-size:.8rem; opacity:.85;">Administrador</div>
                </div>
            </div>
        </div>

        <div class="container">
            @yield('content')
        </div>

    </main>
</div>

<script>
    (function(){
        const btn = document.getElementById('btnToggle');
        const body = document.body;

        if (window.innerWidth < 768) {
            body.classList.add('sidebar-collapsed');
        }

        btn.addEventListener('click', () => {
            body.classList.toggle('sidebar-collapsed');
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) {
                body.classList.add('sidebar-collapsed');
            } else {
                body.classList.remove('sidebar-collapsed');
            }
        });
    })();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@if(session('success'))
<div class="bg-green-500 text-white px-6 py-4 rounded-lg mb-4 shadow-lg">
    <div class="flex items-center">
        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        {{ session('success') }}
    </div>
</div>
@endif

@if($errors->any())
<div class="bg-red-500 text-white px-6 py-4 rounded-lg mb-4 shadow-lg">
    <div class="font-semibold mb-2">Error:</div>
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
</body>
</html>
