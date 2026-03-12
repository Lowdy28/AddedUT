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
    --navy:  #002D62; --navy2: #001a3d; --navy3: #001020;
    --green: #00DC82; --green2:#00b868;
    --white: #F1F5F9; --muted: rgba(241,245,249,.48);
    --bdr:   rgba(0,220,130,.18); --err: #FF5252;
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { height:100%; }
body { font-family:'DM Sans',sans-serif; background:var(--navy3); color:var(--white); min-height:100vh; display:flex; overflow-x:hidden; }
a { text-decoration:none; color:inherit; }

/* Panel izquierdo */
.pl { display:none; flex:1; position:sticky; top:0; height:100vh; flex-shrink:0; overflow:hidden; }
@media(min-width:900px){ .pl { display:block; } }
.pl-bg { position:absolute; inset:0; background:url('{{ asset("imagenes/background.jpg") }}') center/cover no-repeat; filter:brightness(.28) saturate(.55); transform:scale(1.06); animation:bgZ 22s ease-in-out infinite alternate; }
@keyframes bgZ { from{transform:scale(1.06)} to{transform:scale(1.13)} }
.pl-overlay { position:absolute; inset:0; background:linear-gradient(145deg,rgba(0,16,32,.96) 0%,rgba(0,40,90,.75) 50%,rgba(0,60,40,.65) 100%); }
.pl-grid { position:absolute; inset:0; background-image:radial-gradient(circle,rgba(0,220,130,.07) 1px,transparent 1px); background-size:34px 34px; animation:gridDrift 28s linear infinite; }
@keyframes gridDrift { to{transform:translate(34px,34px)} }
.orb { position:absolute; border-radius:50%; pointer-events:none; filter:blur(70px); }
.orb-a { width:280px; height:280px; background:var(--green); opacity:.1; top:5%; left:-80px; animation:orbF 9s ease-in-out infinite; }
.orb-b { width:220px; height:220px; background:#004C99; opacity:.2; bottom:8%; right:-60px; animation:orbF 12s ease-in-out infinite reverse; }
@keyframes orbF { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-30px)} }
.pl-body { position:absolute; inset:0; z-index:3; display:flex; flex-direction:column; justify-content:center; padding:2.8rem 3rem; gap:2rem; }
.pl-logo { display:flex; align-items:center; gap:10px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.55rem; letter-spacing:-1px; }
.pl-logo .iw { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--navy),var(--green2)); display:flex; align-items:center; justify-content:center; box-shadow:0 0 20px rgba(0,220,130,.4); font-weight:900; font-size:1.1rem; color:var(--green); }
.pl-logo .dot { color:var(--green); }
.pl-heading h2 { font-family:'Plus Jakarta Sans',sans-serif; font-size:clamp(1.9rem,2.4vw,2.4rem); font-weight:800; line-height:1.18; letter-spacing:-.5px; margin-bottom:.9rem; }
.pl-heading h2 em { font-style:normal; background:linear-gradient(90deg,var(--green),#00ffaa,var(--green)); background-size:200%; -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; animation:shimmer 4s linear infinite; }
@keyframes shimmer { from{background-position:0%} to{background-position:200%} }
.pl-heading p { font-size:.93rem; color:var(--muted); line-height:1.7; max-width:320px; }

/* Panel derecho */
.pr { width:100%; max-width:500px; background:var(--navy3); display:flex; flex-direction:column; padding:5rem 3.5rem 4rem; position:relative; min-height:100vh; }
.pr::before { content:''; position:fixed; top:0; right:0; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle,rgba(0,220,130,.05) 0%,transparent 70%); pointer-events:none; z-index:0; }
.pr > * { position:relative; z-index:1; }
.mob-logo { display:flex; align-items:center; gap:10px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.4rem; letter-spacing:-1px; margin-bottom:2.5rem; }
.mob-logo .iw { width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg,var(--navy),var(--green2)); display:flex; align-items:center; justify-content:center; font-weight:900; font-size:.95rem; color:var(--green); }
.mob-logo .dot { color:var(--green); }
@media(min-width:900px){ .mob-logo { display:none; } }

.eyebrow { display:inline-flex; align-items:center; gap:7px; background:rgba(0,220,130,.1); border:1px solid var(--bdr); border-radius:50px; padding:.32rem 1rem; font-size:.7rem; font-weight:800; color:var(--green); letter-spacing:1.4px; text-transform:uppercase; margin-bottom:1.1rem; }
.eyebrow-dot { width:6px; height:6px; border-radius:50%; background:var(--green); box-shadow:0 0 7px var(--green); animation:bdot 2s infinite; }
@keyframes bdot { 0%,100%{opacity:1} 50%{opacity:.3} }
.form-h { font-family:'Plus Jakarta Sans',sans-serif; font-size:clamp(1.6rem,3vw,2rem); font-weight:800; letter-spacing:-.5px; line-height:1.15; margin-bottom:.45rem; }
.form-sub { font-size:.9rem; color:var(--muted); margin-bottom:2rem; line-height:1.6; }

