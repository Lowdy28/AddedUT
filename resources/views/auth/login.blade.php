<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | AddedUT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
<style>
/* ══════════════════════════════════════
   BASE
══════════════════════════════════════ */
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
    overflow-x: hidden; /* scroll vertical libre */
}
a { text-decoration:none; color:inherit; }

/* ══════════════════════════════════════
   PANEL IZQUIERDO — sticky, 100vh
══════════════════════════════════════ */
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
    background: url('{{ asset('imagenes/background.jpg') }}') center/cover no-repeat;
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
        rgba(0,60,40,.65) 100%
    );
}
.pl-grid {
    position:absolute; inset:0;
    background-image: radial-gradient(circle, rgba(0,220,130,.07) 1px, transparent 1px);
    background-size: 34px 34px;
    animation: gridDrift 28s linear infinite;
}
@keyframes gridDrift { to{transform:translate(34px,34px)} }

/* Orbes de luz */
.orb {
    position:absolute; border-radius:50%;
    pointer-events:none; filter:blur(70px);
}
.orb-a { width:280px; height:280px; background:var(--green); opacity:.1; top:5%; left:-80px; animation:orbF 9s ease-in-out infinite; }
.orb-b { width:220px; height:220px; background:#004C99; opacity:.2; bottom:8%; right:-60px; animation:orbF 12s ease-in-out infinite reverse; }
.orb-c { width:150px; height:150px; background:var(--green); opacity:.07; top:50%; left:40%; animation:orbF 7s ease-in-out infinite 2s; }
@keyframes orbF { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)} }

/* Contenido del panel — centrado verticalmente */
.pl-body {
    position:absolute; inset:0; z-index:3;
    display:flex; flex-direction:column;
    justify-content:center;
    padding: 2.8rem 3rem;
    gap: 2.2rem;
}

