<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AddedUT - @yield('title', 'Agenda')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        :root {
            --color-uttec-blue-dark: #002D62;
            --color-uttec-green: #00A86B;
            --color-uttec-white: #FFFFFF;
            --color-text-dark: #2c2c2c;
            --color-text-light: #555555;
            --color-accent-blue: #004C99;
            --color-accent-red: #E74C3C;
            --color-glass-light: rgba(255, 255, 255, 0.9);
            --shadow-card: 0 15px 45px rgba(0, 45, 98, 0.15), 0 0 10px rgba(0, 0, 0, 0.05) inset;
            --color-footer-bg: #F4F6F9;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--color-footer-bg); color: var(--color-text-dark); min-height: 100vh; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }
        .feather { width: 20px; height: 20px; stroke-width: 2.5; }
        main { padding-top: 100px; padding-bottom: 5rem; max-width: 1300px; margin: auto; padding-left: 3rem; padding-right: 3rem; min-height: calc(100vh - 80px); }

        header { position: fixed; top:0; left:0; width:100%; background: var(--color-glass-light); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0, 45, 98, 0.1); padding: 0.8rem 3rem; display: flex; justify-content: space-between; align-items: center; z-index: 100; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        header .logo { font-size: 2rem; font-weight: 800; letter-spacing: -1px; color: var(--color-uttec-blue-dark); display: flex; align-items: center; gap: 10px; }
        .logo span { color: var(--color-uttec-green); }
        nav { display: flex; align-items: center; gap: 2rem; }
        nav a, nav button { color: var(--color-uttec-blue-dark); font-weight: 600; padding: 0.5rem 0; position: relative; transition: color 0.3s ease; background: none; border: none; cursor: pointer; font-size: 1rem; display: flex; align-items: center; gap: 6px; }
        nav a::after, nav button::after { content: ''; position: absolute; width: 0; height: 3px; bottom: -5px; left: 50%; transform: translateX(-50%); background: var(--color-uttec-green); transition: width 0.3s ease, background 0.3s ease; }
        nav a:hover, nav button:hover { color: var(--color-uttec-green); }
        nav a:hover::after, nav button:hover::after { width: 100%; }
        .logout-btn { color: var(--color-text-dark) !important; margin-left: 1rem; }
        .logout-btn:hover { color: var(--color-accent-red) !important; }

        .notif-wrapper { position: relative; display: flex; align-items: center; }
        .notif-badge { position: absolute; top: -2px; right: -2px; background: var(--color-accent-red); color: white; font-size: 10px; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; }
        .notif-dropdown { position: absolute; top: 45px; right: 0; width: 320px; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); border: 1px solid #eee; display: none; z-index: 1000; overflow: hidden; }
        .notif-dropdown.active { display: block; animation: slideIn 0.2s ease-out; }
        .notif-header { padding: 12px 15px; background: #f8f9fa; border-bottom: 1px solid #eee; font-weight: 700; color: var(--color-uttec-blue-dark); font-size: 0.9rem; }
        .notif-list { max-height: 350px; overflow-y: auto; }
        .notif-item { padding: 12px 15px; border-bottom: 1px solid #f1f1f1; transition: background 0.2s; cursor: pointer; display: flex; gap: 12px; align-items: flex-start; color: inherit; text-decoration: none; position: relative; overflow: hidden; }
        .notif-item:hover { background: #f0f7f4; }
        .notif-item.unread { border-left: 4px solid var(--color-uttec-green); background: #f9fdfb; }
        .notif-icon { margin-top: 3px; }
        .notif-text b { display: block; font-size: 0.85rem; color: #333; margin-bottom: 2px; }
        .notif-text p { font-size: 0.8rem; color: #666; line-height: 1.3; margin: 0; }
        .notif-time { font-size: 0.7rem; color: #aaa; margin-top: 5px; display: block; }
        .notif-footer { padding: 10px; text-align: center; border-top: 1px solid #eee; }
        .notif-footer a { font-size: 0.8rem; color: var(--color-uttec-green); font-weight: 700; }

       
        .ripple-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 9999;
            overflow: hidden;
        }
        .ripple-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(0, 168, 107, 0.6) 0%, rgba(0, 45, 98, 0.85) 60%, rgba(0, 45, 98, 1) 100%);
            transform: scale(0);
            animation: rippleExpand 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            pointer-events: none;
        }
        @keyframes rippleExpand {
            0%   { transform: scale(0); opacity: 1; }
            100% { transform: scale(25); opacity: 1; }
        }
     

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        footer { background: var(--color-uttec-white); color: var(--color-text-light); padding: 3rem 0 1rem 0; border-top: 5px solid var(--color-uttec-blue-dark); box-shadow: 0 -5px 15px rgba(0, 45, 98, 0.05); }
        .footer-content { max-width: 1300px; margin: 0 auto; padding: 0 3rem; display: flex; justify-content: space-between; gap: 4rem; flex-wrap: wrap; }
        .footer-col { flex: 1; min-width: 250px; }
        .footer-col h4 { font-size: 1.2rem; color: var(--color-uttec-blue-dark); margin-bottom: 1.5rem; font-weight: 700; border-bottom: 2px solid var(--color-uttec-green); padding-bottom: 0.5rem; }
        .footer-col a { display: block; margin-bottom: 0.8rem; color: var(--color-text-light); transition: color 0.3s ease; font-weight: 500; }
        .footer-col a:hover { color: var(--color-uttec-green); text-decoration: underline; }
        .footer-bottom { text-align: center; padding: 1rem 0 0 0; margin-top: 2rem; border-top: 1px solid rgba(0, 45, 98, 0.1); font-size: 0.9rem; color: #888; }
        #scrollTopButton { display: none; position: fixed; bottom: 30px; right: 30px; z-index: 99; border: none; background: var(--color-uttec-green); color: white; cursor: pointer; padding: 15px; border-radius: 50%; opacity: 0.9; box-shadow: 0 5px 15px rgba(0, 168, 107, 0.6); }
        #scrollTopButton:hover { opacity: 1; transform: translateY(-2px); background: var(--color-uttec-blue-dark); }
    </style>
</head>
<body>

<div class="ripple-overlay" id="rippleOverlay"></div>

@php
    $authUser = App\Models\Usuario::find(auth()->id());
@endphp

    <header>
        <a href="{{ route('estudiante.eventos.index') }}" class="logo">
            <i data-feather="book-open" style="color:var(--color-uttec-green);"></i>
            Added<span>UT</span>
        </a>
        <nav>
            <a href="{{ route('estudiante.eventos.index') }}">
                <i data-feather="calendar" class="feather"></i> Eventos
            </a>
            <a href="{{ route('estudiante.noticias.foro') }}">
                <i data-feather="rss" class="feather"></i> Noticias
            </a>

            <div style="display:flex; align-items:center; gap: 20px; border-left: 1px solid #ddd; padding-left: 20px;">

                <div class="notif-wrapper">
                    <button id="layoutNotifBtn" style="background:none; border:none; cursor:pointer; position:relative; display:flex; align-items:center; padding: 4px;">
                        <i data-feather="bell" style="color: var(--color-uttec-blue-dark); width:22px; height:22px; stroke-width:2.5;"></i>
                        @if($authUser->unreadNotifications->count() > 0)
                            <span class="notif-badge" id="layoutNotifBadge">{{ $authUser->unreadNotifications->count() }}</span>
                        @endif
                    </button>

                    <div class="notif-dropdown" id="layoutNotifDropdown">
                        <div class="notif-header">🔔 Notificaciones</div>
                        <div class="notif-list">
                            @forelse($authUser->unreadNotifications as $notification)
                                @php
                                    $tipo  = $notification->data['tipo'] ?? 'info';
                                    $url   = $notification->data['url'] ?? '#';
                                    $icono = match($tipo) {
                                        'cambio'            => 'clock',
                                        'cupos_disponibles' => 'user-plus',
                                        'sin_cupos'         => 'user-x',
                                        'noticia'           => 'rss',
                                        default             => 'info',
                                    };
                                    $color = match($tipo) {
                                        'cambio'            => '#f39c12',
                                        'cupos_disponibles' => '#00A86B',
                                        'sin_cupos'         => '#e74c3c',
                                        'noticia'           => '#004C99',
                                        default             => '#888',
                                    };
                                @endphp
                                <div class="notif-item unread notif-link" data-url="{{ $url }}">
                                    <div class="notif-icon">
                                        <i data-feather="{{ $icono }}" style="color: {{ $color }}; width:16px; height:16px;"></i>
                                    </div>
                                    <div class="notif-text">
                                        <b>{{ $notification->data['titulo'] }}</b>
                                        <p>{{ $notification->data['mensaje'] }}</p>
                                        <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 20px; text-align:center; color:#aaa; font-size:0.85rem;">
                                    <i data-feather="bell-off" style="display:block; margin: 0 auto 8px; width:24px; height:24px;"></i>
                                    No tienes notificaciones nuevas
                                </div>
                            @endforelse
                        </div>
                        <div class="notif-footer">
                            <a href="{{ route('estudiante.noticias.foro') }}">Ver todo el historial</a>
                        </div>
                    </div>
                </div>

                <a href="{{ $authUser->rol === 'profesor' ? route('profesor.profile.edit') : route('estudiante.profile.edit') }}"
                    style="display:flex; align-items:center; gap:8px; font-weight:600; color: var(--color-uttec-blue-dark); font-size: 0.95rem;">
                    @php
                        $fotoUrl = !empty($authUser->foto)
                            ? asset('storage/' . $authUser->foto)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($authUser->nombre) . '&background=002D62&color=fff&size=64';
                    @endphp
                    <img src="{{ $fotoUrl }}" alt="Foto"
                         style="width:30px; height:30px; border-radius:50%; object-fit:cover; border:2px solid var(--color-uttec-blue-dark);">
                    {{ $authUser->nombre }}
                </a>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="logout-btn">
                    <i data-feather="log-out" class="feather"></i> Salir
                </button>
            </form>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h4>Added<span>UT</span></h4>
                <p>Plataforma para la gestión de actividades extracurriculares en la Universidad Tecnológica de Tlaxcala (UTTEC).</p>
            </div>
            <div class="footer-col">
                <h4>Enlaces Rápidos</h4>
                <a href="{{ route('estudiante.eventos.index') }}">Eventos y Actividades</a>
                <a href="{{ route('estudiante.noticias.foro') }}">Foro de Noticias</a>
                <a href="{{ route('estudiante.profile.edit') }}">Mi Perfil</a>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <address>Carretera Federal México-Pachuca km 37.5, Tecámac Edo. Méx.</address>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Universidad Tecnológica de Tecámac (UTTEC). Todos los derechos reservados.
        </div>
    </footer>

    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="scrollTopButton">
        <i data-feather="arrow-up"></i>
    </button>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();

            window.onscroll = function () {
                document.getElementById("scrollTopButton").style.display =
                    (document.documentElement.scrollTop > 100) ? "block" : "none";
            };

            const btn      = document.getElementById('layoutNotifBtn');
            const dropdown = document.getElementById('layoutNotifDropdown');
            const overlay  = document.getElementById('rippleOverlay');
            let leidas = false;

            if (btn && dropdown) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');
                    feather.replace();

                    if (dropdown.classList.contains('active') && !leidas) {
                        leidas = true;
                        fetch('{{ route("notificaciones.markAllRead") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Content-Type': 'application/json'
                            }
                        }).then(function () {
                            const badge = document.getElementById('layoutNotifBadge');
                            if (badge) badge.remove();
                            document.querySelectorAll('.notif-item.unread').forEach(function (item) {
                                item.classList.remove('unread');
                            });
                        });
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!dropdown.contains(e.target) && e.target !== btn) {
                        dropdown.classList.remove('active');
                    }
                });
            }

            document.querySelectorAll('.notif-link').forEach(function (item) {
                item.addEventListener('click', function (e) {
                    const url = this.getAttribute('data-url');
                    if (!url || url === '#') return;

                    const rect   = this.getBoundingClientRect();
                    const clickX = rect.left + rect.width / 2;
                    const clickY = rect.top + rect.height / 2;
                    const size   = 80;

                    const circle = document.createElement('div');
                    circle.classList.add('ripple-circle');
                    circle.style.width  = size + 'px';
                    circle.style.height = size + 'px';
                    circle.style.left   = (clickX - size / 2) + 'px';
                    circle.style.top    = (clickY - size / 2) + 'px';

                    overlay.appendChild(circle);

                    setTimeout(function () {
                        window.location.href = url;
                    }, 550);
                });
            });
        });
    </script>
</body>
</html>