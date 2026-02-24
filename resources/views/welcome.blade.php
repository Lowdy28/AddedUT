<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddedUT | Actividades Extracurriculares · UTTEC</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

<style>
/* ═══════════════════════════════════════════════
   VARIABLES & RESET
═══════════════════════════════════════════════ */
:root {
    --navy:   #002D62;
    --navy2:  #001a3d;
    --green:  #00DC82;
    --green2: #00b868;
    --white:  #F1F5F9;
    --muted:  rgba(241,245,249,.55);
    --glass:  rgba(0,45,98,.35);
    --border: rgba(0,220,130,.18);
}
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
html { scroll-behavior: smooth; }
body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy2);
    color: var(--white);
    overflow-x: hidden;
}
a { text-decoration: none; color: inherit; }

/* ═══════════════════════════════════════════════
   ANIMATED BACKGROUND MESH
═══════════════════════════════════════════════ */
.bg-mesh {
    position: fixed; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 20% 10%, rgba(0,220,130,.12) 0%, transparent 60%),
        radial-gradient(ellipse 60% 70% at 80% 80%, rgba(0,45,98,.9) 0%, transparent 70%),
        radial-gradient(ellipse 100% 100% at 50% 50%, var(--navy2) 30%, #000d1a 100%);
    animation: meshShift 18s ease-in-out infinite alternate;
}
.bg-mesh::after {
    content: '';
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle, rgba(0,220,130,.06) 1px, transparent 1px);
    background-size: 40px 40px;
    animation: gridDrift 30s linear infinite;
}
@keyframes meshShift {
    0%   { filter: hue-rotate(0deg); }
    100% { filter: hue-rotate(12deg); }
}
@keyframes gridDrift {
    from { transform: translate(0,0); }
    to   { transform: translate(40px, 40px); }
}

/* Partículas flotantes */
.particle {
    position: fixed; border-radius: 50%;
    background: var(--green); opacity: 0;
    animation: particleFloat linear infinite;
    pointer-events: none; z-index: 0;
}
@keyframes particleFloat {
    0%   { opacity: 0; transform: translateY(100vh) scale(0); }
    10%  { opacity: .3; }
    90%  { opacity: .1; }
    100% { opacity: 0; transform: translateY(-10vh) scale(1); }
}

