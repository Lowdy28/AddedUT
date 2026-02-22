@extends('layouts.estudiante')
@section('title', $evento->nombre)

@section('content')
@php

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
            $imagePath = $imageMap[$evento->nombre] ?? 'imagenes/default.jpg'; 

    // 2. Diccionario de Descripciones y Detalles Específicos
    $detallesExtra = [
        'Ajedrez' => [
            'descripcion' => 'El ajedrez es mucho más que un juego de tablero; es una disciplina mental fascinante. En este taller aprenderás desde los movimientos básicos hasta aperturas, defensas y tácticas avanzadas de medio juego y finales. Analizaremos partidas históricas y desarrollaremos tu visión espacial y capacidad de resolución de problemas en escenarios complejos.',
            'beneficios' => 'Incrementa drásticamente tu concentración, agiliza la memoria, fomenta el pensamiento lógico-matemático y mejora la toma de decisiones bajo presión.',
            'requisitos' => 'Ganas de aprender y ejercitar la mente. Si cuentas con un tablero profesional o reloj de ajedrez, eres bienvenido a traerlo.'
        ],
        'Teatro' => [
            'descripcion' => 'Sumérgete en el mundo de las artes escénicas. Este taller está diseñado para explorar tu capacidad expresiva a través de dinámicas de improvisación, manejo de voz, dicción, expresión corporal y análisis de textos dramáticos. Finalizaremos el ciclo con el montaje de una puesta en escena frente a la comunidad universitaria.',
            'beneficios' => 'Pierde el pánico escénico, mejora tus habilidades de comunicación oral, fomenta la empatía, libera estrés y desarrolla una gran confianza en ti mismo.',
            'requisitos' => 'Ropa muy cómoda (pants, leggings, playera holgada de algodón), calcetines gruesos o tenis flexibles y una botella de agua.'
        ],
        'Dibujo' => [
            'descripcion' => 'Descubre y perfecciona tu talento visual. Abordaremos técnicas de ilustración tradicional, entendimiento de la luz y la sombra (claroscuro), perspectiva, anatomía básica y proporciones. Es un espacio ideal tanto para principiantes que buscan un pasatiempo relajante como para quienes desean pulir su técnica artística.',
            'beneficios' => 'Estimula la creatividad, afina la motricidad fina, mejora la capacidad de observación y proporciona una excelente vía de relajación mental.',
            'requisitos' => 'Cuaderno de dibujo (sketchbook) sin rayas, lápices de grafito de diferentes graduaciones (HB, 2B, 4B, 6B) y goma de migajón.'
        ],
        'Oratoria' => [
            'descripcion' => 'El arte de hablar en público con elocuencia. En esta actividad dual (que a menudo se combina con dibujo o artes visuales), aprenderás a estructurar discursos, modular tu voz, utilizar el lenguaje no verbal a tu favor y persuadir a tu audiencia. Fundamental para tu futuro profesional.',
            'beneficios' => 'Desarrolla liderazgo, proyecta seguridad, mejora tu argumentación y prepárate para exposiciones académicas y futuras entrevistas laborales.',
            'requisitos' => 'Libreta para apuntes, disposición para hablar frente al grupo y ropa casual/formal para las sesiones de práctica de discurso.'
        ],
        'Americano' => [
            'descripcion' => 'Únete al equipo y experimenta la intensidad del fútbol americano. Nos enfocaremos en acondicionamiento físico de alto rendimiento, técnicas de tacleo seguro, fundamentos por posición (ofensiva y defensiva), lectura de jugadas y estrategias de emparrillado.',
            'beneficios' => 'Forja una disciplina inquebrantable, desarrolla fuerza física, explosividad, trabajo en equipo y un fuerte sentido de pertenencia (hermandad).',
            'requisitos' => 'Ropa deportiva resistente, tachones (cleats), agua en abundancia. El equipo de protección (casco, utilería) se coordinará con el coach.'
        ],
        'Básquetbol' => [
            'descripcion' => 'Domina la duela. Entrenaremos fundamentos técnicos como el drible, pases, mecánica de tiro, rebotes y movimientos de pies. Además, trabajaremos en sistemas tácticos de defensa (zona y personal) y transiciones ofensivas rápidas para competir a nivel universitario.',
            'beneficios' => 'Mejora tu resistencia cardiovascular, agilidad, coordinación ojo-mano y fomenta la comunicación rápida y efectiva en equipo.',
            'requisitos' => 'Shorts deportivos, jersey o playera sin mangas, tenis específicos para básquetbol (para evitar lesiones en tobillos) y toalla.'
        ],
        'Fútbol' => [
            'descripcion' => 'El deporte más popular del mundo llevado al nivel competitivo universitario. Las sesiones incluyen preparación física, circuitos de técnica individual (control, pase, conducción, tiro) y táctica colectiva. Ya sea fútbol asociación (11) o rápido, te prepararás para representar a la institución.',
            'beneficios' => 'Aumenta la resistencia aeróbica, mejora la salud cardiovascular, reduce la ansiedad y fortalece el trabajo colaborativo.',
            'requisitos' => 'Ropa deportiva, espinilleras, tachones o tenis de fútbol rápido (según la superficie) e hidratación.'
        ],
        'Música' => [
            'descripcion' => 'Un espacio para la creación sonora. Dependiendo de tu instrumento o si te enfocas en el canto, aprenderás teoría musical básica, solfeo, ritmo y ensamble. El objetivo es formar grupos musicales o coros que representen a la universidad en eventos culturales.',
            'beneficios' => 'Desarrolla el oído musical, mejora la coordinación motriz, fomenta la memoria y ofrece una poderosa forma de expresión emocional.',
            'requisitos' => 'Instrumento propio (guitarra, bajo, teclado, etc.) si aplica, libreta pautada y afinador.'
        ],
        'Taekwondo' => [
            'descripcion' => 'Arte marcial coreano enfocado en la disciplina y las técnicas de pateo. Practicaremos formas (Poomsae), combate deportivo (Kyorugi), defensa personal y acondicionamiento físico orientado a la flexibilidad y la potencia.',
            'beneficios' => 'Otorga una excelente condición física, flexibilidad, reflejos rápidos, autocontrol, respeto y técnicas efectivas de defensa personal.',
            'requisitos' => 'Ropa deportiva holgada o Dobok (uniforme oficial), botella de agua y toalla pequeña.'
        ],
        'Baile' => [
            'descripcion' => 'Explora diferentes ritmos y estilos de danza. Desde ritmos latinos hasta danza moderna, nos enfocaremos en la coordinación, el aislamiento corporal, el conteo musical y el montaje de coreografías enérgicas. Ideal para despejar la mente después de clases.',
            'beneficios' => 'Quema calorías de forma divertida, mejora la coordinación motriz, la memoria coreográfica y eleva tu estado de ánimo.',
            'requisitos' => 'Ropa muy elástica y cómoda, tenis ligeros y excelente actitud.'
        ],
        'Voleibol' => [
            'descripcion' => 'Deporte de alta explosividad y reflejos. Entrenaremos técnica de voleo, golpe bajo, saque, remate y bloqueo. Aprenderás las rotaciones y sistemas defensivos/ofensivos para jugar fluidamente en la red.',
            'beneficios' => 'Tonifica el tren inferior y superior, mejora la capacidad de reacción, la agilidad y fomenta un nivel altísimo de comunicación grupal.',
            'requisitos' => 'Ropa deportiva (short/licras), tenis con buena amortiguación, rodilleras (muy recomendadas) y agua.'
        ]
    ];

    // Buscamos si el nombre del evento contiene alguna de nuestras palabras clave
    $infoExtra = [
        'descripcion' => $evento->descripcion, // Por defecto, usa la de tu base de datos
        'beneficios' => 'Fomenta el trabajo en equipo, reduce el estrés, mejora tu salud y complementa tu formación integral universitaria.',
        'requisitos' => 'Disposición, compromiso de asistencia y ropa adecuada para la actividad.'
    ];

    foreach($detallesExtra as $clave => $datos) {
        if(stripos($evento->nombre, $clave) !== false) {
            $infoExtra = $datos;
            break; // Si encuentra coincidencia, se detiene y usa esos datos
        }
    }
