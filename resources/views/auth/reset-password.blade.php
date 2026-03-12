<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña | AddedUT</title>
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

.pr { width:100%; max-width:500px; background:var(--navy3); display:flex; flex-direction:column; padding:5rem 3.5rem 4rem; position:relative; min-height:100vh; }
.pr::before { content:''; position:fixed; top:0; right:0; width:400px; height:400px; border-radius:50%; background:radial-gradient(circle,rgba(0,220,130,.05) 0%,transparent 70%); pointer-events:none; z-index:0; }
.pr > * { position:relative; z-index:1; }
.mob-logo { display:flex; align-items:center; gap:10px; font-family:'Plus Jakarta Sans',sans-serif; font-weight:800; font-size:1.4rem; letter-spacing:-1px; margin-bottom:2.5rem; }
.mob-logo .iw { width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg,var(--navy),var(--green2)); display:flex; align-items:center; justify-content:center; font-weight:900; font-size:.95rem; color:var(--green); }
.mob-logo .dot { color:var(--green); }
@media(min-width:900px){ .mob-logo { display:none; } }

.eyebrow { display:inline-flex; align-items:center; gap:7px; background:rgba(0,220,130,.1); border:1px solid var(--bdr); border-radius:50px; padding:.32rem 1rem; font-size:.7rem; font-weight:800; color:var(--green); letter-spacing:1.4px; text-transform:uppercase; margin-bottom:1.1rem; }
.eyebrow-dot { width:6px; height:6px; border-radius:50%; background:var(--green); box-shadow:0 0 7px var(--green); }
.form-h { font-family:'Plus Jakarta Sans',sans-serif; font-size:clamp(1.6rem,3vw,2rem); font-weight:800; letter-spacing:-.5px; line-height:1.15; margin-bottom:.45rem; }
.form-sub { font-size:.9rem; color:var(--muted); margin-bottom:1.5rem; line-height:1.6; }

.alert-err { background:rgba(255,82,82,.1); border:1px solid rgba(255,82,82,.35); border-radius:12px; padding:.85rem 1.1rem; font-size:.88rem; color:#FF5252; display:flex; align-items:center; gap:.6rem; margin-bottom:1.3rem; }

.fgrp { margin-bottom:1.2rem; }
.flbl { display:block; font-size:.78rem; font-weight:700; color:rgba(241,245,249,.65); letter-spacing:.6px; text-transform:uppercase; margin-bottom:.5rem; }
.fwrap { display:flex; align-items:center; background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1); border-radius:12px; overflow:hidden; transition:border-color .2s, box-shadow .2s; }
.fwrap:focus-within { border-color:var(--green); box-shadow:0 0 0 3px rgba(0,220,130,.12); }
.fwrap.err { border-color:var(--err); }
.ficon { padding:0 .85rem; display:flex; align-items:center; color:rgba(241,245,249,.3); }
.ficon svg { width:16px; height:16px; }
.finput { flex:1; background:transparent; border:none; outline:none; color:var(--white); font-size:.95rem; padding:.85rem .85rem .85rem 0; font-family:'DM Sans',sans-serif; }
.finput::placeholder { color:rgba(241,245,249,.25); }
.ftoggle { background:transparent; border:none; padding:0 .85rem; color:rgba(241,245,249,.3); cursor:pointer; display:flex; align-items:center; transition:color .2s; }
.ftoggle:hover { color:var(--green); }
.ferr { font-size:.78rem; color:var(--err); margin-top:.35rem; display:block; }

/* Email readonly chip */
.email-chip {
    display:flex; align-items:center; gap:.6rem;
    background:rgba(255,255,255,.04); border:1px solid rgba(255,255,255,.1);
    border-radius:12px; padding:.7rem 1rem; margin-bottom:1.5rem;
    font-size:.88rem; color:var(--muted);
}
.email-chip svg { width:15px; height:15px; flex-shrink:0; stroke:var(--green); }
.email-chip span { color:var(--white); font-weight:600; }