/* ═══════════════════════════════════════════════
   NAVBAR
═══════════════════════════════════════════════ */
.navbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 100;
    padding: 1.1rem 5%;
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(0,13,30,.6); backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(0,220,130,.1);
    transition: padding .3s, background .3s;
}
.navbar.scrolled {
    padding: .75rem 5%;
    background: rgba(0,13,30,.92);
    box-shadow: 0 4px 30px rgba(0,0,0,.4);
}
.nav-logo {
    display: flex; align-items: center; gap: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.6rem;
    letter-spacing: -1px;
}
.nav-logo .dot { color: var(--green); }
.nav-logo .icon-wrap {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--navy), var(--green2));
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 0 18px rgba(0,220,130,.35);
}
.nav-logo .icon-wrap svg { width: 18px; height: 18px; stroke: #fff; }
.nav-actions { display: flex; gap: 12px; align-items: center; }
.nav-btn {
    padding: .5rem 1.4rem; border-radius: 50px;
    font-family: 'DM Sans', sans-serif; font-weight: 600; font-size: .88rem;
    transition: all .25s; cursor: pointer; border: none;
}
.nav-btn-ghost {
    background: transparent; color: var(--white);
    border: 1.5px solid rgba(241,245,249,.25);
}
.nav-btn-ghost:hover { border-color: var(--green); color: var(--green); }
.nav-btn-solid {
    background: var(--green); color: var(--navy);
    box-shadow: 0 4px 18px rgba(0,220,130,.35);
}
.nav-btn-solid:hover { background: #00f090; transform: translateY(-1px); box-shadow: 0 6px 24px rgba(0,220,130,.5); }

/* ═══════════════════════════════════════════════
   HERO
═══════════════════════════════════════════════ */
.hero {
    position: relative; z-index: 1;
    min-height: 100vh;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    text-align: center;
    padding: 120px 5% 80px;
    overflow: hidden;
}

/* Imagen de fondo del hero con overlay */
.hero-bg {
    position: absolute; inset: 0;
    background: url('{{ asset('imagenes/background.jpg') }}') center/cover no-repeat;
    filter: brightness(.25) saturate(.6);
    transform: scale(1.05);
    animation: heroZoom 20s ease-in-out infinite alternate;
}
@keyframes heroZoom {
    from { transform: scale(1.05); }
    to   { transform: scale(1.12); }
}

/* Línea decorativa de acento */
.hero-accent {
    display: inline-flex; align-items: center; gap: 10px;
    background: rgba(0,220,130,.1); border: 1px solid var(--border);
    border-radius: 50px; padding: .42rem 1.2rem;
    font-size: .78rem; font-weight: 600; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--green);
    margin-bottom: 2rem;
    animation: fadeDown .8s ease both;
}
.hero-accent::before {
    content: ''; width: 6px; height: 6px;
    border-radius: 50%; background: var(--green);
    box-shadow: 0 0 8px var(--green);
    animation: pulse 2s infinite;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }

.hero-h1 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(3rem, 7vw, 6.5rem);
    font-weight: 800; line-height: 1.05;
    letter-spacing: -2px;
    margin-bottom: 1.5rem;
    animation: fadeDown 1s .15s ease both;
}
.hero-h1 .line2 {
    display: block;
    background: linear-gradient(90deg, var(--green), #00f5a0, var(--green));
    background-size: 200%;
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 4s linear infinite;
}
@keyframes shimmer { from{background-position:0%} to{background-position:200%} }

.hero-sub {
    font-size: clamp(1rem, 2.2vw, 1.28rem); font-weight: 300;
    color: var(--muted); max-width: 600px; line-height: 1.75;
    margin-bottom: 3rem;
    animation: fadeDown 1s .3s ease both;
}
.hero-sub strong { color: var(--white); font-weight: 600; }

.hero-btns {
    display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;
    margin-bottom: 5rem;
    animation: fadeDown 1s .45s ease both;
}
.btn-cta-primary {
    display: inline-flex; align-items: center; gap: 9px;
    padding: .9rem 2.2rem; border-radius: 50px;
    background: var(--green); color: var(--navy);
    font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: 1rem;
    box-shadow: 0 8px 28px rgba(0,220,130,.4);
    transition: all .28s cubic-bezier(.34,1.56,.64,1);
    border: none; cursor: pointer;
}
.btn-cta-primary:hover { transform: translateY(-3px) scale(1.03); box-shadow: 0 14px 40px rgba(0,220,130,.55); background: #00f090; }
.btn-cta-ghost {
    display: inline-flex; align-items: center; gap: 9px;
    padding: .9rem 2.2rem; border-radius: 50px;
    background: rgba(255,255,255,.07); color: var(--white);
    border: 1.5px solid rgba(241,245,249,.2);
    font-family: 'DM Sans', sans-serif; font-weight: 600; font-size: 1rem;
    backdrop-filter: blur(10px);
    transition: all .28s;
    cursor: pointer;
}
.btn-cta-ghost:hover { background: rgba(255,255,255,.13); border-color: rgba(241,245,249,.5); transform: translateY(-2px); }

/* Scroll indicator */
.scroll-hint {
    position: absolute; bottom: 36px; left: 50%; transform: translateX(-50%);
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    color: var(--muted); font-size: .75rem; letter-spacing: 1.5px; text-transform: uppercase;
    animation: fadeDown 1s .8s ease both;
}
.scroll-mouse {
    width: 22px; height: 36px; border: 2px solid rgba(241,245,249,.3);
    border-radius: 12px; position: relative;
}
.scroll-mouse::after {
    content: ''; position: absolute; top: 6px; left: 50%; transform: translateX(-50%);
    width: 3px; height: 7px; background: var(--green); border-radius: 2px;
    animation: scrollDot 2s ease-in-out infinite;
}
@keyframes scrollDot {
    0%,100% { transform: translateX(-50%) translateY(0); opacity:1; }
    80%      { transform: translateX(-50%) translateY(12px); opacity:0; }
}

/* ═══════════════════════════════════════════════
   STATS BAR
═══════════════════════════════════════════════ */
.stats-bar {
    position: relative; z-index: 1;
    background: rgba(0,45,98,.4); backdrop-filter: blur(20px);
    border-top: 1px solid rgba(0,220,130,.12);
    border-bottom: 1px solid rgba(0,220,130,.12);
    padding: 2.5rem 5%;
}
.stats-inner {
    max-width: 1100px; margin: 0 auto;
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}
.stat-item { text-align: center; }
.stat-num {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800; color: var(--green);
    line-height: 1;
    display: block; margin-bottom: .3rem;
}
.stat-lbl { font-size: .82rem; color: var(--muted); font-weight: 500; letter-spacing: .5px; }

/* ═══════════════════════════════════════════════
   ACTIVIDADES
═══════════════════════════════════════════════ */
.section {
    position: relative; z-index: 1;
    padding: 7rem 5%;
}
.section-header { text-align: center; margin-bottom: 3.5rem; }
.section-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(0,220,130,.1); border: 1px solid var(--border);
    border-radius: 50px; padding: .35rem 1.1rem;
    font-size: .72rem; font-weight: 700; letter-spacing: 1.5px;
    text-transform: uppercase; color: var(--green);
    margin-bottom: 1.2rem;
}
.section-h2 {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 800; letter-spacing: -1px; line-height: 1.15;
    margin-bottom: .9rem;
}
.section-h2 span { color: var(--green); }
.section-sub { font-size: 1.05rem; color: var(--muted); max-width: 520px; margin: 0 auto; line-height: 1.7; }

/* ═══════════════════════════════════════════════
   CARRUSEL DE ACTIVIDADES
═══════════════════════════════════════════════ */
.carousel-wrap {
    position: relative; max-width: 1200px; margin: 0 auto;
}

/* Flechas de navegación */
.car-arrow {
    position: absolute; top: 50%; transform: translateY(-50%);
    z-index: 10; width: 50px; height: 50px;
    background: rgba(0,13,30,.7); backdrop-filter: blur(12px);
    border: 1px solid rgba(0,220,130,.25); border-radius: 50%;
    color: var(--white); cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 4px 20px rgba(0,0,0,.4);
}
.car-arrow:hover {
    background: var(--green); border-color: var(--green);
    color: var(--navy); transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 24px rgba(0,220,130,.4);
}
.car-arrow svg { width: 20px; height: 20px; }
.car-prev { left: -26px; }
.car-next { right: -26px; }

/* Track */
.car-track-outer {
    overflow: hidden; border-radius: 24px;
}
.car-track {
    display: flex; gap: 20px;
    transition: transform .6s cubic-bezier(.77,0,.175,1);
    will-change: transform;
}

/* Cada slide */
.act-slide {
    flex: 0 0 calc(33.333% - 14px);
    position: relative; border-radius: 22px; overflow: hidden;
    cursor: pointer;
    border: 1px solid rgba(255,255,255,.07);
    aspect-ratio: 3/4;
    transition: transform .4s cubic-bezier(.22,1,.36,1), box-shadow .4s;
}
.act-slide img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform .7s cubic-bezier(.22,1,.36,1), filter .4s;
    filter: brightness(.5) saturate(.75);
}
.act-slide:hover { transform: translateY(-8px) scale(1.01); box-shadow: 0 30px 70px rgba(0,0,0,.6); }
.act-slide:hover img { transform: scale(1.09); filter: brightness(.38) saturate(1.1); }