/* Logo */
.pl-logo {
    display:flex; align-items:center; gap:10px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-weight:800; font-size:1.55rem; letter-spacing:-1px;
    width: fit-content;
}
.pl-logo .iw {
    width:36px; height:36px; border-radius:10px;
    background:linear-gradient(135deg, var(--navy), var(--green2));
    display:flex; align-items:center; justify-content:center;
    box-shadow: 0 0 20px rgba(0,220,130,.4);
}
.pl-logo .iw svg { width:18px; height:18px; stroke:#fff; }
.pl-logo .dot { color:var(--green); }

/* Texto principal */
.pl-heading h2 {
    font-family:'Plus Jakarta Sans', sans-serif;
    font-size: clamp(1.9rem, 2.6vw, 2.6rem);
    font-weight:800; line-height:1.18; letter-spacing:-.5px;
    margin-bottom:.9rem;
}
.pl-heading h2 em {
    font-style:normal;
    background: linear-gradient(90deg, var(--green), #00ffaa, var(--green));
    background-size:200%;
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
    animation: shimmer 4s linear infinite;
}
@keyframes shimmer { from{background-position:0%} to{background-position:200%} }
.pl-heading p { font-size:.95rem; color:var(--muted); line-height:1.7; max-width:320px; }

/* Stats row */
.pl-stats {
    display:flex; gap:1.6rem; flex-wrap:wrap;
}
.ps { }
.ps-n {
    font-family:'Plus Jakarta Sans', sans-serif;
    font-size:1.65rem; font-weight:800; color:var(--green); line-height:1; display:block;
}
.ps-l { font-size:.72rem; color:var(--muted); margin-top:.2rem; display:block; letter-spacing:.3px; }

/* Avatar stack */
.av-stack { display:flex; align-items:center; }
.av {
    width:34px; height:34px; border-radius:50%;
    border:2.5px solid rgba(0,16,32,.9);
    display:flex; align-items:center; justify-content:center;
    font-size:.68rem; font-weight:800;
    margin-left:-9px; flex-shrink:0;
    transition: transform .2s, z-index 0s;
    cursor:default;
}
.av:first-child { margin-left:0; }
.av:hover { transform:translateY(-5px) scale(1.12); z-index:20; }
.av-txt { margin-left:12px; font-size:.8rem; color:var(--muted); font-weight:600; line-height:1.4; }
.av-txt strong { color:var(--green); }

/* Testimonio */
.pl-card {
    background: rgba(0,220,130,.07);
    border: 1px solid rgba(0,220,130,.2);
    border-radius:18px; padding:1.3rem 1.5rem;
    position:relative; overflow:hidden;
}
.pl-card::before {
    content:'"'; position:absolute; top:-10px; left:14px;
    font-size:5rem; font-family:Georgia,serif; color:rgba(0,220,130,.12);
    line-height:1; pointer-events:none; user-select:none;
}
.pl-card-text { font-size:.88rem; color:rgba(241,245,249,.78); line-height:1.7; font-style:italic; margin-bottom:.9rem; }
.pl-card-author { display:flex; align-items:center; gap:10px; }
.pl-card-av {
    width:32px; height:32px; border-radius:50%; flex-shrink:0;
    background:linear-gradient(135deg, var(--navy), var(--green2));
    display:flex; align-items:center; justify-content:center;
    font-size:.72rem; font-weight:800;
}
.pl-card-name { font-size:.82rem; font-weight:700; }
.pl-card-role { font-size:.7rem; color:var(--muted); }

/* Badge seguro */
.pl-badge {
    display:inline-flex; align-items:center; gap:8px;
    background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.08);
    border-radius:50px; padding:.42rem 1rem;
    font-size:.74rem; color:rgba(241,245,249,.55); font-weight:600;
    width:fit-content;
}
.pl-badge-dot { width:7px; height:7px; border-radius:50%; background:var(--green); box-shadow:0 0 8px var(--green); flex-shrink:0; animation:bdot 2s infinite; }
@keyframes bdot { 0%,100%{opacity:1} 50%{opacity:.3} }
.pl-badge svg { width:13px; height:13px; stroke:var(--green); }

/* ══════════════════════════════════════
   PANEL DERECHO — formulario (scrollable)
══════════════════════════════════════ */
.pr {
    width:100%; max-width:500px;
    background:var(--navy3);
    display:flex; flex-direction:column;
    padding: 5rem 3.5rem 4rem;
    position:relative;
    min-height:100vh;
}

/* Glow sutil */
.pr::before {
    content:'';
    position:fixed; top:0; right:0;
    width:400px; height:400px; border-radius:50%;
    background:radial-gradient(circle, rgba(0,220,130,.05) 0%, transparent 70%);
    pointer-events:none; z-index:0;
}
.pr > * { position:relative; z-index:1; }

/* Logo móvil */
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

/* Eyebrow */
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
    animation:bdot 2s infinite;
}

/* Título */
.form-h { font-family:'Plus Jakarta Sans', sans-serif; font-size:clamp(1.75rem,3vw,2.2rem); font-weight:800; letter-spacing:-.5px; line-height:1.15; margin-bottom:.45rem; }
.form-sub { font-size:.93rem; color:var(--muted); margin-bottom:2.2rem; line-height:1.6; }

/* Error */
.ferr {
    display:flex; align-items:center; gap:9px;
    background:rgba(255,82,82,.1); border:1px solid rgba(255,82,82,.35);
    border-radius:10px; padding:.8rem 1rem;
    font-size:.86rem; font-weight:600; color:#FF8080; margin-bottom:1.3rem;
    animation:shake .4s ease;
}
.ferr svg { width:16px; height:16px; flex-shrink:0; }
@keyframes shake { 0%,100%{transform:translateX(0)} 20%,60%{transform:translateX(-5px)} 40%,80%{transform:translateX(5px)} }

/* Grupos */
.fgrp { margin-bottom:1.15rem; }
.flbl { font-size:.8rem; font-weight:700; color:rgba(241,245,249,.75); margin-bottom:.5rem; display:block; }

