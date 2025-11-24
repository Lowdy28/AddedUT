<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>AddedUT - Agenda de Eventos Extracurriculares</title>{{-- Fuentes: Inter (Moderno, Limpio y Escolar) --}}
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

{{-- Íconos (Feather Icons) --}}
<script src="https://unpkg.com/feather-icons"></script>

<style>
    /* Variables de color basadas en el logo UTTEC (Verde y Azul) */
    :root {
        --color-uttec-blue-dark: #002D62; /* Azul Marino UTTEC */
        --color-uttec-green: #00A86B; /* Verde Brillante UTTEC (el más resaltado) */
        --color-uttec-white: #FFFFFF; /* Fondo principal blanco */
        --color-text-dark: #2c2c2c; /* Texto principal más oscuro para contraste */
        --color-text-light: #555555; /* Texto secundario/footer */
        --color-accent-blue: #004C99; /* Azul medio para acentos */
        --color-accent-red: #E74C3C; /* Rojo para alertas (ej. cupo agotado/salir) */
        
        /* Colores de transparencia y sombra mejorada */
        --color-glass-light: rgba(255, 255, 255, 0.9);
        --shadow-card: 0 15px 45px rgba(0, 45, 98, 0.15), 0 0 10px rgba(0, 0, 0, 0.05) inset;
        --color-footer-bg: #F4F6F9; /* Fondo de la página y del footer */
    }

    /* Reset y Base */
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
        font-family: 'Inter', sans-serif;
        background: var(--color-footer-bg);
        color: var(--color-text-dark);
        min-height: 100vh;
        line-height: 1.6;
        scroll-behavior: smooth;
        perspective: 1500px;
    }
    a { text-decoration: none; color: inherit; }
    .feather { width: 20px; height: 20px; stroke-width: 2.5; }
    
    /* Contenedor Principal */
    main { 
        padding-top: 100px; 
        padding-bottom: 5rem; 
        max-width: 1300px;
        margin: auto; 
        padding-left: 3rem; 
        padding-right: 3rem;
        min-height: calc(100vh - 80px); /* Asegura espacio para footer */
    }

    /* Header (Clean & White Glass) */
    header {
        position: fixed; top:0; left:0; width:100%;
        background: var(--color-glass-light);
        backdrop-filter: blur(12px); 
        -webkit-backdrop-filter: blur(12px);
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
    .logo span {
        color: var(--color-uttec-green);
    }

    /* Navegación */
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
    nav a:hover, nav button:hover { 
        color: var(--color-uttec-green);
    }
    nav a:hover::after, nav button:hover::after { width: 100%; }
    .logout-btn { 
        color: var(--color-text-dark) !important;
        margin-left: 1rem;
    }
    .logout-btn:hover { 
        color: var(--color-accent-red) !important;
    }
    .logout-btn:hover::after { 
        background: var(--color-accent-red); 
    }

    /* --- Estilos de la Página de Eventos (Se mantienen iguales) --- */
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
    .events-header h2 i {
        color: var(--color-uttec-green);
    }
    .mis-inscripciones-btn {
        background: var(--color-uttec-green);
        border: 1px solid var(--color-uttec-green);
        color: var(--color-uttec-white);
        padding: 0.8rem 1.6rem;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 5px 15px rgba(0, 168, 107, 0.4);
    }
    .mis-inscripciones-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0, 168, 107, 0.6);
        background: var(--color-uttec-blue-dark);
        border-color: var(--color-uttec-blue-dark);
    }
    .events-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2.5rem;
    }
    .event-card-tilt {
        display: flex;
        flex-direction: column;
        min-height: 450px;
        border-radius: 16px;
        overflow: hidden;
        background: var(--color-uttec-white);
        border: 1px solid rgba(0, 45, 98, 0.05);
        box-shadow: var(--shadow-card);
        transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
        transform-style: preserve-3d;
    }
    .event-card-tilt:hover {
        transform: translateY(-10px) rotateX(2deg) rotateY(-2deg) scale(1.02);
        box-shadow: 0 25px 50px rgba(0, 45, 98, 0.25);
    }
    .event-image-wrapper { height: 200px; overflow: hidden; }
    .event-image { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.85); transition: transform 0.5s ease; }
    .event-card-tilt:hover .event-image { transform: scale(1.1); filter: brightness(1); }
    .event-details { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
    .event-category-tag {
        position: absolute; top: 20px; left: 20px; background: var(--color-uttec-blue-dark);
        color: var(--color-uttec-white); padding: 0.4rem 1rem; border-radius: 4px;
        font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;
        z-index: 5; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    .event-details h3 { font-size: 1.8rem; font-weight: 700; margin-bottom: 0.4rem; color: var(--color-uttec-blue-dark); }
    .event-details .meta { font-size: 0.9rem; color: #6a6a6a; margin-bottom: 1rem; font-weight: 500; display: flex; flex-wrap: wrap; gap: 12px 20px; }
    .event-details .meta .feather { width: 16px; height: 16px; color: var(--color-accent-blue); }
    .event-details p { font-size: 0.95rem; color: #555; margin-bottom: 1.5rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .action-button-group { display: flex; gap: 1rem; align-items: center; justify-content: space-between; margin-top: auto; padding-top: 10px; border-top: 1px dashed rgba(0, 45, 98, 0.1); }
    .action-link { background: var(--color-uttec-green); border: 2px solid var(--color-uttec-green); color: var(--color-uttec-white); font-weight: 700; padding: 0.7rem 1.4rem; border-radius: 50px; transition: all 0.3s; box-shadow: 0 4px 10px rgba(0, 168, 107, 0.3); display: inline-flex; align-items: center; gap: 8px; font-size: 0.95rem; }
    .action-link:hover { background: var(--color-uttec-blue-dark); border-color: var(--color-uttec-blue-dark); box-shadow: 0 6px 15px rgba(0, 45, 98, 0.4); }
    .action-link.enrolled { background: none; color: var(--color-uttec-green); border-color: var(--color-uttec-green); box-shadow: none; }
    .action-link.enrolled:hover { background: var(--color-uttec-green); color: var(--color-uttec-white); border-color: var(--color-uttec-green); }
    .cupos-info { color: var(--color-uttec-blue-dark); font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; padding: 0.4rem 0.8rem; border-radius: 4px; background: rgba(0, 168, 107, 0.1); gap: 4px; }
    .cupos-info .cupos-number { color: var(--color-uttec-green); font-size: 1.1rem; }
    .cupos-info.full { color: var(--color-accent-red); background: rgba(231, 76, 60, 0.1); }

    /* --- FOOTER (Estilo Extraordinario) --- */
    footer {
        background: var(--color-uttec-white); /* Fondo Blanco del Footer */
        color: var(--color-text-light);
        padding: 3rem 0 1rem 0;
        border-top: 5px solid var(--color-uttec-blue-dark); /* Línea gruesa Azul UTTEC */
        box-shadow: 0 -5px 15px rgba(0, 45, 98, 0.05);
    }
    .footer-content {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 3rem;
        display: flex;
        justify-content: space-between;
        gap: 4rem;
        flex-wrap: wrap;
    }
    .footer-col {
        flex: 1;
        min-width: 250px;
    }
    .footer-col h4 {
        font-size: 1.2rem;
        color: var(--color-uttec-blue-dark);
        margin-bottom: 1.5rem;
        font-weight: 700;
        border-bottom: 2px solid var(--color-uttec-green);
        padding-bottom: 0.5rem;
    }
    .footer-col a {
        display: block;
        margin-bottom: 0.8rem;
        color: var(--color-text-light);
        transition: color 0.3s ease;
        font-weight: 500;
    }
    .footer-col a:hover {
        color: var(--color-uttec-green); /* Links en Verde UTTEC */
        text-decoration: underline;
    }
    .footer-col p, .footer-col address {
        margin-bottom: 1rem;
        font-style: normal;
    }

    .footer-bottom {
        text-align: center;
        padding: 1rem 0 0 0;
        margin-top: 2rem;
        border-top: 1px solid rgba(0, 45, 98, 0.1);
        font-size: 0.9rem;
        color: #888;
    }

    /* Botón Flotante Volver Arriba */
    #scrollTopButton {
        display: none; /* Oculto por defecto */
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        background: var(--color-uttec-green);
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 50%;
        opacity: 0.9;
        transition: opacity 0.3s, transform 0.3s;
        box-shadow: 0 5px 15px rgba(0, 168, 107, 0.6);
    }
    #scrollTopButton:hover {
        opacity: 1;
        transform: translateY(-2px);
        background: var(--color-uttec-blue-dark);
    }
    #scrollTopButton .feather {
        width: 24px;
        height: 24px;
    }

</style>
</head><body>{{-- LAYOUT HEADER --}}
<header>
    <a href="{{ route('estudiante.dashboard') }}" class="logo">
        <i data-feather="book-open" style="color:var(--color-uttec-green);"></i>
        Added<span style="color:var(--color-uttec-green);">UT</span>
    </a>
    <nav>
        <a href="{{ route('estudiante.dashboard') }}">
            <i data-feather="grid" class="feather"></i> Inicio
        </a>
        <a href="{{ route('estudiante.eventos.index') }}">
            <i data-feather="calendar" class="feather"></i> Eventos
        </a>
        <a href="{{ route('estudiante.profile.edit') }}">
            <i data-feather="user" class="feather"></i> Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="logout-btn">
                <i data-feather="log-out" class="feather"></i> Salir
            </button>
        </form>
    </nav>
</header>

{{-- LAYOUT MAIN CONTENT --}}
<main>

    {{-- ENCABEZADO DE LA PÁGINA DE EVENTOS --}}
    <div class="events-header">
        <h2><i data-feather="calendar" class="feather"></i> Agenda de Actividades Extracurriculares</h2>
        {{-- Botón "Mis Inscripciones" como span estático (sin ruta activa) --}}
        <span class="mis-inscripciones-btn">
            <i data-feather="bookmark" class="feather"></i> Mis Inscripciones
        </span>
    </div>

    {{-- GRID DE EVENTOS (Iteración con Blade) --}}
    <div class="events-grid">

        @forelse ($eventos as $evento)
        @php
         $inscritoEventIds = $inscritoEventIds ?? [];
            // MAPA DE IMÁGENES EXACTO BASADO EN EL NOMBRE DEL EVENTO
            $imageMap = [
                'Bailes de Salón' => 'imagenes/baile.jpg',
                'Música' => 'imagenes/musica.jpg',
                'Oratoria y Dibujo' => 'imagenes/dibujo.jpg',
                'Teatro' => 'imagenes/teatro.jpg',
                'Ajedrez' => 'imagenes/ajedrez.jpg',
                'Basquetbol' => 'imagenes/basquet.jpg',
                'Fútbol americano' => 'imagenes/americano.jpg',
                'Fútbol rápido y 7' => 'imagenes/frapido.jpg',
                'Fútbol soccer' => 'imagenes/soccer.jpg',
                'Taekwondo' => 'imagenes/taekwdo.jpg',
                'Voleibol' => 'imagenes/volei.jpg',
            ];

            // Asignación de imagen, usando un fallback si no se encuentra
            $imagePath = $imageMap[$evento->nombre] ?? 'imagenes/default.jpg'; 
            
            // --- INICIO DE CORRECCIÓN: Usar la lista de IDs de eventos realmente inscritos ---
            $isEnrolled = in_array($evento->id_evento, $inscritoEventIds);
            // --- FIN DE CORRECCIÓN ---
        @endphp

        <a href="{{ route('estudiante.eventos.show', $evento->id_evento) }}" class="event-card-tilt">
            <span class="event-category-tag">{{ $evento->categoria }}</span>
            
            <div class="event-image-wrapper">
                <img src="{{ asset($imagePath) }}" alt="{{ $evento->nombre }}" class="event-image">
            </div>
            
            <div class="event-details">
                <div>
                    <h3>{{ $evento->nombre }}</h3>
                    <div class="meta">
                        <span>
                            <i data-feather="clock" class="feather"></i> 
                            {{ \Carbon\Carbon::parse($evento->fecha_inicio)->isoFormat('DD MMMM YYYY') }}
                            @if ($evento->horario) | {{ $evento->horario }} @endif
                        </span>
                        <span>
                            <i data-feather="map-pin" class="feather"></i> 
                            {{ $evento->lugar ?? 'Campus UTTEC' }}
                        </span>
                        @if($evento->dias)
                        <span>
                            <i data-feather="calendar" class="feather"></i> 
                            {{ $evento->dias }}
                        </span>
                        @endif
                    </div>
                    <p>{{ $evento->descripcion }}</p>
                </div>
                
                <div class="action-button-group">
                    @if ($isEnrolled)
                        <span class="action-link enrolled">
                            <i data-feather="check-circle" class="feather"></i> Ya Inscrito
                        </span>
                    @else
                        <span class="action-link">
                            <i data-feather="plus" class="feather"></i> Inscribirse
                        </span>
                    @endif
                    
                    <div class="cupos-info @if($evento->cupos <= 5 && !$isEnrolled) full @endif">
                        @if($evento->cupos <= 0 && !$isEnrolled)
                            <i data-feather="alert-triangle" style="color: var(--color-accent-red);"></i> Agotado
                        @else
                            Cupos: <span class="cupos-number">{{ $evento->cupos }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        @empty
            <div class="no-events">
                <i data-feather="info" style="width: 50px; height: 50px;"></i>
                <p>No hay eventos programados en este momento. Vuelve pronto.</p>
            </div>
        @endforelse

    </div>

</main>

{{-- FOOTER --}}
<footer>
    <div class="footer-content">
        <div class="footer-col">
            <h4>Added<span style="color:var(--color-uttec-green);">UT</span></h4>
            <p>Plataforma para la gestión de actividades extracurriculares en la Universidad Tecnológica de Tlaxcala (UTTEC).</p>
            <p>Impulsando el desarrollo integral de la comunidad estudiantil.</p>
        </div>

        <div class="footer-col">
            <h4>Enlaces Rápidos</h4>
            <a href="{{ route('estudiante.dashboard') }}">Inicio / Dashboard</a>
            <a href="{{ route('estudiante.eventos.index') }}">Eventos y Actividades</a>
            <span class="footer-link-static">Mis Inscripciones</span>
            <a href="{{ route('estudiante.profile.edit') }}">Configuración de Perfil</a>
        </div>

        <div class="footer-col">
            <h4>Contacto e Institucional</h4>
            <address>
                Carretera Federal México-Pachuca km 37.5, Predio Sierra Hermosa, Tecámac Edo. Méx.<br>
                <i data-feather="mail" class="feather" style="width:16px;"></i> Email: <a href="mailto:uttecamac@uttecamac.edu.mx">uttecamac@uttecamac.edu.mx</a><br>
                <i data-feather="phone" class="feather" style="width:16px;"></i> Teléfono: (01-55) 59-38-84-00
            </address>
            <a href="https://uttecamac.edomex.gob.mx" target="_blank">Sitio Web Oficial UTTEC</a>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} Universidad Tecnológica de Tecámac (UTTEC). Todos los derechos reservados.
    </div>
</footer>

{{-- Botón Flotante Volver Arriba --}}
<button onclick="topFunction()" id="scrollTopButton" title="Volver al inicio">
    <i data-feather="arrow-up" class="feather"></i>
</button>

{{-- SCRIPTS --}}
<script>
    feather.replace();

    let mybutton = document.getElementById("scrollTopButton");

    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
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
</script>
</body></html>