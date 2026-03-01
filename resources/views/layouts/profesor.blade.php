<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - AddedUT</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { uttec: { green: '#00a86b', dark: '#1a1a1a' } },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .btn-uttec-green { background-color: #00a86b; color: white; transition: all .3s ease; }
        .btn-uttec-green:hover { background-color: #008f5b; transform: translateY(-2px); box-shadow: 0 4px 6px -1px rgba(0,168,107,.4); }
        .nav-link { display: flex; align-items: center; gap: 6px; font-size: .875rem; font-weight: 600; color: #4b5563; text-decoration: none; padding: .5rem .25rem; border-bottom: 2px solid transparent; transition: color .2s, border-color .2s; }
        .nav-link:hover { color: #00a86b; }
        .nav-link.active { color: #00a86b; border-bottom-color: #00a86b; }

        .notif-wrapper { position: relative; display: flex; align-items: center; }
        .notif-badge { position: absolute; top: -2px; right: -2px; background: #E74C3C; color: white; font-size: 10px; width: 16px; height: 16px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white; }
        .notif-dropdown { position: absolute; top: 45px; right: 0; width: 320px; background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); border: 1px solid #eee; display: none; z-index: 1000; overflow: hidden; }
        .notif-dropdown.active { display: block; animation: slideIn 0.2s ease-out; }
        .notif-header { padding: 12px 15px; background: #f8f9fa; border-bottom: 1px solid #eee; font-weight: 700; color: #002D62; font-size: 0.9rem; }
        .notif-list { max-height: 350px; overflow-y: auto; }
        .notif-item { padding: 12px 15px; border-bottom: 1px solid #f1f1f1; transition: background 0.2s; cursor: pointer; display: flex; gap: 12px; align-items: flex-start; color: inherit; text-decoration: none; }
        .notif-item:hover { background: #f0f7f4; }
        .notif-item.unread { border-left: 4px solid #00A86B; background: #f9fdfb; }
        .notif-icon { margin-top: 3px; }
        .notif-text b { display: block; font-size: 0.85rem; color: #333; margin-bottom: 2px; }
        .notif-text p { font-size: 0.8rem; color: #666; line-height: 1.3; margin: 0; }
        .notif-time { font-size: 0.7rem; color: #aaa; margin-top: 5px; display: block; }
        .notif-footer { padding: 10px; text-align: center; border-top: 1px solid #eee; }
        .notif-footer a { font-size: 0.8rem; color: #00A86B; font-weight: 700; }

        .ripple-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 9999; overflow: hidden; }
        .ripple-circle { position: absolute; border-radius: 50%; background: radial-gradient(circle, rgba(0, 168, 107, 0.6) 0%, rgba(0, 45, 98, 0.85) 60%, rgba(0, 45, 98, 1) 100%); transform: scale(0); animation: rippleExpand 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards; pointer-events: none; }
        @keyframes rippleExpand { 0% { transform: scale(0); opacity: 1; } 100% { transform: scale(25); opacity: 1; } }
        @keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

<div class="ripple-overlay" id="profRippleOverlay"></div>

@php
    $profUser = App\Models\User::find(auth()->id());
@endphp

    <nav class="bg-white shadow-sm fixed w-full z-40 top-0 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">

                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('profesor.dashboard') }}" class="flex items-center gap-2 text-2xl font-bold text-gray-900 tracking-tight">
                        <i data-feather="book-open" class="text-uttec-green w-7 h-7"></i>
                        <span>Added<span class="text-uttec-green">UT</span></span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">

                    <a href="{{ route('profesor.dashboard') }}"
                       class="nav-link {{ request()->routeIs('profesor.dashboard') ? 'active' : '' }}">
                        <i data-feather="rss" class="w-4 h-4"></i> Noticias
                    </a>

                    <a href="{{ route('profesor.taller') }}"
                       class="nav-link {{ request()->routeIs('profesor.taller') ? 'active' : '' }}">
                        <i data-feather="layers" class="w-4 h-4"></i> Mi Taller
                    </a>

                    <div class="flex items-center gap-4 pl-6 border-l border-gray-200">

                        <div class="notif-wrapper">
                            <button id="profNotifBtn" style="background:none; border:none; cursor:pointer; position:relative; display:flex; align-items:center; padding:4px;">
                                <i data-feather="bell" style="color:#002D62; width:22px; height:22px; stroke-width:2.5;"></i>
                                @if($profUser && $profUser->unreadNotifications->count() > 0)
                                    <span class="notif-badge" id="profNotifBadge">{{ $profUser->unreadNotifications->count() }}</span>
                                @endif
                            </button>

                            <div class="notif-dropdown" id="profNotifDropdown">
                                <div class="notif-header">🔔 Notificaciones</div>
                                <div class="notif-list">
                                    @if($profUser)
                                        @forelse($profUser->unreadNotifications as $notification)
                                            @php
                                                $tipo  = $notification->data['tipo'] ?? 'info';
                                                $url   = $notification->data['url'] ?? '#';
                                                $icono = match($tipo) {
                                                    'inscripcion'       => 'user-check',
                                                    'baja'              => 'user-minus',
                                                    'like'              => 'heart',
                                                    'cambio'            => 'clock',
                                                    'cupos_disponibles' => 'user-plus',
                                                    'sin_cupos'         => 'user-x',
                                                    'noticia'           => 'rss',
                                                    default             => 'info',
                                                };
                                                $color = match($tipo) {
                                                    'inscripcion'       => '#00A86B',
                                                    'baja'              => '#e74c3c',
                                                    'like'              => '#e74c3c',
                                                    'cambio'            => '#f39c12',
                                                    'cupos_disponibles' => '#00A86B',
                                                    'sin_cupos'         => '#e74c3c',
                                                    'noticia'           => '#004C99',
                                                    default             => '#888',
                                                };
                                            @endphp
                                            <div class="notif-item unread notif-link-prof" data-url="{{ $url }}">
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
                                    @endif
                                </div>
                                <div class="notif-footer">
                                    <a href="{{ route('profesor.taller') }}">Ver mi taller</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('profesor.profile.edit') }}"
                           class="nav-link {{ request()->routeIs('*.profile.*') ? 'active' : '' }}">
                            @php
                                $fotoProf    = $profUser->foto ?? null;
                                $fotoUrlProf = $fotoProf
                                    ? asset('storage/' . $fotoProf)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($profUser->nombre) . '&background=1e3a8a&color=fff&size=64';
                            @endphp
                            <img src="{{ $fotoUrlProf }}" alt="Foto"
                                 style="width:28px; height:28px; border-radius:50%; object-fit:cover; border:2px solid #00a86b;">
                            {{ $profUser->nombre }}
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link" style="background:none; border:none; cursor:pointer;">
                            <i data-feather="log-out" class="w-4 h-4"></i> Salir
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-28 pb-12 px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl mx-auto w-full">

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded shadow-sm flex items-center gap-2">
                <i data-feather="check-circle" class="w-5 h-5"></i> {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded shadow-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white py-6 text-center text-gray-500 text-sm border-t border-gray-200">
        <p>&copy; {{ date('Y') }} AddedUT - Universidad Tecnológica de Tecámac.</p>
    </footer>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();

            const btn      = document.getElementById('profNotifBtn');
            const dropdown = document.getElementById('profNotifDropdown');
            const overlay  = document.getElementById('profRippleOverlay');
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
                            const badge = document.getElementById('profNotifBadge');
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

            document.querySelectorAll('.notif-link-prof').forEach(function (item) {
                item.addEventListener('click', function () {
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