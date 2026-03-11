<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña | AddedUT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
<style>
:root {
    --navy:  #002D62;
    --navy2: #001a3d;
    --navy3: #001020;
    --green: #00DC82;
    --green2:#00b868;
    --white: #F1F5F9;
    --muted: rgba(241,245,249,.48);
    --bdr:   rgba(0,220,130,.18);
    --err:   #FF5252;
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { height:100%; }
body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy3);
    color: var(--white);
    min-height: 100vh;
    display: flex;
    overflow-x: hidden;
}
a { text-decoration:none; color:inherit; }

/* Panel izquierdo */
.pl {
    display: none;
    flex: 1;
    position: sticky;
    top: 0;
    height: 100vh;
    flex-shrink: 0;
    overflow: hidden;
}
@media(min-width:900px){ .pl { display:block; } }
.pl-bg {
    position:absolute; inset:0;
    background: url('{{ asset("imagenes/background.jpg") }}') center/cover no-repeat;
    filter: brightness(.28) saturate(.55);
    transform: scale(1.06);
    animation: bgZ 22s ease-in-out infinite alternate;
}
@keyframes bgZ { from{transform:scale(1.06)} to{transform:scale(1.13)} }
.pl-overlay {
    position:absolute; inset:0;
    background: linear-gradient(145deg,
        rgba(0,16,32,.96) 0%,
        rgba(0,40,90,.75) 50%,
        rgba(0,60,40,.65) 100%);
}
.pl-grid {
    position:absolute; inset:0;
    background-image: radial-gradient(circle, rgba(0,220,130,.07) 1px, transparent 1px);
    background-size: 34px 34px;
    animation: gridDrift 28s linear infinite;
}
@keyframes gridDrift { to{transform:translate(34px,34px)} }
.orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(70px); }
.orb-a { width:280px; height:280px; background:var(--green); opacity:.1; top:5%; left:-80px; animation:orbF 9s ease-in-out infinite; }
.orb-b { width:220px; height:220px; background:#004C99; opacity:.2; bottom:8%; right:-60px; animation:orbF 12s ease-in-out infinite reverse; }
@keyframes orbF { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)} }
.pl-body {
    position:absolute; inset:0; z-index:3;
    display:flex; flex-direction:column;
    justify-content:center;
    padding: 2.8rem 3rem;
    gap: 2rem;
}
.pl-logo {
    display:flex; align-items:center; gap:10px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-weight:800; font-size:1.55rem; letter-spacing:-1px;
}
.pl-logo .iw {
    width:36px; height:36px; border-radius:10px;
    background:linear-gradient(135deg, var(--navy), var(--green2));
    display:flex; align-items:center; justify-content:center;
    box-shadow: 0 0 20px rgba(0,220,130,.4);
    font-weight:900; font-size:1.1rem; color:var(--green);
}
.pl-logo .dot { color:var(--green); }
.pl-heading h2 {
    font-family:'Plus Jakarta Sans', sans-serif;
    font-size:clamp(1.9rem, 2.4vw, 2.4rem);
    font-weight:800; line-height:1.18; letter-spacing:-.5px; margin-bottom:.9rem;
}
.pl-heading h2 em {
    font-style:normal;
    background: linear-gradient(90deg, var(--green), #00ffaa, var(--green));
    background-size:200%;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    animation: shimmer 4s linear infinite;
}
@keyframes shimmer { from{background-position:0%} to{background-position:200%} }
.pl-heading p { font-size:.93rem; color:var(--muted); line-height:1.7; max-width:320px; }

/* Panel derecho */
.pr {
    width:100%; max-width:500px;
    background:var(--navy3);
    display:flex; flex-direction:column;
    padding: 5rem 3.5rem 4rem;
    position:relative;
    min-height:100vh;
}
.pr::before {
    content:'';
    position:fixed; top:0; right:0;
    width:400px; height:400px; border-radius:50%;
    background:radial-gradient(circle, rgba(0,220,130,.05) 0%, transparent 70%);
    pointer-events:none; z-index:0;
}
.pr > * { position:relative; z-index:1; }
.mob-logo {
    display:flex; align-items:center; gap:10px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-weight:800; font-size:1.4rem; letter-spacing:-1px;
    margin-bottom:2.5rem;
}
.mob-logo .iw {
    width:32px; height:32px; border-radius:9px;
    background:linear-gradient(135deg, var(--navy), var(--green2));
    display:flex; align-items:center; justify-content:center;
    font-weight:900; font-size:.95rem; color:var(--green);
}
.mob-logo .dot { color:var(--green); }
@media(min-width:900px){ .mob-logo { display:none; } }

.eyebrow {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(0,220,130,.1); border:1px solid var(--bdr);
    border-radius:50px; padding:.32rem 1rem;
    font-size:.7rem; font-weight:800; color:var(--green);
    letter-spacing:1.4px; text-transform:uppercase; margin-bottom:1.1rem;
}
.eyebrow-dot {
    width:6px; height:6px; border-radius:50%;
    background:var(--green); box-shadow:0 0 7px var(--green);
}
.form-h {
    font-family:'Plus Jakarta Sans', sans-serif;
    font-size:clamp(1.6rem,3vw,2rem);
    font-weight:800; letter-spacing:-.5px; line-height:1.15; margin-bottom:.45rem;
}
.form-sub { font-size:.9rem; color:var(--muted); margin-bottom:2rem; line-height:1.6; }

/* Alert de error */
.alert-err {
    background:rgba(255,82,82,.1); border:1px solid rgba(255,82,82,.35);
    border-radius:12px; padding:.85rem 1.1rem;
    font-size:.88rem; color:#FF5252;
    display:flex; align-items:center; gap:.6rem;
    margin-bottom:1.3rem;
}
.alert-err svg { flex-shrink:0; }

/* Campos */
.fgrp { margin-bottom:1.2rem; }
.flbl {
    display:block; font-size:.78rem; font-weight:700;
    color:rgba(241,245,249,.65); letter-spacing:.6px;
    text-transform:uppercase; margin-bottom:.5rem;
}
.fwrap {
    display:flex; align-items:center;
    background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1);
    border-radius:12px; overflow:hidden;
    transition: border-color .2s, box-shadow .2s;
}
.fwrap:focus-within {
    border-color:var(--green);
    box-shadow:0 0 0 3px rgba(0,220,130,.12);
}
.fwrap.err { border-color:var(--err); }
.ficon {
    padding:0 .85rem; display:flex; align-items:center;
    color:rgba(241,245,249,.3);
}
.ficon svg { width:16px; height:16px; }
.finput {
    flex:1; background:transparent; border:none; outline:none;
    color:var(--white); font-size:.95rem; padding:.85rem .85rem .85rem 0;
    font-family:'DM Sans', sans-serif;
}
.finput::placeholder { color:rgba(241,245,249,.25); }
.ferr { font-size:.78rem; color:var(--err); margin-top:.35rem; display:block; }

