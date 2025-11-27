<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - AddedUT</title>
    
    {{-- Tailwind CSS CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    
    {{-- Fuentes e Íconos --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Configuración de colores para coincidir con las capturas --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        uttec: {
                            green: '#00a86b', // El verde exacto de los botones en tu imagen
                            dark: '#1a1a1a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Clase para el botón principal verde */
        .btn-uttec-green {
            background-color: #00a86b;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-uttec-green:hover {
            background-color: #008f5b;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 168, 107, 0.4);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

    {{-- CLAVE: z-40 para que el modal (z-70) lo cubra --}}
    <nav class="bg-white shadow-sm fixed w-full z-40 top-0 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                
                {{-- Logo Izquierda --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('profesor.dashboard') }}" class="flex items-center gap-2 text-2xl font-bold text-gray-900 tracking-tight">
                        <i data-feather="book-open" class="text-uttec-green w-7 h-7"></i>
                        <span>Added<span class="text-uttec-green">UT</span></span>
                    </a>
                </div>

                {{-- Menú Derecha --}}
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('profesor.dashboard') }}" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-uttec-green transition {{ request()->routeIs('profesor.dashboard') ? 'text-uttec-green' : '' }}">
                        <i data-feather="grid" class="w-4 h-4"></i> Inicio
                    </a>
                    <a href="{{ route('eventos.index') }}" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-uttec-green transition {{ request()->routeIs('eventos.*') ? 'text-uttec-green' : '' }}">
                        <i data-feather="calendar" class="w-4 h-4"></i> Mis Eventos
                    </a>
                    
                    {{-- Perfil y Salir --}}
                    <div class="flex items-center gap-4 pl-6 border-l border-gray-200">
                        <div class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <i data-feather="user" class="w-4 h-4"></i>
                            {{ auth()->user()->nombre }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-red-500 transition">
                                <i data-feather="log-out" class="w-4 h-4 rotate-180"></i> Salir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- ================= CONTENIDO PRINCIPAL ================= --}}
    <main class="flex-grow pt-28 pb-12 px-4 sm:px-6 lg:px-8 relative z-10 max-w-7xl mx-auto w-full">
        
        {{-- Alertas --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-uttec-green text-green-800 px-4 py-3 rounded shadow-sm flex items-center gap-2 animate-fade-in">
                <i data-feather="check-circle" class="w-5 h-5"></i> {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded shadow-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- ================= FOOTER SIMPLE ================= --}}
    <footer class="bg-white py-6 text-center text-gray-500 text-sm border-t border-gray-200">
        <p>&copy; {{ date('Y') }} AddedUT - Universidad Tecnológica de Tecámac.</p>
    </footer>

    <script> feather.replace(); </script>
</body>
</html>