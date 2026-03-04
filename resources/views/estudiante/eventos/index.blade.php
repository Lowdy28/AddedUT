@extends('layouts.estudiante')
@section('title', 'Eventos y Talleres')

@section('content')
<style>
    .events-header { margin-bottom: 3rem; padding-bottom: 1rem; border-bottom: 3px solid var(--color-uttec-green); display: flex; justify-content: space-between; align-items: center; }
    .events-header h2 { font-size: 2.5rem; font-weight: 800; color: var(--color-uttec-blue-dark); display: flex; align-items: center; gap: 15px; }
    .events-header h2 i { color: var(--color-uttec-green); }
    .events-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 2.5rem; }
    .event-card-tilt { display: flex; flex-direction: column; min-height: 450px; border-radius: 16px; overflow: hidden; background: var(--color-uttec-white); box-shadow: var(--shadow-card); transition: transform 0.4s ease; }
    .event-card-tilt:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(0, 45, 98, 0.25); }
    .event-image-wrapper { height: 200px; overflow: hidden; position: relative; background: #f4f4f4; }
    .event-image { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .event-card-tilt:hover .event-image { transform: scale(1.1); }
    .event-category-tag { position: absolute; top: 15px; left: 15px; background: var(--color-uttec-blue-dark); color: white; padding: 0.4rem 1rem; border-radius: 4px; font-weight: 700; z-index: 5; font-size: 0.8rem; text-transform: uppercase; box-shadow: 0 2px 10px rgba(0,0,0,0.2); }
    .event-details { padding: 1.5rem; display: flex; flex-direction: column; flex-grow: 1; }
    .event-details h3 { font-size: 1.6rem; color: var(--color-uttec-blue-dark); font-weight: 700; margin-bottom: 0.5rem; }
    .meta { font-size: 0.9rem; color: #666; margin-bottom: 1rem; display: flex; gap: 15px; font-weight: 500; }
    .meta span { display: flex; align-items: center; gap: 5px; }
    .meta .feather { width: 16px; height: 16px; color: var(--color-uttec-green); }
    .event-desc { color: #555; font-size: 0.95rem; margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .action-button-group { margin-top: auto; border-top: 1px dashed rgba(0,0,0,0.1); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center; }
    .action-link { background: var(--color-uttec-green); color: white; padding: 0.6rem 1.2rem; border-radius: 50px; font-weight: 700; display: inline-flex; align-items: center; gap: 5px; font-size: 0.9rem; }

    /* ── Lechuza ── */
    .owl-mascot-wrap { display: flex; flex-direction: column; align-items: center; gap: 4px; cursor: default; user-select: none; }
    .owl-mascot-wrap svg { width: 90px; height: 158px; filter: drop-shadow(0 4px 10px rgba(0,45,98,0.2)); transition: transform 0.3s ease; }
    .owl-mascot-wrap:hover svg { transform: scale(1.12) rotate(-5deg); }
    .owl-label { font-size: 0.72rem; font-weight: 700; color: var(--color-uttec-blue-dark); letter-spacing: 0.5px; text-transform: uppercase; opacity: 0.7; }
    .owl-eye-l, .owl-eye-r { transform-origin: center; animation: blink 4s infinite; }
    .owl-eye-r { animation-delay: 0.08s; }
    @keyframes blink { 0%, 92%, 100% { transform: scaleY(1); } 94%, 98% { transform: scaleY(0.08); } }
    .owl-body { animation: owlFloat 3s ease-in-out infinite; transform-origin: center bottom; }
    @keyframes owlFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
    .owl-wing-l { transform-origin: 30% 50%; animation: wingL 3s ease-in-out infinite; }
    .owl-wing-r { transform-origin: 70% 50%; animation: wingR 3s ease-in-out infinite; }
    @keyframes wingL { 0%, 100% { transform: rotate(0deg); } 50% { transform: rotate(-8deg); } }
    @keyframes wingR { 0%, 100% { transform: rotate(0deg); } 50% { transform: rotate(8deg); } }
</style>

<div class="events-header">
    <h2><i data-feather="calendar" class="feather"></i> Agenda de Actividades</h2>

    <div class="owl-mascot-wrap" title="¡Hola! Soy Tecky, la mascota de UTTEC 🦉">
        <svg viewBox="0 0 160 280" xmlns="http://www.w3.org/2000/svg" fill="none">

    <!-- ── Sombra suave en el suelo ── -->
    <ellipse cx="80" cy="272" rx="35" ry="7" fill="rgba(0,0,0,0.15)"/>

    <!-- ══════════════════════════════
         PIERNAS Y TENIS
    ══════════════════════════════ -->
    <!-- Pierna izquierda (pantalón negro) -->
    <rect x="52" y="190" width="26" height="55" rx="8" fill="#1a1a2e"/>
    <!-- Pierna derecha -->
    <rect x="82" y="190" width="26" height="55" rx="8" fill="#1a1a2e"/>

    <!-- Tenis izquierdo -->
    <ellipse cx="62" cy="248" rx="20" ry="10" fill="#e8e8e8"/>
    <ellipse cx="62" cy="248" rx="20" ry="10" fill="none" stroke="#ccc" stroke-width="1"/>
    <rect x="44" y="240" width="36" height="10" rx="5" fill="#d0d0d0"/>
    <rect x="46" y="238" width="32" height="8" rx="4" fill="#e8e8e8"/>
    <!-- Cordones izquierdo -->
    <line x1="54" y1="239" x2="56" y2="244" stroke="#aaa" stroke-width="1.5"/>
    <line x1="60" y1="239" x2="62" y2="244" stroke="#aaa" stroke-width="1.5"/>
    <line x1="66" y1="239" x2="68" y2="244" stroke="#aaa" stroke-width="1.5"/>
    <line x1="72" y1="239" x2="70" y2="244" stroke="#aaa" stroke-width="1.5"/>

    <!-- Tenis derecho -->
    <ellipse cx="98" cy="248" rx="20" ry="10" fill="#e8e8e8"/>
    <rect x="80" y="240" width="36" height="10" rx="5" fill="#d0d0d0"/>
    <rect x="82" y="238" width="32" height="8" rx="4" fill="#e8e8e8"/>
    <!-- Cordones derecho -->
    <line x1="90" y1="239" x2="92" y2="244" stroke="#aaa" stroke-width="1.5"/>
    <line x1="96" y1="239" x2="98" y2="244" stroke="#aaa" stroke-width="1.5"/>
    <line x1="102" y1="239" x2="104" y2="244" stroke="#aaa" stroke-width="1.5"/>
    <line x1="108" y1="239" x2="106" y2="244" stroke="#aaa" stroke-width="1.5"/>

    <!-- ══════════════════════════════
         CUERPO (chaqueta azul marino)
    ══════════════════════════════ -->
    <ellipse cx="80" cy="175" rx="42" ry="52" fill="#002D62"/>

    <!-- Pecho blanco central -->
    <ellipse cx="80" cy="178" rx="22" ry="32" fill="#f0f4f8"/>

    <!-- Cremallera / línea central chaqueta -->
    <line x1="80" y1="148" x2="80" y2="200" stroke="#001a40" stroke-width="2"/>

    <!-- Detalle solapa izquierda chaqueta -->
    <path d="M80,148 Q65,155 58,170 Q65,165 80,168 Z" fill="#003580"/>
    <!-- Detalle solapa derecha -->
    <path d="M80,148 Q95,155 102,170 Q95,165 80,168 Z" fill="#003580"/>

    <!-- Símbolo/logo en pecho (pequeño escudo) -->
    <rect x="72" y="162" width="16" height="14" rx="3" fill="#002D62"/>
    <text x="80" y="172" text-anchor="middle" font-size="7" font-weight="bold" fill="white" font-family="Arial">UT</text>

    <!-- ══════════════════════════════
         BRAZO IZQUIERDO (puño cerrado)
    ══════════════════════════════ -->
    <ellipse cx="30" cy="178" rx="14" ry="36" fill="#002D62" transform="rotate(15 30 178)"/>
    <!-- Puño izquierdo (marrón) -->
    <ellipse cx="22" cy="210" rx="13" ry="12" fill="#7B4A1E"/>
    <ellipse cx="22" cy="206" rx="11" ry="7" fill="#8B5520"/>
    <!-- Nudillos -->
    <ellipse cx="16" cy="205" rx="4" ry="3" fill="#6B3A10"/>
    <ellipse cx="22" cy="203" rx="4" ry="3" fill="#6B3A10"/>
    <ellipse cx="28" cy="205" rx="4" ry="3" fill="#6B3A10"/>

    <!-- ══════════════════════════════
         BRAZO DERECHO (pulgar arriba)
    ══════════════════════════════ -->
    <ellipse cx="130" cy="165" rx="14" ry="36" fill="#002D62" transform="rotate(-20 130 165)"/>

    <!-- Mano derecha con pulgar arriba -->
    <!-- Mano base (marrón) -->
    <ellipse cx="138" cy="140" rx="14" ry="13" fill="#7B4A1E"/>
    <!-- Dedos cerrados -->
    <rect x="126" y="136" width="24" height="14" rx="6" fill="#8B5520"/>
    <!-- Nudillos dedos -->
    <ellipse cx="130" cy="135" rx="3.5" ry="2.5" fill="#6B3A10"/>
    <ellipse cx="137" cy="133" rx="3.5" ry="2.5" fill="#6B3A10"/>
    <ellipse cx="144" cy="135" rx="3.5" ry="2.5" fill="#6B3A10"/>
    <!-- Pulgar apuntando arriba -->
    <ellipse cx="148" cy="127" rx="6" ry="14" fill="#8B5520" transform="rotate(10 148 127)"/>
    <ellipse cx="149" cy="120" rx="5" ry="6" fill="#9B6530"/>
    <!-- Uña del pulgar -->
    <ellipse cx="149" cy="117" rx="3" ry="4" fill="#c49060" opacity="0.6"/>

    <!-- ══════════════════════════════
         CABEZA
    ══════════════════════════════ -->
    <!-- Base cabeza marrón -->
    <ellipse cx="80" cy="88" rx="40" ry="44" fill="#8B5520"/>

    <!-- Plumas frente (marrón oscuro textura) -->
    <ellipse cx="80" cy="72" rx="32" ry="22" fill="#7B4010"/>
    <ellipse cx="65" cy="75" rx="12" ry="14" fill="#7B4010"/>
    <ellipse cx="95" cy="75" rx="12" ry="14" fill="#7B4010"/>

    <!-- Cara / disco facial (beige claro) -->
    <ellipse cx="80" cy="95" rx="28" ry="26" fill="#D4956A"/>

    <!-- Cejas expresivas marrón oscuro -->
    <path d="M56,75 Q65,68 74,73" stroke="#3d1f00" stroke-width="4" stroke-linecap="round" fill="none"/>
    <path d="M86,73 Q95,68 104,75" stroke="#3d1f00" stroke-width="4" stroke-linecap="round" fill="none"/>

    <!-- ── Ojo izquierdo ── -->
    <circle cx="65" cy="88" r="13" fill="white"/>
    <circle cx="65" cy="88" r="10" fill="#c8a800"/>
    <circle cx="65" cy="88" r="6" fill="#2d5a00"/>
    <circle cx="65" cy="88" r="3.5" fill="#0a1a00"/>
    <circle cx="67" cy="86" r="1.5" fill="white"/>
    <!-- Reflejo -->
    <circle cx="62" cy="90" r="0.8" fill="white" opacity="0.6"/>

    <!-- ── Ojo derecho ── -->
    <circle cx="95" cy="88" r="13" fill="white"/>
    <circle cx="95" cy="88" r="10" fill="#c8a800"/>
    <circle cx="95" cy="88" r="6" fill="#2d5a00"/>
    <circle cx="95" cy="88" r="3.5" fill="#0a1a00"/>
    <circle cx="97" cy="86" r="1.5" fill="white"/>
    <circle cx="92" cy="90" r="0.8" fill="white" opacity="0.6"/>

    <!-- Pico -->
    <polygon points="80,102 72,114 88,114" fill="#e8a020"/>
    <line x1="72" y1="109" x2="88" y2="109" stroke="#c07010" stroke-width="1.5"/>

    <!-- Penachos / orejas de búho -->
    <polygon points="52,52 44,28 62,46" fill="#7B4010"/>
    <polygon points="52,52 46,32 60,48" fill="#9B5520"/>
    <polygon points="108,52 116,28 98,46" fill="#7B4010"/>
    <polygon points="108,52 114,32 100,48" fill="#9B5520"/>

    <!-- ══════════════════════════════
         ANIMACIONES CSS inline
    ══════════════════════════════ -->
    <style>
        .mascot-body-group {
            animation: mascotFloat 3s ease-in-out infinite;
            transform-origin: 80px 260px;
        }
        @keyframes mascotFloat {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-6px); }
        }
        .mascot-thumb {
            transform-origin: 148px 130px;
            animation: thumbUp 2.5s ease-in-out infinite;
        }
        @keyframes thumbUp {
            0%, 100% { transform: rotate(0deg); }
            50%       { transform: rotate(-8deg); }
        }
        .mascot-eye-l, .mascot-eye-r {
            transform-origin: center;
            animation: owlBlink 5s infinite;
        }
        .mascot-eye-r { animation-delay: 0.1s; }
        @keyframes owlBlink {
            0%, 88%, 100% { transform: scaleY(1); }
            92%, 96%      { transform: scaleY(0.05); }
        }
    </style>

</svg>
        <span class="owl-label">Tecky UTTEC</span>
    </div>
</div>

<div class="events-grid">
    @forelse ($eventos as $evento)
        @php
            $imagenUrl = $evento->imagen_url;
            $inscritoEventIds = $inscritoEventIds ?? [];
            $isEnrolled = in_array($evento->id_evento, $inscritoEventIds);
        @endphp

        <a href="{{ route('estudiante.eventos.show', $evento->id_evento) }}" class="event-card-tilt">
            <div class="event-image-wrapper">
                <span class="event-category-tag">{{ $evento->categoria }}</span>
                <img src="{{ $imagenUrl }}" alt="{{ $evento->nombre }}" class="event-image" onerror="this.src='{{ asset('imagenes/uttec.jpeg') }}'">
            </div>

            <div class="event-details">
                <h3>{{ $evento->nombre }}</h3>
                <div class="meta">
                    <span><i data-feather="clock"></i> {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M Y') }}</span>
                    <span><i data-feather="map-pin"></i> {{ $evento->lugar ?? 'Campus UTTEC' }}</span>
                </div>
                <p class="event-desc">{{ $evento->descripcion }}</p>

                <div class="action-button-group">
                    @if ($isEnrolled)
                        <span class="action-link" style="background:transparent; color:var(--color-uttec-green); border:1px solid var(--color-uttec-green);">
                            <i data-feather="check-circle"></i> Inscrito
                        </span>
                    @else
                        <span class="action-link"><i data-feather="plus"></i> Inscribirse</span>
                    @endif
                    <strong style="color:var(--color-uttec-blue-dark); font-size:0.9rem;">
                        Cupos: <span style="color:var(--color-uttec-green);">{{ $evento->cupo_disponible ?? $evento->cupos }}</span>
                    </strong>
                </div>
            </div>
        </a>
    @empty
        <p style="grid-column: 1/-1; text-align:center; color:#777; font-size:1.1rem;">No hay eventos disponibles en este momento.</p>
    @endforelse
</div>

<script>
    if (typeof feather !== 'undefined') feather.replace();
</script>
@endsection
