<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: DejaVu Sans, sans-serif; font-size: 10.5px; color: #1a1a2e; background: #fff; }
.header { background: #002D62; padding: 22px 30px 18px; display: flex; justify-content: space-between; align-items: flex-end; }
.logo-text { font-size: 20px; font-weight: 900; color: #fff; letter-spacing: -0.5px; margin-bottom: 2px; }
.logo-text span { color: #00A86B; }
.logo-sub { font-size: 8px; color: rgba(255,255,255,0.45); text-transform: uppercase; letter-spacing: 1.2px; }
.doc-title { font-size: 15px; font-weight: 800; color: #fff; line-height: 1.2; }
.doc-sub { font-size: 9px; color: rgba(255,255,255,0.5); margin-top: 2px; text-align: right; }
.green-bar { background: #00A86B; height: 5px; margin-bottom: 22px; }
.section { padding: 0 30px; margin-bottom: 20px; }
.section-title { font-size: 16px; font-weight: 900; color: #002D62; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 2px solid #00A86B; }
table { width: 100%; border-collapse: collapse; }
thead tr { background: #002D62; }
thead th { color: white; padding: 8px 10px; text-align: left; font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; }
tbody tr { border-bottom: 1px solid #f1f5f9; }
tbody tr:nth-child(even) { background: #f9fafb; }
tbody td { padding: 7px 10px; vertical-align: middle; font-size: 9.5px; }
.td-name  { font-weight: 700; color: #0f172a; font-size: 10px; }
.td-muted { color: #64748b; font-size: 9px; }
.td-center { text-align: center; }
.badge { display: inline-block; padding: 2.5px 9px; border-radius: 50px; font-size: 8px; font-weight: 800; text-transform: uppercase; }
.b-activo   { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.b-baja     { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.b-pendiente{ background: #fffbeb; color: #854d0e; border: 1px solid #fde047; }
.b-default  { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
</style>
</head>
<body>
@php
    $total    = $rows->count();
    $activos  = $rows->filter(fn($r) => ($r['estado'] ?? '') === 'activo')->count();
    $bajas    = $rows->filter(fn($r) => ($r['estado'] ?? '') === 'baja')->count();
@endphp
<div class="header">
    <div>
        <div class="logo-text">Added<span>UT</span></div>
        <div class="logo-sub">Universidad Tecnológica de Tecámac</div>
    </div>
    <div>
        <div class="doc-title">Reporte de Inscripciones</div>
        <div class="doc-sub">Generado: {{ now()->isoFormat('D MMM YYYY, HH:mm') }}</div>
    </div>
</div>
<div class="green-bar"></div>
<div class="section">
    <div class="section-title">Reporte General de Inscripciones</div>
    <table style="width:100%; border-collapse:separate; border-spacing:6px 0; margin-bottom:18px;">
        <tr>
            <td style="width:33%; background:#eff6ff; border:1.5px solid #93c5fd; border-radius:8px; padding:10px 14px;">
                <span style="font-size:22px; font-weight:900; color:#1e40af; display:block; line-height:1;">{{ $total }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; color:#1e40af; display:block;">Total</span>
            </td>
            <td style="width:33%; background:#f0fdf4; border:1.5px solid #86efac; border-radius:8px; padding:10px 14px;">
                <span style="font-size:22px; font-weight:900; color:#166534; display:block; line-height:1;">{{ $activos }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; color:#166534; display:block;">Activas</span>
            </td>
            <td style="width:33%; background:#fef2f2; border:1.5px solid #fca5a5; border-radius:8px; padding:10px 14px;">
                <span style="font-size:22px; font-weight:900; color:#991b1b; display:block; line-height:1;">{{ $bajas }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; color:#991b1b; display:block;">Bajas</span>
            </td>
        </tr>
    </table>
    <table>
        <thead><tr><th>#</th><th>Estudiante</th><th>Evento</th><th>Estado</th></tr></thead>
        <tbody>
            @foreach($rows as $i => $r)
            <tr>
                <td class="td-center td-muted">{{ $i + 1 }}</td>
                <td class="td-name">{{ $r['estudiante'] }}</td>
                <td class="td-muted">{{ $r['evento'] }}</td>
                <td>
                    @php $est = strtolower($r['estado'] ?? ''); @endphp
                    @if($est === 'activo')      <span class="badge b-activo">Activo</span>
                    @elseif($est === 'baja')    <span class="badge b-baja">Baja</span>
                    @elseif($est === 'pendiente')<span class="badge b-pendiente">Pendiente</span>
                    @else                       <span class="badge b-default">{{ $r['estado'] }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div style="padding:0 30px; margin-top:10px; border-top:2px solid #00A86B; padding-top:8px;">
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="font-size:9px; font-weight:900; color:#002D62;">Added<span style="color:#00A86B;">UT</span> — Reporte de Inscripciones</td>
            <td style="text-align:right; font-size:8px; color:#9ca3af;">{{ now()->format('d/m/Y') }} · {{ $total }} registros</td>
        </tr>
    </table>
</div>
</body>
</html>