/* Botón */
.btn-go {
    width:100%; padding:1rem; border:none; border-radius:14px;
    background:linear-gradient(135deg, var(--green2), var(--green));
    color:#001a1a; font-weight:800; font-size:1rem;
    cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.5rem;
    box-shadow:0 4px 20px rgba(0,220,130,.3);
    transition: box-shadow .2s, transform .15s;
    font-family:'Plus Jakarta Sans', sans-serif; letter-spacing:.3px;
    margin-top:.5rem;
}
.btn-go:hover { box-shadow:0 8px 28px rgba(0,220,130,.45); transform:translateY(-2px); }
.btn-go svg { width:18px; height:18px; }

.ffoot {
    text-align:center; margin-top:1.4rem;
    font-size:.88rem; color:var(--muted);
}
.ffoot a { color:var(--green); font-weight:700; transition:opacity .2s; }
.ffoot a:hover { opacity:.8; }
.fback {
    display:inline-flex; align-items:center; gap:.4rem;
    font-size:.84rem; color:var(--muted);
    transition:color .2s;
}
.fback:hover { color:var(--green); }
.fback svg { width:14px; height:14px; }

/* Pasos visuales */
.steps-bar {
    display:flex; align-items:center; gap:0;
    margin-bottom:2rem;
}
.step-item {
    display:flex; align-items:center; gap:.5rem; flex:1;
}
.step-num {
    width:28px; height:28px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    font-size:.78rem; font-weight:800; flex-shrink:0;
}
.step-num.active { background:var(--green); color:#001a1a; box-shadow:0 0 12px rgba(0,220,130,.4); }
.step-num.done   { background:rgba(0,220,130,.2); color:var(--green); }
.step-num.pending{ background:rgba(255,255,255,.07); color:var(--muted); }
.step-label { font-size:.72rem; font-weight:600; color:var(--muted); white-space:nowrap; }
.step-label.active { color:var(--green); }
.step-line { flex:1; height:1px; background:rgba(255,255,255,.1); margin:0 .5rem; }
.step-line.done { background:rgba(0,220,130,.3); }
</style>
</head>
<body>

{{-- Panel izquierdo --}}
<div class="pl">
    <div class="pl-bg"></div>
    <div class="pl-overlay"></div>
    <div class="pl-grid"></div>
    <div class="orb orb-a"></div>
    <div class="orb orb-b"></div>
    <div class="pl-body">
        <div class="pl-logo">
            <div class="iw">A</div>
            Added<span class="dot">UT</span>
        </div>
        <div class="pl-heading">
            <h2>Recupera el acceso a tu <em>cuenta</em></h2>
            <p>Verifica tu identidad con los datos con los que te registraste y podrás establecer una nueva contraseña en segundos.</p>
        </div>
        <div style="background:rgba(0,220,130,.07); border:1px solid rgba(0,220,130,.2); border-radius:18px; padding:1.3rem 1.5rem;">
            <p style="font-size:.85rem; color:rgba(241,245,249,.75); line-height:1.7;">
                🔒 Tu contraseña nunca se almacena en texto plano. El sistema usa cifrado bcrypt de grado universitario.
            </p>
        </div>
    </div>
</div>

{{-- Panel derecho --}}
<div class="pr">

    <div class="mob-logo">
        <div class="iw">A</div>
        Added<span class="dot">UT</span>
    </div>

    {{-- Barra de pasos --}}
    <div class="steps-bar">
        <div class="step-item">
            <div class="step-num active">1</div>
            <span class="step-label active">Verificar identidad</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
            <div class="step-num pending">2</div>
            <span class="step-label">Nueva contraseña</span>
        </div>
        <div class="step-line"></div>
        <div class="step-item">
            <div class="step-num pending">3</div>
            <span class="step-label">Listo</span>
        </div>
    </div>

    <div class="eyebrow">
        <div class="eyebrow-dot"></div>
        Recuperar acceso
    </div>
    <h1 class="form-h">Verifica tu identidad</h1>
    <p class="form-sub">Ingresa tu matrícula y nombre completo tal como los registraste en el sistema.</p>

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert-err">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('recuperar.verificar') }}">
        @csrf

        {{-- Matrícula --}}
        <div class="fgrp">
            <label class="flbl" for="matricula">Matrícula</label>
            <div class="fwrap {{ $errors->has('matricula') ? 'err' : '' }}">
                <span class="ficon"><i data-feather="credit-card"></i></span>
                <input class="finput" type="text" name="matricula" id="matricula"
                       placeholder="Ej. 2523260044 o P2301"
                       value="{{ old('matricula') }}" required autofocus>
            </div>
            @error('matricula')
                <span class="ferr">{{ $message }}</span>
            @enderror
        </div>

        {{-- Nombre completo --}}
        <div class="fgrp">
            <label class="flbl" for="nombre">Nombre completo</label>
            <div class="fwrap {{ $errors->has('nombre') ? 'err' : '' }}">
                <span class="ficon"><i data-feather="user"></i></span>
                <input class="finput" type="text" name="nombre" id="nombre"
                       placeholder="Tal como te registraste"
                       value="{{ old('nombre') }}" required>
            </div>
            @error('nombre')
                <span class="ferr">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-go">
            <i data-feather="shield"></i>
            Verificar identidad
        </button>
    </form>

    <div class="ffoot" style="margin-top:1.5rem;">
        <a href="{{ route('login') }}" class="fback">
            <i data-feather="arrow-left"></i> Volver al inicio de sesión
        </a>
    </div>

</div>

<script>feather.replace();</script>
</body>
</html>