/* Input wrap */
.fwrap { position:relative; display:flex; align-items:center; }
.ficon {
    position:absolute; left:.95rem; z-index:1;
    color:rgba(241,245,249,.28); display:flex; align-items:center;
    pointer-events:none; transition:color .2s;
}
.ficon svg { width:16px; height:16px; }
.fwrap:focus-within .ficon { color:var(--green); }

.finput {
    width:100%; padding:.85rem 1rem .85rem 2.65rem;
    background:rgba(255,255,255,.05);
    border:1.5px solid rgba(255,255,255,.08);
    border-radius:12px; outline:none;
    font-family:'DM Sans', sans-serif; font-size:.94rem; color:var(--white);
    transition:border-color .2s, background .2s, box-shadow .2s;
}
.finput::placeholder { color:rgba(241,245,249,.22); }
.finput:focus {
    border-color:var(--green);
    background:rgba(0,220,130,.04);
    box-shadow:0 0 0 3px rgba(0,220,130,.1);
}
.finput.err { border-color:var(--err); box-shadow:0 0 0 3px rgba(255,82,82,.1); }

/* Toggle ojo */
.ftoggle {
    position:absolute; right:.85rem;
    background:none; border:none; cursor:pointer;
    color:rgba(241,245,249,.28); display:flex; padding:.2rem;
    transition:color .2s;
}
.ftoggle:hover { color:var(--white); }
.ftoggle svg { width:16px; height:16px; }

/* Botón principal */
.btn-go {
    width:100%; padding:.95rem;
    background:var(--green); color:var(--navy);
    border:none; border-radius:12px;
    font-family:'Plus Jakarta Sans', sans-serif;
    font-weight:800; font-size:1rem; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:9px;
    box-shadow:0 8px 28px rgba(0,220,130,.35);
    transition:all .28s cubic-bezier(.34,1.56,.64,1);
    margin-top:.3rem;
}
.btn-go:hover {
    transform:translateY(-2px) scale(1.02);
    background:#00f090;
    box-shadow:0 14px 36px rgba(0,220,130,.5);
}
.btn-go svg { width:18px; height:18px; }

/* Separador */
.sep { display:flex; align-items:center; gap:12px; margin:1.6rem 0; color:rgba(241,245,249,.18); font-size:.75rem; }
.sep::before, .sep::after { content:''; flex:1; height:1px; background:rgba(255,255,255,.06); }

/* Link pie */
.ffoot { text-align:center; font-size:.88rem; color:var(--muted); }
.ffoot a { color:var(--green); font-weight:700; }
.ffoot a:hover { text-decoration:underline; }

/* Volver */
.fback {
    display:inline-flex; align-items:center; gap:5px;
    font-size:.78rem; font-weight:600; color:var(--muted);
    margin-top:.8rem; transition:color .2s;
}
.fback:hover { color:var(--white); }
.fback svg { width:13px; height:13px; }

/* Seguridad hint */
.sec-hint {
    display:flex; align-items:center; gap:7px;
    font-size:.75rem; color:rgba(241,245,249,.3); margin-top:1.6rem;
    padding-top:1.4rem; border-top:1px solid rgba(255,255,255,.05);
    justify-content:center;
}
.sec-hint svg { width:13px; height:13px; stroke:rgba(0,220,130,.5); }

/* Animación de entrada */
.pr { animation:slideIn .55s cubic-bezier(.22,1,.36,1) both; }
@keyframes slideIn { from{opacity:0;transform:translateX(24px)} to{opacity:1;transform:translateX(0)} }

@media(max-width:900px) {
    .pr { max-width:100%; padding:3rem 2rem 4rem; }
}
@media(max-width:480px) {
    .pr { padding:2.5rem 1.5rem 3rem; }
}
</style>
</head>
<body>

