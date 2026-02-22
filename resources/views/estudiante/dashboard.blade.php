@extends('layouts.estudiante')
@section('title', 'Dashboard Estudiante')

@section('content')

{{-- ESTILOS EXCLUSIVOS DEL DASHBOARD Y LAS TARJETAS --}}
<style>
    .dashboard-welcome { margin-bottom: 2rem; }
    .dashboard-welcome h1 { font-size: 2.2rem; color: var(--color-uttec-blue-dark); font-weight: 800; display: flex; align-items: center; gap: 10px; }
    .dashboard-welcome p { color: var(--color-text-light); font-size: 1.1rem; }
    
    .events-header { margin-bottom: 3rem; padding-bottom: 1rem; border-bottom: 3px solid var(--color-uttec-green); display: flex; justify-content: space-between; align-items: center; }
    .events-header h2 { font-size: 2.5rem; font-weight: 800; color: var(--color-uttec-blue-dark); display: flex; align-items: center; gap: 15px; }
    .events-header h2 i { color: var(--color-uttec-green); }
    
    .mis-inscripciones-btn { background: var(--color-uttec-green); border: 1px solid var(--color-uttec-green); color: var(--color-uttec-white); padding: 0.8rem 1.6rem; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 5px 15px rgba(0, 168, 107, 0.4); }
    .mis-inscripciones-btn:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(0, 168, 107, 0.6); background: var(--color-uttec-blue-dark); border-color: var(--color-uttec-blue-dark); }
    
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
</style>

<div class="dashboard-welcome">
    <h1>¡Bienvenido, {{ Auth::user()->name ?? 'Aldo' }}! 🎉</h1>
    <p>Descubre eventos, inscríbete y gestiona tu aprendizaje con estilo.</p>
</div>

<div class="events-header">
    <h2><i data-feather="calendar" class="feather"></i> Agenda de Actividades Extracurriculares</h2>
    <a href="#" class="mis-inscripciones-btn">
        <i data-feather="bookmark" class="feather"></i> Mis Inscripciones
    </a>
</div>

<div class="events-grid">
    @forelse ($eventos as $evento)
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
            $inscritoEventIds = $inscritoEventIds ?? [];
            $isEnrolled = in_array($evento->id_evento, $inscritoEventIds);
        @endphp

        <a href="{{ route('estudiante.eventos.show', $evento->id_evento) }}" class="event-card-tilt">
            <div class="event-image-wrapper">
                <span class="event-category-tag">{{ $evento->categoria }}</span>
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
