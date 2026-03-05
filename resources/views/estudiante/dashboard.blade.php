@extends('layouts.estudiante')
@section('title', 'Dashboard Estudiante')

@section('content')

<style>
    .dashboard-welcome { margin-bottom: 2rem; }
    .dashboard-welcome h1 { font-size: 2.2rem; color: var(--color-uttec-blue-dark); font-weight: 800; display: flex; align-items: center; gap: 10px; }
    .dashboard-welcome p { color: var(--color-text-light); font-size: 1.1rem; }

    .events-header { margin-bottom: 3rem; padding-bottom: 1rem; border-bottom: 3px solid var(--color-uttec-green); display: flex; justify-content: space-between; align-items: center; }
    .events-header h2 { font-size: 2.5rem; font-weight: 800; color: var(--color-uttec-blue-dark); display: flex; align-items: center; gap: 15px; }
    .events-header h2 i { color: var(--color-uttec-green); }

    .events-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; }

    .event-card-tilt { display: flex; flex-direction: column; min-height: 450px; border-radius: 16px; overflow: hidden; background: var(--color-uttec-white); border: 1px solid rgba(0, 45, 98, 0.05); box-shadow: var(--shadow-card); transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1); transform-style: preserve-3d; }
    .event-card-tilt:hover { transform: translateY(-10px) rotateX(2deg) rotateY(-2deg) scale(1.02); box-shadow: 0 25px 50px rgba(0, 45, 98, 0.25); }
    .event-image-wrapper { height: 200px; overflow: hidden; position: relative; }
    .event-image { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.85); transition: transform 0.5s ease; }
    .event-card-tilt:hover .event-image { transform: scale(1.1); filter: brightness(1); }

    .event-category-tag { position: absolute; top: 20px; left: 20px; background: var(--color-uttec-blue-dark); color: var(--color-uttec-white); padding: 0.4rem 1rem; border-radius: 4px; font-size: 0.8rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; z-index: 5; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); }

    .event-details { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
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

    /* ── Lechuza ── */
    .owl-mascot-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        cursor: default;
        user-select: none;
    }
    .owl-mascot-wrap svg {
        width: 72px;
        height: 72px;
        filter: drop-shadow(0 4px 10px rgba(0,45,98,0.2));
        transition: transform 0.3s ease;
    }
    .owl-mascot-wrap:hover svg {
        transform: scale(1.12) rotate(-5deg);
    }
    .owl-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--color-uttec-blue-dark);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        opacity: 0.7;
    }

    /* Animaciones internas del SVG */
    .owl-eye-l, .owl-eye-r { transform-origin: center; animation: blink 4s infinite; }
    .owl-eye-r { animation-delay: 0.08s; }
    @keyframes blink {
        0%, 92%, 100% { transform: scaleY(1); }
        94%, 98%      { transform: scaleY(0.08); }
    }
    .owl-body { animation: owlFloat 3s ease-in-out infinite; transform-origin: center bottom; }
    @keyframes owlFloat {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-5px); }
    }
    .owl-wing-l { transform-origin: 30% 50%; animation: wingL 3s ease-in-out infinite; }
    .owl-wing-r { transform-origin: 70% 50%; animation: wingR 3s ease-in-out infinite; }
    @keyframes wingL {
        0%, 100% { transform: rotate(0deg); }
        50%       { transform: rotate(-8deg); }
    }
    @keyframes wingR {
        0%, 100% { transform: rotate(0deg); }
        50%       { transform: rotate(8deg); }
    }
</style>

<div class="dashboard-welcome">
    <h1>¡Bienvenido, {{ Auth::user()->nombre ?? Auth::user()->name ?? 'Estudiante' }}! 🎉</h1>
    <p>Descubre eventos, inscríbete y gestiona tu aprendizaje con estilo.</p>
</div>

