<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddedUT - Mis Talleres</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        /* --- Copié (y reduje) los estilos principales del layout de estudiante --- */
        :root {
            --color-uttec-blue-dark: #002D62;
            --color-uttec-green: #00A86B;
            --color-uttec-white: #FFFFFF;
            --color-text-dark: #2c2c2c;
            --color-text-light: #555555;
            --color-accent-blue: #004C99;
            --color-accent-red: #E74C3C;
            --color-glass-light: rgba(255,255,255,0.9);
            --shadow-card: 0 15px 45px rgba(0,45,98,0.15), 0 0 10px rgba(0,0,0,0.05) inset;
            --color-footer-bg: #F4F6F9;
        }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Inter',sans-serif;background:var(--color-footer-bg);color:var(--color-text-dark);min-height:100vh;line-height:1.6;scroll-behavior:smooth;}
        a{text-decoration:none;color:inherit}
        .feather{width:20px;height:20px;stroke-width:2.5}

        header{position:fixed;top:0;left:0;width:100%;background:var(--color-glass-light);backdrop-filter:blur(12px);-webkit-backdrop-filter:blur(12px);border-bottom:1px solid rgba(0,45,98,0.1);padding:0.8rem 3rem;display:flex;justify-content:space-between;align-items:center;z-index:100;box-shadow:0 2px 8px rgba(0,0,0,0.08);}
        .logo{font-size:2rem;font-weight:800;color:var(--color-uttec-blue-dark);display:flex;align-items:center;gap:10px}
        .logo span{color:var(--color-uttec-green)}
        nav{display:flex;align-items:center;gap:2rem}
        nav a, nav button{color:var(--color-uttec-blue-dark);font-weight:600;padding:0.5rem 0;background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:6px}
        nav a:hover{color:var(--color-uttec-green)}
        main{padding-top:100px;padding-bottom:5rem;max-width:1300px;margin:auto;padding-left:3rem;padding-right:3rem;min-height:calc(100vh - 80px)}
        .card{background:var(--color-uttec-white);border-radius:12px;padding:1.25rem;border:1px solid rgba(0,45,98,0.05);box-shadow:var(--shadow-card)}
        .card + .card{margin-top:1.25rem}
        .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:1.5rem}
        .badge{display:inline-block;padding:0.25rem 0.6rem;border-radius:999px;font-weight:700}
        footer{background:var(--color-uttec-white);color:var(--color-text-light);padding:3rem 0 1rem;border-top:5px solid var(--color-uttec-blue-dark);box-shadow:0 -5px 15px rgba(0,45,98,0.05)}
        .footer-content{max-width:1300px;margin:0 auto;padding:0 3rem;display:flex;justify-content:space-between;gap:4rem;flex-wrap:wrap}
        .footer-bottom{text-align:center;padding:1rem 0 0 0;margin-top:2rem;border-top:1px solid rgba(0,45,98,0.1);font-size:0.9rem;color:#888}
        #scrollTopButton{display:none;position:fixed;bottom:30px;right:30px;z-index:99;border:none;background:var(--color-uttec-green);color:white;padding:15px;border-radius:50%;box-shadow:0 5px 15px rgba(0,168,107,0.6)}
    </style>
</head>
<body>
    <header>
        <a href="{{ route(auth()->user()->rol === 'estudiante' ? 'estudiante.dashboard' : (auth()->user()->rol === 'profesor' ? 'profesor.dashboard' : 'dashboard')) }}" class="logo">
            <i data-feather="book-open" style="color:var(--color-uttec-green);"></i>
            Added<span style="color:var(--color-uttec-green);">UT</span>
        </a>

        <nav>
            @if(auth()->user()->rol === 'estudiante')
                <a href="{{ route('estudiante.dashboard') }}"><i data-feather="grid" class="feather"></i> Inicio</a>
                <a href="{{ route('estudiante.eventos.index') }}"><i data-feather="calendar" class="feather"></i> Eventos</a>
                <a href="{{ route('estudiante.profile.edit') }}"><i data-feather="user" class="feather"></i> Perfil</a>
            @elseif(auth()->user()->rol === 'profesor')
                <a href="{{ route('profesor.dashboard') }}"><i data-feather="grid" class="feather"></i> Inicio</a>
                <a href="{{ route('eventos.index') }}"><i data-feather="calendar" class="feather"></i> Mis Eventos</a>
                <a href="{{ route('profile.edit') }}"><i data-feather="user" class="feather"></i> Perfil</a>
            @else
                <a href="{{ route('dashboard') }}"><i data-feather="grid" class="feather"></i> Dashboard</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="logout-btn"><i data-feather="log-out" class="feather"></i> Salir</button>
            </form>
        </nav>
    </header>

    <main>
        <div class="events-header" style="margin-bottom:1.5rem">
            <h2 style="font-size:2rem;color:var(--color-uttec-blue-dark)">Mis Talleres</h2>
        </div>

        <div class="grid">
            @if($talleres->isEmpty())
                <div class="card">Aún no has creado talleres.</div>
            @else
                @foreach($talleres as $taller)
                    <div class="card">
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <div>
                                <h3 style="margin-bottom:6px">{{ $taller->nombre }}</h3>
                                <p style="margin-bottom:8px;color:#666">{{ $taller->descripcion ?? 'Sin descripción' }}</p>
                                <div style="font-size:0.9rem;color:#444">
                                    <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($taller->fecha_inicio)->isoFormat('DD MMMM YYYY') }} |
                                    <strong>Fin:</strong> {{ \Carbon\Carbon::parse($taller->fecha_fin)->isoFormat('DD MMMM YYYY') }}
                                </div>
                            </div>
                            <div style="text-align:right">
                                <div class="badge" style="background:rgba(0,168,107,0.1);color:var(--color-uttec-blue-dark)">Cupos: {{ $taller->cupos }}</div>
                                <div style="margin-top:8px;color:#777">Inscritos: {{ $taller->inscritos->count() }}</div>
                            </div>
                        </div>

                        <hr style="margin:12px 0">

                        <h4 style="margin-bottom:8px">Alumnos inscritos</h4>
                        @if($taller->inscritos->isEmpty())
                            <p style="color:#777">Aún no hay alumnos inscritos.</p>
                        @else
                            <ul style="list-style:none;padding-left:0;margin:0">
                                @foreach($taller->inscritos as $ins)
                                    <li style="padding:8px 0;border-bottom:1px solid rgba(0,0,0,0.03)">
                                        <strong>{{ $ins->usuario->nombre }}</strong>
                                        <div style="font-size:0.85rem;color:#666">{{ $ins->usuario->email }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h4>Added<span style="color:var(--color-uttec-green);">UT</span></h4>
                <p>Plataforma para la gestión de actividades extracurriculares en la Universidad Tecnológica de Tlaxcala (UTTEC).</p>
            </div>
            <div class="footer-col">
                <h4>Enlaces Rápidos</h4>
                <a href="{{ route('estudiante.eventos.index') }}">Eventos</a>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <address>uttecamac@uttecamac.edu.mx<br>(01-55) 59-38-84-00</address>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} Universidad Tecnológica de Tecámac (UTTEC). Todos los derechos reservados.
        </div>
    </footer>

    <button onclick="topFunction()" id="scrollTopButton" title="Volver al inicio" style="display:none">
        <i data-feather="arrow-up" class="feather"></i>
    </button>

    <script>feather.replace();let mybutton=document.getElementById("scrollTopButton");window.onscroll=function(){if(document.body.scrollTop>100||document.documentElement.scrollTop>100){mybutton.style.display='block'}else{mybutton.style.display='none'}};function topFunction(){document.body.scrollTop=0;document.documentElement.scrollTop=0}</script>
</body>
</html>