<!-- ── PANEL IZQUIERDO ── -->
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
            <h2>Bienvenido<br>de <em>regreso.</em></h2>
            <p>Accede a tu cuenta y retoma tus actividades extracurriculares donde las dejaste.</p>
        </div>

        <div class="pl-stats">
            <div class="ps">
                <span class="ps-n">500+</span>
                <span class="ps-l">Estudiantes activos</span>
            </div>
            <div class="ps">
                <span class="ps-n">12</span>
                <span class="ps-l">Actividades</span>
            </div>
            <div class="ps">
                <span class="ps-n">98%</span>
                <span class="ps-l">Satisfacción</span>
            </div>
        </div>

        <!-- Avatares -->
        <div class="av-stack">
            <div class="av" style="background:linear-gradient(135deg,#002D62,#00b868)">JR</div>
            <div class="av" style="background:linear-gradient(135deg,#004C99,#00DC82)">AM</div>
            <div class="av" style="background:linear-gradient(135deg,#00b868,#002D62)">SC</div>
            <div class="av" style="background:linear-gradient(135deg,#003580,#009960)">LP</div>
            <div class="av" style="background:linear-gradient(135deg,#005e8a,#00DC82)">KV</div>
            <div class="av" style="background:rgba(0,220,130,.15);border:1px solid rgba(0,220,130,.3);color:var(--green);font-size:.65rem">+495</div>
            <span class="av-txt">Únete a<br><strong>500+ estudiantes</strong></span>
        </div>

        <!-- Testimonio -->
        <div class="pl-card">
            <p class="pl-card-text">"AddedUT me ayudó a inscribirme al taller de música en segundos. Todo muy fácil y organizado."</p>
            <div class="pl-card-author">
                <div class="pl-card-av">MC</div>
                <div>
                    <div class="pl-card-name">María C.</div>
                    <div class="pl-card-role">Estudiante · Ing. en Software</div>
                </div>
            </div>
        </div>

        <div class="pl-badge">
            <div class="pl-badge-dot"></div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
            Plataforma oficial · UTTEC · Conexión segura
        </div>

    </div>
</div>

<!-- ── PANEL DERECHO ── -->
<div class="pr">

    <a href="/" class="mob-logo">
        <div class="iw"><i data-feather="book-open"></i></div>
        Added<span class="dot">UT</span>
    </a>

    <span class="eyebrow"><span class="eyebrow-dot"></span> Acceso seguro</span>
    <h1 class="form-h">Inicia sesión en<br>tu cuenta</h1>
    <p class="form-sub">Usa tus credenciales institucionales para continuar.</p>

    @if($errors->any())
    <div class="ferr">
        <i data-feather="alert-circle"></i>
        {{ $errors->first() }}
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <!-- Email -->
        <div class="fgrp">
            <label class="flbl" for="email">Correo electrónico</label>
            <div class="fwrap">
                <span class="ficon"><i data-feather="mail"></i></span>
                <input class="finput {{ $errors->has('email') ? 'err' : '' }}"
                    type="email" name="email" id="email"
                    placeholder="matricula@uttec.edu.mx"
                    value="{{ old('email') }}" required autofocus>
            </div>
        </div>

        <!-- Contraseña -->
        <div class="fgrp">
            <label class="flbl" for="pwd">Contraseña</label>
            <div class="fwrap">
                <span class="ficon"><i data-feather="lock"></i></span>
                <input class="finput {{ $errors->has('password') ? 'err' : '' }}"
                    type="password" name="password" id="pwd"
                    placeholder="••••••••" required>
                <button type="button" class="ftoggle" onclick="togglePwd('pwd',this)" aria-label="Mostrar">
                    <i data-feather="eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-go">
            <i data-feather="log-in"></i>
            Ingresar a AddedUT
        </button>
    </form>

    <div class="sep">o</div>

    <div class="ffoot" style="margin-bottom:.7rem">
        ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate gratis</a>
    </div>
    <div class="ffoot">
        <a href="/" class="fback"><i data-feather="arrow-left"></i> Volver al inicio</a>
    </div>

    <div class="sec-hint">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
        Tu información está protegida con cifrado seguro
    </div>

</div>

<script>
feather.replace();
function togglePwd(id, btn) {
    const el = document.getElementById(id);
    const show = el.type === 'password';
    el.type = show ? 'text' : 'password';
    btn.innerHTML = show
        ? `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
        : `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}
</script>
</body>
</html>