/* Fortaleza contraseña */
.pwd-bars { display:flex; gap:4px; margin-top:.5rem; margin-bottom:.3rem; }
.pwd-bar { flex:1; height:3px; border-radius:50px; background:rgba(255,255,255,.1); transition:background .3s; }
.pwd-bar.weak   { background:#FF5252; }
.pwd-bar.medium { background:#f59e0b; }
.pwd-bar.strong { background:var(--green); }
.pwd-hint { font-size:.75rem; color:var(--muted); }

.btn-go { width:100%; padding:1rem; border:none; border-radius:14px; background:linear-gradient(135deg,var(--green2),var(--green)); color:#001a1a; font-weight:800; font-size:1rem; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:.5rem; box-shadow:0 4px 20px rgba(0,220,130,.3); transition:box-shadow .2s, transform .15s; font-family:'Plus Jakarta Sans',sans-serif; letter-spacing:.3px; margin-top:.5rem; }
.btn-go:hover { box-shadow:0 8px 28px rgba(0,220,130,.45); transform:translateY(-2px); }
.btn-go svg { width:18px; height:18px; }
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
            <h2>Crea una contraseña <em>segura</em></h2>
            <p>Elige una contraseña que no hayas usado antes. Recomendamos combinar letras, números y símbolos.</p>
        </div>
        <div style="background:rgba(0,220,130,.07); border:1px solid rgba(0,220,130,.2); border-radius:18px; padding:1.3rem 1.5rem;">
            <p style="font-size:.85rem; color:rgba(241,245,249,.75); line-height:1.7;">
                ✅ Enlace verificado. Ya puedes establecer tu nueva contraseña.
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
        Nueva contraseña
    </div>
    <h1 class="form-h">Escribe tu nueva contraseña</h1>
    <p class="form-sub">El enlace es de un solo uso. Una vez que guardes, podrás iniciar sesión normalmente.</p>

    {{-- Correo del usuario --}}
    <div class="email-chip">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
            <polyline points="22,6 12,13 2,6"/>
        </svg>
        <span>{{ request('email') ?? old('email') }}</span>
    </div>

    @if ($errors->any())
        <div class="alert-err">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Token oculto — Laravel lo requiere para validar el enlace --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ request('email') ?? old('email') }}">

        <div class="fgrp">
            <label class="flbl" for="password">Nueva contraseña</label>
            <div class="fwrap {{ $errors->has('password') ? 'err' : '' }}">
                <span class="ficon"><i data-feather="lock"></i></span>
                <input class="finput" type="password" name="password" id="password"
                       placeholder="Mínimo 8 caracteres" required autofocus
                       oninput="checkStrength(this.value)">
                <button type="button" class="ftoggle" onclick="togglePwd('password',this)">
                    <i data-feather="eye"></i>
                </button>
            </div>
            <div class="pwd-bars">
                <div class="pwd-bar" id="bar1"></div>
                <div class="pwd-bar" id="bar2"></div>
                <div class="pwd-bar" id="bar3"></div>
                <div class="pwd-bar" id="bar4"></div>
            </div>
            <span class="pwd-hint" id="pwd-hint">Escribe tu contraseña</span>
            @error('password')
                <span class="ferr">{{ $message }}</span>
            @enderror
        </div>

        <div class="fgrp">
            <label class="flbl" for="password_confirmation">Confirmar contraseña</label>
            <div class="fwrap">
                <span class="ficon"><i data-feather="lock"></i></span>
                <input class="finput" type="password" name="password_confirmation"
                       id="password_confirmation" placeholder="Repite la contraseña" required>
                <button type="button" class="ftoggle" onclick="togglePwd('password_confirmation',this)">
                    <i data-feather="eye"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-go">
            <i data-feather="check-circle"></i>
            Guardar nueva contraseña
        </button>
    </form>
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

function checkStrength(val) {
    const bars = ['bar1','bar2','bar3','bar4'].map(id => document.getElementById(id));
    const hint = document.getElementById('pwd-hint');
    bars.forEach(b => b.className = 'pwd-bar');
    if (!val) { hint.textContent = 'Escribe tu contraseña'; hint.style.color = ''; return; }

    let score = 0;
    if (val.length >= 8)  score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const labels = ['','Débil','Regular','Buena','Fuerte'];
    const cls    = ['','weak', 'medium','strong','strong'];
    for (let i = 0; i < score; i++) bars[i].classList.add(cls[score]);
    hint.textContent = labels[score] || 'Muy corta';
    hint.style.color = score >= 3 ? 'var(--green)' : score === 2 ? '#f59e0b' : '#FF5252';
}
</script>
</body>
</html>
