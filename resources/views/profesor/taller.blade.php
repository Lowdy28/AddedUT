@extends('layouts.profesor')
@section('title', 'Mi Taller')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js" defer></script>

<style>
[x-cloak] { display: none !important; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
.fade-up  { animation: fadeInUp .45s ease both; }
.fade-up-2 { animation: fadeInUp .45s .1s ease both; }
.fade-up-3 { animation: fadeInUp .45s .2s ease both; }

.hero-banner {
    width: 100%; aspect-ratio: 21 / 7;
    border-radius: 20px; overflow: hidden;
    position: relative;
    box-shadow: 0 20px 60px rgba(0,0,0,0.18);
    margin-bottom: 2.5rem;
    background: linear-gradient(135deg, #1e3a8a, #065f46);
}
.hero-banner img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
.hero-banner:hover img { transform: scale(1.03); }
.hero-banner-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.75) 30%, rgba(0,0,0,0.1) 100%);
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 2rem 2.5rem;
}

.detail-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; }
@media(max-width:900px) {
    .detail-grid { grid-template-columns: 1fr; }
    .hero-banner { aspect-ratio: 16/7; }
}

.section-title {
    font-size: 1.05rem; font-weight: 800; color: #1e3a8a;
    display: flex; align-items: center; gap: .5rem;
    padding-bottom: .55rem;
    border-bottom: 2px solid #00a86b;
    margin-bottom: 1.2rem;
}
.info-chip {
    display: flex; align-items: center; gap: .6rem;
    padding: .6rem .9rem; border-radius: .75rem;
    background: #f8fafc; border: 1px solid #e5e7eb;
    font-size: .88rem; color: #374151; font-weight: 500;
}
.info-chip svg { color: #00a86b; flex-shrink: 0; }
.info-chip strong { color: #1e3a8a; }

.stat-box { text-align: center; padding: 1.1rem 1rem; border-radius: 1rem; border: 1px solid #e5e7eb; background: #f8fafc; }
.stat-box .num { font-size: 2.4rem; font-weight: 900; line-height: 1; color: #1e3a8a; }
.stat-box .lbl { font-size: .75rem; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; margin-top: .3rem; }

.alumno-row { display: flex; align-items: center; gap: .75rem; padding: .65rem .85rem; border-radius: .75rem; transition: background .2s; }
.alumno-row:hover { background: #f0fdf4; }
.alumno-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: linear-gradient(135deg, #1e3a8a, #00a86b);
    color: #fff; font-weight: 800; font-size: .88rem;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}



    /* SweetAlert encima del modal de asistencia */
    .swal-on-top { z-index: 999999 !important; }

    .asist-modal-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    z-index: 99999;
    background: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
    padding-top: 5rem; /* compensa el navbar fijo */
}
.asist-modal {
    background: #fff; border-radius: 1.5rem;
    width: 100%; max-width: 680px;
    max-height: calc(100vh - 6rem); /* deja espacio al navbar */
    overflow: hidden; display: flex; flex-direction: column;
    box-shadow: 0 25px 60px rgba(0,0,0,0.35);
    animation: asistIn .2s ease;
}
@keyframes asistIn {
    from { opacity:0; transform:scale(.94) translateY(20px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
.asist-header {
    background: linear-gradient(135deg, #1e3a8a, #065f46);
    padding: 1.4rem 1.8rem;
    display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
}
.asist-body {
    flex: 1; overflow-y: auto; padding: 1.4rem 1.8rem;
    scrollbar-width: thin; scrollbar-color: #e5e7eb transparent;
}
.asist-footer {
    padding: 1rem 1.8rem; border-top: 1px solid #f0f0f0;
    display: flex; justify-content: space-between; align-items: center;
    flex-shrink: 0; background: #fafafa;
}
/* Fila alumno */
.asist-row {
    display: grid; grid-template-columns: 38px 1fr auto auto;
    gap: .75rem; align-items: center;
    padding: .7rem .4rem; border-bottom: 1px solid #f5f5f5;
}
.asist-row:last-child { border-bottom: none; }
.asist-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #1e3a8a, #00a86b);
    color: #fff; font-weight: 800; font-size: .85rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden;
}
.asist-avatar img { width:100%; height:100%; object-fit:cover; }
/* Botones estado */
.asist-opts { display: flex; gap: .35rem; }
.asist-opt {
    padding: .3rem .65rem; border-radius: 6px; font-size: .72rem;
    font-weight: 700; border: 1.5px solid transparent; cursor: pointer;
    transition: all .15s; text-transform: uppercase; letter-spacing: .04em;
}
.asist-opt.p { border-color: #00a86b; color: #065f46; background: #f0fdf4; }
.asist-opt.p.sel, .asist-opt.p:hover { background: #00a86b; color: #fff; }
.asist-opt.a { border-color: #ef4444; color: #991b1b; background: #fef2f2; }
.asist-opt.a.sel, .asist-opt.a:hover { background: #ef4444; color: #fff; }
.asist-opt.j { border-color: #f59e0b; color: #92400e; background: #fffbeb; }
.asist-opt.j.sel, .asist-opt.j:hover { background: #f59e0b; color: #fff; }
/* Stats rápidos */
.asist-stat-bar {
    display: flex; gap: .5rem; margin-bottom: 1.1rem; flex-wrap: wrap;
}
.asist-stat {
    flex: 1; min-width: 80px; text-align: center;
    padding: .6rem .5rem; border-radius: .75rem; font-size: .78rem; font-weight: 700;
}


/* ── MODAL ALUMNO ── */
.alumno-row { cursor: pointer; }
.alumno-row:hover .alumno-nombre { color: #1e3a8a; text-decoration: underline; }

.alumno-estado-baja .alumno-avatar {
    background: linear-gradient(135deg, #9ca3af, #6b7280) !important;
}
.alumno-estado-baja { opacity: .65; }

.al-modal-overlay {
    position: fixed; top:0; left:0; right:0; bottom:0;
    z-index: 99998;
    background: rgba(0,0,0,0.55); backdrop-filter: blur(4px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem; padding-top: 5rem;
}
.al-modal {
    background: #fff; border-radius: 1.25rem;
    width: 100%; max-width: 460px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
    overflow: hidden;
    animation: alIn .18s ease;
}
@keyframes alIn {
    from { opacity:0; transform:scale(.95) translateY(16px); }
    to   { opacity:1; transform:scale(1) translateY(0); }
}
.al-header {
    background: linear-gradient(135deg, #1e3a8a, #065f46);
    padding: 1.4rem 1.6rem;
    display: flex; align-items: center; gap: 1rem;
}
.al-avatar-lg {
    width: 52px; height: 52px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    color: #fff; font-weight: 900; font-size: 1.3rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden; border: 2px solid rgba(255,255,255,.35);
}
.al-avatar-lg img { width:100%; height:100%; object-fit:cover; }
.al-body { padding: 1.4rem 1.6rem; }
.al-info-row {
    display: flex; justify-content: space-between;
    padding: .5rem 0; border-bottom: 1px solid #f5f5f5;
    font-size: .88rem;
}
.al-info-row:last-child { border-bottom: none; }
.al-info-label { color: #9ca3af; font-weight: 600; }
.al-info-value { color: #1e293b; font-weight: 700; text-align: right; max-width: 60%; }
.al-footer {
    padding: 1rem 1.6rem;
    border-top: 1px solid #f0f0f0;
    background: #fafafa;
    display: flex; flex-direction: column; gap: .75rem;
}
.al-nota-area {
    width: 100%; padding: .6rem .85rem; border-radius: .6rem;
    border: 1.5px solid #d1d5db; font-size: .88rem; color: #111;
    resize: vertical; min-height: 70px; font-family: inherit;
    transition: border-color .2s;
}
.al-nota-area:focus { outline: none; border-color: #1e3a8a; }
.al-btns { display: flex; gap: .6rem; }
.al-btn {
    flex: 1; padding: .6rem; border-radius: .65rem;
    font-size: .82rem; font-weight: 700; border: none;
    cursor: pointer; transition: opacity .15s; display: flex;
    align-items: center; justify-content: center; gap: .35rem;
}
.al-btn:hover { opacity: .85; }
.al-btn-cancel { background: #f3f4f6; color: #374151; border: 1.5px solid #d1d5db !important; border: none; }
.al-btn-nota   { background: #eff6ff; color: #1e40af; border: 1.5px solid #93c5fd !important; border: none; }
.al-btn-baja   { background: #fef2f2; color: #991b1b; border: 1.5px solid #fca5a5 !important; border: none; }
.al-btn-reactiv{ background: #f0fdf4; color: #065f46; border: 1.5px solid #86efac !important; border: none; }
.al-btn-save   { background: linear-gradient(135deg,#1e3a8a,#065f46); color: #fff; }

.badge { display: inline-flex; align-items: center; gap: .3rem; padding: .28rem .8rem; border-radius: 50px; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
.badge-green  { background: #d1fae5; color: #065f46; }
.badge-blue   { background: #dbeafe; color: #1e40af; }
.badge-orange { background: #ffedd5; color: #9a3412; }
</style>

@php $taller = $talleres->first(); @endphp

<div x-data="profesorHandler()">

{{-- SIN TALLER --}}
@if(!$taller)
    <div class="flex flex-col items-center justify-center py-32 text-center fade-up">
        <div style="background:#f1f5f9; border-radius:50%; padding:2rem; margin-bottom:1.5rem;">
            <i data-feather="inbox" style="width:52px; height:52px; color:#94a3b8;"></i>
        </div>
        <h2 style="font-size:1.75rem; font-weight:800; color:#1e3a8a; margin-bottom:.6rem;">
            Aún no tienes un taller asignado
        </h2>
        <p style="color:#6b7280; max-width:400px; font-size:.95rem; line-height:1.6;">
            El administrador te asignará un taller próximamente. Cuando eso ocurra, toda la información aparecerá aquí.
        </p>
    </div>

{{-- CON TALLER --}}
@else
    @php
        $inscritos      = $taller->inscritos;
        $totalInscritos = $inscritos->count();
        $cuposLibres    = max(0, $taller->cupos - $totalInscritos);
        $porcentaje     = $taller->cupos > 0 ? round(($totalInscritos / $taller->cupos) * 100) : 0;
        $imagenUrl      = $taller->imagen_url ?? asset('imagenes/uttec.jpeg');
    @endphp

    {{-- HERO --}}
    <div class="hero-banner fade-up">
        <img src="{{ $imagenUrl }}" alt="{{ $taller->nombre }}" onerror="this.src='{{ asset('imagenes/uttec.jpeg') }}'">
        <div class="hero-banner-overlay">
            <span class="badge badge-green" style="margin-bottom:.6rem; width:fit-content;">
                <i data-feather="tag" style="width:11px;height:11px;"></i>
                {{ $taller->categoria ?? 'Taller' }}
            </span>
            <h1 style="color:#fff; font-size:2.3rem; font-weight:900; margin:0; line-height:1.15; text-shadow:0 2px 8px rgba(0,0,0,.5);">
                {{ $taller->nombre }}
            </h1>
            <p style="color:rgba(255,255,255,.75); margin-top:.4rem; font-size:.95rem;">
                Tu taller asignado — edita los detalles cuando lo necesites
            </p>
        </div>
    </div>

    {{-- STATS --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:2rem;" class="fade-up-2">
        <div class="stat-box">
            <div class="num">{{ $taller->cupos }}</div>
            <div class="lbl">Cupos Totales</div>
        </div>
        <div class="stat-box">
            <div class="num" style="color:#00a86b;">{{ $totalInscritos }}</div>
            <div class="lbl">Inscritos</div>
        </div>
        <div class="stat-box">
            <div class="num" style="color:{{ $cuposLibres === 0 ? '#ef4444' : '#f59e0b' }};">{{ $cuposLibres }}</div>
            <div class="lbl">Cupos Libres</div>
        </div>
        <div class="stat-box">
            <div class="num" style="color:{{ $porcentaje >= 90 ? '#ef4444' : '#1e3a8a' }};">{{ $porcentaje }}%</div>
            <div class="lbl">Ocupación</div>
        </div>
    </div>

    {{-- BARRA DE PROGRESO --}}
    <div style="background:#f8fafc; border-radius:1rem; padding:1rem 1.25rem; margin-bottom:2rem; border:1px solid #e5e7eb;" class="fade-up-2">
        <div style="display:flex; justify-content:space-between; font-size:.8rem; font-weight:700; color:#6b7280; margin-bottom:.5rem;">
            <span>Ocupación del taller</span>
            <span>{{ $totalInscritos }} / {{ $taller->cupos }} alumnos</span>
        </div>
        <div style="background:#e5e7eb; border-radius:50px; height:10px; overflow:hidden;">
            <div style="height:100%; border-radius:50px; width:{{ $porcentaje }}%;
                        background:{{ $porcentaje >= 90 ? 'linear-gradient(90deg,#f59e0b,#ef4444)' : 'linear-gradient(90deg,#00a86b,#1e3a8a)' }};
                        transition:width .8s ease;">
            </div>
        </div>
    </div>

    {{-- GRID PRINCIPAL --}}
    <div class="detail-grid fade-up-3">

        {{-- IZQUIERDA --}}
        <div style="display:flex; flex-direction:column; gap:1.75rem;">

            <div style="background:#fff; border-radius:1.25rem; padding:1.75rem; border:1px solid #e5e7eb; box-shadow:0 2px 12px rgba(0,0,0,.04);">
                <div class="section-title">
                    <i data-feather="file-text" style="width:17px;height:17px;"></i> Descripción del Taller
                </div>
                <p style="color:#374151; font-size:1rem; line-height:1.8; text-align:justify;">
                    {{ $taller->descripcion ?? 'Sin descripción. Puedes editarla con el botón de arriba.' }}
                </p>
            </div>

            <div style="background:#fff; border-radius:1.25rem; padding:1.75rem; border:1px solid #e5e7eb; box-shadow:0 2px 12px rgba(0,0,0,.04);">
                <div class="section-title">
                    <i data-feather="info" style="width:17px;height:17px;"></i> Información Logística
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:.75rem;">
                    <div class="info-chip">
                        <i data-feather="calendar" style="width:15px;height:15px;"></i>
                        <span><strong>Inicio:</strong> {{ $taller->fecha_inicio ? \Carbon\Carbon::parse($taller->fecha_inicio)->format('d M Y') : '—' }}</span>
                    </div>
                    <div class="info-chip">
                        <i data-feather="calendar" style="width:15px;height:15px;"></i>
                        <span><strong>Fin:</strong> {{ $taller->fecha_fin ? \Carbon\Carbon::parse($taller->fecha_fin)->format('d M Y') : '—' }}</span>
                    </div>
                    <div class="info-chip">
                        <i data-feather="clock" style="width:15px;height:15px;"></i>
                        <span><strong>Horario:</strong> {{ $taller->horario ?? 'No definido' }}</span>
                    </div>
                    <div class="info-chip">
                        <i data-feather="sun" style="width:15px;height:15px;"></i>
                        <span><strong>Días:</strong> {{ $taller->dias ?? 'No definido' }}</span>
                    </div>
                    <div class="info-chip" style="grid-column:1/-1;">
                        <i data-feather="map-pin" style="width:15px;height:15px;"></i>
                        <span><strong>Lugar:</strong> {{ $taller->lugar ?? 'Campus UTTEC' }}</span>
                    </div>
                </div>
            </div>

            {{-- Lista de alumnos --}}
            <div style="background:#fff; border-radius:1.25rem; padding:1.75rem; border:1px solid #e5e7eb; box-shadow:0 2px 12px rgba(0,0,0,.04);">
                <div class="section-title">
                    <i data-feather="users" style="width:17px;height:17px;"></i>
                    Alumnos Inscritos
                    <span class="badge badge-blue" style="margin-left:.4rem;">{{ $totalInscritos }}</span>
                </div>

                @forelse($inscritos as $inscripcion)
                    @php $esBaja = ($inscripcion->estado === 'baja'); @endphp
                    <div class="alumno-row {{ $esBaja ? 'alumno-estado-baja' : '' }}"
                         onclick="abrirAlumno({{ $taller->id_evento }}, {{ $inscripcion->id_usuario }})">
                        <div class="alumno-avatar">
                            @if(!empty($inscripcion->usuario->foto))
                                <img src="{{ asset('storage/' . $inscripcion->usuario->foto) }}"
                                     style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                            @else
                                {{ strtoupper(substr($inscripcion->usuario->nombre ?? 'A', 0, 1)) }}
                            @endif
                        </div>
                        <div style="flex:1; min-width:0;">
                            <p class="alumno-nombre" style="font-weight:700; color:#111827; font-size:.9rem; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; transition:color .15s;">
                                {{ $inscripcion->usuario->nombre ?? '—' }}
                            </p>
                            <p style="font-size:.78rem; color:#6b7280; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $inscripcion->usuario->matricula ?? $inscripcion->usuario->email ?? '' }}
                            </p>
                        </div>
                        @if($esBaja)
                            <span class="badge badge-orange" style="font-size:.68rem;">Baja</span>
                        @else
                            <span class="badge badge-green" style="font-size:.68rem;">Inscrito</span>
                        @endif
                        <i data-feather="chevron-right" style="width:14px;height:14px;color:#9ca3af;flex-shrink:0;"></i>
                    </div>
                    @if(!$loop->last)<hr style="border:none; border-top:1px solid #f3f4f6; margin:.1rem 0;">@endif
                @empty
                    <div style="text-align:center; padding:2rem; color:#9ca3af;">
                        <i data-feather="user-x" style="width:34px;height:34px; margin:0 auto .6rem; display:block;"></i>
                        <p style="font-weight:600; font-size:.88rem;">Aún no hay alumnos inscritos.</p>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- DERECHA --}}
        <div style="display:flex; flex-direction:column; gap:1.5rem;">

            {{-- Botón editar --}}
            <div style="background:#fff; border-radius:1.25rem; padding:1.4rem; border:1px solid #e5e7eb; box-shadow:0 2px 12px rgba(0,0,0,.04);">
                <div class="section-title">
                    <i data-feather="settings" style="width:17px;height:17px;"></i> Acciones
                </div>
                <button @click="openEdit({{ $taller }})"
                        style="width:100%; padding:.85rem; border-radius:.8rem;
                               background:linear-gradient(135deg,#1e3a8a,#2563eb);
                               color:#fff; font-weight:800; font-size:.93rem;
                               border:none; cursor:pointer;
                               box-shadow:0 4px 14px rgba(30,58,138,.35);
                               display:flex; align-items:center; justify-content:center; gap:.6rem;
                               transition:box-shadow .2s, transform .2s;"
                        onmouseover="this.style.boxShadow='0 8px 20px rgba(30,58,138,.5)'; this.style.transform='translateY(-2px)';"
                        onmouseout="this.style.boxShadow='0 4px 14px rgba(30,58,138,.35)'; this.style.transform='translateY(0)';">
                    <i data-feather="edit-3" style="width:17px;height:17px;"></i> Editar mi Taller
                </button>
                <p style="font-size:.76rem; color:#9ca3af; text-align:center; margin-top:.6rem;">
                    Actualiza nombre, descripción, horario, lugar y más.
                </p>
            </div>

            {{-- Tomar Lista --}}
            <div style="background:#fff; border-radius:1.25rem; padding:1.4rem; border:1px solid #e5e7eb; box-shadow:0 2px 12px rgba(0,0,0,.04);">
                <div class="section-title">
                    <i data-feather="check-square" style="width:17px;height:17px;"></i> Asistencia
                </div>
                <p style="font-size:.82rem; color:#6b7280; margin:0 0 1rem; line-height:1.5;">
                    Registra la asistencia de los alumnos por sesión.
                </p>
                <button onclick="abrirAsistencia({{ $taller->id_evento }})"
                        style="width:100%; padding:.7rem 1rem; border-radius:.75rem;
                               background:linear-gradient(135deg,#1e3a8a,#065f46);
                               color:#fff; border:none; font-weight:800; font-size:.88rem;
                               cursor:pointer; display:flex; align-items:center; justify-content:center;
                               gap:.5rem; transition:opacity .2s;"
                        onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
                    <i data-feather="check-square" style="width:15px;height:15px;"></i>
                    Tomar Lista
                </button>
            </div>

            {{-- Cupos visual --}}
            <div style="background:#fff; border-radius:1.25rem; padding:1.4rem; border:1px solid #e5e7eb; box-shadow:0 2px 12px rgba(0,0,0,.04);">
                <div class="section-title">
                    <i data-feather="pie-chart" style="width:17px;height:17px;"></i> Cupos
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:.75rem; text-align:center;">
                    <div style="background:#f0fdf4; border-radius:.75rem; padding:1rem; border:1px solid #bbf7d0;">
                        <div style="font-size:1.8rem; font-weight:900; color:#00a86b;">{{ $totalInscritos }}</div>
                        <div style="font-size:.72rem; font-weight:700; color:#166534; text-transform:uppercase;">Ocupados</div>
                    </div>
                    <div style="background:{{ $cuposLibres === 0 ? '#fef2f2' : '#eff6ff' }}; border-radius:.75rem; padding:1rem; border:1px solid {{ $cuposLibres === 0 ? '#fecaca' : '#bfdbfe' }};">
                        <div style="font-size:1.8rem; font-weight:900; color:{{ $cuposLibres === 0 ? '#ef4444' : '#1d4ed8' }};">{{ $cuposLibres }}</div>
                        <div style="font-size:.72rem; font-weight:700; color:{{ $cuposLibres === 0 ? '#991b1b' : '#1e40af' }}; text-transform:uppercase;">Disponibles</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endif



   {{-- ══════════════════════════════════
        MODAL GESTIÓN ALUMNO
   ══════════════════════════════════ --}}
   <div id="al-overlay" class="al-modal-overlay" style="display:none;" onclick="cerrarAlumno(event)">
       <div class="al-modal" onclick="event.stopPropagation()">

           {{-- Header --}}
           <div class="al-header">
               <div class="al-avatar-lg" id="al-avatar-el">A</div>
               <div style="flex:1; min-width:0;">
                   <div id="al-nombre" style="font-size:1.1rem; font-weight:900; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"></div>
                   <div id="al-matricula" style="font-size:.8rem; color:rgba(255,255,255,.65); margin-top:2px;"></div>
               </div>
               <button onclick="cerrarAlumno()" style="background:rgba(255,255,255,.15); border:none; border-radius:50%; width:32px; height:32px; color:#fff; font-size:1rem; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0;">✕</button>
           </div>

           {{-- Info --}}
           <div class="al-body">
               <div class="al-info-row">
                   <span class="al-info-label">Correo</span>
                   <span class="al-info-value" id="al-email">—</span>
               </div>
               <div class="al-info-row">
                   <span class="al-info-label">Estado</span>
                   <span class="al-info-value" id="al-estado-badge">—</span>
               </div>
               <div class="al-info-row">
                   <span class="al-info-label">Inscrito desde</span>
                   <span class="al-info-value" id="al-fecha">—</span>
               </div>
               <div class="al-info-row" id="al-asist-row">
                   <span class="al-info-label">Asistencia</span>
                   <span class="al-info-value" id="al-asist">—</span>
               </div>
           </div>

           {{-- Footer con nota y acciones --}}
           <div class="al-footer">
               <div>
                   <label style="font-size:.75rem; font-weight:700; color:#374151; text-transform:uppercase; letter-spacing:.05em; display:block; margin-bottom:.4rem;">
                       Nota / Observación del profesor
                   </label>
                   <textarea id="al-nota" class="al-nota-area" placeholder="Escribe una observación sobre este alumno..."></textarea>
               </div>
               <div class="al-btns">
                   <button class="al-btn al-btn-cancel" onclick="cerrarAlumno()">Cerrar</button>
                   <button class="al-btn al-btn-save" onclick="guardarNotaAlumno()">
                       <i data-feather="save" style="width:13px;height:13px;"></i> Guardar nota
                   </button>
               </div>
               <div id="al-baja-wrap">
                   <button id="al-btn-baja" class="al-btn al-btn-baja" style="width:100%;" onclick="darDeBaja()">
                       <i data-feather="user-x" style="width:13px;height:13px;"></i> Dar de baja del taller
                   </button>
                   <button id="al-btn-reactiv" class="al-btn al-btn-reactiv" style="width:100%; display:none;" onclick="reactivarAlumno()">
                       <i data-feather="user-check" style="width:13px;height:13px;"></i> Reactivar inscripción
                   </button>
               </div>
           </div>
       </div>
   </div>

   {{-- ══════════════════════════════════
        MODAL ASISTENCIA
   ══════════════════════════════════ --}}
   <div id="asist-overlay" class="asist-modal-overlay" style="display:none;" onclick="cerrarAsistencia(event)">
       <div class="asist-modal" onclick="event.stopPropagation()">

           {{-- Header --}}
           <div class="asist-header">
               <div>
                   <h2 style="color:#fff; font-size:1.2rem; font-weight:900; margin:0;">
                       Tomar Lista de Asistencia
                   </h2>
                   <p style="color:rgba(255,255,255,.7); font-size:.8rem; margin:.25rem 0 0;" id="asist-subtitle">
                       Cargando...
                   </p>
               </div>
               <button onclick="cerrarAsistencia()" style="background:rgba(255,255,255,.15); border:none; border-radius:50%;
                       width:34px; height:34px; color:#fff; font-size:1rem; cursor:pointer;
                       display:flex; align-items:center; justify-content:center;">✕</button>
           </div>

           {{-- Sub-header: selector de fecha + stats --}}
           <div style="padding:1rem 1.8rem; border-bottom:1px solid #f0f0f0; background:#f8fafc; flex-shrink:0;">
               <div style="display:flex; align-items:center; gap:.75rem; flex-wrap:wrap; margin-bottom:.75rem;">
                   <label style="font-size:.8rem; font-weight:700; color:#374151;">Fecha:</label>
                   <input type="date" id="asist-fecha"
                          style="border:1.5px solid #d1d5db; border-radius:.5rem; padding:.35rem .7rem;
                                 font-size:.85rem; color:#111; font-weight:600;"
                          onchange="cargarAsistencia()">
                   <button onclick="cargarAsistencia()"
                           style="padding:.35rem .9rem; border-radius:.5rem; background:#1e3a8a;
                                  color:#fff; border:none; font-size:.8rem; font-weight:700; cursor:pointer;">
                       Cargar
                   </button>
               </div>
               {{-- Stats rápidos --}}
               <div class="asist-stat-bar">
                   <div class="asist-stat" style="background:#f0fdf4; color:#065f46;">
                       <span id="cnt-p">0</span> Presentes
                   </div>
                   <div class="asist-stat" style="background:#fef2f2; color:#991b1b;">
                       <span id="cnt-a">0</span> Ausentes
                   </div>
                   <div class="asist-stat" style="background:#fffbeb; color:#92400e;">
                       <span id="cnt-j">0</span> Justificados
                   </div>
                   <div class="asist-stat" style="background:#f1f5f9; color:#475569;">
                       <span id="cnt-n">0</span> Sin marcar
                   </div>
               </div>
           </div>

           {{-- Body: lista de alumnos --}}
           <div class="asist-body" id="asist-lista">
               <div style="text-align:center; padding:3rem; color:#9ca3af;">
                   <i data-feather="loader" style="width:36px;height:36px;"></i>
                   <p style="margin-top:.75rem; font-size:.9rem;">Cargando alumnos...</p>
               </div>
           </div>

           {{-- Footer --}}
           <div class="asist-footer">
               <span style="font-size:.8rem; color:#9ca3af;" id="asist-guardado"></span>
               <div style="display:flex; gap:.75rem; flex-wrap:wrap;">
                   <button onclick="cerrarAsistencia()"
                           style="padding:.55rem 1.2rem; border-radius:.65rem; background:#f3f4f6;
                                  color:#374151; border:1.5px solid #d1d5db; font-weight:700;
                                  font-size:.88rem; cursor:pointer;">
                       Cerrar
                   </button>
                   <button onclick="descargarPdf()"
                           style="padding:.55rem 1.2rem; border-radius:.65rem; background:#fff;
                                  color:#1e3a8a; border:1.5px solid #1e3a8a; font-weight:700;
                                  font-size:.88rem; cursor:pointer; display:flex; align-items:center; gap:.4rem;">
                       <i data-feather="download" style="width:14px;height:14px;"></i> Descargar PDF
                   </button>
                   <button onclick="guardarAsistencia()"
                           style="padding:.55rem 1.4rem; border-radius:.65rem;
                                  background:linear-gradient(135deg,#1e3a8a,#065f46);
                                  color:#fff; border:none; font-weight:800; font-size:.88rem;
                                  cursor:pointer; display:flex; align-items:center; gap:.4rem;">
                       <i data-feather="save" style="width:14px;height:14px;"></i> Guardar
                   </button>
               </div>
           </div>
       </div>
   </div>

   {{-- MODAL EDITAR --}}
<div x-show="modalEdit" x-cloak
     class="fixed inset-0 z-[70] flex items-end sm:items-center justify-center bg-black/60 backdrop-blur-sm p-4 pt-20"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div style="background:#fff; border-radius:1.25rem; width:95%; max-width:560px; max-height:85vh; overflow-y:auto; box-shadow:0 25px 60px rgba(0,0,0,.4);">

        <div style="background:linear-gradient(135deg,#1e3a8a,#2563eb); border-radius:1.25rem 1.25rem 0 0; padding:1rem 1.4rem; display:flex; justify-content:space-between; align-items:center; position:sticky; top:0; z-index:10;">
            <div>
                <h3 style="color:#fff; font-size:1.1rem; font-weight:800; margin:0;">✏️ Editar Taller</h3>
                <p style="color:rgba(255,255,255,.7); font-size:.75rem; margin:.1rem 0 0;">Solo tú puedes editar tu taller asignado</p>
            </div>
            <button @click="closeAll()" style="background:rgba(255,255,255,.15); border:none; border-radius:50%; width:30px; height:30px; color:#fff; cursor:pointer; font-size:1rem; display:flex; align-items:center; justify-content:center;">✕</button>
        </div>

        <form id="formEditTaller" @submit.prevent="submitEdit(editData.id_evento)" style="padding:1.2rem 1.4rem;">

            {{-- IMAGEN --}}
            <div style="margin-bottom:.9rem;">
                <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">Imagen del taller</label>
                <div style="display:flex; align-items:center; gap:1rem;">
                    <img id="previewImagen" :src="editData.imagen_url" alt="preview"
                         style="width:80px; height:56px; object-fit:cover; border-radius:.5rem; border:2px solid #e5e7eb; flex-shrink:0;">
                    <div style="flex:1;">
                        <input type="file" id="inputImagen" name="imagen" accept="image/*"
                               onchange="previewImg(this)"
                               style="width:100%; font-size:.82rem; color:#374151; background:#f8fafc; border:1.5px dashed #d1d5db; border-radius:.6rem; padding:.45rem .7rem; cursor:pointer;">
                        <p style="font-size:.7rem; color:#9ca3af; margin-top:.3rem;">JPG, PNG o WEBP · máx. 3MB · Deja vacío para no cambiar</p>
                    </div>
                </div>
            </div>

            <div style="margin-bottom:.9rem;">
                <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Nombre *</label>
                <input type="text" x-model="editData.nombre" required
                       style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.92rem;"
                       onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#d1d5db'" />
            </div>

            <div style="margin-bottom:.9rem;">
                <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Descripción</label>
                <textarea x-model="editData.descripcion" rows="2"
                          style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.92rem; resize:vertical;"
                          onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#d1d5db'"></textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:.9rem; margin-bottom:.9rem;">
                <div>
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Categoría</label>
                    <select x-model="editData.categoria" style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111;">
                        <option value="General">General</option>
                        <option value="Academico">Académico</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Deportivo">Deportivo</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Cupos *</label>
                    <input type="number" x-model="editData.cupos" required min="1"
                           style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111;" />
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:.9rem; margin-bottom:.9rem;">
                <div>
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Fecha inicio *</label>
                    <input type="date" x-model="editData.fecha_inicio" required
                           style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111;" />
                </div>
                <div>
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Fecha fin *</label>
                    <input type="date" x-model="editData.fecha_fin" required
                           style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111;" />
                </div>
            </div>

            <div style="margin-bottom:.9rem;">
                <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Lugar</label>
                <input type="text" x-model="editData.lugar" placeholder="Ej. Cancha principal, Aula 3B..."
                       style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111;"
                       onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#d1d5db'" />
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:.9rem; margin-bottom:1.2rem;">
                <div>
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Horario</label>
                    <input type="text" x-model="editData.horario" placeholder="14:00 – 16:00 hrs"
                           style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111;" />
                </div>
                <div>
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Días</label>
                    <input type="text" x-model="editData.dias" placeholder="Lunes y Miércoles"
                           style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111;" />
                </div>
            </div>

            <div style="border-top:1px solid #e5e7eb; padding-top:1rem; display:flex; justify-content:flex-end; gap:.7rem;">
                <button type="button" @click="closeAll()"
                        style="padding:.6rem 1.3rem; border-radius:.6rem; background:#f3f4f6; color:#374151; font-weight:700; border:1.5px solid #d1d5db; cursor:pointer; font-size:.88rem;">
                    Cancelar
                </button>
                <button type="submit"
                        style="padding:.6rem 1.6rem; border-radius:.6rem; background:linear-gradient(135deg,#1e3a8a,#2563eb); color:#fff; font-weight:700; border:none; cursor:pointer; font-size:.88rem; box-shadow:0 4px 14px rgba(30,58,138,.4);">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

</div>{{-- fin x-data --}}

<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('previewImagen').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

function profesorHandler() {
    return {
        modalEdit: false,
        editData: { id_evento:'', nombre:'', descripcion:'', categoria:'', cupos:1, fecha_inicio:'', fecha_fin:'', lugar:'', horario:'', dias:'', imagen_url:'' },

        openEdit(taller) {
            this.editData = {
                id_evento:    taller.id_evento,
                nombre:       taller.nombre,
                descripcion:  taller.descripcion || '',
                categoria:    taller.categoria   || 'General',
                cupos:        taller.cupos,
                fecha_inicio: taller.fecha_inicio ? taller.fecha_inicio.substring(0,10) : '',
                fecha_fin:    taller.fecha_fin    ? taller.fecha_fin.substring(0,10)    : '',
                lugar:        taller.lugar   || '',
                horario:      taller.horario || '',
                dias:         taller.dias    || '',
                imagen_url:   taller.imagen_url  || '{{ asset("imagenes/uttec.jpeg") }}',
            };
            // limpiar input file anterior
            const inp = document.getElementById('inputImagen');
            if (inp) inp.value = '';
            this.modalEdit = true;
        },

        closeAll() { this.modalEdit = false; },

        async submitEdit(id) {
            try {
                const formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('nombre',       this.editData.nombre);
                formData.append('descripcion',  this.editData.descripcion || '');
                formData.append('categoria',    this.editData.categoria || 'General');
                formData.append('cupos',        this.editData.cupos);
                formData.append('fecha_inicio', this.editData.fecha_inicio);
                formData.append('fecha_fin',    this.editData.fecha_fin);
                formData.append('lugar',        this.editData.lugar || '');
                formData.append('horario',      this.editData.horario || '');
                formData.append('dias',         this.editData.dias || '');

                const inputImg = document.getElementById('inputImagen');
                if (inputImg && inputImg.files[0]) {
                    formData.append('imagen', inputImg.files[0]);
                }

                const res = await fetch(`/eventos/${id}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                });

                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error');
                this.closeAll();
                Swal.fire({ title:'¡Guardado!', text:json.message, icon:'success', timer:1800, showConfirmButton:false, customClass: { container: 'swal-on-top' } })
                    .then(() => location.reload());
            } catch(err) {
                Swal.fire({ title:'Error', text:err.message, icon:'error', customClass: { container: 'swal-on-top' } });
            }
        }
    }
}
</script>

@endsection
<script>
/* ══════════════════════════════════
   ASISTENCIA JS
══════════════════════════════════ */
let asistEventoId = null;
let asistData     = [];

function abrirAsistencia(eventoId) {
    asistEventoId = eventoId;
    document.getElementById('asist-overlay').style.display = 'flex';
    // Fecha de hoy por defecto
    const hoy = new Date().toISOString().split('T')[0];
    document.getElementById('asist-fecha').value = hoy;
    cargarAsistencia();
}

function cerrarAsistencia(e) {
    if (e && e.target !== document.getElementById('asist-overlay')) return;
    document.getElementById('asist-overlay').style.display = 'none';
    document.getElementById('asist-guardado').textContent = '';
}

async function cargarAsistencia() {
    const fecha = document.getElementById('asist-fecha').value;
    document.getElementById('asist-subtitle').textContent =
        `Sesión del ${new Date(fecha + 'T12:00:00').toLocaleDateString('es-MX', {weekday:'long', year:'numeric', month:'long', day:'numeric'})}`;

    document.getElementById('asist-lista').innerHTML =
        `<div style="text-align:center;padding:2rem;color:#9ca3af;">
            <p>Cargando alumnos...</p>
         </div>`;

    const res  = await fetch(`/profesor/asistencia/${asistEventoId}?fecha=${fecha}`, {
        headers: { 'Accept': 'application/json',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    const data = await res.json();
    asistData  = data.lista.map(a => ({ ...a, estado: a.estado ?? null }));
    renderLista();
}

function renderLista() {
    if (!asistData.length) {
        document.getElementById('asist-lista').innerHTML =
            `<div style="text-align:center;padding:3rem;color:#9ca3af;">
                <p>No hay alumnos inscritos en este taller.</p>
             </div>`;
        return;
    }

    let html = '';
    asistData.forEach((al, i) => {
        const av = al.foto
            ? `<div class="asist-avatar"><img src="${al.foto}" alt="${al.nombre}"></div>`
            : `<div class="asist-avatar">${al.nombre.charAt(0).toUpperCase()}</div>`;

        const est = al.estado;
        html += `
        <div class="asist-row">
            ${av}
            <div>
                <div style="font-weight:700;font-size:.88rem;color:#1e3a8a;">${esc(al.nombre)}</div>
                <div style="font-size:.73rem;color:#9ca3af;">${esc(al.matricula)}</div>
            </div>
            <div class="asist-opts">
                <button class="asist-opt p ${est==='presente'?'sel':''}"
                        onclick="setEstado(${i},'presente',this)">Presente</button>
                <button class="asist-opt a ${est==='ausente'?'sel':''}"
                        onclick="setEstado(${i},'ausente',this)">Ausente</button>
                <button class="asist-opt j ${est==='justificado'?'sel':''}"
                        onclick="setEstado(${i},'justificado',this)">Justif.</button>
            </div>
        </div>`;
    });

    document.getElementById('asist-lista').innerHTML = html;
    actualizarStats();
    feather.replace();
}

function setEstado(idx, estado, btn) {
    // Deseleccionar hermanos
    btn.closest('.asist-opts').querySelectorAll('.asist-opt').forEach(b => b.classList.remove('sel'));
    // Seleccionar este o deseleccionar si ya estaba activo
    const mismoEstado = asistData[idx].estado === estado;
    asistData[idx].estado = mismoEstado ? null : estado;
    if (!mismoEstado) btn.classList.add('sel');
    actualizarStats();
}

function actualizarStats() {
    const cnts = { presente:0, ausente:0, justificado:0, null:0 };
    asistData.forEach(a => {
        if (a.estado === 'presente')    cnts.presente++;
        else if (a.estado === 'ausente')     cnts.ausente++;
        else if (a.estado === 'justificado') cnts.justificado++;
        else cnts.null++;
    });
    document.getElementById('cnt-p').textContent = cnts.presente;
    document.getElementById('cnt-a').textContent = cnts.ausente;
    document.getElementById('cnt-j').textContent = cnts.justificado;
    document.getElementById('cnt-n').textContent = cnts.null;
}

async function guardarAsistencia() {
    const fecha = document.getElementById('asist-fecha').value;
    const payload = {
        fecha,
        asistencias: asistData
            .filter(a => a.estado !== null)
            .map(a => ({ id_usuario: a.id_usuario, estado: a.estado, nota: a.nota || '' }))
    };

    if (!payload.asistencias.length) {
        Swal.fire({ icon:'warning', title:'Sin cambios', text:'Marca al menos un alumno antes de guardar.', timer:2000, showConfirmButton:false, customClass: { container: 'swal-on-top' } });
        return;
    }

    const res  = await fetch(`/profesor/asistencia/${asistEventoId}/guardar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(payload)
    });
    const data = await res.json();

    if (res.ok) {
        Swal.fire({ icon:'success', title:'¡Guardado!', text: data.message, timer:1800, showConfirmButton:false, customClass: { container: 'swal-on-top' } });
        const now = new Date().toLocaleTimeString('es-MX', {hour:'2-digit', minute:'2-digit'});
        document.getElementById('asist-guardado').textContent = `Último guardado: ${now}`;
    } else {
        Swal.fire({ icon:'error', title:'Error', text: data.message || 'No se pudo guardar.', customClass: { container: 'swal-on-top' } });
    }
}


function descargarPdf() {
    const fecha = document.getElementById('asist-fecha').value;
    if (!fecha) { alert('Selecciona una fecha primero.'); return; }
    window.open(`/profesor/asistencia/${asistEventoId}/pdf?fecha=${fecha}`, '_blank');
}

/* ══════════════════════════════════
   GESTIÓN ALUMNO JS
══════════════════════════════════ */
let alEventoId  = null;
let alUsuarioId = null;
let alEstadoActual = null;

async function abrirAlumno(eventoId, usuarioId) {
    alEventoId  = eventoId;
    alUsuarioId = usuarioId;

    // Limpiar y mostrar overlay
    document.getElementById('al-nombre').textContent    = 'Cargando...';
    document.getElementById('al-matricula').textContent = '';
    document.getElementById('al-email').textContent     = '—';
    document.getElementById('al-estado-badge').innerHTML= '—';
    document.getElementById('al-fecha').textContent     = '—';
    document.getElementById('al-asist').textContent     = '—';
    document.getElementById('al-nota').value            = '';
    document.getElementById('al-overlay').style.display = 'flex';

    const res  = await fetch(`/profesor/alumno/${eventoId}/${usuarioId}`, {
        headers: { 'Accept': 'application/json',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    const d = await res.json();

    // Avatar
    const avEl = document.getElementById('al-avatar-el');
    avEl.innerHTML = d.foto
        ? `<img src="${d.foto}" style="width:100%;height:100%;object-fit:cover;">`
        : d.nombre.charAt(0).toUpperCase();

    document.getElementById('al-nombre').textContent    = d.nombre;
    document.getElementById('al-matricula').textContent = d.matricula;
    document.getElementById('al-email').textContent     = d.email;
    document.getElementById('al-fecha').textContent     = d.fecha_inscripcion
        ? new Date(d.fecha_inscripcion).toLocaleDateString('es-MX', {day:'2-digit', month:'long', year:'numeric'})
        : '—';

    // Estado badge
    alEstadoActual = d.estado;
    const estadoBadge = d.estado === 'baja'
        ? `<span style="background:#ffedd5;color:#9a3412;padding:2px 10px;border-radius:50px;font-size:.78rem;font-weight:800;">Baja</span>`
        : `<span style="background:#d1fae5;color:#065f46;padding:2px 10px;border-radius:50px;font-size:.78rem;font-weight:800;">Inscrito</span>`;
    document.getElementById('al-estado-badge').innerHTML = estadoBadge;

    // Asistencia
    if (d.sesiones_total > 0) {
        document.getElementById('al-asist').textContent =
            `${d.sesiones_presente} / ${d.sesiones_total} sesiones (${d.asistencia_pct}%)`;
    } else {
        document.getElementById('al-asist').textContent = 'Sin sesiones registradas';
    }

    // Nota
    document.getElementById('al-nota').value = d.nota || '';

    // Mostrar botón baja o reactivar según estado
    const btnBaja    = document.getElementById('al-btn-baja');
    const btnReactiv = document.getElementById('al-btn-reactiv');
    if (d.estado === 'baja') {
        btnBaja.style.display    = 'none';
        btnReactiv.style.display = 'flex';
    } else {
        btnBaja.style.display    = 'flex';
        btnReactiv.style.display = 'none';
    }

    feather.replace();
}

function cerrarAlumno(e) {
    if (e && e.target !== document.getElementById('al-overlay')) return;
    document.getElementById('al-overlay').style.display = 'none';
}

async function guardarNotaAlumno() {
    const nota = document.getElementById('al-nota').value;
    const res  = await fetch(`/profesor/alumno/${alEventoId}/${alUsuarioId}/nota`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json', 'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ nota })
    });
    const data = await res.json();
    if (res.ok) {
        Swal.fire({ icon:'success', title:'Nota guardada', text: data.message,
                    timer:1600, showConfirmButton:false, customClass:{ container:'swal-on-top' } });
    } else {
        Swal.fire({ icon:'error', title:'Error', text: data.message, customClass:{ container:'swal-on-top' } });
    }
}

async function darDeBaja() {
    const confirm = await Swal.fire({
        icon: 'warning',
        title: '¿Dar de baja?',
        text: 'El alumno perderá acceso al taller y recibirá una notificación.',
        showCancelButton: true,
        confirmButtonText: 'Sí, dar de baja',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444',
        customClass: { container: 'swal-on-top' }
    });
    if (!confirm.isConfirmed) return;

    const res  = await fetch(`/profesor/alumno/${alEventoId}/${alUsuarioId}/baja`, {
        method: 'PATCH',
        headers: { 'Accept': 'application/json',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    const data = await res.json();
    if (res.ok) {
        Swal.fire({ icon:'success', title:'Baja registrada', text: data.message,
                    timer:1800, showConfirmButton:false, customClass:{ container:'swal-on-top' } })
            .then(() => location.reload());
    } else {
        Swal.fire({ icon:'error', title:'Error', text: data.message, customClass:{ container:'swal-on-top' } });
    }
}

async function reactivarAlumno() {
    const confirm = await Swal.fire({
        icon: 'question',
        title: '¿Reactivar alumno?',
        text: 'El alumno volverá a tener estado "inscrito" y recibirá una notificación.',
        showCancelButton: true,
        confirmButtonText: 'Sí, reactivar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#00a86b',
        customClass: { container: 'swal-on-top' }
    });
    if (!confirm.isConfirmed) return;

    const res  = await fetch(`/profesor/alumno/${alEventoId}/${alUsuarioId}/reactivar`, {
        method: 'PATCH',
        headers: { 'Accept': 'application/json',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
    });
    const data = await res.json();
    if (res.ok) {
        Swal.fire({ icon:'success', title:'Alumno reactivado', text: data.message,
                    timer:1800, showConfirmButton:false, customClass:{ container:'swal-on-top' } })
            .then(() => location.reload());
    } else {
        Swal.fire({ icon:'error', title:'Error', text: data.message, customClass:{ container:'swal-on-top' } });
    }
}


function esc(s) {
    return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