/* Overlay del slide */
.act-slide-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,5,20,.95) 0%,
        rgba(0,20,60,.5)  45%,
        rgba(0,0,0,.05)   100%
    );
    display: flex; flex-direction: column; justify-content: flex-end;
    padding: 1.8rem 1.6rem;
    transition: background .4s;
}
.act-slide:hover .act-slide-overlay {
    background: linear-gradient(
        to top,
        rgba(0,5,20,.97) 0%,
        rgba(0,40,100,.6) 55%,
        rgba(0,0,0,.1)    100%
    );
}

/* Número grande decorativo */
.act-slide-num {
    position: absolute; top: 1.2rem; right: 1.4rem;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 4.5rem; font-weight: 800;
    color: rgba(255,255,255,.06); line-height: 1;
    pointer-events: none; user-select: none;
    transition: color .4s;
}
.act-slide:hover .act-slide-num { color: rgba(0,220,130,.1); }

.act-tag {
    display: inline-flex; align-items: center; gap: 5px;
    background: var(--green); color: var(--navy);
    font-size: .67rem; font-weight: 800; letter-spacing: 1px;
    text-transform: uppercase; padding: .28rem .8rem; border-radius: 50px;
    margin-bottom: .65rem; width: fit-content;
    box-shadow: 0 3px 12px rgba(0,220,130,.4);
}
.act-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.45rem; font-weight: 800;
    line-height: 1.2; margin-bottom: .5rem;
    transition: color .3s;
}
.act-slide:hover .act-name { color: var(--green); }
.act-desc {
    font-size: .85rem; color: rgba(241,245,249,.65); line-height: 1.6;
    max-height: 0; overflow: hidden;
    transition: max-height .4s ease, opacity .35s;
    opacity: 0;
}
.act-slide:hover .act-desc { max-height: 100px; opacity: 1; }

/* Hint "click" que aparece al hover */
.act-hint {
    display: inline-flex; align-items: center; gap: 5px;
    margin-top: .7rem;
    font-size: .75rem; font-weight: 700; color: var(--green);
    opacity: 0; transform: translateY(6px);
    transition: opacity .3s, transform .3s;
}
.act-slide:hover .act-hint { opacity: 1; transform: translateY(0); }
.act-hint svg { width: 13px; height: 13px; }

/* Dots / indicadores */
.car-dots {
    display: flex; justify-content: center; gap: 8px;
    margin-top: 2rem;
}
.car-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgba(241,245,249,.2); cursor: pointer;
    transition: all .3s cubic-bezier(.34,1.56,.64,1);
    border: none;
}
.car-dot.active {
    background: var(--green);
    width: 28px; border-radius: 4px;
    box-shadow: 0 0 10px rgba(0,220,130,.5);
}

/* Contador slide */
.car-counter {
    text-align: center; margin-top: 1rem;
    font-size: .8rem; color: var(--muted); font-weight: 600;
    letter-spacing: .5px;
}
.car-counter span { color: var(--green); font-weight: 800; }

/* ═══════════════════════════════════════════════
   MODAL DE ALERTA (Regístrate / Inicia sesión)
═══════════════════════════════════════════════ */
.modal-overlay {
    position: fixed; inset: 0; z-index: 9000;
    background: rgba(0,5,20,.85); backdrop-filter: blur(12px);
    display: flex; align-items: center; justify-content: center;
    padding: 1.5rem;
    opacity: 0; pointer-events: none;
    transition: opacity .3s;
}
.modal-overlay.open { opacity: 1; pointer-events: all; }

