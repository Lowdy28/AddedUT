<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | AddedUT</title>
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
    font-family:'DM Sans', sans-serif;
    background:var(--navy3);
    color:var(--white);
    min-height:100vh;
    display:flex;
    overflow-x:hidden;
}
a { text-decoration:none; color:inherit; }

/* PANEL IZQUIERDO */
.pl {
    display:none; flex:1;
    position:sticky; top:0; height:100vh;
    flex-shrink:0; overflow:hidden;
}
@media(min-width:900px){ .pl { display:block; } }
.pl-bg {
    position:absolute; inset:0;
    background:url('{{ asset('imagenes/background.jpg') }}') center/cover no-repeat;
    filter:brightness(.28) saturate(.55);
    transform:scale(1.06);
    animation:bgZ 22s ease-in-out infinite alternate;
}
@keyframes bgZ { from{transform:scale(1.06)} to{transform:scale(1.13)} }
.pl-overlay {
    position:absolute; inset:0;
    background:linear-gradient(145deg, rgba(0,16,32,.96) 0%, rgba(0,40,90,.75) 50%, rgba(0,60,40,.65) 100%);
}
.pl-grid {
    position:absolute; inset:0;
    background-image:radial-gradient(circle, rgba(0,220,130,.07) 1px, transparent 1px);
    background-size:34px 34px;
    animation:gridD 28s linear infinite;
}
@keyframes gridD { to{transform:translate(34px,34px)} }
.orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(70px); }
.orb-a { width:280px; height:280px; background:var(--green); opacity:.1; top:5%; left:-80px; animation:orbF 9s ease-in-out infinite; }
.orb-b { width:220px; height:220px; background:#004C99; opacity:.2; bottom:8%; right:-60px; animation:orbF 12s ease-in-out infinite reverse; }
.orb-c { width:140px; height:140px; background:var(--green); opacity:.07; top:55%; left:35%; animation:orbF 7s ease-in-out infinite 3s; }
@keyframes orbF { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-28px)} }
.pl-body {
    position:absolute; inset:0; z-index:3;
    display:flex; flex-direction:column;
    justify-content:center;
    padding:2.8rem 3rem;
    gap:2rem;
}
.pl-logo {
    display:flex; align-items:center; gap:10px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-weight:800; font-size:1.55rem; letter-spacing:-1px;
    width:fit-content;
}
.pl-logo .iw {
    width:36px; height:36px; border-radius:10px;
    background:linear-gradient(135deg, var(--navy), var(--green2));
    display:flex; align-items:center; justify-content:center;
    box-shadow:0 0 20px rgba(0,220,130,.4);
}
.pl-logo .iw svg { width:18px; height:18px; stroke:#fff; }
.pl-logo .dot { color:var(--green); }
.pl-heading h2 {
    font-family:'Plus Jakarta Sans', sans-serif;
    font-size:clamp(1.9rem, 2.6vw, 2.6rem);
    font-weight:800; line-height:1.18; letter-spacing:-.5px; margin-bottom:.9rem;
}
.pl-heading h2 em {
    font-style:normal;
    background:linear-gradient(90deg, var(--green), #00ffaa, var(--green));
    background-size:200%;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
    animation:shimmer 4s linear infinite;
}
@keyframes shimmer { from{background-position:0%} to{background-position:200%} }
.pl-heading p { font-size:.93rem; color:var(--muted); line-height:1.7; max-width:320px; }
.pl-steps { display:flex; flex-direction:column; gap:1.1rem; }
.step {
    display:flex; align-items:flex-start; gap:13px;
    padding:.9rem 1.1rem;
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.06);
    border-radius:14px;
    transition:background .3s, border-color .3s;
}
.step:hover { background:rgba(0,220,130,.05); border-color:rgba(0,220,130,.15); }
.step-ico { width:28px; height:28px; flex-shrink:0; display:flex; align-items:center; justify-content:center; }
.step-ico svg { width:16px; height:16px; stroke:var(--green); }
.step-text { font-size:.86rem; color:rgba(241,245,249,.72); line-height:1.5; padding-top:.2rem; }
.step-text strong { color:var(--white); font-weight:700; }
.pl-perks { display:flex; flex-wrap:wrap; gap:.6rem; }
.perk {
    display:inline-flex; align-items:center; gap:6px;
    background:rgba(0,220,130,.07); border:1px solid rgba(0,220,130,.15);
    border-radius:50px; padding:.3rem .9rem;
    font-size:.74rem; font-weight:700; color:rgba(241,245,249,.75);
}
.perk svg { width:12px; height:12px; stroke:var(--green); }
.pl-badge {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.07);
    border-radius:50px; padding:.42rem 1rem;
    font-size:.72rem; color:rgba(241,245,249,.45); font-weight:600;
    width:fit-content;
}
.bdot { width:7px; height:7px; border-radius:50%; background:var(--green); box-shadow:0 0 8px var(--green); flex-shrink:0; animation:bdotA 2s infinite; }
@keyframes bdotA { 0%,100%{opacity:1} 50%{opacity:.3} }
.pl-badge svg { width:13px; height:13px; stroke:var(--green); }