<div class="events-header">
    <h2><i data-feather="calendar" class="feather"></i> Agenda de Actividades Extracurriculares</h2>

    <div class="owl-mascot-wrap" title="¡Hola! Soy Lechuzo, la mascota de UTTEC 🦉">
        <div class="lec-ring-wrap">
            <div class="lec-ring"></div>
            <div class="lec-ring2"></div>
            <svg viewBox="0 0 160 280" xmlns="http://www.w3.org/2000/svg" fill="none">
                <ellipse cx="80" cy="272" rx="35" ry="7" fill="rgba(0,0,0,0.15)"/>
                <g class="lec-body">
                    <!-- Piernas -->
                    <rect x="52" y="190" width="26" height="55" rx="8" fill="#1a1a2e"/>
                    <rect x="82" y="190" width="26" height="55" rx="8" fill="#1a1a2e"/>
                    <!-- Tenis izq -->
                    <rect x="44" y="240" width="36" height="10" rx="5" fill="#d0d0d0"/>
                    <rect x="46" y="238" width="32" height="8" rx="4" fill="#e8e8e8"/>
                    <line x1="54" y1="239" x2="56" y2="244" stroke="#aaa" stroke-width="1.5"/>
                    <line x1="62" y1="239" x2="62" y2="244" stroke="#aaa" stroke-width="1.5"/>
                    <line x1="70" y1="239" x2="68" y2="244" stroke="#aaa" stroke-width="1.5"/>
                    <!-- Tenis der -->
                    <rect x="80" y="240" width="36" height="10" rx="5" fill="#d0d0d0"/>
                    <rect x="82" y="238" width="32" height="8" rx="4" fill="#e8e8e8"/>
                    <line x1="90" y1="239" x2="92" y2="244" stroke="#aaa" stroke-width="1.5"/>
                    <line x1="98" y1="239" x2="98" y2="244" stroke="#aaa" stroke-width="1.5"/>
                    <line x1="106" y1="239" x2="104" y2="244" stroke="#aaa" stroke-width="1.5"/>
                    <!-- Cuerpo chaqueta -->
                    <ellipse cx="80" cy="175" rx="42" ry="52" fill="#002D62"/>
                    <ellipse cx="80" cy="178" rx="22" ry="32" fill="#f0f4f8"/>
                    <line x1="80" y1="148" x2="80" y2="200" stroke="#001a40" stroke-width="2"/>
                    <path d="M80,148 Q65,155 58,170 Q65,165 80,168 Z" fill="#003580"/>
                    <path d="M80,148 Q95,155 102,170 Q95,165 80,168 Z" fill="#003580"/>
                    <rect x="72" y="162" width="16" height="14" rx="3" fill="#002D62"/>
                    <text x="80" y="172" text-anchor="middle" font-size="7" font-weight="bold" fill="white" font-family="Arial">UT</text>
                    <!-- Brazo izq puño -->
                    <g class="lec-wing-l">
                        <ellipse cx="30" cy="178" rx="14" ry="36" fill="#002D62" transform="rotate(15 30 178)"/>
                        <ellipse cx="22" cy="210" rx="13" ry="12" fill="#7B4A1E"/>
                        <ellipse cx="22" cy="206" rx="11" ry="7" fill="#8B5520"/>
                        <ellipse cx="16" cy="205" rx="4" ry="3" fill="#6B3A10"/>
                        <ellipse cx="22" cy="203" rx="4" ry="3" fill="#6B3A10"/>
                        <ellipse cx="28" cy="205" rx="4" ry="3" fill="#6B3A10"/>
                    </g>
                    <!-- Brazo der pulgar -->
                    <g class="lec-wing-r">
                        <ellipse cx="130" cy="165" rx="14" ry="36" fill="#002D62" transform="rotate(-20 130 165)"/>
                        <ellipse cx="138" cy="140" rx="14" ry="13" fill="#7B4A1E"/>
                        <rect x="126" y="136" width="24" height="14" rx="6" fill="#8B5520"/>
                        <ellipse cx="130" cy="135" rx="3.5" ry="2.5" fill="#6B3A10"/>
                        <ellipse cx="137" cy="133" rx="3.5" ry="2.5" fill="#6B3A10"/>
                        <ellipse cx="144" cy="135" rx="3.5" ry="2.5" fill="#6B3A10"/>
                        <g class="lec-thumb">
                            <ellipse cx="148" cy="127" rx="6" ry="14" fill="#8B5520" transform="rotate(10 148 127)"/>
                            <ellipse cx="149" cy="120" rx="5" ry="6" fill="#9B6530"/>
                            <ellipse cx="149" cy="117" rx="3" ry="4" fill="#c49060" opacity="0.6"/>
                        </g>
                    </g>
                    <!-- Cabeza -->
                    <ellipse cx="80" cy="88" rx="40" ry="44" fill="#8B5520"/>
                    <ellipse cx="80" cy="72" rx="32" ry="22" fill="#7B4010"/>
                    <ellipse cx="65" cy="75" rx="12" ry="14" fill="#7B4010"/>
                    <ellipse cx="95" cy="75" rx="12" ry="14" fill="#7B4010"/>
                    <ellipse cx="80" cy="95" rx="28" ry="26" fill="#D4956A"/>
                    <path d="M56,75 Q65,68 74,73" stroke="#3d1f00" stroke-width="4" stroke-linecap="round" fill="none"/>
                    <path d="M86,73 Q95,68 104,75" stroke="#3d1f00" stroke-width="4" stroke-linecap="round" fill="none"/>
                    <g class="lec-eye-l">
                        <circle cx="65" cy="88" r="13" fill="white"/>
                        <circle cx="65" cy="88" r="10" fill="#c8a800"/>
                        <circle cx="65" cy="88" r="6" fill="#2d5a00"/>
                        <circle cx="65" cy="88" r="3.5" fill="#0a1a00"/>
                        <circle cx="67" cy="86" r="1.5" fill="white"/>
                    </g>
                    <g class="lec-eye-r">
                        <circle cx="95" cy="88" r="13" fill="white"/>
                        <circle cx="95" cy="88" r="10" fill="#c8a800"/>
                        <circle cx="95" cy="88" r="6" fill="#2d5a00"/>
                        <circle cx="95" cy="88" r="3.5" fill="#0a1a00"/>
                        <circle cx="97" cy="86" r="1.5" fill="white"/>
                    </g>
                    <polygon points="80,102 72,114 88,114" fill="#e8a020"/>
                    <line x1="72" y1="109" x2="88" y2="109" stroke="#c07010" stroke-width="1.5"/>
                    <polygon points="52,52 44,28 62,46" fill="#7B4010"/>
                    <polygon points="52,52 46,32 60,48" fill="#9B5520"/>
                    <polygon points="108,52 116,28 98,46" fill="#7B4010"/>
                    <polygon points="108,52 114,32 100,48" fill="#9B5520"/>
                </g>
            </svg>
        </div>
        <span class="owl-label">Lechuzo UTTEC</span>
    </div>
