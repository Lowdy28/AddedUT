<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddedUT | Actividades Extracurriculares</title>
    
    {{-- Fuentes: Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    {{-- Íconos (Feather Icons) --}}
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        /* Variables UTTEC para unificación */
        :root {
            --color-uttec-blue-dark: #002D62; /* Azul Marino UTTEC (Principal) */
            --color-uttec-green: #00DC82; /* ¡NUEVO VERDE MÁS INTENSO Y BRILLANTE! */
            --color-text-light: #F1F1F1; /* Texto en fondo oscuro */
            --color-overlay-dark: rgba(0, 45, 98, 0.75); /* Oscurecedor para Hero */
            --color-overlay-light: rgba(0, 168, 107, 0.6); /* Tono claro para Hero */
            --color-card-bg: rgba(0, 45, 98, 0.45); /* Fondo de tarjetas */
            --color-accent-white: #FFFFFF; /* Blanco puro para botones de contraste */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, var(--color-overlay-dark), var(--color-overlay-light)),
                        url('{{ asset('imagenes/background.jpg') }}') center/cover no-repeat fixed;
            color: var(--color-text-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            overflow-x: hidden;
            animation: fadeZoomIn 1.2s ease both;
            position: relative;
            perspective: 1px;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.08), transparent 60%),
                        radial-gradient(circle at 70% 70%, rgba(255,255,255,0.05), transparent 60%);
            background-size: 200% 200%;
            animation: moveGlow 14s ease-in-out infinite alternate;
            z-index: 0;
            transform: translateZ(-1px) scale(2);
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 2;
            padding: 40px 20px 80px;
            backdrop-filter: blur(3px);
        }

        /* --- Estilo del Título del Logo --- */
        .logo-title {
            font-size: clamp(3rem, 7vw, 5rem);
            font-weight: 800;
            letter-spacing: -2px;
            color: var(--color-text-light);
            margin-bottom: 25px;
            animation: fadeIn 1.2s ease, float 3s ease-in-out infinite;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo-title .feather {
            color: var(--color-uttec-green); /* ¡Ahora más intenso! */
            width: clamp(30px, 5vw, 50px);
            height: auto;
        }
        .logo-title span {
            color: var(--color-uttec-green); /* ¡Ahora más intenso! */
        }

        h1 {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
            margin-bottom: 0.5rem;
            animation: fadeInDown 1.2s ease;
        }

        h2 {
            font-weight: 300;
            font-size: clamp(1rem, 2.5vw, 1.4rem);
            margin-bottom: 3.5rem;
            opacity: 0.9;
            animation: fadeIn 1.5s ease;
        }

        .highlight {
            color: var(--color-uttec-green); /* ¡Ahora más intenso! */
            font-weight: 700;
        }

        /* --- Botones de Acción (CONTRASTE CORREGIDO) --- */
        .btn-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            animation: fadeInUp 2.2s ease;
            margin-bottom: 80px;
        }

        .btn {
            padding: 14px 40px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            font-size: clamp(1rem, 2vw, 1.1rem);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.4);
        }

        /* Botón 1: Iniciar Sesión (Azul Marino Sólido) */
        .btn-primary {
            background: var(--color-uttec-blue-dark);
            color: var(--color-accent-white);
            border-color: var(--color-uttec-blue-dark);
        }

        .btn-primary:hover {
            background: var(--color-uttec-green); /* ¡Hover al verde más intenso! */
            border-color: var(--color-uttec-green);
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 168, 107, 0.5);
        }
        
        /* Botón 2: Registrarse (Outline BLANCO) */
        .btn-secondary {
            background: transparent;
            color: var(--color-accent-white);
            border-color: var(--color-accent-white);
        }

        .btn-secondary:hover {
            background: var(--color-accent-white);
            color: var(--color-uttec-blue-dark);
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.5);
        }

        /* --- Estilo de Carrusel de Actividades --- */
        .activities {
            max-width: 1200px;
            margin: 50px auto 30px;
            z-index: 2;
            position: relative;
            padding: 0 20px;
        }

        .activities h2 {
            font-size: clamp(1.5rem, 4vw, 2.2rem);
            margin-bottom: 30px;
            font-weight: 700;
            color: var(--color-text-light);
        }

        .carousel {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 15px;
            scroll-padding-left: 20px;
        }

        .carousel::-webkit-scrollbar { height: 10px; }
        .carousel::-webkit-scrollbar-thumb { background: var(--color-uttec-green); /* ¡Más intenso! */ border-radius: 10px; }
        .carousel::-webkit-scrollbar-track { background: var(--color-overlay-dark); border-radius: 10px; }

        .card {
            flex: 0 0 280px;
            background: var(--color-card-bg);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            cursor: pointer;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 40px rgba(0,0,0,0.6);
            border-color: var(--color-uttec-green); /* ¡Borde de hover más intenso! */
        }

        .card img { width: 100%; height: 200px; object-fit: cover; filter: brightness(0.9); }
        .card-info { padding: 20px; text-align: left; }
        .card-info h3 { margin-bottom: 8px; font-size: 1.4rem; color: var(--color-uttec-green); /* ¡Título más intenso! */ }
        .card-info p { font-size: 1rem; line-height: 1.5; color: var(--color-text-light); opacity: 0.8; text-align: left; }

        /* NUEVO TEXTO INTRODUCTORIO AL FINAL */
        .final-call {
            max-width: 900px;
            margin: 50px auto 80px;
            padding: 20px 30px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            font-size: clamp(1rem, 2vw, 1.2rem);
            font-weight: 500;
            line-height: 1.8;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            animation: fadeIn 2.5s ease;
        }

        /* Media Queries y Animaciones */
        @media (max-width: 480px) {
            body { background-attachment: scroll; }
            .btn-container { flex-direction: column; gap: 15px;}
            .btn { width: 90%; max-width: 300px; }
            .card { flex: 0 0 80%; } 
            .carousel { justify-content: start; } 
            .final-call { padding: 15px; }
        }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes fadeZoomIn { 0% { opacity: 0; transform: scale(0.96); } 100% { opacity: 1; transform: scale(1); } }
        @keyframes moveGlow { 0% { background-position: 0% 50%; } 100% { background-position: 100% 50%; } }
    </style>