.modal-box {
    background: linear-gradient(145deg, #001833, #002a50);
    border: 1px solid rgba(0,220,130,.2);
    border-radius: 28px; padding: 2.8rem 2.5rem;
    max-width: 460px; width: 100%;
    text-align: center;
    transform: scale(.9) translateY(20px);
    transition: transform .4s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 30px 80px rgba(0,0,0,.6), 0 0 0 1px rgba(0,220,130,.08);
    position: relative; overflow: hidden;
}
.modal-overlay.open .modal-box { transform: scale(1) translateY(0); }

/* Brillo decorativo */
.modal-box::before {
    content: '';
    position: absolute; top: -60px; left: 50%; transform: translateX(-50%);
    width: 200px; height: 200px; border-radius: 50%;
    background: radial-gradient(circle, rgba(0,220,130,.18) 0%, transparent 70%);
    pointer-events: none;
}

.modal-icon {
    width: 72px; height: 72px; border-radius: 50%;
    background: rgba(0,220,130,.1); border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    animation: modalIconPulse 2s ease-in-out infinite;
}
.modal-icon svg { width: 32px; height: 32px; stroke: var(--green); }
@keyframes modalIconPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,220,130,.3); }
    50%      { box-shadow: 0 0 0 12px rgba(0,220,130,0); }
}

.modal-activity-name {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(0,220,130,.1); border: 1px solid var(--border);
    border-radius: 50px; padding: .32rem 1rem;
    font-size: .78rem; font-weight: 700; color: var(--green);
    margin-bottom: 1rem;
}
.modal-h {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 1.55rem; font-weight: 800;
    margin-bottom: .7rem; line-height: 1.25;
}
.modal-sub {
    font-size: .95rem; color: var(--muted); line-height: 1.7;
    margin-bottom: 2rem;
}
.modal-btns {
    display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;
}
.modal-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    padding: .75rem 1.8rem; border-radius: 50px;
    background: var(--green); color: var(--navy);
    font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: .92rem;
    border: none; cursor: pointer;
    box-shadow: 0 6px 20px rgba(0,220,130,.35);
    transition: all .25s cubic-bezier(.34,1.56,.64,1);
    text-decoration: none;
}
.modal-btn-primary:hover { transform: translateY(-2px) scale(1.04); background: #00f090; box-shadow: 0 10px 28px rgba(0,220,130,.5); }
.modal-btn-ghost {
    display: inline-flex; align-items: center; gap: 8px;
    padding: .75rem 1.8rem; border-radius: 50px;
    background: rgba(255,255,255,.07); color: var(--white);
    border: 1.5px solid rgba(241,245,249,.18);
    font-family: 'DM Sans', sans-serif; font-weight: 600; font-size: .92rem;
    cursor: pointer; backdrop-filter: blur(8px);
    transition: all .25s;
    text-decoration: none;
}
.modal-btn-ghost:hover { background: rgba(255,255,255,.13); border-color: rgba(241,245,249,.4); }
.modal-close {
    position: absolute; top: 1.1rem; right: 1.1rem;
    background: rgba(255,255,255,.07); border: none;
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--muted);
    transition: all .2s;
}
.modal-close:hover { background: rgba(255,255,255,.15); color: var(--white); }

/* ═══════════════════════════════════════════════
   FEATURES / POR QUÉ ADDEDUT
═══════════════════════════════════════════════ */
.features-section {
    position: relative; z-index: 1;
    padding: 6rem 5%;
    background: rgba(0,45,98,.18);
    border-top: 1px solid rgba(0,220,130,.08);
    border-bottom: 1px solid rgba(0,220,130,.08);
}
.features-inner { max-width: 1100px; margin: 0 auto; }
.features-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 2rem; margin-top: 3.5rem;
}
.feat-card {
    background: rgba(255,255,255,.04);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 20px; padding: 2rem 1.8rem;
    transition: all .3s; position: relative; overflow: hidden;
}
.feat-card::before {
    content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px;
    background: linear-gradient(90deg, transparent, var(--green), transparent);
    opacity: 0; transition: opacity .3s;
}
.feat-card:hover { background: rgba(0,220,130,.05); border-color: rgba(0,220,130,.25); transform: translateY(-4px); }
.feat-card:hover::before { opacity: 1; }
.feat-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: rgba(0,220,130,.1); border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 1.4rem;
    transition: background .3s;
}
.feat-card:hover .feat-icon { background: rgba(0,220,130,.18); }
.feat-icon svg { width: 24px; height: 24px; stroke: var(--green); }
.feat-title {
    font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.15rem;
    font-weight: 700; margin-bottom: .7rem;
}
.feat-text { font-size: .92rem; color: var(--muted); line-height: 1.7; }

/* ═══════════════════════════════════════════════
   CTA FINAL
═══════════════════════════════════════════════ */
.cta-section {
    position: relative; z-index: 1;
    padding: 8rem 5%; text-align: center; overflow: hidden;
}
.cta-glow {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
    width: 600px; height: 600px; border-radius: 50%;
    background: radial-gradient(circle, rgba(0,220,130,.15) 0%, transparent 70%);
    pointer-events: none;
}
.cta-inner { position: relative; z-index: 1; max-width: 700px; margin: 0 auto; }
.cta-h2 {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: clamp(2.2rem, 5vw, 4rem);
    font-weight: 800; letter-spacing: -1.5px;
    line-height: 1.1; margin-bottom: 1.3rem;
}
.cta-h2 span {
    background: linear-gradient(90deg, var(--green), #00f5a0);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.cta-sub {
    font-size: 1.08rem; color: var(--muted); line-height: 1.75;
    margin-bottom: 2.5rem;
}
.cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; }