/* Alert éxito */
.alert-ok {
    background:rgba(0,220,130,.08); border:1px solid rgba(0,220,130,.3);
    border-radius:14px; padding:1.1rem 1.2rem;
    font-size:.9rem; color:rgba(241,245,249,.88);
    display:flex; align-items:flex-start; gap:.75rem;
    margin-bottom:1.5rem; line-height:1.6;
}
.alert-ok svg { flex-shrink:0; margin-top:2px; stroke:var(--green); }
.alert-ok strong { color:var(--green); display:block; margin-bottom:.2rem; }

/* Alert error */
.alert-err { background:rgba(255,82,82,.1); border:1px solid rgba(255,82,82,.35); border-radius:12px; padding:.85rem 1.1rem; font-size:.88rem; color:#FF5252; display:flex; align-items:center; gap:.6rem; margin-bottom:1.3rem; }
.alert-err svg { flex-shrink:0; }

.fgrp { margin-bottom:1.2rem; }
.flbl { display:block; font-size:.78rem; font-weight:700; color:rgba(241,245,249,.65); letter-spacing:.6px; text-transform:uppercase; margin-bottom:.5rem; }
.fwrap { display:flex; align-items:center; background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1); border-radius:12px; overflow:hidden; transition:border-color .2s, box-shadow .2s; }
.fwrap:focus-within { border-color:var(--green); box-shadow:0 0 0 3px rgba(0,220,130,.12); }
.fwrap.err { border-color:var(--err); }
.ficon { padding:0 .85rem; display:flex; align-items:center; color:rgba(241,245,249,.3); }
.ficon svg { width:16px; height:16px; }
.finput { flex:1; background:transparent; border:none; outline:none; color:var(--white); font-size:.95rem; padding:.85rem .85rem .85rem 0; font-family:'DM Sans',sans-serif; }
.finput::placeholder { color:rgba(241,245,249,.25); }
.ferr { font-size:.78rem; color:var(--err); margin-top:.35rem; display:block; }

.btn-go { width:100%; padding:1rem; border:none; border-radius:14px; background:linear-gradient(135deg,var(--green2),var(--green)); color:#001a1a; font-weight:800; font-size:1rem; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.5rem; box-shadow:0 4px 20px rgba(0,220,130,.3); transition:box-shadow .2s, transform .15s; font-family:'Plus Jakarta Sans',sans-serif; letter-spacing:.3px; margin-top:.5rem; }
.btn-go:hover { box-shadow:0 8px 28px rgba(0,220,130,.45); transform:translateY(-2px); }
.btn-go:disabled { opacity:.6; cursor:not-allowed; transform:none; }
.btn-go svg { width:18px; height:18px; }

.ffoot { text-align:center; margin-top:1.4rem; font-size:.88rem; color:var(--muted); }
.ffoot a { color:var(--green); font-weight:700; transition:opacity .2s; }
.ffoot a:hover { opacity:.8; }
.fback { display:inline-flex; align-items:center; gap:.4rem; font-size:.84rem; color:var(--muted); transition:color .2s; }
.fback:hover { color:var(--green); }
</style>
</head>
<body>

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
            <p>Te enviaremos un enlace seguro a tu correo institucional para que puedas establecer una nueva contraseña.</p>
        </div>
        <div style="background:rgba(0,220,130,.07); border:1px solid rgba(0,220,130,.2); border-radius:18px; padding:1.3rem 1.5rem;">
            <p style="font-size:.85rem; color:rgba(241,245,249,.75); line-height:1.7;">
                🔒 El enlace expira en <strong style="color:var(--green);">60 minutos</strong> y solo puede usarse una vez.
            </p>
        </div>
    </div>
</div>

<div class="pr">
    <div class="mob-logo">
        <div class="iw">A</div>
        Added<span class="dot">UT</span>
    </div>

    <div class="eyebrow">
        <div class="eyebrow-dot"></div>
        Recuperar acceso
    </div>
    <h1 class="form-h">¿Olvidaste tu contraseña?</h1>
    <p class="form-sub">Ingresa tu correo institucional y te enviamos el enlace de recuperación.</p>

    {{-- Mensaje de éxito --}}
    @if (session('status'))
        <div class="alert-ok">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>¡Correo enviado!</strong>
                Revisa tu bandeja en Mailtrap. El enlace es válido por 60 minutos.
            </div>
        </div>
    @endif

    {{-- Error --}}
    @if ($errors->any())
        <div class="alert-err">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" id="form-recuperar">
        @csrf
        <div class="fgrp">
            <label class="flbl" for="email">Correo institucional</label>
            <div class="fwrap {{ $errors->has('email') ? 'err' : '' }}">
                <span class="ficon"><i data-feather="mail"></i></span>
                <input class="finput" type="email" name="email" id="email"
                       placeholder="matricula@e.uttecamac.edu.mx"
                       value="{{ old('email') }}" required autofocus>
            </div>
            @error('email')
                <span class="ferr">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-go" id="btn-enviar">
            <i data-feather="send"></i>
            Enviar enlace de recuperación
        </button>
    </form>

    <div class="ffoot" style="margin-top:1.5rem;">
        <a href="{{ route('login') }}" class="fback">
            <i data-feather="arrow-left"></i> Volver al inicio de sesión
        </a>
    </div>
</div>

<script>
feather.replace();
document.getElementById('form-recuperar').addEventListener('submit', function() {
    const btn = document.getElementById('btn-enviar');
    btn.disabled = true;
    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg> Enviando...';
});
</script>
</body>
</html>