/* PANEL DERECHO */
.pr {
    width:100%; max-width:520px;
    background:var(--navy3);
    display:flex; flex-direction:column;
    padding:4rem 3.5rem 4rem;
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
    box-shadow:0 0 12px rgba(0,220,130,.3);
}
.mob-logo .iw svg { width:15px; height:15px; stroke:#fff; }
.mob-logo .dot { color:var(--green); }
@media(min-width:900px){ .mob-logo { display:none; } }
.eyebrow {
    display:inline-flex; align-items:center; gap:7px;
    background:rgba(0,220,130,.1); border:1px solid var(--bdr);
    border-radius:50px; padding:.32rem 1rem;
    font-size:.7rem; font-weight:800; color:var(--green);
    letter-spacing:1.4px; text-transform:uppercase; margin-bottom:1.1rem;
}
.eyebrow-dot { width:6px; height:6px; border-radius:50%; background:var(--green); box-shadow:0 0 7px var(--green); animation:bdotA 2s infinite; }
.form-h { font-family:'Plus Jakarta Sans', sans-serif; font-size:clamp(1.65rem,3vw,2.1rem); font-weight:800; letter-spacing:-.5px; line-height:1.15; margin-bottom:.45rem; }
.form-sub { font-size:.9rem; color:var(--muted); margin-bottom:1.8rem; line-height:1.6; }
.ferr {
    display:flex; align-items:center; gap:9px;
    background:rgba(255,82,82,.1); border:1px solid rgba(255,82,82,.35);
    border-radius:10px; padding:.8rem 1rem;
    font-size:.85rem; font-weight:600; color:#FF8080; margin-bottom:1.2rem;
    animation:shake .4s ease;
}
.ferr svg { width:16px; height:16px; flex-shrink:0; }
@keyframes shake { 0%,100%{transform:translateX(0)} 20%,60%{transform:translateX(-5px)} 40%,80%{transform:translateX(5px)} }
.fgrp { margin-bottom:1rem; }
.flbl { font-size:.78rem; font-weight:700; color:rgba(241,245,249,.72); margin-bottom:.48rem; display:block; }
.frow { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
@media(max-width:480px){ .frow { grid-template-columns:1fr; } }
.fwrap { position:relative; display:flex; align-items:center; }
.ficon {
    position:absolute; left:.9rem; z-index:1;
    color:rgba(241,245,249,.26); display:flex; align-items:center;
    pointer-events:none; transition:color .2s;
}
.ficon svg { width:15px; height:15px; }
.fwrap:focus-within .ficon { color:var(--green); }
.finput {
    width:100%; padding:.82rem 1rem .82rem 2.55rem;
    background:rgba(255,255,255,.05);
    border:1.5px solid rgba(255,255,255,.08);
    border-radius:12px; outline:none;
    font-family:'DM Sans', sans-serif; font-size:.92rem; color:var(--white);
    transition:border-color .2s, background .2s, box-shadow .2s;
    -webkit-appearance:none; appearance:none;
}
.finput::placeholder { color:rgba(241,245,249,.2); }
.finput:focus {
    border-color:var(--green);
    background:rgba(0,220,130,.04);
    box-shadow:0 0 0 3px rgba(0,220,130,.1);
}
.finput.err { border-color:var(--err); box-shadow:0 0 0 3px rgba(255,82,82,.1); }
.ftoggle {
    position:absolute; right:.85rem;
    background:none; border:none; cursor:pointer;
    color:rgba(241,245,249,.26); display:flex; padding:.2rem;
    transition:color .2s;
}
.ftoggle:hover { color:var(--white); }
.ftoggle svg { width:15px; height:15px; }

/* === ROL BADGE — deteccion automatica === */
.rol-badge-wrap {
    margin-top:.55rem;
    min-height: 30px;
    display:flex;
    align-items:center;
}
.rol-badge {
    display:inline-flex; align-items:center; gap:7px;
    border-radius:50px; padding:.3rem .9rem;
    font-size:.75rem; font-weight:700;
    border:1px solid;
    transition:all .25s ease;
    animation:fadeIn .2s ease;
}
@keyframes fadeIn { from{opacity:0;transform:translateY(-4px)} to{opacity:1;transform:translateY(0)} }
.rol-badge.estudiante {
    background:rgba(0,220,130,.12);
    border-color:rgba(0,220,130,.35);
    color:#00DC82;
}
.rol-badge.profesor {
    background:rgba(0,76,153,.2);
    border-color:rgba(0,140,255,.35);
    color:#5fb3ff;
}
.rol-badge.invalido {
    background:rgba(255,82,82,.1);
    border-color:rgba(255,82,82,.3);
    color:#FF8080;
}
.rol-badge svg { width:12px; height:12px; }

/* Hint debajo del email */
.email-hint {
    margin-top:.45rem;
    font-size:.73rem;
    color:rgba(241,245,249,.3);
    line-height:1.5;
}
.email-hint span { color:rgba(0,220,130,.7); font-weight:600; }

/* Contraseña */
.pwd-str { margin-top:.5rem; }
.str-bars { display:flex; gap:4px; margin-bottom:.28rem; }
.str-bar { flex:1; height:3px; border-radius:2px; background:rgba(255,255,255,.09); transition:background .3s; }
.s-weak { background:#FF5252; }
.s-mid  { background:#FFD60A; }
.s-good { background:#00DC82; }
.str-lbl { font-size:.7rem; color:var(--muted); }

/* Checkbox */
.check-wrap { display:flex; align-items:flex-start; gap:10px; margin:1rem 0 .5rem; }
.check-box {
    width:18px; height:18px; border-radius:5px; flex-shrink:0;
    background:rgba(255,255,255,.05); border:1.5px solid rgba(255,255,255,.14);
    cursor:pointer; -webkit-appearance:none; appearance:none;
    margin-top:2px; transition:all .2s; position:relative;
}
.check-box:checked { background:var(--green); border-color:var(--green); }
.check-box:checked::after {
    content:''; position:absolute; top:2px; left:5px;
    width:5px; height:9px;
    border-right:2px solid var(--navy); border-bottom:2px solid var(--navy);
    transform:rotate(45deg);
}
.check-lbl { font-size:.83rem; color:var(--muted); line-height:1.55; cursor:pointer; }
.check-lbl a { color:var(--green); font-weight:700; }
.check-lbl a:hover { text-decoration:underline; }

/* Boton */
.btn-go {
    width:100%; padding:.93rem;
    background:var(--green); color:var(--navy);
    border:none; border-radius:12px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-weight:800; font-size:.98rem; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:9px;
    box-shadow:0 8px 28px rgba(0,220,130,.35);
    transition:all .28s cubic-bezier(.34,1.56,.64,1); margin-top:.4rem;
}
.btn-go:hover {
    transform:translateY(-2px) scale(1.02);
    background:#00f090;
    box-shadow:0 14px 36px rgba(0,220,130,.5);
}
.btn-go:disabled {
    opacity:.45; cursor:not-allowed;
    transform:none; box-shadow:none;
}
.btn-go svg { width:18px; height:18px; }
.sep { display:flex; align-items:center; gap:12px; margin:1.4rem 0; color:rgba(241,245,249,.18); font-size:.74rem; }
.sep::before, .sep::after { content:''; flex:1; height:1px; background:rgba(255,255,255,.06); }
.ffoot { text-align:center; font-size:.87rem; color:var(--muted); }
.ffoot a { color:var(--green); font-weight:700; }
.ffoot a:hover { text-decoration:underline; }
.fback {
    display:inline-flex; align-items:center; gap:5px;
    font-size:.77rem; font-weight:600; color:var(--muted);
    margin-top:.7rem; transition:color .2s;
}
.fback:hover { color:var(--white); }
.fback svg { width:13px; height:13px; }
.sec-hint {
    display:flex; align-items:center; gap:7px;
    font-size:.73rem; color:rgba(241,245,249,.28); margin-top:1.5rem;
    padding-top:1.3rem; border-top:1px solid rgba(255,255,255,.05);
    justify-content:center;
}
.sec-hint svg { width:13px; height:13px; stroke:rgba(0,220,130,.5); }
.pr { animation:slideIn .55s cubic-bezier(.22,1,.36,1) both; }
@keyframes slideIn { from{opacity:0;transform:translateX(24px)} to{opacity:1;transform:translateX(0)} }
@media(max-width:900px){ .pr { max-width:100%; padding:3rem 2rem 4rem; } }
@media(max-width:480px){ .pr { padding:2.5rem 1.5rem 3.5rem; } }
</style>
</head>
<body>

<!-- PANEL IZQUIERDO -->
<div class="pl">
    <div class="pl-bg"></div>
    <div class="pl-overlay"></div>
    <div class="pl-grid"></div>
    <div class="orb orb-a"></div>
    <div class="orb orb-b"></div>
    <div class="orb orb-c"></div>
    <div class="pl-body">
        <a href="/" class="pl-logo">
            <div class="iw"><i data-feather="book-open"></i></div>
            Added<span class="dot">UT</span>
        </a>
        <div class="pl-heading">
            <h2>Empieza tu<br>camino <em>hoy.</em></h2>
            <p>Crea tu cuenta con tu correo institucional y accede a todas las actividades extracurriculares de la UTTEC.</p>
        </div>
        <div class="pl-steps">
            <div class="step">
                <div class="step-ico"><i data-feather="mail"></i></div>
                <div class="step-text"><strong>Usa tu correo institucional</strong> — tu matricula determina tu rol automaticamente.</div>
            </div>
            <div class="step">
                <div class="step-ico"><i data-feather="search"></i></div>
                <div class="step-text"><strong>Explora</strong> el catalogo de actividades disponibles en la UTTEC.</div>
            </div>
            <div class="step">
                <div class="step-ico"><i data-feather="check-circle"></i></div>
                <div class="step-text"><strong>Inscribete</strong> y construye tu perfil extracurricular completo.</div>
            </div>
        </div>
        <div class="pl-perks">
            <span class="perk"><i data-feather="zap"></i> Gratis</span>
            <span class="perk"><i data-feather="shield"></i> Seguro</span>
            <span class="perk"><i data-feather="smartphone"></i> Cualquier dispositivo</span>
            <span class="perk"><i data-feather="clock"></i> 2 min</span>
        </div>
        <div class="pl-badge">
            <div class="bdot"></div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
            Plataforma oficial · UTTEC · Conexion segura
        </div>
    </div>
</div>

<!-- PANEL DERECHO -->
<div class="pr">

    <a href="/" class="mob-logo">
        <div class="iw"><i data-feather="book-open"></i></div>
        Added<span class="dot">UT</span>
    </a>

    <span class="eyebrow"><span class="eyebrow-dot"></span> Es gratis</span>
    <h1 class="form-h">Crea tu cuenta<br>en AddedUT</h1>
    <p class="form-sub">Ingresa tu correo institucional — tu rol se detecta automaticamente.</p>

    @if($errors->any())
    <div class="ferr">
        <i data-feather="alert-circle"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('registro.post') }}" method="POST" id="formRegistro">
        @csrf

        <!-- Nombre -->
        <div class="fgrp">
            <label class="flbl" for="nombre">Nombre completo</label>
            <div class="fwrap">
                <span class="ficon"><i data-feather="user"></i></span>
                <input class="finput {{ $errors->has('nombre') ? 'err' : '' }}"
                    type="text" name="nombre" id="nombre"
                    placeholder="Nombre Apellido Apellido"
                    value="{{ old('nombre') }}" required autofocus>
            </div>
        </div>

        <!-- Correo institucional -->
        <div class="fgrp">
            <label class="flbl" for="email">Correo institucional</label>
            <div class="fwrap">
                <span class="ficon"><i data-feather="mail"></i></span>
                <input class="finput {{ $errors->has('email') ? 'err' : '' }}"
                    type="email" name="email" id="email"
                    placeholder="matricula@uttec.edu.mx"
                    value="{{ old('email') }}"
                    required
                    autocomplete="off"
                    oninput="detectarRol(this.value)">
            </div>

            <!-- Hint de formato -->
            <div class="email-hint" id="emailHint">
                Estudiantes: <span>2523260044@uttec.edu.mx</span> &nbsp;|&nbsp;
                Profesores: <span>P2301@uttec.edu.mx</span>
            </div>

            <!-- Badge de rol detectado -->
            <div class="rol-badge-wrap" id="rolBadgeWrap"></div>

            <!-- Campo oculto que lleva el rol al servidor (informativo, el server lo revalida) -->
            <input type="hidden" name="rol_detectado" id="rolDetectado" value="">
        </div>

        <!-- Contrasenas -->
        <div class="frow">
            <div class="fgrp">
                <label class="flbl" for="pwd">Contrasena</label>
                <div class="fwrap">
                    <span class="ficon"><i data-feather="lock"></i></span>
                    <input class="finput {{ $errors->has('password') ? 'err' : '' }}"
                        type="password" name="password" id="pwd"
                        placeholder="••••••••" required
                        oninput="checkStr(this.value)">
                    <button type="button" class="ftoggle" onclick="togglePwd('pwd',this)"><i data-feather="eye"></i></button>
                </div>
                <div class="pwd-str">
                    <div class="str-bars">
                        <div class="str-bar" id="b1"></div>
                        <div class="str-bar" id="b2"></div>
                        <div class="str-bar" id="b3"></div>
                        <div class="str-bar" id="b4"></div>
                    </div>
                    <span class="str-lbl" id="str-lbl"></span>
                </div>
            </div>
            <div class="fgrp">
                <label class="flbl" for="pwd2">Confirmar</label>
                <div class="fwrap">
                    <span class="ficon"><i data-feather="shield"></i></span>
                    <input class="finput"
                        type="password" name="password_confirmation" id="pwd2"
                        placeholder="••••••••" required>
                    <button type="button" class="ftoggle" onclick="togglePwd('pwd2',this)"><i data-feather="eye"></i></button>
                </div>
            </div>
        </div>

        <!-- Terminos -->
        <div class="check-wrap">
            <input type="checkbox" class="check-box" name="terms" id="terms" required>
            <label class="check-lbl" for="terms">
                Acepto los <a href="{{ route('terminos') }}" target="_blank">Terminos y Condiciones</a> de la plataforma AddedUT.
            </label>
        </div>

        <button type="submit" class="btn-go" id="btnSubmit">
            <i data-feather="user-plus"></i>
            Crear mi cuenta
        </button>
    </form>

    <div class="sep">o</div>

    <div class="ffoot" style="margin-bottom:.6rem">
        Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesion aqui</a>
    </div>
    <div class="ffoot">
        <a href="/" class="fback"><i data-feather="arrow-left"></i> Volver al inicio</a>
    </div>

    <div class="sec-hint">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
        Tu informacion esta protegida con cifrado seguro
    </div>

</div>

<script>
feather.replace();

const eyeSVG    = `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
const eyeOffSVG = `<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`;

function togglePwd(id, btn) {
    const el   = document.getElementById(id);
    const show = el.type === 'password';
    el.type    = show ? 'text' : 'password';
    btn.innerHTML = show ? eyeOffSVG : eyeSVG;
}

/* ── Indicador de fortaleza de contrasena ── */
function checkStr(v) {
    const bars = [1,2,3,4].map(i => document.getElementById('b'+i));
    const lbl  = document.getElementById('str-lbl');
    let s = 0;
    if (v.length >= 6)  s++;
    if (v.length >= 10) s++;
    if (/[A-Z]/.test(v) && /[0-9]/.test(v)) s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const cfg = [
        ['',''],
        ['s-weak','Debil'],
        ['s-mid','Regular'],
        ['s-mid','Buena'],
        ['s-good','Excelente'],
    ];
    bars.forEach((b,i) => { b.className = 'str-bar' + (i < s ? ' '+cfg[s][0] : ''); });
    lbl.textContent = cfg[s][1];
}

function detectarRol(emailVal) {
    const wrap  = document.getElementById('rolBadgeWrap');
    const input = document.getElementById('rolDetectado');
    const hint  = document.getElementById('emailHint');
    const btn   = document.getElementById('btnSubmit');

    const emailLower = emailVal.trim().toLowerCase();

    if (!emailLower.includes('@')) {
        wrap.innerHTML = '';
        input.value    = '';
        hint.style.display = 'block';
        btn.disabled   = false;
        return;
    }

    const partes    = emailLower.split('@');
    const matricula = partes[0];
    const dominio   = partes[1] || '';

    hint.style.display = 'none';

    if (dominio && dominio !== 'uttec.edu.mx') {
        mostrarBadge(wrap, 'invalido', 'x-circle',
            'Solo se acepta @uttec.edu.mx');
        input.value  = '';
        btn.disabled = true;
        return;
    }

    if (dominio !== 'uttec.edu.mx') {
        wrap.innerHTML = '';
        input.value    = '';
        btn.disabled   = false;
        return;
    }

    if (/^\d{10}$/.test(matricula)) {
        mostrarBadge(wrap, 'estudiante', 'user',
            'Estudiante detectado — matricula ' + matricula);
        input.value  = 'estudiante';
        btn.disabled = false;

    } else if (/^[a-zA-Z]+\d{2,}$/.test(matricula)) {
        mostrarBadge(wrap, 'profesor', 'briefcase',
            'Profesor detectado — clave ' + matricula.toUpperCase());
        input.value  = 'profesor';
        btn.disabled = false;

    } else {
        mostrarBadge(wrap, 'invalido', 'alert-circle',
            'Formato de matricula no reconocido');
        input.value  = '';
        btn.disabled = true;
    }
}

function mostrarBadge(wrap, tipo, icono, texto) {
    const iconosSVG = {
        'user':          `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>`,
        'briefcase':     `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>`,
        'alert-circle':  `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
        'x-circle':      `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
    };
    wrap.innerHTML = `
        <span class="rol-badge ${tipo}">
            ${iconosSVG[icono] || ''}
            ${texto}
        </span>`;
}

document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    if (emailInput && emailInput.value) {
        detectarRol(emailInput.value);
    }
});
</script>
</body>
</html>
