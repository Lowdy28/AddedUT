@extends('layouts.admin')

@section('content')
<style>
    /* ── KPI Grid ── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 1rem;
        margin-bottom: 1.8rem;
    }
    .kpi-card {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.1);
        backdrop-filter: blur(8px);
        border-radius: 16px;
        padding: 1.3rem 1.2rem;
        display: flex;
        flex-direction: column;
        gap: 10px;
        transition: transform .25s, box-shadow .25s;
        animation: kpiFade .5s ease both;
    }
    .kpi-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,0.4);
        background: rgba(255,255,255,0.09);
    }
    @keyframes kpiFade {
        from { opacity:0; transform: translateY(14px); }
        to   { opacity:1; transform: translateY(0); }
    }
    .kpi-card:nth-child(1){animation-delay:.05s}
    .kpi-card:nth-child(2){animation-delay:.10s}
    .kpi-card:nth-child(3){animation-delay:.15s}
    .kpi-card:nth-child(4){animation-delay:.20s}
    .kpi-card:nth-child(5){animation-delay:.25s}
    .kpi-card:nth-child(6){animation-delay:.30s}

    .kpi-top { display:flex; align-items:center; justify-content:space-between; }
    .kpi-icon {
        width:40px; height:40px; border-radius:10px;
        display:flex; align-items:center; justify-content:center;
    }
    .kpi-icon svg { width:18px; height:18px; }
    .kpi-icon.green  { background:rgba(0,168,107,0.2);  color:#00A86B; }
    .kpi-icon.blue   { background:rgba(0,120,255,0.2);  color:#5aaeff; }
    .kpi-icon.yellow { background:rgba(243,156,18,0.2); color:#f39c12; }
    .kpi-icon.red    { background:rgba(231,76,60,0.2);  color:#e74c3c; }
    .kpi-icon.cyan   { background:rgba(0,200,220,0.2);  color:#00c8dc; }
    .kpi-icon.purple { background:rgba(155,89,182,0.2); color:#9b59b6; }

    .kpi-badge {
        font-size:.68rem; font-weight:700; padding:2px 8px;
        border-radius:50px; background:rgba(0,168,107,0.2); color:#5dffc0;
    }
    .kpi-value {
        font-size:2.4rem; font-weight:800; color:#fff; line-height:1;
    }
    .kpi-label {
        font-size:.75rem; font-weight:600; color:rgba(255,255,255,0.5);
        text-transform:uppercase; letter-spacing:.5px;
    }

    /* ── Grid principal ── */
    .dash-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.2rem;
        margin-bottom: 1.2rem;
    }
    .dash-grid.three { grid-template-columns: 1fr 1fr 1fr; }
    @media (max-width: 900px) {
        .dash-grid, .dash-grid.three { grid-template-columns: 1fr; }
    }

    /* ── Panel ── */
    .dpanel {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        backdrop-filter: blur(8px);
        border-radius: 16px;
        overflow: hidden;
    }
    .dpanel-header {
        padding: .9rem 1.2rem;
        border-bottom: 1px solid rgba(255,255,255,0.07);
        display: flex; align-items: center; justify-content: space-between;
    }
    .dpanel-title {
        font-size:.88rem; font-weight:800; color:#fff;
        display:flex; align-items:center; gap:8px;
    }
    .dpanel-title i { color:#00A86B; }
    .dpanel-body { padding: 1rem 1.2rem; }

    /* ── Tabla interna ── */
    .d-table { width:100%; border-collapse:collapse; font-size:.82rem; }
    .d-table thead th {
        text-align:left; padding:.5rem .7rem;
        color:rgba(255,255,255,0.4);
        font-size:.7rem; text-transform:uppercase; letter-spacing:.5px;
        border-bottom:1px solid rgba(255,255,255,0.07);
    }
    .d-table tbody td {
        padding:.6rem .7rem; color:rgba(255,255,255,0.85);
        border-bottom:1px solid rgba(255,255,255,0.04);
        vertical-align:middle;
    }
    .d-table tbody tr:last-child td { border-bottom:none; }
    .d-table tbody tr:hover td { background:rgba(255,255,255,0.04); }

    /* ── Badges ── */
    .dbadge {
        display:inline-block; padding:2px 9px; border-radius:50px;
        font-size:.68rem; font-weight:700; text-transform:uppercase;
    }
    .dbadge.green   { background:rgba(0,168,107,0.2);  color:#5dffc0; }
    .dbadge.yellow  { background:rgba(243,156,18,0.2); color:#ffd080; }
    .dbadge.blue    { background:rgba(0,120,255,0.2);  color:#90c8ff; }
    .dbadge.red     { background:rgba(231,76,60,0.2);  color:#ff8a80; }

    /* ── Barra de progreso ── */
    .prog-bar-wrap { background:rgba(255,255,255,0.08); border-radius:50px; height:6px; overflow:hidden; }
    .prog-bar-fill { height:100%; border-radius:50px; background:linear-gradient(90deg,#00A86B,#00d88a); transition:width 1s ease; }

    /* ── Próximos eventos ── */
    .event-row {
        display:flex; align-items:center; gap:12px;
        padding:.6rem 0; border-bottom:1px solid rgba(255,255,255,0.05);
    }
    .event-row:last-child { border-bottom:none; }
    .event-date-box {
        width:44px; height:44px; border-radius:10px;
        background:rgba(0,168,107,0.15); border:1px solid rgba(0,168,107,0.25);
        display:flex; flex-direction:column; align-items:center; justify-content:center;
        flex-shrink:0;
    }
    .event-date-day { font-size:.95rem; font-weight:800; color:#5dffc0; line-height:1; }
    .event-date-mon { font-size:.58rem; font-weight:700; color:rgba(255,255,255,0.5); text-transform:uppercase; }
    .event-info strong { display:block; font-size:.83rem; color:#fff; }
    .event-info span   { font-size:.73rem; color:rgba(255,255,255,0.45); }

    /* ── Ocupación gauge ── */
    .gauge-wrap { text-align:center; padding:.5rem 0 1rem; }
    .gauge-value { font-size:3rem; font-weight:800; color:#fff; }
    .gauge-sub   { font-size:.78rem; color:rgba(255,255,255,0.45); margin-top:4px; }

    /* ── Top talleres ── */
    .top-bar-item { margin-bottom:.85rem; }
    .top-bar-label { display:flex; justify-content:space-between; margin-bottom:4px; font-size:.8rem; font-weight:600; color:rgba(255,255,255,.8); }
    .top-bar-label span { color:rgba(255,255,255,.4); }

    /* ── Chart canvas ── */
    .chart-canvas-wrap { padding:.5rem 0 .5rem; position:relative; max-height:220px; }
</style>

<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem; flex-wrap:wrap; gap:.8rem;">
    <div>
        <h1 style="font-size:1.7rem; font-weight:800; color:#fff;">Panel de Control</h1>
        <p style="font-size:.85rem; color:rgba(255,255,255,.5); margin-top:2px;">
            {{ \Carbon\Carbon::now()->isoFormat('dddd, D [de] MMMM YYYY') }}
        </p>
    </div>
    <a href="{{ route('reportes.index') }}"
       style="display:inline-flex; align-items:center; gap:7px; background:rgba(0,168,107,0.18); border:1px solid rgba(0,168,107,0.35); color:#5dffc0; padding:.55rem 1.1rem; border-radius:8px; font-size:.83rem; font-weight:700; text-decoration:none; transition:all .2s;"
       onmouseover="this.style.background='rgba(0,168,107,0.3)'" onmouseout="this.style.background='rgba(0,168,107,0.18)'">
        <i data-feather="bar-chart-2" style="width:15px;height:15px;"></i> Ver reportes completos
    </a>
</div>

{{-- ── KPI Cards ── --}}
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon blue"><i data-feather="users"></i></div>
            <span class="kpi-badge">+{{ $nuevosEsteMes }} este mes</span>
        </div>
        <div class="kpi-value">{{ $totalUsuarios }}</div>
        <div class="kpi-label">Usuarios totales</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon green"><i data-feather="user-check"></i></div>
        </div>
        <div class="kpi-value">{{ $totalEstudiantes }}</div>
        <div class="kpi-label">Estudiantes</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon yellow"><i data-feather="briefcase"></i></div>
        </div>
        <div class="kpi-value">{{ $totalProfesores }}</div>
        <div class="kpi-label">Profesores</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon cyan"><i data-feather="calendar"></i></div>
        </div>
        <div class="kpi-value">{{ $totalEventos }}</div>
        <div class="kpi-label">Talleres activos</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon green"><i data-feather="bookmark"></i></div>
        </div>
        <div class="kpi-value">{{ $totalInscripciones }}</div>
        <div class="kpi-label">Inscripciones</div>
    </div>
    <div class="kpi-card">
        <div class="kpi-top">
            <div class="kpi-icon purple"><i data-feather="rss"></i></div>
        </div>
        <div class="kpi-value">{{ $totalNoticias }}</div>
        <div class="kpi-label">Noticias publicadas</div>
    </div>
</div>

{{-- ── Fila 1: Gráfica inscripciones + Ocupación + Próximos eventos ── --}}
<div class="dash-grid three">

    {{-- Gráfica inscripciones por mes --}}
    <div class="dpanel" style="grid-column: span 2;">
        <div class="dpanel-header">
            <div class="dpanel-title">
                <i data-feather="trending-up" style="width:15px;height:15px;"></i>
                Inscripciones últimos 6 meses
            </div>
        </div>
        <div class="dpanel-body">
            <div class="chart-canvas-wrap">
                <canvas id="chartInscMes"></canvas>
            </div>
        </div>
    </div>

    {{-- Ocupación --}}
    <div class="dpanel">
        <div class="dpanel-header">
            <div class="dpanel-title">
                <i data-feather="pie-chart" style="width:15px;height:15px;"></i>
                Categorías de talleres
            </div>
        </div>
        <div class="dpanel-body">
            <div class="chart-canvas-wrap">
                <canvas id="chartCategorias"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- ── Fila 2: Inscripciones recientes + Próximos eventos ── --}}
<div class="dash-grid">

    {{-- Inscripciones recientes --}}
    <div class="dpanel">
        <div class="dpanel-header">
            <div class="dpanel-title">
                <i data-feather="clock" style="width:15px;height:15px;"></i>
                Inscripciones recientes
            </div>
            <a href="{{ route('inscripciones.index') }}" style="font-size:.73rem; color:#00A86B; font-weight:700; text-decoration:none;">Ver todas →</a>
        </div>
        <div class="dpanel-body" style="padding:0 1.2rem;">
            <table class="d-table">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Taller</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscripcionesRecientes as $ins)
                    <tr>
                        <td>
                            <strong>{{ $ins->usuario->nombre ?? '—' }}</strong>
                        </td>
                        <td style="color:rgba(255,255,255,.6)">{{ Str::limit($ins->evento->nombre ?? '—', 20) }}</td>
                        <td><span class="dbadge green">{{ $ins->estado }}</span></td>
                        <td style="color:rgba(255,255,255,.4); font-size:.72rem;">
                            {{ \Carbon\Carbon::parse($ins->fecha_inscripcion)->format('d M') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; color:rgba(255,255,255,.3); padding:1.5rem;">Sin inscripciones</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Próximos eventos + Top talleres --}}
    <div style="display:flex; flex-direction:column; gap:1.2rem;">

        <div class="dpanel">
            <div class="dpanel-header">
                <div class="dpanel-title">
                    <i data-feather="calendar" style="width:15px;height:15px;"></i>
                    Próximos talleres
                </div>
                <a href="{{ route('eventos.index') }}" style="font-size:.73rem; color:#00A86B; font-weight:700; text-decoration:none;">Ver todos →</a>
            </div>
            <div class="dpanel-body">
                @forelse($eventosProximos as $ev)
                <div class="event-row">
                    <div class="event-date-box">
                        <span class="event-date-day">{{ \Carbon\Carbon::parse($ev->fecha_inicio)->format('d') }}</span>
                        <span class="event-date-mon">{{ \Carbon\Carbon::parse($ev->fecha_inicio)->isoFormat('MMM') }}</span>
                    </div>
                    <div class="event-info">
                        <strong>{{ $ev->nombre }}</strong>
                        <span>{{ $ev->cupo_disponible }} cupos · {{ $ev->categoria }}</span>
                    </div>
                </div>
                @empty
                <p style="color:rgba(255,255,255,.3); font-size:.83rem; text-align:center; padding:.8rem 0;">Sin eventos próximos</p>
                @endforelse
            </div>
        </div>

        <div class="dpanel">
            <div class="dpanel-header">
                <div class="dpanel-title">
                    <i data-feather="award" style="width:15px;height:15px;"></i>
                    Top talleres por inscripciones
                </div>
            </div>
            <div class="dpanel-body">
                @php $maxTop = $topTalleres->max('total') ?: 1; @endphp
                @foreach($topTalleres as $t)
                <div class="top-bar-item">
                    <div class="top-bar-label">
                        <span>{{ Str::limit($t->nombre, 28) }}</span>
                        <span>{{ $t->total }}</span>
                    </div>
                    <div class="prog-bar-wrap">
                        <div class="prog-bar-fill" style="width: {{ ($t->total / $maxTop) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
                @if($topTalleres->isEmpty())
                <p style="color:rgba(255,255,255,.3); font-size:.83rem; text-align:center;">Sin datos</p>
                @endif
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof feather !== 'undefined') feather.replace();

    const COLORS = ['#00A86B','#5aaeff','#f39c12','#e74c3c','#9b59b6','#00c8dc'];

    // ── Gráfica inscripciones por mes ──
    const meses  = @json($inscripcionesPorMes->pluck('mes'));
    const totales = @json($inscripcionesPorMes->pluck('total'));

    new Chart(document.getElementById('chartInscMes'), {
        type: 'bar',
        data: {
            labels: meses,
            datasets: [{
                label: 'Inscripciones',
                data: totales,
                backgroundColor: 'rgba(0,168,107,0.25)',
                borderColor: '#00A86B',
                borderWidth: 2,
                borderRadius: 6,
                hoverBackgroundColor: 'rgba(0,168,107,0.45)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,.5)', font: { size: 11 } } },
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: 'rgba(255,255,255,.5)', font: { size: 11 } }, beginAtZero: true }
            }
        }
    });

    // ── Gráfica categorías ──
    const cats   = @json($eventosPorCategoria->pluck('categoria'));
    const catVals = @json($eventosPorCategoria->pluck('total'));

    new Chart(document.getElementById('chartCategorias'), {
        type: 'doughnut',
        data: {
            labels: cats,
            datasets: [{
                data: catVals,
                backgroundColor: COLORS,
                borderColor: 'rgba(0,20,60,0.8)',
                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: 'rgba(255,255,255,0.6)', font: { size: 11 }, padding: 12 }
                }
            }
        }
    });
});
</script>

@endsection