/* Decorative ring */
.cta-ring {
    position: absolute; border-radius: 50%; border: 1px solid rgba(0,220,130,.12);
    top: 50%; left: 50%; transform: translate(-50%,-50%);
    pointer-events: none;
}
.cta-ring:nth-child(1) { width: 500px; height: 500px; animation: ringPulse 4s ease-in-out infinite; }
.cta-ring:nth-child(2) { width: 700px; height: 700px; animation: ringPulse 4s 1s ease-in-out infinite; }
.cta-ring:nth-child(3) { width: 900px; height: 900px; animation: ringPulse 4s 2s ease-in-out infinite; }
@keyframes ringPulse {
    0%,100% { opacity:.3; transform: translate(-50%,-50%) scale(1); }
    50%      { opacity:.06; transform: translate(-50%,-50%) scale(1.05); }
}

/* ═══════════════════════════════════════════════
   FOOTER
═══════════════════════════════════════════════ */
footer {
    position: relative; z-index: 1;
    padding: 1.8rem 5%;
    border-top: 1px solid rgba(255,255,255,.06);
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .8rem;
    background: rgba(0,13,30,.5); backdrop-filter: blur(20px);
    font-size: .82rem; color: rgba(241,245,249,.4);
}
.footer-logo { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 800; font-size: 1.1rem; }
.footer-logo span { color: var(--green); }

/* ═══════════════════════════════════════════════
   SCROLL REVEAL
═══════════════════════════════════════════════ */
.reveal {
    opacity: 0; transform: translateY(36px);
    transition: opacity .7s ease, transform .7s ease;
}
.reveal.visible { opacity: 1; transform: translateY(0); }
.reveal-delay-1 { transition-delay: .1s; }
.reveal-delay-2 { transition-delay: .2s; }
.reveal-delay-3 { transition-delay: .3s; }
.reveal-delay-4 { transition-delay: .4s; }

