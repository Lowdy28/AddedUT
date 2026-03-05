<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, sans-serif; font-size: 10.5px; color: #1a1a2e; background: #fff; }

/* ── HEADER ── */
.header {
    background: #002D62;
    padding: 22px 30px 18px;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 0;
}
.header-left { flex: 1; }
.logo-text {
    font-size: 20px;
    font-weight: 900;
    color: #fff;
    letter-spacing: -0.5px;
    margin-bottom: 2px;
}
.logo-text span { color: #00A86B; }
.logo-sub {
    font-size: 8px;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase;
    letter-spacing: 1.2px;
}
.header-right {
    text-align: right;
}
.doc-title {
    font-size: 15px;
    font-weight: 800;
    color: #fff;
    line-height: 1.2;
}
.doc-sub {
    font-size: 9px;
    color: rgba(255,255,255,0.5);
    margin-top: 2px;
}

/* ── BARRA VERDE ── */
.green-bar {
    background: #00A86B;
    height: 5px;
    margin-bottom: 22px;
}

/* ── INFO TALLER ── */
.info-section {
    padding: 0 30px;
    margin-bottom: 20px;
}
.taller-nombre {
    font-size: 16px;
    font-weight: 900;
    color: #002D62;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 2px solid #00A86B;
}
.info-grid {
    display: flex;
    gap: 0;
}
.info-col {
    flex: 1;
    padding-right: 20px;
}
.info-col:last-child { padding-right: 0; }
.info-row {
    display: flex;
    flex-direction: column;
    margin-bottom: 8px;
}
.info-label {
    font-size: 7.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #9ca3af;
}
.info-value {
    font-size: 10.5px;
    font-weight: 700;
    color: #1e293b;
    margin-top: 1px;
}

/* ── STATS HORIZONTALES ── */
.stats-section {
    padding: 0 30px;
    margin-bottom: 20px;
}
.stats-label {
    font-size: 7.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #9ca3af;
    margin-bottom: 8px;
}
/* stats via tabla HTML */

/* ── TABLA ── */
.table-section { padding: 0 30px; margin-bottom: 22px; }
.table-label {
    font-size: 7.5px; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.8px; color: #9ca3af;
    margin-bottom: 8px;
}
table { width: 100%; border-collapse: collapse; }
thead tr { background: #002D62; }
thead th {
    color: white; padding: 8px 10px; text-align: left;
    font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px;
}
thead th.ctr { text-align: center; width: 28px; }
tbody tr { border-bottom: 1px solid #f1f5f9; }
tbody tr:nth-child(even) { background: #f9fafb; }
tbody td { padding: 7px 10px; vertical-align: middle; }
.tc { text-align: center; color: #9ca3af; font-size: 9px; }
.tn { font-weight: 700; color: #0f172a; font-size: 10px; }
.tm { font-family: monospace; color: #64748b; font-size: 9.5px; }
.to { color: #9ca3af; font-style: italic; font-size: 9px; }

.badge { display: inline-block; padding: 2.5px 9px; border-radius: 50px; font-size: 8px; font-weight: 800; text-transform: uppercase; }
.bp { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.ba { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.bj { background: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
.bs { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

</style>
</head>
<body>

@php
    $presentes    = $lista->where('estado','presente')->count();
    $ausentes     = $lista->where('estado','ausente')->count();
    $justificados = $lista->where('estado','justificado')->count();
    $sinMarcar    = $lista->filter(fn($a) => is_null($a->estado))->count();
    $total        = $lista->count();
    $pct          = $total > 0 ? round($presentes / $total * 100) : 0;
    $fechaFmt     = \Carbon\Carbon::parse($fecha)->isoFormat('dddd D [de] MMMM [de] YYYY');
@endphp

{{-- ══ HEADER ══ --}}
<div class="header">
    <div class="header-left">
        <div class="logo-text">Added<span>UT</span></div>
        <div class="logo-sub">Universidad Tecnológica de Tecámac</div>
    </div>
    <div class="header-right">
        <div class="doc-title">Lista de Asistencia</div>
        <div class="doc-sub">Generado: {{ now()->isoFormat('D MMM YYYY, HH:mm') }}</div>
    </div>
</div>
<div class="green-bar"></div>

{{-- ══ INFO DEL TALLER ══ --}}
<div class="info-section">
    <div class="taller-nombre">{{ $taller->nombre }}</div>
    <div class="info-grid">
        <div class="info-col">
            <div class="info-row">
                <span class="info-label">Fecha de sesión</span>
                <span class="info-value">{{ $fechaFmt }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Profesor</span>
                <span class="info-value">{{ $taller->creador->nombre ?? '—' }}</span>
            </div>
        </div>
        <div class="info-col">
            <div class="info-row">
                <span class="info-label">Lugar</span>
                <span class="info-value">{{ $taller->lugar ?? 'Campus UTTEC' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Horario</span>
                <span class="info-value">{{ $taller->horario ?? '—' }}
                    @if($taller->dias) · {{ $taller->dias }}@endif
                </span>
            </div>
        </div>
        <div class="info-col">
            <div class="info-row">
                <span class="info-label">Categoría</span>
                <span class="info-value">{{ $taller->categoria ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total inscritos</span>
                <span class="info-value">{{ $total }} estudiantes</span>
            </div>
        </div>
    </div>
</div>

{{-- ══ STATS EN TABLA ══ --}}
<div class="stats-section">
    <div class="stats-label">Resumen de la sesión</div>
    <table style="width:100%; border-collapse:separate; border-spacing:6px 0;">
        <tr>
            <td style="width:25%; background:#f0fdf4; border:1.5px solid #86efac; border-radius:8px; padding:10px 14px; vertical-align:middle;">
                <span style="font-size:22px; font-weight:900; color:#166534; display:block; line-height:1;">{{ $presentes }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#166534; display:block;">Presentes</span>
                <span style="font-size:8px; color:#4ade80; display:block; margin-top:1px;">{{ $pct }}% del grupo</span>
            </td>
            <td style="width:25%; background:#fef2f2; border:1.5px solid #fca5a5; border-radius:8px; padding:10px 14px; vertical-align:middle;">
                <span style="font-size:22px; font-weight:900; color:#991b1b; display:block; line-height:1;">{{ $ausentes }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#991b1b; display:block;">Ausentes</span>
            </td>
            <td style="width:25%; background:#fffbeb; border:1.5px solid #fde047; border-radius:8px; padding:10px 14px; vertical-align:middle;">
                <span style="font-size:22px; font-weight:900; color:#854d0e; display:block; line-height:1;">{{ $justificados }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#854d0e; display:block;">Justificados</span>
            </td>
            <td style="width:25%; background:#eff6ff; border:1.5px solid #93c5fd; border-radius:8px; padding:10px 14px; vertical-align:middle;">
                <span style="font-size:22px; font-weight:900; color:#1e40af; display:block; line-height:1;">{{ $sinMarcar }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px; color:#1e40af; display:block;">Sin registrar</span>
            </td>
        </tr>
    </table>
    {{-- Barra progreso --}}
    <table style="width:100%; margin-top:8px; border-collapse:collapse;">
        <tr>
            <td style="background:#f1f5f9; border-radius:4px; height:6px; padding:0;">
                <table style="width:{{ $pct }}%; border-collapse:collapse; height:6px;">
                    <tr><td style="background:#00A86B; border-radius:4px; height:6px; padding:0;"></td></tr>
                </table>
            </td>
        </tr>
    </table>
</div>

{{-- ══ TABLA ══ --}}
<div class="table-section">
    <div class="table-label">Registro individual</div>
    <table>
        <thead>
            <tr>
                <th class="ctr">#</th>
                <th>Nombre completo</th>
                <th>Matrícula</th>
                <th>Asistencia</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lista as $i => $al)
            <tr>
                <td class="tc">{{ $i + 1 }}</td>
                <td class="tn">{{ $al->nombre }}</td>
                <td class="tm">{{ $al->matricula ?? '—' }}</td>
                <td>
                    @if($al->estado === 'presente')        <span class="badge bp">Presente</span>
                    @elseif($al->estado === 'ausente')     <span class="badge ba">Ausente</span>
                    @elseif($al->estado === 'justificado') <span class="badge bj">Justificado</span>
                    @else                                  <span class="badge bs">Sin registrar</span>
                    @endif
                </td>
                <td class="to">{{ $al->nota ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ══ FOOTER ══ --}}
<div style="padding: 0 30px; margin-top: 10px; border-top: 2px solid #00A86B; padding-top: 8px;">
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="font-size:9px; font-weight:900; color:#002D62; letter-spacing:-0.3px;">
                Added<span style="color:#00A86B;">UT</span> — Reporte
            </td>
            <td style="text-align:right; font-size:8px; color:#9ca3af;">
                {{ $taller->nombre }} · Sesión {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
            </td>
        </tr>
    </table>
</div>

</body>
</html>
