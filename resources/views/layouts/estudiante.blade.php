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

    <header>
        <a href="{{ route('estudiante.eventos.index') }}" class="logo">
            <i data-feather="book-open" style="color:var(--color-uttec-green);"></i>
            Added<span>UT</span>
        </a>
        <nav>
            <a href="{{ route('estudiante.eventos.index') }}"><i data-feather="calendar" class="feather"></i> Eventos</a>
            <a href="{{ route('estudiante.noticias.foro') }}"><i data-feather="rss" class="feather"></i> Noticias</a>
            <div class="flex items-center gap-4 pl-6 border-l border-gray-200">
                <a href="{{ auth()->user()->rol === 'profesor' ? route('profesor.profile.edit') : route('estudiante.profile.edit') }}" 
                    class="flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-uttec-green transition {{ request()->routeIs('*.profile.*') ? 'text-uttec-green' : '' }}">
                            
                        <i data-feather="user" class="w-4 h-4"></i>
                        {{ auth()->user()->nombre }}
                            
                        </a>
                    </div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="logout-btn"><i data-feather="log-out" class="feather"></i> Salir</button>
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

    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="scrollTopButton"><i data-feather="arrow-up"></i></button>

    <script>
        feather.replace();
        window.onscroll = function() {
            document.getElementById("scrollTopButton").style.display = (document.documentElement.scrollTop > 100) ? "block" : "none";
        };
    </script>
</body>
</html>