/* ═══════════════════════════════════════════════
   ANIMATIONS HELPERS
═══════════════════════════════════════════════ */
@keyframes fadeDown {
    from { opacity:0; transform:translateY(-20px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════════ */
@media (max-width: 900px) {
    .stats-inner { grid-template-columns: repeat(2, 1fr); }
    .acts-grid {
        grid-template-columns: 1fr 1fr;
    }
    .acts-row2 {
        max-width: 100%;
        grid-template-columns: 1fr 1fr;
    }
    .act-card:nth-child(1),
    .act-card:nth-child(4) { grid-column: 1 / 3; aspect-ratio: 16/7; }
    .act-slide { flex: 0 0 calc(50% - 10px); }
    .car-prev { left: -18px; }
    .car-next { right: -18px; }
    .features-grid { grid-template-columns: 1fr; }
    .nav-actions .nav-btn-ghost { display: none; }
}
@media (max-width: 600px) {
    .acts-grid, .acts-row2 { grid-template-columns: 1fr !important; max-width: 100% !important; }
    .act-slide { flex: 0 0 calc(85% - 10px); }
    .car-prev { left: 4px; }
    .car-next { right: 4px; }
}
@media (max-width: 480px) {
    .hero-h1 { letter-spacing: -1px; }
    .hero-btns { flex-direction: column; align-items: center; }
    .hero-btns a, .hero-btns div { width: 100%; max-width: 300px; justify-content: center; }
    footer { flex-direction: column; text-align: center; }
}
</style>
</head>
<body>

<!-- Mesh background -->
<div class="bg-mesh"></div>

<!-- Partículas -->
<div class="particle" style="left:8%;width:3px;height:3px;animation-duration:12s;animation-delay:0s;"></div>
<div class="particle" style="left:22%;width:2px;height:2px;animation-duration:18s;animation-delay:3s;"></div>
<div class="particle" style="left:55%;width:4px;height:4px;animation-duration:14s;animation-delay:1.5s;"></div>
<div class="particle" style="left:75%;width:2px;height:2px;animation-duration:20s;animation-delay:5s;"></div>
<div class="particle" style="left:88%;width:3px;height:3px;animation-duration:16s;animation-delay:7s;"></div>
<div class="particle" style="left:40%;width:2px;height:2px;animation-duration:22s;animation-delay:2s;"></div>
<div class="particle" style="left:65%;width:3px;height:3px;animation-duration:11s;animation-delay:9s;"></div>

<!-- ── NAVBAR ── -->
<nav class="navbar" id="navbar">
    <div class="nav-logo">
        <div class="icon-wrap">
            <i data-feather="book-open"></i>
        </div>
        Added<span class="dot">UT</span>
    </div>
    <div class="nav-actions">
        <a href="{{ route('login') }}" class="nav-btn nav-btn-ghost">Iniciar sesión</a>
        <a href="{{ route('registro') }}" class="nav-btn nav-btn-solid">Registrarse</a>
    </div>
</nav>

<!-- ── HERO ── -->
<section class="hero">
    <div class="hero-bg"></div>

    <span class="hero-accent">
        Universidad Tecnológica de Tecámac
    </span>

    <h1 class="hero-h1">
        -TU DESARROLLO-<br>
        <span class="line2">MÁS ALLÁ DEL AULA</span>
    </h1>

    <p class="hero-sub">
        <strong>AddedUT</strong> es la plataforma oficial de actividades extracurriculares de la UTTEC.
        Inscríbete, participa y construye tu perfil integral universitario.
    </p>

    <div class="hero-btns">
        <a href="{{ route('registro') }}" class="btn-cta-primary">
            <i data-feather="zap" style="width:18px;height:18px;"></i>
            Empieza ahora
        </a>
        <a href="{{ route('login') }}" class="btn-cta-ghost">
            <i data-feather="log-in" style="width:17px;height:17px;"></i>
            Iniciar sesión
        </a>
    </div>

    <div class="scroll-hint">
        <div class="scroll-mouse"></div>
        <span>Descubre más</span>
    </div>
</section>

<!-- ── STATS ── -->
<div class="stats-bar">
    <div class="stats-inner">
        <div class="stat-item reveal">
            <span class="stat-num" data-target="500">0</span>
            <span class="stat-lbl">Estudiantes activos</span>
        </div>
        <div class="stat-item reveal reveal-delay-1">
            <span class="stat-num" data-target="12">0</span>
            <span class="stat-lbl">Actividades disponibles</span>
        </div>
        <div class="stat-item reveal reveal-delay-2">
            <span class="stat-num" data-target="5">0</span>
            <span class="stat-lbl">Categorías deportivas</span>
        </div>
        <div class="stat-item reveal reveal-delay-3">
            <span class="stat-num" data-target="98" data-suffix="%">0</span>
            <span class="stat-lbl">Satisfacción estudiantil</span>
        </div>
    </div>
</div>

<!-- ── ACTIVIDADES ── -->
<section class="section">
    <div class="section-header reveal">
        <span class="section-tag">
            <i data-feather="grid" style="width:12px;height:12px;"></i>
            Actividades
        </span>
        <h2 class="section-h2">Explora lo que <span>AddedUT</span> tiene para ti</h2>
        <p class="section-sub">Desde deportes hasta expresión artística — encuentra tu pasión y desarrolla habilidades para la vida.</p>
    </div>

    <div class="carousel-wrap reveal">
        <!-- Flecha izquierda -->
        <button class="car-arrow car-prev" id="car-prev" aria-label="Anterior">
            <i data-feather="chevron-left"></i>
        </button>

        <!-- Track del carrusel -->
        <div class="car-track-outer">
            <div class="car-track" id="car-track">

                <div class="act-slide" onclick="abrirModal('Fútbol Soccer', 'Deporte')">
                    <img src="{{ asset('imagenes/soccer.jpg') }}" alt="Fútbol Soccer">
                    <span class="act-slide-num">01</span>
                    <div class="act-slide-overlay">
                        <span class="act-tag"><i data-feather="star" style="width:10px;height:10px;"></i> Destacado</span>
                        <div class="act-name">Fútbol Soccer</div>
                        <div class="act-desc">Fortalece el trabajo en equipo, la disciplina y la resistencia física.</div>
                        <div class="act-hint">
                            <i data-feather="arrow-right"></i> Toca para saber más
                        </div>
                    </div>
                </div>

                <div class="act-slide" onclick="abrirModal('Bailes de Salón', 'Arte')">
                    <img src="{{ asset('imagenes/baile.jpg') }}" alt="Bailes de Salón">
                    <span class="act-slide-num">02</span>
                    <div class="act-slide-overlay">
                        <span class="act-tag">Arte</span>
                        <div class="act-name">Bailes de Salón</div>
                        <div class="act-desc">Coordinación, ritmo y expresión artística en cada movimiento.</div>
                        <div class="act-hint">
                            <i data-feather="arrow-right"></i> Toca para saber más
                        </div>
                    </div>
                </div>

                <div class="act-slide" onclick="abrirModal('Ajedrez', 'Estrategia')">
                    <img src="{{ asset('imagenes/ajedrez.jpg') }}" alt="Ajedrez">
                    <span class="act-slide-num">03</span>
                    <div class="act-slide-overlay">
                        <span class="act-tag">Mente</span>
                        <div class="act-name">Ajedrez</div>
                        <div class="act-desc">Estrategia, concentración y toma de decisiones bajo presión.</div>
                        <div class="act-hint">
                            <i data-feather="arrow-right"></i> Toca para saber más
                        </div>
                    </div>
                </div>

                <div class="act-slide" onclick="abrirModal('Taekwondo', 'Combate')">
                    <img src="{{ asset('imagenes/taekwdo.jpg') }}" alt="Taekwondo">
                    <span class="act-slide-num">04</span>
                    <div class="act-slide-overlay">
                        <span class="act-tag">Combate</span>
                        <div class="act-name">Taekwondo</div>
                        <div class="act-desc">Arte marcial que forja disciplina, respeto y autoconfianza.</div>
                        <div class="act-hint">
                            <i data-feather="arrow-right"></i> Toca para saber más
                        </div>
                    </div>
                </div>

                <div class="act-slide" onclick="abrirModal('Música', 'Cultura')">
                    <img src="{{ asset('imagenes/musica.jpg') }}" alt="Música">
                    <span class="act-slide-num">05</span>
                    <div class="act-slide-overlay">
                        <span class="act-tag">Cultura</span>
                        <div class="act-name">Música</div>
                        <div class="act-desc">Explora tu talento musical y participa en eventos culturales UTTEC.</div>
                        <div class="act-hint">
                            <i data-feather="arrow-right"></i> Toca para saber más
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Flecha derecha -->
        <button class="car-arrow car-next" id="car-next" aria-label="Siguiente">
            <i data-feather="chevron-right"></i>
        </button>

        <!-- Dots -->
        <div class="car-dots" id="car-dots"></div>
        <div class="car-counter"><span id="car-cur">1</span> / <span id="car-total">5</span></div>
    </div>
</section>

<!-- ── MODAL ── -->
<div class="modal-overlay" id="modal" onclick="cerrarModal(event)">
    <div class="modal-box">
        <button class="modal-close" onclick="cerrarModal(null, true)" aria-label="Cerrar">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div class="modal-icon">
            <i data-feather="lock"></i>
        </div>
        <div class="modal-activity-name" id="modal-activity-name">
            <i data-feather="tag" style="width:11px;height:11px;"></i>
            <span id="modal-act-txt">Actividad</span>
        </div>
        <h2 class="modal-h">¡Únete para ver más!</h2>
        <p class="modal-sub">
            Para explorar <strong id="modal-act-name2" style="color:var(--white);">esta actividad</strong>,
            inscribirte y acceder a toda la información, necesitas una cuenta UTTEC.
        </p>
        <div class="modal-btns">
            <a href="{{ route('registro') }}" class="modal-btn-primary">
                <i data-feather="user-plus" style="width:16px;height:16px;"></i>
                Registrarme gratis
            </a>
            <a href="{{ route('login') }}" class="modal-btn-ghost">
                <i data-feather="log-in" style="width:16px;height:16px;"></i>
                Ya tengo cuenta
            </a>
        </div>
    </div>
</div>

<!-- ── FEATURES ── -->
<section class="features-section">
    <div class="features-inner">
        <div class="section-header reveal">
            <span class="section-tag">
                <i data-feather="award" style="width:12px;height:12px;"></i>
                ¿Por qué AddedUT?
            </span>
            <h2 class="section-h2">Todo lo que necesitas,<br><span>en un solo lugar.</span></h2>
        </div>

        <div class="features-grid">
            <div class="feat-card reveal">
                <div class="feat-icon"><i data-feather="clipboard"></i></div>
                <div class="feat-title">Gestión de inscripciones</div>
                <p class="feat-text">Regístrate en tus actividades favoritas en segundos. Sin filas, sin papeleo, todo desde tu celular o computadora.</p>
            </div>
            <div class="feat-card reveal reveal-delay-1">
                <div class="feat-icon"><i data-feather="bell"></i></div>
                <div class="feat-title">Notificaciones en tiempo real</div>
                <p class="feat-text">Mantente informado de avisos, cambios de horario y noticias importantes de tu universidad al instante.</p>
            </div>
            <div class="feat-card reveal reveal-delay-2">
                <div class="feat-icon"><i data-feather="bar-chart-2"></i></div>
                <div class="feat-title">Seguimiento de progreso</div>
                <p class="feat-text">Visualiza tu historial de participación y construye un expediente extracurricular sólido durante tu trayectoria.</p>
            </div>
            <div class="feat-card reveal reveal-delay-1">
                <div class="feat-icon"><i data-feather="users"></i></div>
                <div class="feat-title">Comunidad estudiantil</div>
                <p class="feat-text">Conecta con compañeros que comparten tus intereses. Comenta, opina y forma parte del foro de noticias UTTEC.</p>
            </div>
            <div class="feat-card reveal reveal-delay-2">
                <div class="feat-icon"><i data-feather="shield"></i></div>
                <div class="feat-title">Acceso seguro</div>
                <p class="feat-text">Tu cuenta institucional protegida. Solo estudiantes y personal UTTEC con credenciales verificadas.</p>
            </div>
            <div class="feat-card reveal reveal-delay-3">
                <div class="feat-icon"><i data-feather="smartphone"></i></div>
                <div class="feat-title">Diseño responsivo</div>
                <p class="feat-text">Accede desde cualquier dispositivo. AddedUT funciona perfecto en celular, tablet o computadora.</p>
            </div>
        </div>
    </div>
</section>

<!-- ── CTA FINAL ── -->
<section class="cta-section">
    <div class="cta-ring"></div>
    <div class="cta-ring"></div>
    <div class="cta-ring"></div>
    <div class="cta-glow"></div>
    <div class="cta-inner reveal">
        <h2 class="cta-h2">¿Listo para <span>dar el siguiente paso?</span></h2>
        <p class="cta-sub">Únete a cientos de estudiantes UTTEC que ya están desarrollando su potencial dentro y fuera del salón de clases.</p>
        <div class="cta-btns">
            <a href="{{ route('registro') }}" class="btn-cta-primary">
                <i data-feather="user-plus" style="width:18px;height:18px;"></i>
                Crear mi cuenta
            </a>
            <a href="{{ route('login') }}" class="btn-cta-ghost">
                <i data-feather="log-in" style="width:17px;height:17px;"></i>
                Ya tengo cuenta
            </a>
        </div>
    </div>
</section>

<!-- ── FOOTER ── -->
<footer>
    <div class="footer-logo">Added<span>UT</span></div>
    <span>Plataforma oficial · Universidad Tecnológica de Tecámac</span>
    <span>© {{ date('Y') }} · Proyecto académico SCRUM</span>
</footer>

<script>
feather.replace();

/* ── Navbar scroll ── */
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', scrollY > 40);
}, { passive: true });

/* ── Scroll reveal ── */
const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

/* ── Counters ── */
function animateCounter(el) {
    const target  = parseInt(el.dataset.target);
    const suffix  = el.dataset.suffix || '+';
    const dur     = 1800;
    const step    = 16;
    const inc     = target / (dur / step);
    let current   = 0;
    const timer   = setInterval(() => {
        current += inc;
        if (current >= target) { current = target; clearInterval(timer); }
        el.textContent = Math.floor(current) + suffix;
    }, step);
}

const statsObs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            document.querySelectorAll('.stat-num').forEach(animateCounter);
            statsObs.disconnect();
        }
    });
}, { threshold: 0.3 });
const statsEl = document.querySelector('.stats-bar');
if (statsEl) statsObs.observe(statsEl);

