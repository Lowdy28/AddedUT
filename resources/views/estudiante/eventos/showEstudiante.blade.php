<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddedUT - Detalle del Evento</title>

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
            --shadow-card: 0 15px 45px rgba(0, 45, 98, 0.15), 0 0 10px rgba(0, 0, 0, 0.05);
            --color-footer-bg: #F4F6F9;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--color-footer-bg);
            color: var(--color-text-dark);
            min-height: 100vh;
            line-height: 1.6;
            scroll-behavior: smooth;
        }
        a { text-decoration: none; color: inherit; }
        .feather { width: 20px; height: 20px; stroke-width: 2.5; }

        header {
            position: fixed; top:0; left:0; width:100%;
            background: var(--color-glass-light);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 45, 98, 0.1);
            padding: 0.8rem 3rem;
            display: flex; justify-content: space-between; align-items: center;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        header .logo {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--color-uttec-blue-dark);
            display: flex; align-items: center; gap: 10px;
        }
        .logo span { color: var(--color-uttec-green); }

        nav { display: flex; align-items: center; gap: 2rem; }
        nav a, nav button {
            color: var(--color-uttec-blue-dark);
            font-weight: 600; padding: 0.5rem 0;
            position: relative; transition: color 0.3s ease;
            background: none; border: none; cursor: pointer; font-size: 1rem;
            display: flex; align-items: center; gap: 6px;
        }
        nav a::after, nav button::after {
            content: ''; position: absolute; width: 0; height: 3px; bottom: -5px;
            left: 50%; transform: translateX(-50%); background: var(--color-uttec-green);
            transition: width 0.3s ease, background 0.3s ease;
        }
        nav a:hover, nav button:hover { color: var(--color-uttec-green); }
        nav a:hover::after, nav button:hover::after { width: 100%; }
        .logout-btn { color: var(--color-text-dark) !important; margin-left: 1rem; }
        .logout-btn:hover { color: var(--color-accent-red) !important; }
        .logout-btn:hover::after { background: var(--color-accent-red); }

        main {
            padding-top: 100px;
            padding-bottom: 5rem;
            max-width: 1300px;
            margin: auto;
            padding-left: 3rem;
            padding-right: 3rem;
            min-height: calc(100vh - 80px);
        }

        .events-header {
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid var(--color-uttec-green);
            display: flex; justify-content: space-between; align-items: center;
        }
        .events-header h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--color-uttec-blue-dark);
            display: flex; align-items: center; gap: 15px;
        }
        .events-header h2 i { color: var(--color-uttec-green); }

        .event-detail-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 40px;
            background: var(--color-uttec-white);
            border-radius: 16px;
            padding: 3rem;
            box-shadow: var(--shadow-card);
        }

        .detail-main-content {
            padding-right: 2rem;
            border-right: 1px solid rgba(0, 45, 98, 0.1);
        }
        .detail-main-content h1 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--color-uttec-blue-dark);
            margin-bottom: 0.5rem;
        }
        .detail-category-tag {
            display: inline-block;
            background: var(--color-uttec-green);
            color: var(--color-uttec-white);
            padding: 0.4rem 1.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 168, 107, 0.3);
        }
        .detail-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--color-uttec-blue-dark);
            border-bottom: 2px solid var(--color-accent-blue);
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        .detail-section p { margin-bottom: 1.5rem; font-size: 1rem; color: var(--color-text-light); }
        .detail-section ul { list-style: none; padding-left: 0; }
        .detail-section ul li { display: flex; align-items: flex-start; gap: 15px; margin-bottom: 15px; font-weight: 500; color: var(--color-text-dark); }
        .detail-section ul li .feather { color: var(--color-uttec-green); min-width: 24px; height: 24px; }

        .detail-sidebar { display: flex; flex-direction: column; gap: 20px; }
        .sidebar-box {
            background: var(--color-footer-bg);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid rgba(0, 45, 98, 0.1);
        }
        .sidebar-box h4 {
            font-size: 1.2rem;
            color: var(--color-uttec-blue-dark);
            margin-bottom: 1rem;
            font-weight: 700;
            display: flex; align-items: center; gap: 8px;
        }
        .sidebar-box p { margin-bottom: 0.5rem; font-size: 0.95rem; color: var(--color-text-light); font-weight: 500; }

        .action-button {
            font-weight: 700;
            padding: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            width: 100%;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .inscrito-btn { background: var(--color-uttec-green); color: var(--color-uttec-white); box-shadow: 0 5px 15px rgba(0, 168, 107, 0.4); }
        .inscrito-btn:hover { background: var(--color-uttec-blue-dark); box-shadow: 0 7px 20px rgba(0, 45, 98, 0.6); }
        .cancelar-btn { background: var(--color-accent-red); color: var(--color-uttec-white); box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4); }
        .cancelar-btn:hover { background: #C0392B; box-shadow: 0 7px 20px rgba(192, 57, 43, 0.6); }

        .cupos-display { text-align: center; padding: 1rem 0; border-radius: 8px; margin-top: 1rem; font-size: 1rem; font-weight: 700; }
        .cupos-display span { display: block; font-size: 2rem; font-weight: 800; }
        .cupos-available { color: var(--color-uttec-green); background: rgba(0, 168, 107, 0.1); }
        .cupos-full { color: var(--color-accent-red); background: rgba(231, 76, 60, 0.1); }
        .disabled-btn { background: #bdc3c7 !important; cursor: not-allowed !important; color: #ecf0f1 !important; box-shadow: none !important; opacity: 0.8; }

        footer { background: var(--color-uttec-white); color: var(--color-text-light); padding: 3rem 0 1rem 0; border-top: 5px solid var(--color-uttec-blue-dark); box-shadow: 0 -5px 15px rgba(0, 45, 98, 0.05); }
        .footer-content { max-width: 1300px; margin: 0 auto; padding: 0 3rem; display: flex; justify-content: space-between; gap: 4rem; flex-wrap: wrap; }
        .footer-col { flex: 1; min-width: 250px; }
        .footer-col h4 { font-size: 1.2rem; color: var(--color-uttec-blue-dark); margin-bottom: 1.5rem; font-weight: 700; border-bottom: 2px solid var(--color-uttec-green); padding-bottom: 0.5rem; }
        .footer-col a, .footer-col span { display: block; margin-bottom: 0.8rem; color: var(--color-text-light); transition: color 0.3s ease; font-weight: 500; }
        .footer-col a:hover { color: var(--color-uttec-green); text-decoration: underline; }
        .footer-col p, .footer-col address { margin-bottom: 1rem; font-style: normal; }
        .footer-bottom { text-align: center; padding: 1rem 0 0 0; margin-top: 2rem; border-top: 1px solid rgba(0, 45, 98, 0.1); font-size: 0.9rem; color: #888; }

        @media (max-width: 1024px) {
            header, main, .footer-content { padding-left: 1.5rem; padding-right: 1.5rem; }
            .events-header h2 { font-size: 2rem; }
            .event-detail-container { grid-template-columns: 1fr; padding: 1.5rem; }
            .detail-main-content { padding-right: 0; border-right: none; padding-bottom: 2rem; border-bottom: 1px solid rgba(0, 45, 98, 0.1); }
            nav { display: none; }
            header { justify-content: center; }
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('estudiante.dashboard') }}" class="logo">
            <i data-feather="book-open" style="color:var(--color-uttec-green);"></i>
            Added<span style="color:var(--color-uttec-green);">UT</span>
        </a>
        <nav>
            <a href="{{ route('estudiante.dashboard') }}"><i data-feather="grid" class="feather"></i> Inicio</a>
            <a href="{{ route('estudiante.eventos.index') }}"><i data-feather="calendar" class="feather"></i> Eventos</a>
            <a href="{{ route('estudiante.profile.edit') }}"><i data-feather="user" class="feather"></i> Perfil</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">@csrf
                <button type="submit" class="logout-btn"><i data-feather="log-out" class="feather"></i> Salir</button>
            </form>
        </nav>
    </header>

    <main>
        <div class="events-header">
            <h2><i data-feather="info" class="feather"></i> Detalles de la Actividad</h2>
        </div>

        <div class="event-detail-container">
            <div class="detail-main-content">
                <span class="detail-category-tag">{{ $evento->categoria ?? 'Cultural' }}</span>
                <h1>{{ $evento->nombre ?? 'Taller de Expresión y Teatro Moderno' }}</h1>
                
                <div class="detail-section">
                    <h3>Descripción Completa</h3>
                    <p>{{ $evento->descripcion ?? 'Este taller intensivo está diseñado para desarrollar habilidades de comunicación no verbal...' }}</p>
                    <p>Se recomienda a los participantes traer ropa cómoda y un cuaderno...</p>
                </div>

                <div class="detail-section">
                    <h3>Objetivos del Taller</h3>
                    <ul>
                        <li><i data-feather="check-square" class="feather"></i> Mejorar la dicción y la proyección vocal.</li>
                        <li><i data-feather="check-square" class="feather"></i> Fomentar la creatividad a través de la improvisación.</li>
                        <li><i data-feather="check-square" class="feather"></i> Desarrollar la capacidad de trabajo en equipo y la escucha activa.</li>
                        <li><i data-feather="check-square" class="feather"></i> Entender los fundamentos de la puesta en escena.</li>
                    </ul>
                </div>

                <div class="detail-section">
                    <h3>Requisitos y Notas Adicionales</h3>
                    <p>No se requiere experiencia previa en actuación. Solo se pide compromiso y puntualidad...</p>
                </div>
            </div>

            <div class="detail-sidebar">
                <div class="sidebar-box">
                    <h4><i data-feather="calendar" class="feather"></i> Datos del Evento</h4>
                    <p><strong>Días:</strong> {{ $evento->dias ?? 'Lunes y Miércoles' }}</p>
                    <p><strong>Horario:</strong> {{ $evento->horario ?? '16:00 a 18:00 hrs' }}</p>
                    <p><strong>Fecha de Inicio:</strong> {{ optional($evento->fecha_inicio)->format('d M Y') ?? '15 Octubre 2025' }}</p>
                    <p><strong>Lugar:</strong> {{ $evento->lugar ?? 'Aula Magna - Edificio E' }}</p>
                    <p><strong>Instructor:</strong> {{ $evento->creador->nombre ?? 'Lic. Sofía Hernández' }}</p>
                </div>

                <div class="sidebar-box">
                    <h4><i data-feather="users" class="feather"></i> Cupos y Estado</h4>
                    @php
                        $cuposDisponibles = $evento->cupo_disponible ?? 0; 
        $cupoClase = $cuposDisponibles > 0 ? 'cupos-available' : 'cupos-full';
                    @endphp

                    <div class="cupos-display {{ $cupoClase }}">
                        Cupos Disponibles: <span>{{ $cuposDisponibles }}</span>
                    </div>

                    @if ($estaInscrito)
                        <form action="{{ route('estudiante.inscripciones.destroy', $evento) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-button cancelar-btn">
                                <i data-feather="x-circle" class="feather"></i> Cancelar mi Inscripción
                            </button>
                        </form>
                        <small style="display:block; text-align:center; margin-top:10px; color:var(--color-text-light); font-weight: 600;">
                            ¡Estás inscrito a esta actividad!
                        </small>
                    @else
                        @if ($cuposDisponibles > 0)
                            <form action="{{ route('estudiante.inscripciones.store', $evento) }}" method="POST">
                                @csrf
                                <button type="submit" class="action-button inscrito-btn">
                                    <i data-feather="plus" class="feather"></i> Inscribirse Ahora
                                </button>
                            </form>
                        @else
                            <button class="action-button disabled-btn" disabled>
                                <i data-feather="slash" class="feather"></i> Cupo Agotado
                            </button>
                            <small style="display:block; text-align:center; margin-top:10px; color:var(--color-accent-red); font-weight: 600;">
                                Vuelve más tarde, la actividad está llena.
                            </small>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h4>AddedUT</h4>
                <p>Plataforma oficial de gestión de actividades extracurriculares de la Universidad Tecnológica.</p>
            </div>
            <div class="footer-col">
                <h4>Contacto</h4>
                <address>Av. Universidad 123, Ciudad, Estado</address>
                <span>Email: contacto@addedut.mx</span>
                <span>Tel: +52 55 1234 5678</span>
            </div>
            <div class="footer-col">
                <h4>Síguenos</h4>
                <a href="#"><i data-feather="facebook" class="feather"></i> Facebook</a>
                <a href="#"><i data-feather="instagram" class="feather"></i> Instagram</a>
                <a href="#"><i data-feather="twitter" class="feather"></i> Twitter</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2025 AddedUT. Todos los derechos reservados.
        </div>
    </footer>

    <script>
        feather.replace()
        let mybutton = document.getElementById("scrollTopButton");

        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            // Añadida comprobación de nulidad para evitar TypeError
            if (!mybutton) return;

            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
        
        // Función de alerta personalizada (Reemplaza alert())
        function showMessage(message) {
            console.log(message);
            // En una aplicación real, usarías un modal o notificación aquí.
            // Para esta simulación, uso console.log.
        }
    </script>
</body>
</html>