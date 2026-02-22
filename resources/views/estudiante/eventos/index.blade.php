@extends('layouts.estudiante')
@section('title', 'Eventos y Talleres')

@section('content')
<style>
    .events-header { margin-bottom: 3rem; padding-bottom: 1rem; border-bottom: 3px solid var(--color-uttec-green); display: flex; justify-content: space-between; align-items: center; }
    .events-header h2 { font-size: 2.5rem; font-weight: 800; color: var(--color-uttec-blue-dark); display: flex; align-items: center; gap: 15px; }
    .events-header h2 i { color: var(--color-uttec-green); }
    .mis-inscripciones-btn { background: var(--color-uttec-green); color: var(--color-uttec-white); padding: 0.8rem 1.6rem; border-radius: 8px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease; }
    .mis-inscripciones-btn:hover { background: var(--color-uttec-blue-dark); transform: translateY(-2px); }
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
</style>

<div class="events-header">
    <h2><i data-feather="calendar" class="feather"></i> Agenda de Actividades</h2>
    <a href="#" class="mis-inscripciones-btn"><i data-feather="bookmark" class="feather"></i> Mis Inscripciones</a>
</div>

<div class="events-grid">
    @forelse ($eventos as $evento)
        @php
        $imageMap = [ 
            'Oratoria y Dibujo' => 'imagenes/dibujo.jpg', 'Dibujo' => 'imagenes/dibujo.jpg', 
            'Teatro' => 'imagenes/teatro.jpg', 'Ajedrez' => 'imagenes/ajedrez.jpg',
            'Fútbol Americano' => 'imagenes/americano.jpg', 'Americano' => 'imagenes/americano.jpg',
            'Baile' => 'imagenes/baile.jpg', 'Danza' => 'imagenes/baile.jpg',
            'Básquetbol' => 'imagenes/basquet.jpg', 'Basquetbol' => 'imagenes/basquet.jpg',
            'Fútbol Rápido' => 'imagenes/frapido.jpg', 'Futbol Rapido' => 'imagenes/frapido.jpg',
            'Fútbol' => 'imagenes/futbol.jpg', 'Futbol' => 'imagenes/futbol.jpg', 'Soccer' => 'imagenes/soccer.jpg',
            'Música' => 'imagenes/musica.jpg', 'Musica' => 'imagenes/musica.jpg',
            'Taekwondo' => 'imagenes/taekwdo.jpg', 'Voleibol' => 'imagenes/volei.jpg'
        ];
        $imagePath = $imageMap[$evento->nombre] ?? 'imagenes/uttec.jpeg'; 
            
            $inscritoEventIds = $inscritoEventIds ?? [];
            $isEnrolled = in_array($evento->id_evento, $inscritoEventIds);
        @endphp

        <a href="{{ route('estudiante.eventos.show', $evento->id_evento) }}" class="event-card-tilt">
            <div class="event-image-wrapper">
                <span class="event-category-tag">{{ $evento->categoria }}</span>
                <img src="{{ asset($imagePath) }}" alt="{{ $evento->nombre }}" class="event-image" onerror="this.src='{{ asset('imagenes/uttec.jpeg') }}'">
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
                        <span class="action-link" style="background:transparent; color:var(--color-uttec-green); border:1px solid var(--color-uttec-green);"><i data-feather="check-circle"></i> Inscrito</span>
                    @else
                        <span class="action-link"><i data-feather="plus"></i> Inscribirse</span>
                    @endif
                    <strong style="color:var(--color-uttec-blue-dark); font-size:0.9rem;">Cupos: <span style="color:var(--color-uttec-green);">{{ $evento->cupo_disponible ?? $evento->cupos }}</span></strong>
                </div>
            </div>
        </a>
    @empty
        <p style="grid-column: 1/-1; text-align:center; color:#777; font-size:1.1rem;">No hay eventos disponibles en este momento.</p>
    @endforelse
</div>
@endsection