/* ════════════════════════════════════
   CARRUSEL
════════════════════════════════════ */
(function() {
    const track    = document.getElementById('car-track');
    const slides   = track ? track.querySelectorAll('.act-slide') : [];
    const dotsWrap = document.getElementById('car-dots');
    const curEl    = document.getElementById('car-cur');
    const totalEl  = document.getElementById('car-total');
    if (!track || !slides.length) return;

    // Cuántos slides mostrar según ancho
    function visibles() {
        if (window.innerWidth <= 600) return 1;
        if (window.innerWidth <= 900) return 2;
        return 3;
    }

    let cur = 0;
    const total = slides.length;
    if (totalEl) totalEl.textContent = total;

    // Crear dots
    for (let i = 0; i < total; i++) {
        const d = document.createElement('button');
        d.className = 'car-dot' + (i === 0 ? ' active' : '');
        d.setAttribute('aria-label', 'Ir a slide ' + (i+1));
        d.addEventListener('click', () => goTo(i));
        dotsWrap.appendChild(d);
    }

    function goTo(idx) {
        cur = Math.max(0, Math.min(idx, total - visibles()));
        const vis = visibles();
        // Calcular el ancho de un slide + gap
        const slideEl = slides[0];
        const gap = 20;
        const slideW = slideEl.getBoundingClientRect().width + gap;
        track.style.transform = `translateX(-${cur * slideW}px)`;

        // Actualizar dots
        dotsWrap.querySelectorAll('.car-dot').forEach((d, i) => {
            d.classList.toggle('active', i === cur);
        });
        if (curEl) curEl.textContent = cur + 1;
    }

    document.getElementById('car-prev')?.addEventListener('click', () => goTo(cur - 1));
    document.getElementById('car-next')?.addEventListener('click', () => goTo(cur + 1));

    // Swipe táctil
    let touchX = 0;
    track.addEventListener('touchstart', e => { touchX = e.touches[0].clientX; }, { passive: true });
    track.addEventListener('touchend', e => {
        const dx = e.changedTouches[0].clientX - touchX;
        if (Math.abs(dx) > 50) goTo(dx < 0 ? cur + 1 : cur - 1);
    });

    // Re-calcular al resize
    window.addEventListener('resize', () => goTo(cur));

    // Auto-avance cada 4s
    let auto = setInterval(() => {
        const maxIdx = total - visibles();
        goTo(cur >= maxIdx ? 0 : cur + 1);
    }, 4000);

    // Pausar autoavance al hover
    track.addEventListener('mouseenter', () => clearInterval(auto));
    track.addEventListener('mouseleave', () => {
        auto = setInterval(() => {
            const maxIdx = total - visibles();
            goTo(cur >= maxIdx ? 0 : cur + 1);
        }, 4000);
    });

    goTo(0);
})();

/* ════════════════════════════════════
   MODAL
════════════════════════════════════ */
function abrirModal(nombre, categoria) {
    const modal = document.getElementById('modal');
    document.getElementById('modal-act-txt').textContent  = nombre;
    document.getElementById('modal-act-name2').textContent = nombre;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    // Re-render feather dentro del modal
    feather.replace();
}

function cerrarModal(e, force) {
    if (force || (e && e.target === document.getElementById('modal'))) {
        document.getElementById('modal').classList.remove('open');
        document.body.style.overflow = '';
    }
}

// Cerrar con Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') cerrarModal(null, true);
});
</script>
</body>
</html>