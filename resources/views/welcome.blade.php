<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddedUT | Actividades UTT</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --azul: #004aad;
            --celeste: #00bcd4;
            --amarillo: #ffdd57;
            --negro-trans: rgba(0, 0, 0, 0.45);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background: linear-gradient(135deg, rgba(0,74,173,0.85), rgba(0,188,212,0.7)),
                        url('{{ asset('imagenes/background.jpg') }}') center/cover no-repeat fixed;
            color: #fff;
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

        .logo-img {
            width: clamp(200px, 40vw, 400px);
            height: auto;
            margin-bottom: 25px;
            animation: fadeIn 1.2s ease, float 3s ease-in-out infinite;
        }

        h1 {
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 600;
            margin-bottom: 0.5rem;
            animation: fadeInDown 1.2s ease;
        }

        h2 {
            font-weight: 300;
            font-size: clamp(1rem, 2.5vw, 1.4rem);
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeIn 1.5s ease;
        }

        .intro {
            max-width: 800px;
            background: var(--negro-trans);
            padding: 25px 35px;
            border-radius: 15px;
            line-height: 1.8;
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            margin-bottom: 2.5rem;
            animation: fadeInUp 2s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
            text-align: justify;
        }

        .highlight {
            color: var(--amarillo);
            font-weight: 600;
        }

        .btn-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            animation: fadeInUp 2.2s ease;
        }

        .btn {
            background: #fff;
            color: var(--azul);
            padding: 14px 36px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            font-size: clamp(1rem, 2vw, 1.1rem);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: var(--azul);
            color: #fff;
            transform: scale(1.07);
        }

        footer {
            width: 100%;
            text-align: center;
            font-size: clamp(0.7rem, 1.8vw, 0.9rem);
            opacity: 0.85;
            color: #f1f1f1;
            padding: 12px 10px;
            background: rgba(0, 0, 0, 0.25);
            z-index: 2;
            position: fixed;
            bottom: 0;
            left: 0;
            transition: transform 0.5s ease;
        }

        footer.hidden {
            transform: translateY(100%);
        }

        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes fadeZoomIn { 0% { opacity: 0; transform: scale(0.96); } 100% { opacity: 1; transform: scale(1); } }
        @keyframes moveGlow { 0% { background-position: 0% 50%; } 100% { background-position: 100% 50%; } }

        @media (max-width: 480px) {
            body { background-attachment: scroll; }
            .btn { width: 100%; }
            .intro { padding: 20px; }
        }

        .activities {
            max-width: 1200px;
            margin: 50px auto 80px;
            z-index: 2;
            position: relative;
            padding: 0 20px;
        }

        .activities h2 {
            font-size: clamp(1.5rem, 4vw, 2.2rem);
            margin-bottom: 30px;
        }

        .carousel {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 10px;
        }

        .carousel::-webkit-scrollbar { height: 8px; }
        .carousel::-webkit-scrollbar-thumb { background: var(--amarillo); border-radius: 10px; }
        .carousel::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }

        .card {
            flex: 0 0 250px;
            background: var(--negro-trans);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(0,0,0,0.5);
        }

        .card img { width: 100%; height: 180px; object-fit: cover; }
        .card-info { padding: 15px; text-align: left; }
        .card-info h3 { margin-bottom: 8px; font-size: 1.2rem; color: var(--amarillo); }
        .card-info p { font-size: 0.9rem; line-height: 1.4; color: #fff; text-align: justify; }

        @media (max-width: 768px) { .carousel { gap: 15px; } .card { flex: 0 0 200px; } }
        @media (max-width: 480px) { .card { flex: 0 0 160px; } .card-info h3 { font-size: 1rem; } .card-info p { font-size: 0.8rem; } }
    </style>
</head>

<body>
    <main>
        <img src="{{ asset('imagenes/logo.png') }}" alt="Logo AddedUT" class="logo-img">

        <h1>Bienvenido a <span class="highlight">AddedUT</span></h1>
        <h2>Plataforma de Actividades Extracurriculares<br>Universidad Tecnológica de Tecámac</h2>

        <div class="intro">
            <p>
                En <span class="highlight">AddedUT</span> podrás inscribirte, gestionar y participar en las
                <b>actividades extracurriculares</b> de nuestra universidad.
                Fomentamos el desarrollo personal, social y profesional de cada estudiante
                a través de actividades deportivas, culturales, tecnológicas y de bienestar integral.
            </p>
            <p>
                ¡Forma parte de la comunidad activa de la <b>UT Tecámac</b> y descubre
                todo lo que puedes lograr fuera del aula!
            </p>
        </div>

      <div class="btn-container">
    <a href="{{ route('login') }}" class="btn">Iniciar Sesión</a>
    <a href="{{ route('registro') }}" class="btn">Registrarse</a>
</div>

        <section class="activities">
            <h2>Explora nuestras <span class="highlight">Actividades</span></h2>
            <div class="carousel">
                <div class="card">
                    <img src="{{ asset('imagenes/futbol.jpg') }}" alt="Fútbol">
                    <div class="card-info">
                        <h3>Fútbol</h3>
                        <p>Practica tu deporte favorito y fortalece trabajo en equipo y disciplina.</p>
                    </div>
                </div>
                <div class="card">
                    <img src="{{ asset('imagenes/baile.jpg') }}" alt="Danza">
                    <div class="card-info">
                        <h3>Danza</h3>
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
            </div>
        </section>
    </main>

    <footer id="page-footer">
        © {{ date('Y') }} | Proyecto académico desarrollado bajo metodología <b>SCRUM</b>.
    </footer>

    <script>
        // Footer que desaparece al hacer scroll hacia abajo
        let lastScroll = 0;
        const footer = document.getElementById('page-footer');

        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;
            if (currentScroll > lastScroll) {
                footer.classList.add('hidden');
            } else {
                footer.classList.remove('hidden');
            }
            lastScroll = currentScroll;
        });
    </script>
</body>
</html>
