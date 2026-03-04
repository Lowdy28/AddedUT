<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="Sat, 01 Jan 2000 00:00:00 GMT">

    <title>{{ config('app.name', 'Panel Admin') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-900">

<div class="flex">

    <!-- Sidebar -->
    <aside class="w-64 min-h-screen bg-gray-900 text-white shadow-lg">
        <div class="p-4 text-center border-b border-gray-700">
            <h1 class="text-2xl font-bold">Actividades</h1>
            <p class="text-sm opacity-75">Panel Administrativo</p>
        </div>

        <nav class="mt-6">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('dashboard') ? 'bg-gray-800' : '' }}">
                        📊 Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('usuarios.index') }}" 
                       class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('usuarios*') ? 'bg-gray-800' : '' }}">
                        👤 Usuarios
                    </a>
                </li>

                <li>
                    <a href="{{ route('eventos.index') }}" 
                       class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('eventos*') ? 'bg-gray-800' : '' }}">
                        🎉 Eventos
                    </a>
                </li>

                <li>
                    <a href="{{ route('inscripciones.index') }}" 
                       class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('inscripciones*') ? 'bg-gray-800' : '' }}">
                        📝 Inscripciones
                    </a>
                </li>

                <li>
                    <a href="{{ route('notificaciones.index') }}" 
                       class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('notificaciones*') ? 'bg-gray-800' : '' }}">
                        🔔 Notificaciones
                    </a>
                </li>

                <li>
                    <a href="{{ route('reportes.index') }}" 
                       class="block px-6 py-3 hover:bg-gray-700 {{ request()->is('reportes*') ? 'bg-gray-800' : '' }}">
                        📑 Reportes
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-6 py-3 hover:bg-red-700 bg-red-600 mt-5">
                            🚪 Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>
    <script>
        window.addEventListener('pageshow', function (e) {
            if (e.persisted || (window.performance && window.performance.getEntriesByType('navigation')[0]?.type === 'back_forward')) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