</head>

<body>
    <main>
        {{-- LOGO ESTILIZADO --}}
        <div class="logo-title">
             <i data-feather="book-open"></i>
            Added<span>UT</span>
        </div>

        <h1>Plataforma Oficial de Actividades</h1>
        <h2>Fomentando el Desarrollo Integral en la UTTEC </h2>

        {{-- BOTONES DE ALTO CONTRASTE --}}
      <div class="btn-container">
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i data-feather="log-in" class="feather"></i> Iniciar Sesión
            </a>
            <a href="{{ route('registro') }}" class="btn btn-secondary">
                <i data-feather="user-plus" class="feather"></i> Registrarse
            </a>
        </div>

        <section class="activities">
            <h2>Explora nuestras <span class="highlight">Actividades</span></h2>
            <div class="carousel">
                <div class="card">
                    <img src="{{ asset('imagenes/soccer.jpg') }}" alt="Fútbol">
                    <div class="card-info">
                        <h3>Fútbol Soccer</h3>
                        <p>Practica tu deporte favorito y fortalece trabajo en equipo y disciplina.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="{{ asset('imagenes/baile.jpg') }}" alt="Bailes de Salón">
                    <div class="card-info">
                        <h3>Bailes de Salón</h3>
                        <p>Desarrolla tu creatividad, coordinación y expresión artística en cada movimiento.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="{{ asset('imagenes/ajedrez.jpg') }}" alt="Ajedrez">
                    <div class="card-info">
                        <h3>Ajedrez</h3>
                        <p>Ejercita tu mente, estrategia y toma de decisiones con cada partida.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="{{ asset('imagenes/taekwdo.jpg') }}" alt="Taekwondo">
                    <div class="card-info">
                        <h3>Taekwondo</h3>
                        <p>Aprende defensa personal, disciplina y concentración a través del arte marcial.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="{{ asset('imagenes/musica.jpg') }}" alt="Música">
                    <div class="card-info">
                        <h3>Música</h3>
                        <p>Explora tu talento musical y participa en eventos culturales de la universidad.</p>
                    </div>
                </div>
            </div>
        </section>
        
        {{-- CALL TO ACTION FINAL --}}
        <div class="final-call">
            <p>
                ¡Únete a la comunidad activa de la Universidad Tecnológica de Tecámac! 
                <span class="highlight">Inscríbete, gestiona y participa</span> en el desarrollo personal, social y profesional que AddedUT tiene para ti.
            </p>
        </div>
    </main>

    <footer id="page-footer">
        © {{ date('Y') }} | Proyecto académico desarrollado bajo metodología <b>SCRUM</b>.
    </footer>

    <script>
        feather.replace();

        let lastScroll = 0;
        const footer = document.getElementById('page-footer');

        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;
            if (currentScroll > lastScroll && currentScroll > 50) {
                footer.classList.add('hidden');
            } else {
                footer.classList.remove('hidden');
            }
            lastScroll = currentScroll;
        });
    </script>
</body>
</html>
