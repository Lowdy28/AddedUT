@extends('layouts.admin')

@section('content')

    <h1 style="font-size:1.6rem; font-weight:800; margin-bottom:1rem; color: #eaf4ff;">Panel de Control</h1>

    <div style="display:grid; grid-template-columns: repeat(1,1fr); gap:1rem;">
        <!-- en Desktop usaremos 3 columnas: -->
        <div style="display:grid; grid-template-columns: repeat(3,1fr); gap:1rem;">
            <div class="card">
                <h3>Usuarios</h3>
                <div class="big" style="color: var(--amarillo)">{{ $usuarios ?? 0 }}</div>
            </div>

            <div class="card">
                <h3>Talleres</h3>
                <div class="big" style="color: #9be7ff">{{ $eventos ?? 0 }}</div>
            </div>

            <div class="card">
                <h3>Inscripciones</h3>
                <div class="big" style="color: #aef48b">{{ $inscripciones ?? 0 }}</div>
            </div>
        </div>

        <!-- actividad reciente -->
        <div class="card" style="margin-top:.5rem;">
            <h3>Actividad reciente</h3>
            <ul style="margin-top:.6rem; list-style:none; padding-left:0;">
                @foreach($eventosRecientes ?? [] as $ev)
                    <li style="padding:.6rem 0; border-bottom:1px solid rgba(255,255,255,0.03);">
                        <strong style="color:#fff;">{{ $ev->nombre_evento ?? $ev->nombre ?? 'Evento' }}</strong>
                        <div style="font-size:.85rem; opacity:.9;">{{ \Carbon\Carbon::parse($ev->fecha_inicio ?? now())->format('d M, Y') }}</div>
                    </li>
                @endforeach
                @if(empty($eventosRecientes) || count($eventosRecientes) === 0)
                    <li style="padding:.6rem 0; color:rgba(255,255,255,0.85)">Sin eventos recientes</li>
                @endif
            </ul>
        </div>
    </div>

@endsection
