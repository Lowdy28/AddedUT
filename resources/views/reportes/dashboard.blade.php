@extends('layouts.admin')

@section('content')

<style>
    /* ── Variables ── */
    :root {
        --rep-blue:   #002D62;
        --rep-green:  #00A86B;
        --rep-red:    #e74c3c;
        --rep-yellow: #f39c12;
        --rep-bg:     #f0f4f9;
        --rep-card:   #ffffff;
        --rep-border: rgba(0,45,98,0.08);
    }

    .rep-page { font-family: 'Plus Jakarta Sans', 'DM Sans', sans-serif; }

    /* ── Header ── */
    .rep-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .rep-title {
        font-size: 1.9rem;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .rep-title span {
        background: var(--rep-green);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 50px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* ── KPI Cards ── */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .kpi-card {
        background: var(--rep-card);
        border-radius: 16px;
        padding: 1.4rem 1.2rem;
        border: 1px solid var(--rep-border);
        box-shadow: 0 4px 16px rgba(0,45,98,0.07);
        display: flex;
        flex-direction: column;
        gap: 8px;
        transition: transform 0.25s, box-shadow 0.25s;
        animation: kpiFadeIn 0.5s ease both;
    }
    .kpi-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(0,45,98,0.14); }
    @keyframes kpiFadeIn {
        from { opacity:0; transform: translateY(12px); }
        to   { opacity:1; transform: translateY(0); }
    }
    .kpi-card:nth-child(1) { animation-delay: .05s; }
    .kpi-card:nth-child(2) { animation-delay: .10s; }
    .kpi-card:nth-child(3) { animation-delay: .15s; }
    .kpi-card:nth-child(4) { animation-delay: .20s; }
    .kpi-card:nth-child(5) { animation-delay: .25s; }

    .kpi-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .kpi-icon svg { width: 18px; height: 18px; }
    .kpi-icon.blue   { background: rgba(0,45,98,0.1);   color: var(--rep-blue); }
    .kpi-icon.green  { background: rgba(0,168,107,0.1); color: var(--rep-green); }
    .kpi-icon.red    { background: rgba(231,76,60,0.1); color: var(--rep-red); }
    .kpi-icon.yellow { background: rgba(243,156,18,0.1);color: var(--rep-yellow); }

    .kpi-label { font-size: 0.78rem; font-weight: 600; color: #888; text-transform: uppercase; letter-spacing: .5px; }
    .kpi-value { font-size: 2rem; font-weight: 800; color: var(--rep-blue); line-height: 1; }

    /* ── Tab Bar ── */
    .rep-tabs {
        display: flex;
        gap: 4px;
        background: rgba(255,255,255,0.15);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        padding: 5px;
        margin-bottom: 1.5rem;
        width: fit-content;
    }
    .rep-tab {
        padding: 0.55rem 1.4rem;
        border-radius: 8px;
        border: none;
        background: transparent;
        color: rgba(255,255,255,0.7);
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.25s;
        display: flex;
        align-items: center;
        gap: 7px;
        letter-spacing: .3px;
    }
    .rep-tab:hover { background: rgba(255,255,255,0.12); color: #fff; }
    .rep-tab.activo { background: #fff; color: var(--rep-blue); box-shadow: 0 3px 10px rgba(0,0,0,0.15); }

    /* ── Panel ── */
    .rep-panel { display: none; animation: panelSlide 0.3s ease; }
    .rep-panel.activo { display: block; }
    @keyframes panelSlide {
        from { opacity:0; transform: translateX(10px); }
        to   { opacity:1; transform: translateX(0); }
    }

    .rep-card {
        background: var(--rep-card);
        border-radius: 18px;
        box-shadow: 0 6px 24px rgba(0,45,98,0.08);
        border: 1px solid var(--rep-border);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .rep-card-header {
        padding: 1.2rem 1.6rem;
        border-bottom: 1px solid var(--rep-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .rep-card-title {
        font-size: 1rem;
        font-weight: 800;
        color: var(--rep-blue);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .rep-card-title i { color: var(--rep-green); }

    /* ── Botones export ── */
    .export-btns { display: flex; gap: 8px; flex-wrap: wrap; }

    .btn-export {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 0.55rem 1.1rem;
        border-radius: 8px;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s;
        letter-spacing: .3px;
        border: 2px solid transparent;
    }
    .btn-export svg { width: 14px; height: 14px; }

    .btn-pdf {
        background: #fff0ef;
        color: #c0392b;
        border-color: #fad0cd;
    }
    .btn-pdf:hover {
        background: #c0392b;
        color: #fff;
        border-color: #c0392b;
        transform: translateY(-2px);
        box-shadow: 0 5px 14px rgba(192,57,43,0.3);
    }

    .btn-excel {
        background: #edfbf4;
        color: #1a7a44;
        border-color: #b2ecd1;
    }
    .btn-excel:hover {
        background: #1a7a44;
        color: #fff;
        border-color: #1a7a44;
        transform: translateY(-2px);
        box-shadow: 0 5px 14px rgba(26,122,68,0.3);
    }

    /* ── Gráficas ── */
    .chart-wrap {
        padding: 1.4rem 1.6rem;
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        flex-wrap: wrap;
    }
    .chart-box {
        flex: 1;
        min-width: 220px;
        max-width: 280px;
    }
    .chart-box canvas { max-height: 230px; }
    .chart-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #888;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 10px;
        text-align: center;
    }

    /* ── Tabla ── */
    .rep-table-wrap {
        padding: 0 1.6rem 1.6rem;
        overflow-x: auto;
    }
    .rep-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.87rem;
    }
    .rep-table thead tr {
        background: var(--rep-blue);
        color: #fff;
    }
    .rep-table thead th {
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 700;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }
    .rep-table tbody tr {
        border-bottom: 1px solid #f0f4f8;
        transition: background 0.15s;
    }
    .rep-table tbody tr:hover { background: #f5f9ff; }
    .rep-table tbody td {
        padding: 0.7rem 1rem;
        color: #444;
        vertical-align: middle;
    }

    .badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-admin      { background: rgba(0,45,98,0.1);   color: var(--rep-blue); }
    .badge-estudiante { background: rgba(0,168,107,0.1); color: var(--rep-green); }
    .badge-profesor   { background: rgba(243,156,18,0.1);color: var(--rep-yellow); }
    .badge-activo     { background: #edfbf4; color: #1a7a44; }
    .badge-inactivo   { background: #fff0ef; color: #c0392b; }
    .badge-confirmada { background: #edfbf4; color: #1a7a44; }

    .loading-row td {
        text-align: center;
        padding: 2rem;
        color: #aaa;
        font-style: italic;
    }
    .spinner-inline {
        display: inline-block;
        width: 16px; height: 16px;
        border: 2px solid #dde;
        border-top-color: var(--rep-green);
        border-radius: 50%;
        animation: spin .7s linear infinite;
        vertical-align: middle;
        margin-right: 6px;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="rep-page">

    {{-- Header --}}
    <div class="rep-header">
        <div class="rep-title">
            <i data-feather="bar-chart-2" style="width:28px;height:28px;color:#00A86B;"></i>
            Panel de Reportes
            <span>AddedUT</span>
        </div>
    </div>

    {{-- KPI Cards --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon blue"><i data-feather="users"></i></div>
            <div class="kpi-label">Total usuarios</div>
            <div class="kpi-value">{{ $totalUsuarios }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon green"><i data-feather="user-check"></i></div>
            <div class="kpi-label">Estudiantes</div>
            <div class="kpi-value">{{ $totalEstudiantes }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon yellow"><i data-feather="briefcase"></i></div>
            <div class="kpi-label">Profesores</div>
            <div class="kpi-value">{{ $totalProfesores }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon blue"><i data-feather="calendar"></i></div>
            <div class="kpi-label">Eventos</div>
            <div class="kpi-value">{{ $totalEventos }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon green"><i data-feather="bookmark"></i></div>
            <div class="kpi-label">Inscripciones</div>
            <div class="kpi-value">{{ $totalInscripciones }}</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon" style="background:rgba(155,89,182,0.1);color:#9b59b6;"><i data-feather="rss" style="width:16px;height:16px;"></i></div>
            <div class="kpi-label">Noticias</div>
            <div class="kpi-value">{{ $totalNoticias }}</div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="rep-tabs">
        <button class="rep-tab activo" data-tab="usuarios">
            <i data-feather="users" style="width:14px;height:14px;"></i> Usuarios
        </button>
        <button class="rep-tab" data-tab="eventos">
            <i data-feather="calendar" style="width:14px;height:14px;"></i> Eventos
        </button>
        <button class="rep-tab" data-tab="inscripciones">
            <i data-feather="bookmark" style="width:14px;height:14px;"></i> Inscripciones
        </button>
        <button class="rep-tab" data-tab="noticias">
            <i data-feather="rss" style="width:14px;height:14px;"></i> Noticias
        </button>
    </div>

    {{-- ══ PANEL USUARIOS ══ --}}
    <div class="rep-panel activo" id="panel-usuarios">
        <div class="rep-card">
            <div class="rep-card-header">
                <div class="rep-card-title">
                    <i data-feather="users" style="width:16px;height:16px;"></i>
                    Reporte de Usuarios
                </div>
                <div class="export-btns">
                    <a href="{{ route('reportes.export', ['tipo'=>'usuarios','formato'=>'pdf']) }}"
                       class="btn-export btn-pdf">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/></svg>
                        Exportar PDF
                    </a>
                    <a href="{{ route('reportes.export', ['tipo'=>'usuarios','formato'=>'xlsx']) }}"
                       class="btn-export btn-excel">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="9" y1="13" x2="15" y2="13"/><line x1="9" y1="17" x2="15" y2="17"/></svg>
                        Exportar Excel
                    </a>
                </div>
            </div>
            <div class="chart-wrap">
                <div class="chart-box">
                    <div class="chart-label">Distribución por rol</div>
                    <canvas id="chartUsuarios"></canvas>
                </div>
                <div class="chart-box">
                    <div class="chart-label">Estado de cuentas</div>
                    <canvas id="chartActivos"></canvas>
                </div>
            </div>
            <div class="rep-table-wrap">
                <table class="rep-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Nombre</th><th>Email</th>
                            <th>Rol</th><th>Estado</th><th>Registro</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyUsuarios">
                        <tr class="loading-row"><td colspan="6"><span class="spinner-inline"></span> Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ══ PANEL EVENTOS ══ --}}
    <div class="rep-panel" id="panel-eventos">
        <div class="rep-card">
            <div class="rep-card-header">
                <div class="rep-card-title">
                    <i data-feather="calendar" style="width:16px;height:16px;"></i>
                    Reporte de Eventos
                </div>
                <div class="export-btns">
                    <a href="{{ route('reportes.export', ['tipo'=>'eventos','formato'=>'pdf']) }}"
                       class="btn-export btn-pdf">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Exportar PDF
                    </a>
                    <a href="{{ route('reportes.export', ['tipo'=>'eventos','formato'=>'xlsx']) }}"
                       class="btn-export btn-excel">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Exportar Excel
                    </a>
                </div>
            </div>
            <div class="chart-wrap">
                <div class="chart-box">
                    <div class="chart-label">Por categoría</div>
                    <canvas id="chartEventos"></canvas>
                </div>
            </div>
            <div class="rep-table-wrap">
                <table class="rep-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Nombre</th><th>Categoría</th>
                            <th>Cupos</th><th>Inicio</th><th>Fin</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyEventos">
                        <tr class="loading-row"><td colspan="6"><span class="spinner-inline"></span> Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ══ PANEL INSCRIPCIONES ══ --}}
    <div class="rep-panel" id="panel-inscripciones">
        <div class="rep-card">
            <div class="rep-card-header">
                <div class="rep-card-title">
                    <i data-feather="bookmark" style="width:16px;height:16px;"></i>
                    Reporte de Inscripciones
                </div>
                <div class="export-btns">
                    <a href="{{ route('reportes.export', ['tipo'=>'inscripciones','formato'=>'pdf']) }}"
                       class="btn-export btn-pdf">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Exportar PDF
                    </a>
                    <a href="{{ route('reportes.export', ['tipo'=>'inscripciones','formato'=>'xlsx']) }}"
                       class="btn-export btn-excel">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Exportar Excel
                    </a>
                </div>
            </div>
            <div class="rep-table-wrap" style="padding-top:1.4rem;">
                <table class="rep-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Estudiante</th><th>Evento</th><th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyInscripciones">
                        <tr class="loading-row"><td colspan="4"><span class="spinner-inline"></span> Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


    {{-- ══ PANEL NOTICIAS ══ --}}
    <div class="rep-panel" id="panel-noticias">
        <div class="rep-card">
            <div class="rep-card-header">
                <div class="rep-card-title">
                    <i data-feather="rss" style="width:16px;height:16px;"></i>
                    Reporte de Noticias
                </div>
                <div class="export-btns">
                    <a href="{{ route('reportes.export', ['tipo'=>'noticias','formato'=>'pdf']) }}"
                       class="btn-export btn-pdf">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Exportar PDF
                    </a>
                    <a href="{{ route('reportes.export', ['tipo'=>'noticias','formato'=>'xlsx']) }}"
                       class="btn-export btn-excel">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Exportar Excel
                    </a>
                </div>
            </div>
            <div class="chart-wrap">
                <div class="chart-box">
                    <div class="chart-label">Por categoría</div>
                    <canvas id="chartNoticias"></canvas>
                </div>
                <div class="chart-box">
                    <div class="chart-label">Estado de publicación</div>
                    <canvas id="chartPublicadas"></canvas>
                </div>
            </div>
            <div class="rep-table-wrap">
                <table class="rep-table">
                    <thead>
                        <tr>
                            <th>ID</th><th>Título</th><th>Categoría</th>
                            <th>Publicada</th><th>Autor</th><th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyNoticias">
                        <tr class="loading-row"><td colspan="6"><span class="spinner-inline"></span> Cargando...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ── Tabs ────────────────────────────────────────────────────────────────────
document.querySelectorAll('.rep-tab').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.rep-tab').forEach(b => b.classList.remove('activo'));
        document.querySelectorAll('.rep-panel').forEach(p => p.classList.remove('activo'));
        btn.classList.add('activo');
        document.getElementById('panel-' + btn.dataset.tab).classList.add('activo');
    });
});

// ── Colores ──────────────────────────────────────────────────────────────────
const COLORS = ['#002D62','#00A86B','#f39c12','#e74c3c','#3498db','#9b59b6','#1abc9c'];

function grafica(id, labels, values, tipo = 'doughnut') {
    const canvas = document.getElementById(id);
    if (!canvas) return;
    if (canvas._chart) canvas._chart.destroy();
    canvas._chart = new Chart(canvas, {
        type: tipo,
        data: {
            labels,
            datasets: [{ data: values, backgroundColor: COLORS, borderWidth: 2, borderColor: '#fff' }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { font: { size: 11, weight: '600' }, padding: 10 } }
            }
        }
    });
}

// ── Usuarios ─────────────────────────────────────────────────────────────────
fetch('/reportes/data/usuarios')
    .then(r => r.json())
    .then(data => {
        // Gráfica roles
        const roles  = data.byRole || [];
        grafica('chartUsuarios', roles.map(x => x.rol), roles.map(x => x.total));

        // Gráfica activos
        grafica('chartActivos',
            ['Activos', 'Inactivos'],
            [data.active ?? 0, data.inactive ?? 0]
        );

        // Tabla
        const rows = data.table?.data || data.table || [];
        const tbody = document.getElementById('tbodyUsuarios');
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;color:#aaa;padding:1.5rem;">Sin datos</td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(u => `
            <tr>
                <td>${u.id_usuario}</td>
                <td><strong>${u.nombre}</strong></td>
                <td style="color:#666">${u.email}</td>
                <td><span class="badge badge-${u.rol}">${u.rol}</span></td>
                <td><span class="badge ${u.activo ? 'badge-activo' : 'badge-inactivo'}">${u.activo ? 'Activo' : 'Inactivo'}</span></td>
                <td style="color:#888">${u.fecha_registro?.substring(0,10) ?? '—'}</td>
            </tr>`).join('');
    });

// ── Eventos ──────────────────────────────────────────────────────────────────
fetch('/reportes/data/eventos')
    .then(r => r.json())
    .then(data => {
        const cats = data.byCategory || [];
        grafica('chartEventos', cats.map(x => x.categoria), cats.map(x => x.total));

        const rows = data.table?.data || data.table || [];
        const tbody = document.getElementById('tbodyEventos');
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;color:#aaa;padding:1.5rem;">Sin datos</td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(e => `
            <tr>
                <td>${e.id_evento}</td>
                <td><strong>${e.nombre}</strong></td>
                <td><span class="badge badge-estudiante">${e.categoria}</span></td>
                <td>${e.cupos}</td>
                <td style="color:#888">${e.fecha_inicio?.substring(0,10) ?? '—'}</td>
                <td style="color:#888">${e.fecha_fin?.substring(0,10) ?? '—'}</td>
            </tr>`).join('');
    });

// ── Inscripciones ─────────────────────────────────────────────────────────────
fetch('/reportes/data/inscripciones')
    .then(r => r.json())
    .then(data => {
        const rows = data.table?.data || data.table || [];
        const tbody = document.getElementById('tbodyInscripciones');
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;color:#aaa;padding:1.5rem;">Sin datos</td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(i => `
            <tr>
                <td>${i.id_inscripcion}</td>
                <td><strong>${i.usuario?.nombre ?? '—'}</strong></td>
                <td>${i.evento?.nombre ?? '—'}</td>
                <td><span class="badge badge-${i.estado ?? 'confirmada'}">${i.estado ?? 'confirmada'}</span></td>
            </tr>`).join('');
    });


// ── Noticias ──────────────────────────────────────────────────────────────────
fetch('/reportes/data/noticias')
    .then(r => r.json())
    .then(data => {
        const cats = data.byCategory || [];
        grafica('chartNoticias', cats.map(x => x.categoria), cats.map(x => x.total));
        grafica('chartPublicadas',
            ['Publicadas', 'Borradores'],
            [data.publicadas ?? 0, data.borradores ?? 0]
        );

        const rows = data.table?.data || data.table || [];
        const tbody = document.getElementById('tbodyNoticias');
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;color:#aaa;padding:1.5rem;">Sin datos</td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(n => `
            <tr>
                <td>${n.id_noticia}</td>
                <td><strong>${n.titulo}</strong></td>
                <td><span class="badge badge-estudiante">${n.categoria ?? '—'}</span></td>
                <td><span class="badge ${n.publicada ? 'badge-activo' : 'badge-inactivo'}">${n.publicada ? 'Sí' : 'No'}</span></td>
                <td style="color:#666">${n.autor?.nombre ?? '—'}</td>
                <td style="color:#888">${n.created_at?.substring(0,10) ?? '—'}</td>
            </tr>`).join('');
    });

if (typeof feather !== 'undefined') feather.replace();
</script>

@endsection