@endphp

<style>
    .event-header-image { 
        width: 100%; 
        max-width: 100%;
        aspect-ratio: 21 / 9; /* Proporción panorámica perfecta */
        border-radius: 16px; 
        overflow: hidden; 
        margin-bottom: 2.5rem; 
        box-shadow: var(--shadow-card); 
        background: #f4f4f4;
    }
    .event-header-image img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        object-position: center; /* Centra la imagen para que no corte cabezas */
        transition: transform 0.5s ease; 
    }
    .event-header-image:hover img { 
        transform: scale(1.02); 
    }
    
    .event-detail-container { 
        display: grid; 
        grid-template-columns: 2fr 1fr; 
        gap: 40px; 
        background: var(--color-uttec-white); 
        border-radius: 16px; 
        padding: 3rem; 
        box-shadow: var(--shadow-card); 
        width: 100%; 
    }
    
    .detail-main-content { padding-right: 2rem; border-right: 1px solid rgba(0, 45, 98, 0.1); }
    .detail-main-content h1 { font-size: 3rem; font-weight: 800; color: var(--color-uttec-blue-dark); margin-bottom: 0.5rem; line-height: 1.2; }
    .detail-category-tag { display: inline-block; background: var(--color-uttec-green); color: var(--color-uttec-white); padding: 0.4rem 1.5rem; border-radius: 50px; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 1px; font-size: 0.9rem; }
    
    .detail-section { margin-top: 2.5rem; }
    .detail-section h3 { font-size: 1.4rem; font-weight: 700; color: var(--color-uttec-blue-dark); border-bottom: 2px solid rgba(0, 168, 107, 0.3); padding-bottom: 0.5rem; margin-bottom: 1.2rem; display: flex; align-items: center; gap: 10px; }
    .detail-section p { font-size: 1.05rem; color: var(--color-text-light); line-height: 1.8; text-align: justify; }
    
    .info-card { background: rgba(0, 45, 98, 0.03); border-left: 4px solid var(--color-accent-blue); padding: 1.5rem; border-radius: 0 8px 8px 0; margin-bottom: 1.5rem; }
    .info-card strong { color: var(--color-uttec-blue-dark); display: block; margin-bottom: 5px; font-size: 1.1rem; }
    
    .sidebar-box { background: var(--color-footer-bg); border-radius: 12px; padding: 1.8rem; border: 1px solid rgba(0, 45, 98, 0.08); margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
    .sidebar-box h4 { font-size: 1.2rem; color: var(--color-uttec-blue-dark); margin-bottom: 1.2rem; font-weight: 700; display: flex; align-items: center; gap: 8px; border-bottom: 1px dashed #ccc; padding-bottom: 10px;}
    .sidebar-box p { margin-bottom: 0.8rem; font-size: 0.95rem; color: var(--color-text-light); display: flex; align-items: center; gap: 10px;}
    .sidebar-box p i { color: var(--color-uttec-green); width: 16px; height: 16px; }
    
    .action-button { font-weight: 700; padding: 1rem; border-radius: 8px; transition: all 0.3s ease; display: flex; justify-content: center; align-items: center; gap: 8px; cursor: pointer; border: none; width: 100%; font-size: 1.1rem; color: white; text-transform: uppercase; letter-spacing: 0.5px; }
    .inscrito-btn { background: var(--color-uttec-green); box-shadow: 0 5px 15px rgba(0, 168, 107, 0.3); }
    .inscrito-btn:hover { background: var(--color-uttec-blue-dark); transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 45, 98, 0.3); }
    .cancelar-btn { background: var(--color-accent-red); box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3); }
    .cancelar-btn:hover { background: #c0392b; transform: translateY(-2px); }
    
    .cupos-display { text-align: center; padding: 1rem 0; border-radius: 8px; margin-top: 1rem; font-size: 1rem; font-weight: 700; background: rgba(0, 168, 107, 0.1); color: var(--color-uttec-green); border: 1px solid rgba(0, 168, 107, 0.2); }
    .cupos-display span { display: block; font-size: 2.2rem; font-weight: 800; line-height: 1; margin-top: 5px; }

    @media (max-width: 1024px) {
        .event-detail-container { grid-template-columns: 1fr; padding: 1.5rem; }
        .detail-main-content { padding-right: 0; border-right: none; padding-bottom: 2rem; }
        .event-header-image { aspect-ratio: 16 / 9; }
    }
</style>

<div class="mb-4">
    <a href="{{ route('estudiante.eventos.index') }}" style="color:var(--color-uttec-blue-dark); font-weight:600; display:inline-flex; align-items:center; gap:5px; transition: color 0.3s ease;" onmouseover="this.style.color='var(--color-uttec-green)'" onmouseout="this.style.color='var(--color-uttec-blue-dark)'">
        <i data-feather="arrow-left" style="width:18px;"></i> Regresar a la agenda
    </a>
</div>

<div class="event-detail-container">
    <div class="detail-main-content">
        
        {{-- IMAGEN PERFECTAMENTE PROPORCIONADA --}}
        <div class="event-header-image">
            <img src="{{ asset($imagePath) }}" alt="{{ $evento->nombre }}" onerror="this.src='{{ asset('imagenes/uttec.jpeg') }}'">
        </div>

        <span class="detail-category-tag">{{ $evento->categoria }}</span>
        <h1>{{ $evento->nombre }}</h1>
        
        <div class="detail-section">
            <h3><i data-feather="info"></i> ¿De qué trata?</h3>
            {{-- Aquí inyectamos la descripción larga de nuestro diccionario --}}
            <p>{{ $infoExtra['descripcion'] }}</p>
        </div>

        <div class="detail-section">
            <h3><i data-feather="star"></i> ¿Por qué inscribirte?</h3>
            <div class="info-card">
                <strong>Beneficios de esta actividad:</strong>
                <p>{{ $infoExtra['beneficios'] }}</p>
            </div>
        </div>

        <div class="detail-section">
            <h3><i data-feather="check-circle"></i> Lo que necesitas</h3>
            <div class="info-card" style="border-left-color: var(--color-uttec-green); background: rgba(0, 168, 107, 0.03);">
                <strong>Requisitos e Indumentaria:</strong>
                <p>{{ $infoExtra['requisitos'] }}</p>
            </div>
        </div>
    </div>

    <div class="detail-sidebar">
        <div class="sidebar-box">
            <h4><i data-feather="calendar" class="feather"></i> Detalles de Agenda</h4>
            <p><i data-feather="sun"></i> <strong>Días:</strong> {{ $evento->dias ?? 'Consultar horario' }}</p>
            <p><i data-feather="clock"></i> <strong>Horario:</strong> {{ $evento->horario ?? 'No definido' }}</p>
            <p><i data-feather="flag"></i> <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M Y') }}</p>
            <p><i data-feather="map-pin"></i> <strong>Lugar:</strong> {{ $evento->lugar ?? 'Campus UTTEC' }}</p>
            <p><i data-feather="user"></i> <strong>Instructor:</strong> {{ $evento->creador->nombre ?? 'Por asignar' }}</p>
        </div>

        <div class="sidebar-box">
            <h4><i data-feather="users" class="feather"></i> Disponibilidad</h4>
            @php $cuposDisp = $evento->cupo_disponible ?? $evento->cupos; @endphp

            <div class="cupos-display" style="{{ $cuposDisp <= 0 ? 'background: rgba(231,76,60,0.1); color: var(--color-accent-red); border-color: rgba(231,76,60,0.3);' : '' }}">
                Cupos Disponibles: <span>{{ $cuposDisp }}</span>
            </div>

            <div style="margin-top: 1.5rem;">
                @if (isset($estaInscrito) && $estaInscrito)
                    <form action="{{ route('estudiante.inscripciones.destroy', $evento->id_evento) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="action-button cancelar-btn"><i data-feather="x-circle"></i> Cancelar Inscripción</button>
                    </form>
                    <p style="text-align:center; margin-top:10px; font-weight:600; font-size:0.9rem; color:var(--color-uttec-blue-dark);">¡Ya estás inscrito a esta actividad!</p>
                @else
                    @if ($cuposDisp > 0)
                        <form action="{{ route('estudiante.inscripciones.store', $evento->id_evento) }}" method="POST">
                            @csrf
                            <button type="submit" class="action-button inscrito-btn"><i data-feather="plus"></i> Asegurar mi lugar</button>
                        </form>
                    @else
                        <button class="action-button" style="background:#ccc; cursor:not-allowed;" disabled><i data-feather="slash"></i> Agotado</button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
