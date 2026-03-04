<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="Sat, 01 Jan 2000 00:00:00 GMT">
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

        /* NOTIF WRAPPER */
        .notif-wrapper { position: relative; display: flex; align-items: center; }
        .notif-badge { position: absolute; top: -4px; right: -4px; background: #E74C3C; color: white; font-size: 10px; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white; }

        /* PANEL ESTILO NETFLIX */
        .notif-panel { position: absolute; top: calc(100% + 14px); right: 0; width: 360px; background: rgba(15, 20, 45, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); display: none; z-index: 1000; overflow: hidden; }
        .notif-panel.active { display: block; }
        .notif-panel-header { padding: 14px 16px 10px; font-weight: 800; font-size: .95rem; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; }
        .notif-list { max-height: 380px; overflow-y: auto; }
        .notif-list::-webkit-scrollbar { width: 4px; }
        .notif-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }
        .notif-row { display: flex; gap: 12px; align-items: flex-start; padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.05); cursor: pointer; transition: background .2s; }
        .notif-row:hover { background: rgba(255,255,255,0.06); }
        .notif-row.unread { background: rgba(0,168,107,0.07); }
        .notif-row.unread:hover { background: rgba(0,168,107,0.12); }
        .notif-row-icon { width: 42px; height: 42px; border-radius: 10px; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1rem; }
        .notif-row-body { flex: 1; min-width: 0; }
        .notif-row-title { font-size: .83rem; font-weight: 700; color: #fff; margin-bottom: 2px; }
        .notif-row-msg { font-size: .77rem; color: rgba(255,255,255,0.6); line-height: 1.4; }
        .notif-row-time { font-size: .7rem; color: rgba(255,255,255,0.35); margin-top: 4px; }
        .notif-unread-dot { width: 8px; height: 8px; border-radius: 50%; background: #00A86B; flex-shrink: 0; margin-top: 6px; }
        .notif-empty { padding: 30px; text-align: center; color: rgba(255,255,255,0.4); font-size: .85rem; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

@php $profUser = App\Models\User::find(auth()->id()); @endphp

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

                        <!-- CAMPANA ESTILO NETFLIX -->
                        <div class="notif-wrapper">
                            <button id="profNotifBtn" style="background:none; border:none; cursor:pointer; position:relative; display:flex; align-items:center; padding:4px;">
                                <i data-feather="bell" style="color:#002D62; width:22px; height:22px; stroke-width:2.5;"></i>
                                @if($profUser && $profUser->unreadNotifications->count() > 0)
                                    <span class="notif-badge" id="profNotifBadge">{{ $profUser->unreadNotifications->count() }}</span>
                                @endif
                            </button>

                            <div class="notif-panel" id="profNotifPanel">
                                <div class="notif-panel-header">
                                    <span>🔔 Notificaciones</span>
                                </div>
                                <div class="notif-list">
                                    @if($profUser)
                                        @forelse($profUser->unreadNotifications as $notification)
                                            @php
                                                $tipo  = $notification->data['tipo'] ?? 'info';
                                                $url   = $notification->data['url'] ?? '#';
                                                $icono = match($tipo) {
                                                    'inscripcion' => '✅',
                                                    'baja'        => '❌',
                                                    'like'        => '❤️',
                                                    'cambio'      => '🕐',
                                                    'cupos_disponibles' => '🟢',
                                                    'sin_cupos'   => '🔴',
                                                    'noticia'     => '📰',
                                                    default       => '🔔',
                                                };
                                            @endphp
                                            <div class="notif-row unread notif-link-prof" data-url="{{ $url }}">
                                                <div class="notif-row-icon">{{ $icono }}</div>
                                                <div class="notif-row-body">
                                                    <div class="notif-row-title">{{ $notification->data['titulo'] }}</div>
                                                    <div class="notif-row-msg">{{ $notification->data['mensaje'] }}</div>
                                                    <div class="notif-row-time">{{ $notification->created_at->diffForHumans() }}</div>
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

                        <!-- PERFIL -->
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
            const dropdown = document.getElementById('profNotifPanel');
            let leidas = false;

            if (btn && dropdown) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('active');

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
                            document.querySelectorAll('.notif-unread-dot').forEach(d => d.remove());
                            document.querySelectorAll('.notif-row.unread').forEach(r => r.classList.remove('unread'));
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
                    window.location.href = url;
                });
            });
        });
        window.addEventListener('pageshow', function (e) {
            if (e.persisted || (window.performance && window.performance.getEntriesByType('navigation')[0]?.type === 'back_forward')) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
