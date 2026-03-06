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
.b-admin    { background: #ede9fe; color: #4c1d95; border: 1px solid #c4b5fd; }
.b-prof     { background: #eff6ff; color: #1e40af; border: 1px solid #93c5fd; }
.b-est      { background: #f0fdf4; color: #166534; border: 1px solid #86efac; }
.b-activo   { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.b-inactivo { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
</style>
</head>
<body>
@php
    $total       = $rows->count();
    $admins      = $rows->where('rol','admin')->count();
    $profesores  = $rows->where('rol','profesor')->count();
    $estudiantes = $rows->where('rol','estudiante')->count();
    $activos     = $rows->where('activo', 1)->count();
@endphp
<div class="header">
    <div>
        <div class="logo-text">Added<span>UT</span></div>
        <div class="logo-sub">Universidad Tecnológica de Tecámac</div>
    </div>
    <div>
        <div class="doc-title">Reporte de Usuarios</div>
        <div class="doc-sub">Generado: {{ now()->isoFormat('D MMM YYYY, HH:mm') }}</div>
    </div>
</div>
<div class="green-bar"></div>
<div class="section">
    <div class="section-title">Reporte General de Usuarios</div>
    <table style="width:100%; border-collapse:separate; border-spacing:6px 0; margin-bottom:18px;">
        <tr>
            <td style="width:25%; background:#eff6ff; border:1.5px solid #93c5fd; border-radius:8px; padding:10px 14px;">
                <span style="font-size:22px; font-weight:900; color:#1e40af; display:block; line-height:1;">{{ $total }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; color:#1e40af; display:block;">Total Usuarios</span>
            </td>
            <td style="width:25%; background:#ede9fe; border:1.5px solid #c4b5fd; border-radius:8px; padding:10px 14px;">
                <span style="font-size:22px; font-weight:900; color:#4c1d95; display:block; line-height:1;">{{ $admins }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; color:#4c1d95; display:block;">Admins</span>
            </td>
            <td style="width:25%; background:#fffbeb; border:1.5px solid #fde047; border-radius:8px; padding:10px 14px;">
                <span style="font-size:22px; font-weight:900; color:#854d0e; display:block; line-height:1;">{{ $profesores }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; color:#854d0e; display:block;">Profesores</span>
            </td>
            <td style="width:25%; background:#f0fdf4; border:1.5px solid #86efac; border-radius:8px; padding:10px 14px;">
                <span style="font-size:22px; font-weight:900; color:#166534; display:block; line-height:1;">{{ $estudiantes }}</span>
                <span style="font-size:7.5px; font-weight:700; text-transform:uppercase; color:#166534; display:block;">Estudiantes</span>
                <span style="font-size:8px; color:#4ade80; display:block; margin-top:1px;">{{ $activos }} activos</span>
            </td>
        </tr>
    </table>
    <table>
        <thead><tr><th>#</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Estado</th><th>Fecha Registro</th></tr></thead>
        <tbody>
            @foreach($rows as $i => $r)
            <tr>
                <td class="td-center td-muted">{{ $i + 1 }}</td>
                <td class="td-name">{{ $r->nombre }}</td>
                <td class="td-muted">{{ $r->email }}</td>
                <td>
                    @if($r->rol === 'admin')       <span class="badge b-admin">Admin</span>
                    @elseif($r->rol === 'profesor') <span class="badge b-prof">Profesor</span>
                    @else                           <span class="badge b-est">Estudiante</span>
                    @endif
                </td>
                <td>
                    @if($r->activo) <span class="badge b-activo">Activo</span>
                    @else           <span class="badge b-inactivo">Inactivo</span>
                    @endif
                </td>
                <td class="td-muted">{{ \Carbon\Carbon::parse($r->fecha_registro)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div style="padding:0 30px; margin-top:10px; border-top:2px solid #00A86B; padding-top:8px;">
    <table style="width:100%; border-collapse:collapse;">
        <tr>
            <td style="font-size:9px; font-weight:900; color:#002D62;">Added<span style="color:#00A86B;">UT</span> — Reporte de Usuarios</td>
            <td style="text-align:right; font-size:8px; color:#9ca3af;">{{ now()->format('d/m/Y') }} · {{ $total }} registros</td>
        </tr>
    </table>
</div>
</body>
</html>