@extends('layouts.admin')

@section('title', 'Notificaciones')

@section('content')
<div class="main">
    <div style="max-width: 800px; margin: 0 auto;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: #fff;">🔔 Notificaciones</h2>
            @if($notificaciones->total() > 0)
                <form method="POST" action="{{ route('notificaciones.markAllRead') }}">
                    @csrf
                    <button type="submit" style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 6px 14px; border-radius: 8px; cursor: pointer; font-size: 0.85rem;">
                        Marcar todas como leídas
                    </button>
                </form>
            @endif
        </div>

        @if($notificaciones->isEmpty())
            <div style="background: rgba(255,255,255,0.1); border-radius: 12px; padding: 40px; text-align: center; color: rgba(255,255,255,0.7);">
                <div style="font-size: 2rem; margin-bottom: 10px;">🔕</div>
                No tienes notificaciones por ahora.
            </div>
        @else
            @foreach($notificaciones as $notif)
                @php
                    $tipo  = $notif->data['tipo'] ?? 'info';
                    $leida = !is_null($notif->read_at);
                    $icono = match($tipo) {
                        'inscripcion'       => '✅',
                        'baja'              => '❌',
                        'like'              => '❤️',
                        'cambio'            => '🕐',
                        'cupos_disponibles' => '🟢',
                        'sin_cupos'         => '🔴',
                        'noticia'           => '📰',
                        default             => '🔔',
                    };
                @endphp
                <div style="background: {{ $leida ? 'rgba(255,255,255,0.06)' : 'rgba(255,255,255,0.15)' }}; border-left: 4px solid {{ $leida ? 'rgba(255,255,255,0.2)' : '#00A86B' }}; border-radius: 10px; padding: 14px 18px; margin-bottom: 10px; display: flex; gap: 14px; align-items: flex-start;">
                    <div style="font-size: 1.3rem; margin-top: 2px;">{{ $icono }}</div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; font-size: 0.9rem; color: #fff; margin-bottom: 3px;">
                            {{ $notif->data['titulo'] ?? 'Sin título' }}
                        </div>
                        <div style="font-size: 0.82rem; color: rgba(255,255,255,0.75);">
                            {{ $notif->data['mensaje'] ?? '' }}
                        </div>
                        <div style="font-size: 0.72rem; color: rgba(255,255,255,0.45); margin-top: 5px;">
                            {{ $notif->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if(!$leida)
                        <span style="background: #00A86B; color: white; font-size: 0.65rem; padding: 2px 8px; border-radius: 20px; font-weight: 700; white-space: nowrap;">
                            NUEVA
                        </span>
                    @endif
                </div>
            @endforeach

            <div style="margin-top: 1rem;">
                {{ $notificaciones->links() }}
            </div>
        @endif
    </div>
</div>
@endsection