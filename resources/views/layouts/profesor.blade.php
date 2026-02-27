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

        .nav-link {
            display: flex; align-items: center; gap: 6px;
            font-size: .875rem; font-weight: 600; color: #4b5563;
            text-decoration: none; padding: .5rem .25rem;
            border-bottom: 2px solid transparent;
            transition: color .2s, border-color .2s;
        }
        .nav-link:hover { color: #00a86b; }
        .nav-link.active { color: #00a86b; border-bottom-color: #00a86b; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 font-sans leading-normal tracking-normal min-h-screen flex flex-col">

    <nav class="bg-white shadow-sm fixed w-full z-40 top-0 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">

                {{-- Logo → lleva a noticias (inicio del profesor) --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('profesor.dashboard') }}" class="flex items-center gap-2 text-2xl font-bold text-gray-900 tracking-tight">
                        <i data-feather="book-open" class="text-uttec-green w-7 h-7"></i>
                        <span>Added<span class="text-uttec-green">UT</span></span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">

                    {{-- Noticias = inicio --}}
                    <a href="{{ route('profesor.dashboard') }}"
                       class="nav-link {{ request()->routeIs('profesor.dashboard') ? 'active' : '' }}">
                        <i data-feather="rss" class="w-4 h-4"></i> Noticias
                    </a>

                    {{-- Mi Taller = vista completa del taller --}}
                    <a href="{{ route('profesor.taller') }}"
                       class="nav-link {{ request()->routeIs('profesor.taller') ? 'active' : '' }}">
                        <i data-feather="layers" class="w-4 h-4"></i> Mi Taller
                    </a>

                    {{-- Perfil --}}
                    <div class="flex items-center gap-4 pl-6 border-l border-gray-200">
                        <a href="{{ route('profesor.profile.edit') }}"
                           class="nav-link {{ request()->routeIs('*.profile.*') ? 'active' : '' }}">
                            @php
                                $fotoProf = auth()->user()->foto ?? null;
                                $fotoUrlProf = $fotoProf
                                    ? asset('storage/' . $fotoProf)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->nombre) . '&background=1e3a8a&color=fff&size=64';
                            @endphp
                            <img src="{{ $fotoUrlProf }}" alt="Foto"
                                 style="width:28px; height:28px; border-radius:50%; object-fit:cover; border:2px solid #00a86b;">
                            {{ auth()->user()->nombre }}
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
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded shadow-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white py-6 text-center text-gray-500 text-sm border-t border-gray-200">
        <p>&copy; {{ date('Y') }} AddedUT - Universidad Tecnológica de Tecámac.</p>
    </footer>

    <script> feather.replace(); </script>
</body>
</html>