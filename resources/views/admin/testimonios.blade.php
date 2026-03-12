@extends('layouts.admin')

@section('title', 'Testimonios')

@section('content')
<div style="padding: 2rem;">

    {{-- Header --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.8rem; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 style="font-size:1.5rem; font-weight:800; color:#111827; margin-bottom:.25rem;">
                Moderación de Testimonios
            </h1>
            <p style="font-size:.9rem; color:#6b7280;">
                Aprueba o rechaza las opiniones de estudiantes y profesores antes de publicarlas.
            </p>
        </div>
        <a href="{{ route('dashboard.admin') }}"
           style="display:inline-flex; align-items:center; gap:.5rem; padding:.6rem 1.2rem;
                  background:#f3f4f6; border-radius:10px; font-size:.85rem; font-weight:600;
                  color:#374151; text-decoration:none; transition:background .2s;"
           onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
            ← Volver al panel
        </a>
    </div>

    {{-- Toast --}}
    @if(session('status'))
    <div style="background:#d1fae5; border:1px solid #6ee7b7; border-radius:10px;
                padding:.85rem 1.2rem; margin-bottom:1.5rem; color:#065f46;
                font-size:.88rem; font-weight:600; display:flex; align-items:center; gap:.5rem;">
        ✅ {{ session('status') }}
    </div>
    @endif

    {{-- PENDIENTES --}}
    <div style="margin-bottom:2.5rem;">
        <div style="display:flex; align-items:center; gap:.75rem; margin-bottom:1rem;">
            <h2 style="font-size:1.05rem; font-weight:700; color:#111827;">Pendientes de aprobación</h2>
            <span style="background:#fef3c7; color:#92400e; font-size:.75rem; font-weight:800;
                         padding:.2rem .65rem; border-radius:50px;">
                {{ $pendientes->count() }}
            </span>
        </div>

        @if($pendientes->isEmpty())
            <div style="background:#f9fafb; border:1px dashed #d1d5db; border-radius:12px;
                        padding:2rem; text-align:center; color:#9ca3af; font-size:.9rem;">
                No hay testimonios pendientes. ✓
            </div>
        @else
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:1rem;">
                @foreach($pendientes as $t)
                <div style="background:#fff; border:1px solid #e5e7eb; border-radius:14px;
                             padding:1.2rem 1.4rem; box-shadow:0 1px 4px rgba(0,0,0,.05);">

                    {{-- Estrellas --}}
                    <div style="display:flex; gap:2px; margin-bottom:.75rem;">
                        @for($i=1; $i<=5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                 fill="{{ $i <= $t->estrellas ? '#f59e0b' : 'none' }}"
                                 stroke="#f59e0b" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        @endfor
                        <span style="font-size:.78rem; color:#9ca3af; margin-left:.4rem;">{{ $t->estrellas }}/5</span>
                    </div>

                    {{-- Comentario --}}
                    <p style="font-size:.9rem; color:#374151; line-height:1.6; margin-bottom:1rem;
                               font-style:italic;">
                        "{{ $t->comentario }}"
                    </p>

                    {{-- Usuario --}}
                    <div style="display:flex; align-items:center; gap:.65rem; margin-bottom:1rem;
                                 padding-top:.75rem; border-top:1px solid #f3f4f6;">
                        <div style="width:32px; height:32px; border-radius:50%;
                                     background:linear-gradient(135deg,#002D62,#00b868);
                                     display:flex; align-items:center; justify-content:center;
                                     font-size:.78rem; font-weight:800; color:#fff; flex-shrink:0;">
                            {{ strtoupper(substr($t->usuario->nombre ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:.85rem; font-weight:700; color:#111827;">
                                {{ $t->usuario->nombre ?? '—' }}
                            </div>
                            <div style="font-size:.72rem; color:#9ca3af; text-transform:capitalize;">
                                {{ $t->usuario->rol ?? '—' }} · {{ $t->usuario->matricula ?? '' }}
                            </div>
                        </div>
                        <div style="margin-left:auto; font-size:.72rem; color:#9ca3af;">
                            {{ $t->created_at->diffForHumans() }}
                        </div>
                    </div>

                    {{-- Acciones --}}
                    <div style="display:flex; gap:.6rem;">
                        <form method="POST" action="{{ route('admin.testimonios.aprobar', $t->id_testimonio) }}" style="flex:1;">
                            @csrf @method('PATCH')
                            <button type="submit"
                                    style="width:100%; padding:.6rem; background:#d1fae5; color:#065f46;
                                           border:1px solid #6ee7b7; border-radius:9px; font-size:.85rem;
                                           font-weight:700; cursor:pointer; transition:background .2s;"
                                    onmouseover="this.style.background='#a7f3d0'"
                                    onmouseout="this.style.background='#d1fae5'">
                                ✓ Aprobar
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.testimonios.rechazar', $t->id_testimonio) }}" style="flex:1;"
                              onsubmit="return confirm('¿Eliminar este testimonio?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="width:100%; padding:.6rem; background:#fee2e2; color:#991b1b;
                                           border:1px solid #fca5a5; border-radius:9px; font-size:.85rem;
                                           font-weight:700; cursor:pointer; transition:background .2s;"
                                    onmouseover="this.style.background='#fecaca'"
                                    onmouseout="this.style.background='#fee2e2'">
                                ✕ Rechazar
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- APROBADOS --}}
    <div>
        <div style="display:flex; align-items:center; gap:.75rem; margin-bottom:1rem;">
            <h2 style="font-size:1.05rem; font-weight:700; color:#111827;">Publicados</h2>
            <span style="background:#d1fae5; color:#065f46; font-size:.75rem; font-weight:800;
                         padding:.2rem .65rem; border-radius:50px;">
                {{ $aprobados->count() }}
            </span>
        </div>

        @if($aprobados->isEmpty())
            <div style="background:#f9fafb; border:1px dashed #d1d5db; border-radius:12px;
                        padding:2rem; text-align:center; color:#9ca3af; font-size:.9rem;">
                Aún no hay testimonios publicados.
            </div>
        @else
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:1rem;">
                @foreach($aprobados as $t)
                <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:14px;
                             padding:1.2rem 1.4rem;">
                    <div style="display:flex; gap:2px; margin-bottom:.6rem;">
                        @for($i=1; $i<=5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                 fill="{{ $i <= $t->estrellas ? '#f59e0b' : 'none' }}"
                                 stroke="#f59e0b" stroke-width="2">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        @endfor
                    </div>
                    <p style="font-size:.88rem; color:#374151; font-style:italic; line-height:1.6; margin-bottom:.75rem;">
                        "{{ $t->comentario }}"
                    </p>
                    <div style="display:flex; align-items:center; justify-content:space-between;">
                        <span style="font-size:.8rem; font-weight:700; color:#065f46;">
                            {{ $t->usuario->nombre ?? '—' }}
                            <span style="font-weight:400; color:#6b7280; text-transform:capitalize;">
                                · {{ $t->usuario->rol ?? '' }}
                            </span>
                        </span>
                        <form method="POST" action="{{ route('admin.testimonios.rechazar', $t->id_testimonio) }}"
                              onsubmit="return confirm('¿Quitar este testimonio de la publicación?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    style="background:none; border:none; color:#ef4444; font-size:.78rem;
                                           font-weight:600; cursor:pointer; padding:.2rem .4rem;">
                                Quitar
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
