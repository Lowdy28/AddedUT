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
                    <div class="alumno-row">
                        <div class="alumno-avatar">{{ strtoupper(substr($inscripcion->usuario->nombre ?? 'A', 0, 1)) }}</div>
                        <div style="flex:1; min-width:0;">
                            <p style="font-weight:700; color:#111827; font-size:.9rem; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $inscripcion->usuario->nombre ?? '—' }}
                            </p>
                            <p style="font-size:.78rem; color:#6b7280; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $inscripcion->usuario->email ?? '' }}
                            </p>
                        </div>
                        <span class="badge badge-green" style="font-size:.68rem;">Inscrito</span>
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

            {{-- Estado --}}
            <div style="background:#fff; border-radius:1.25rem; padding:1.4rem; border:1px solid #e5e7eb; box-shadow:0 2px 12px rgba(0,0,0,.04);">
                <div class="section-title">
                    <i data-feather="activity" style="width:17px;height:17px;"></i> Estado
                </div>
                @php
                    $hoy    = \Carbon\Carbon::today();
                    $inicio = \Carbon\Carbon::parse($taller->fecha_inicio);
                    $fin    = \Carbon\Carbon::parse($taller->fecha_fin ?? $taller->fecha_inicio);
                    if ($hoy->lt($inicio)) {
                        $estadoLabel = 'Próximamente'; $estadoClass = 'badge-blue';
                        $estadoDesc  = 'Inicia en ' . $hoy->diffInDays($inicio) . ' día(s).';
                    } elseif ($hoy->between($inicio, $fin)) {
                        $estadoLabel = 'En curso'; $estadoClass = 'badge-green';
                        $estadoDesc  = 'Activo. Quedan ' . $hoy->diffInDays($fin) . ' día(s).';
                    } else {
                        $estadoLabel = 'Finalizado'; $estadoClass = 'badge-orange';
                        $estadoDesc  = 'Concluyó el ' . $fin->format('d M Y') . '.';
                    }
                @endphp
                <div style="text-align:center; padding:.4rem 0;">
                    <span class="badge {{ $estadoClass }}" style="font-size:.88rem; padding:.45rem 1.4rem;">{{ $estadoLabel }}</span>
                    <p style="font-size:.83rem; color:#6b7280; margin-top:.7rem; line-height:1.5;">{{ $estadoDesc }}</p>
                </div>
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

    {{-- MODAL EDITAR --}}
    <div x-show="modalEdit" x-cloak
         class="fixed inset-0 z-[70] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
         x-transition:enter="transition duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90">

        <div style="background:#fff; border-radius:1.25rem; width:95%; max-width:580px; max-height:92vh; overflow-y:auto; box-shadow:0 25px 60px rgba(0,0,0,.4);">

            <div style="background:linear-gradient(135deg,#1e3a8a,#2563eb); border-radius:1.25rem 1.25rem 0 0; padding:1.2rem 1.6rem; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <h3 style="color:#fff; font-size:1.2rem; font-weight:800; margin:0;">✏️ Editar Taller</h3>
                    <p style="color:rgba(255,255,255,.7); font-size:.8rem; margin:.15rem 0 0;">Solo tú puedes editar tu taller asignado</p>
                </div>
                <button @click="closeAll()" style="background:rgba(255,255,255,.15); border:none; border-radius:50%; width:32px; height:32px; color:#fff; cursor:pointer; font-size:1rem; display:flex; align-items:center; justify-content:center;">✕</button>
            </div>

            <form @submit.prevent="submitEdit(editData.id_evento)" style="padding:1.4rem 1.6rem;">

                <div style="margin-bottom:.9rem;">
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Nombre *</label>
                    <input type="text" x-model="editData.nombre" required
                           style="width:100%; padding:.6rem .9rem; border-radius:.6rem; border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.92rem;"
                           onfocus="this.style.borderColor='#1e3a8a'" onblur="this.style.borderColor='#d1d5db'" />
                </div>

                <div style="margin-bottom:.9rem;">
                    <label style="display:block; font-size:.75rem; font-weight:700; color:#1e3a8a; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.3rem;">Descripción</label>
                    <textarea x-model="editData.descripcion" rows="3"
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

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:.9rem; margin-bottom:1.4rem;">
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

                <div style="border-top:1px solid #e5e7eb; padding-top:1.1rem; display:flex; justify-content:flex-end; gap:.7rem;">
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
function profesorHandler() {
    return {
        modalEdit: false,
        editData: { id_evento:'', nombre:'', descripcion:'', categoria:'', cupos:1, fecha_inicio:'', fecha_fin:'', lugar:'', horario:'', dias:'' },

        openEdit(taller) {
            this.editData = {
                id_evento:   taller.id_evento,
                nombre:      taller.nombre,
                descripcion: taller.descripcion || '',
                categoria:   taller.categoria   || 'General',
                cupos:       taller.cupos,
                fecha_inicio: taller.fecha_inicio ? taller.fecha_inicio.substring(0,10) : '',
                fecha_fin:    taller.fecha_fin    ? taller.fecha_fin.substring(0,10)    : '',
                lugar:   taller.lugar   || '',
                horario: taller.horario || '',
                dias:    taller.dias    || '',
            };
            this.modalEdit = true;
        },

        closeAll() { this.modalEdit = false; },

        async submitEdit(id) {
            try {
                const res = await fetch(`/eventos/${id}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(this.editData)
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error');
                this.closeAll();
                Swal.fire({ title:'¡Guardado!', text:json.message, icon:'success', timer:1800, showConfirmButton:false })
                    .then(() => location.reload());
            } catch(err) {
                Swal.fire({ title:'Error', text:err.message, icon:'error' });
            }
        }
    }
}
</script>

@endsection