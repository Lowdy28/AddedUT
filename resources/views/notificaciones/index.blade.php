@extends('layouts.admin')

@section('title', 'Notificaciones')

@section('content')
<div style="max-width:860px; margin:0 auto; padding:2rem 1.5rem;">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 style="font-family:'Inter',sans-serif; font-size:1.6rem; font-weight:800;
                        color:#fff; letter-spacing:-.5px; margin-bottom:.2rem;">
                Notificaciones
            </h1>
            <p style="font-size:.85rem; color:rgba(255,255,255,.45);">
                {{ $notificaciones->total() }} notificacion{{ $notificaciones->total() !== 1 ? 'es' : '' }} en total
            </p>
        </div>

        @php $sinLeer = $notificaciones->getCollection()->filter(fn($n) => is_null($n->read_at))->count(); @endphp
        @if($sinLeer > 0)
        <button onclick="marcarTodasLeidas(this)"
                style="display:inline-flex; align-items:center; gap:.5rem;
                       background:rgba(0,168,107,.15); border:1px solid rgba(0,168,107,.35);
                       color:#5dffc0; padding:.55rem 1.1rem; border-radius:10px;
                       cursor:pointer; font-size:.85rem; font-weight:700;
                       transition:background .2s; font-family:'Inter',sans-serif;"
                onmouseover="this.style.background='rgba(0,168,107,.28)'"
                onmouseout="this.style.background='rgba(0,168,107,.15)'">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"
                 stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Marcar todas como leídas
            <span style="background:rgba(0,168,107,.3); border-radius:50px;
                          padding:.1rem .5rem; font-size:.72rem;">{{ $sinLeer }}</span>
        </button>
        @endif
    </div>

    {{-- Lista --}}
    @if($notificaciones->isEmpty())
        <div style="background:rgba(255,255,255,.05); border:1px dashed rgba(255,255,255,.15);
                    border-radius:16px; padding:4rem; text-align:center;">
            <div style="font-size:2.5rem; margin-bottom:.75rem;">🔕</div>
            <p style="color:rgba(255,255,255,.5); font-size:.95rem;">No tienes notificaciones por ahora.</p>
        </div>
    @else
        <div style="display:flex; flex-direction:column; gap:.65rem;" id="notif-list">
            @foreach($notificaciones as $notif)
            @php
                $tipo  = $notif->data['tipo'] ?? 'info';
                $leida = !is_null($notif->read_at);
                $iconos = [
                    'inscripcion'       => ['svg' => 'check-circle', 'color' => '#00A86B', 'bg' => 'rgba(0,168,107,.15)'],
                    'baja'              => ['svg' => 'x-circle',      'color' => '#ef4444', 'bg' => 'rgba(239,68,68,.15)'],
                    'like'              => ['svg' => 'heart',         'color' => '#f472b6', 'bg' => 'rgba(244,114,182,.15)'],
                    'cambio'            => ['svg' => 'clock',         'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,.15)'],
                    'cupos_disponibles' => ['svg' => 'unlock',        'color' => '#00A86B', 'bg' => 'rgba(0,168,107,.15)'],
                    'sin_cupos'         => ['svg' => 'alert-circle',  'color' => '#ef4444', 'bg' => 'rgba(239,68,68,.15)'],
                    'noticia'           => ['svg' => 'file-text',     'color' => '#60a5fa', 'bg' => 'rgba(96,165,250,.15)'],
                ];
                $ic = $iconos[$tipo] ?? ['svg' => 'bell', 'color' => '#94a3b8', 'bg' => 'rgba(148,163,184,.15)'];
            @endphp

            <div class="notif-card {{ $leida ? 'leida' : 'nueva' }}"
                 style="background:{{ $leida ? 'rgba(255,255,255,.04)' : 'rgba(255,255,255,.10)' }};
                         border:1px solid {{ $leida ? 'rgba(255,255,255,.07)' : 'rgba(0,168,107,.25)' }};
                         border-radius:14px; padding:1rem 1.2rem;
                         display:flex; gap:1rem; align-items:center;
                         {{ !$leida ? 'box-shadow:0 2px 12px rgba(0,168,107,.1);' : '' }}
                         transition:all .3s;">

                {{-- Ícono --}}
                <div style="width:40px; height:40px; border-radius:11px; flex-shrink:0;
                             background:{{ $ic['bg'] }};
                             display:flex; align-items:center; justify-content:center;">
                    <i data-feather="{{ $ic['svg'] }}"
                       style="width:18px; height:18px; stroke:{{ $ic['color'] }};"></i>
                </div>

                {{-- Contenido --}}
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:700; font-size:.9rem; color:#fff; margin-bottom:.2rem;">
                        {{ $notif->data['titulo'] ?? 'Sin título' }}
                    </div>
                    <div style="font-size:.82rem; color:rgba(255,255,255,.65); line-height:1.5;">
                        {{ $notif->data['mensaje'] ?? '' }}
                    </div>
                    <div style="font-size:.72rem; color:rgba(255,255,255,.35); margin-top:.35rem;
                                 display:flex; align-items:center; gap:.35rem;">
                        <i data-feather="clock" style="width:11px; height:11px;"></i>
                        {{ $notif->created_at->diffForHumans() }}
                    </div>
                </div>

                {{-- Badge --}}
                @if(!$leida)
                <span class="badge-nueva"
                      style="background:linear-gradient(135deg,#00A86B,#00DC82);
                             color:#001a1a; font-size:.62rem; padding:.22rem .7rem;
                             border-radius:50px; font-weight:800; white-space:nowrap;
                             letter-spacing:.5px; flex-shrink:0;">
                    NUEVA
                </span>
                @else
                <span style="color:rgba(255,255,255,.2); font-size:.72rem; flex-shrink:0;">
                    Leída
                </span>
                @endif
            </div>
            @endforeach
        </div>

        @if($notificaciones->hasPages())
        <div style="margin-top:1.5rem;">
            {{ $notificaciones->links() }}
        </div>
        @endif
    @endif
</div>

<script>
feather.replace();

function marcarTodasLeidas(btn) {
    btn.disabled = true;
    btn.style.opacity = '.6';
    btn.textContent = 'Marcando...';

    fetch('{{ route("notificaciones.markAllRead") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            // Actualizar visualmente cada card sin recargar
            document.querySelectorAll('.notif-card.nueva').forEach(card => {
                card.style.background = 'rgba(255,255,255,.04)';
                card.style.border = '1px solid rgba(255,255,255,.07)';
                card.style.boxShadow = 'none';
                const badge = card.querySelector('.badge-nueva');
                if (badge) {
                    badge.style.background = 'none';
                    badge.style.color = 'rgba(255,255,255,.2)';
                    badge.style.fontWeight = '400';
                    badge.textContent = 'Leída';
                }
                card.classList.remove('nueva');
                card.classList.add('leida');
            });
            // Quitar badge del campanazo en topbar
            const topBadge = document.querySelector('.notif-count');
            if (topBadge) topBadge.remove();
            // Quitar el botón con animación
            btn.style.transition = 'opacity .4s';
            btn.style.opacity = '0';
            setTimeout(() => btn.remove(), 400);
        }
    })
    .catch(() => {
        btn.disabled = false;
        btn.style.opacity = '1';
        btn.textContent = 'Marcar todas como leídas';
    });
}
</script>
@endsection