</div>

<div class="events-grid">
    @forelse ($eventos as $evento)
        @php
            // Usar imagen_url del modelo — ya prioriza la imagen subida en storage
            // y solo cae al mapa estático si no hay imagen subida
            $inscritoEventIds = $inscritoEventIds ?? [];
            $isEnrolled = in_array($evento->id_evento, $inscritoEventIds);
        @endphp

        <a href="{{ route('estudiante.eventos.show', $evento->id_evento) }}" class="event-card-tilt">
            <div class="event-image-wrapper">
                <span class="event-category-tag">{{ $evento->categoria }}</span>
                <img src="{{ $evento->imagen_url }}" alt="{{ $evento->nombre }}" class="event-image" onerror="this.src='{{ asset('imagenes/uttec.jpeg') }}'">
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

                    <div class="cupos-info @if($evento->cupo_disponible <= 5 && !$isEnrolled) full @endif">
                        @if($evento->cupo_disponible <= 0 && !$isEnrolled)
                            <i data-feather="alert-triangle" style="color: var(--color-accent-red);"></i> Agotado
                        @else
                            Cupos: <span class="cupos-number">{{ $evento->cupo_disponible }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 12px; border: 1px solid rgba(0,0,0,0.05);">
            <i data-feather="info" style="width: 40px; height: 40px; color: var(--color-uttec-blue-dark); margin-bottom: 1rem;"></i>
            <p style="font-size: 1.1rem; color: #666;">No hay eventos programados en este momento. Vuelve pronto.</p>
        </div>
    @endforelse
</div>

<script>
    if(typeof feather !== 'undefined') {
        feather.replace();
    }
</script>

@endsection
