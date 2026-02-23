@extends('layouts.estudiante')
@section('title', $noticia->titulo)

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=Nunito:wght@400;600;700;800;900&family=Instrument+Serif:ital@0;1&display=swap');

/* ══════════════════════════════════════
   PROGRESO DE LECTURA
══════════════════════════════════════ */
#reading-bar {
    position: fixed; top: 0; left: 0; z-index: 9999;
    height: 3px; width: 0%;
    background: linear-gradient(90deg, var(--color-uttec-green) 0%, #00d48a 50%, #FFD60A 100%);
    transition: width .08s linear;
    box-shadow: 0 0 10px rgba(0,168,107,.6), 0 0 20px rgba(0,168,107,.3);
}

/* ══════════════════════════════════════
   BASE
══════════════════════════════════════ */
.nw * { box-sizing: border-box; }
.nw { font-family: 'Nunito', sans-serif; }

/* Back */
.back-link {
    display: inline-flex; align-items: center; gap: 7px;
    color: var(--color-uttec-green); font-weight: 700; font-size: .88rem;
    margin-bottom: 2rem; transition: gap .2s;
}
.back-link:hover { gap: 12px; }

/* ══════════════════════════════════════
   HERO
══════════════════════════════════════ */
.hero {
    position: relative;
    width: calc(100% + 6rem); margin-left: -3rem;
    height: 520px; overflow: hidden;
    background: linear-gradient(135deg, #001833 0%, #003070 55%, #005535 100%);
}
.hero img {
    width: 100%; height: 100%; object-fit: cover; display: block;
    transition: transform 9s ease;
}
.hero:hover img { transform: scale(1.04); }
.hero-veil {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom,
        rgba(0,0,0,.04) 0%,
        rgba(0,0,0,.08) 40%,
        rgba(0,0,0,.82) 100%
    );
}
.hero-ph {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
}
.hero-ph svg { width: 96px; height: 96px; stroke: rgba(255,255,255,.12); }

/* Pastillas flotantes hero */
.hero-badges {
    position: absolute; top: 22px; left: 22px; right: 22px; z-index: 3;
    display: flex; justify-content: space-between; align-items: flex-start;
}
.hero-cat {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--color-uttec-green); color: #fff;
    font-family: 'Nunito', sans-serif; font-weight: 800;
    font-size: .72rem; letter-spacing: 1.2px; text-transform: uppercase;
    padding: .4rem 1.1rem; border-radius: 4px;
    box-shadow: 0 4px 18px rgba(0,168,107,.5);
}
.hero-right-badges { display: flex; flex-direction: column; gap: 8px; align-items: flex-end; }
.hero-badge-sm {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(0,0,0,.4); backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.18);
    color: rgba(255,255,255,.9); font-family: 'Nunito', sans-serif;
    font-weight: 700; font-size: .75rem;
    padding: .32rem .85rem; border-radius: 50px;
}

/* Texto sobre hero */
.hero-bottom {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 2.2rem 3rem 2rem; z-index: 3;
}
.hero-h1 {
    font-family: 'Instrument Serif', Georgia, serif;
    font-size: clamp(2rem, 3.8vw, 3.1rem);
    font-weight: 400; font-style: italic;
    color: #fff; line-height: 1.22;
    text-shadow: 0 2px 28px rgba(0,0,0,.45);
    margin-bottom: 1rem; max-width: 790px;
    letter-spacing: -.3px;
}
.hero-meta { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; }
.hero-meta-chip {
    display: flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,.13); backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.2);
    color: rgba(255,255,255,.85); font-family: 'Nunito', sans-serif;
    font-size: .79rem; font-weight: 700;
    padding: .3rem .85rem; border-radius: 50px;
}
.hero-meta-sep { color: rgba(255,255,255,.25); }

/* ══════════════════════════════════════
   LAYOUT 2 COLUMNAS
══════════════════════════════════════ */
.layout {
    display: grid;
    grid-template-columns: 1fr 272px;
    gap: 3.5rem;
    margin-top: 3rem;
    align-items: start;
}

/* ══════════════════════════════════════
   ARTÍCULO
══════════════════════════════════════ */
.art-lead {
    font-family: 'Lora', Georgia, serif;
    font-size: 1.18rem; font-weight: 400; font-style: italic;
    color: #444; line-height: 1.9;
    border-top: 3px solid var(--color-uttec-blue-dark);
    border-bottom: 1px solid #e8e8e8;
    padding: 1.4rem 0 1.3rem;
    margin-bottom: 2rem;
}
.art-body {
    font-family: 'Lora', Georgia, serif;
    font-size: 1.06rem; line-height: 1.92; color: #1e1e1e;
    white-space: pre-wrap; word-break: break-word;
}
/* Drop cap elegante */
.art-body::first-letter {
    font-family: 'Instrument Serif', serif;
    font-size: 5.2rem; font-weight: 400;
    float: left; line-height: .78;
    margin: .06rem .16rem -.1rem 0;
    color: var(--color-uttec-blue-dark);
}

/* ══════════════════════════════════════
   REACCIONES — bloque destacado
══════════════════════════════════════ */
.reacciones-wrap {
    margin: 2.8rem 0 0;
    background: linear-gradient(135deg, #f4f8ff 0%, #edfff6 100%);
    border: 1.5px solid rgba(0,45,98,.07);
    border-radius: 22px;
    padding: 1.6rem 2rem;
}
.reacciones-lbl {
    font-family: 'Nunito', sans-serif;
    font-weight: 800; font-size: .72rem; letter-spacing: 1.4px;
    text-transform: uppercase; color: #aaa; margin-bottom: 1.2rem;
}
.reacciones-row {
    display: flex; gap: .7rem; flex-wrap: wrap; align-items: center;
}
.reac-btn {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    background: #fff; border: 2px solid #e8e8e8; border-radius: 16px;
    padding: .75rem 1.05rem; cursor: pointer; min-width: 68px;
    transition: all .28s cubic-bezier(.34, 1.56, .64, 1);
    position: relative;
    font-family: 'Nunito', sans-serif;
}
.reac-btn:hover {
    transform: translateY(-5px) scale(1.07);
    box-shadow: 0 10px 26px rgba(0,0,0,.12);
    border-color: rgba(0,168,107,.3);
}
.reac-btn.active {
    background: rgba(0,168,107,.06);
    border-color: var(--color-uttec-green);
    box-shadow: 0 0 0 3px rgba(0,168,107,.12);
}
.reac-btn.active .reac-label { color: var(--color-uttec-green); }
.reac-emoji {
    font-size: 1.9rem; line-height: 1;
    transition: transform .32s cubic-bezier(.34, 1.56, .64, 1);
    user-select: none;
}
.reac-btn:hover .reac-emoji { transform: scale(1.35) rotate(-6deg); }
.reac-btn.active .reac-emoji { animation: reactPop .4s cubic-bezier(.34,1.56,.64,1); }
@keyframes reactPop {
    0%   { transform: scale(1); }
    40%  { transform: scale(1.55) rotate(8deg); }
    70%  { transform: scale(.9); }
    100% { transform: scale(1); }
}
.reac-label {
    font-size: .68rem; font-weight: 800; color: #888;
    text-transform: uppercase; letter-spacing: .5px; white-space: nowrap;
}
.reac-count {
    font-size: .88rem; font-weight: 900;
    color: var(--color-uttec-blue-dark);
}
.reac-btn.active .reac-count { color: var(--color-uttec-green); }

/* Separador entre reacciones y like */
.reacciones-sep {
    width: 1px; height: 52px; background: #e0e0e0; margin: 0 .3rem; flex-shrink: 0;
}

/* Like inline con reacciones */
.like-pill {
    display: flex; flex-direction: column; align-items: center; gap: 5px;
    background: #fff; border: 2px solid #e8e8e8; border-radius: 16px;
    padding: .75rem 1.05rem; cursor: pointer; min-width: 68px;
    font-family: 'Nunito', sans-serif;
    transition: all .28s cubic-bezier(.34,1.56,.64,1);
}
.like-pill:hover { transform: translateY(-5px) scale(1.07); box-shadow: 0 10px 26px rgba(0,0,0,.12); border-color: rgba(231,76,60,.3); }
.like-pill.liked { border-color: #e74c3c; background: rgba(231,76,60,.05); box-shadow: 0 0 0 3px rgba(231,76,60,.1); }
.like-pill.liked .like-icon { fill: #e74c3c; stroke: #e74c3c; }
.like-pill.liked .like-lbl { color: #e74c3c; }
.like-pill.liked .like-num { color: #e74c3c; }
.like-icon { width: 28px; height: 28px; transition: transform .32s cubic-bezier(.34,1.56,.64,1); fill: none; stroke: #888; stroke-width: 2; }
.like-pill:hover .like-icon { transform: scale(1.35); stroke: #e74c3c; }
.like-lbl  { font-size: .68rem; font-weight: 800; color: #888; text-transform: uppercase; letter-spacing: .5px; }
.like-num  { font-size: .88rem; font-weight: 900; color: var(--color-uttec-blue-dark); }
.like-pill.pop { animation: reactPop .4s cubic-bezier(.34,1.56,.64,1); }

/* Chip de comentarios */
.coms-chip {
    display: flex; align-items: center; gap: 6px;
    font-family: 'Nunito', sans-serif; font-size: .85rem;
    color: #bbb; font-weight: 700; margin-top: .8rem;
}

/* ══════════════════════════════════════
   COMENTARIOS
══════════════════════════════════════ */
.coms-title {
    font-family: 'Instrument Serif', serif;
    font-size: 1.7rem; font-style: italic; font-weight: 400;
    color: var(--color-uttec-blue-dark);
    margin: 2.5rem 0 1.8rem;
    display: flex; align-items: center; gap: 14px;
}
.coms-title::after {
    content: ''; flex: 1; height: 1px;
    background: linear-gradient(to right, #dde4f0, transparent);
}

/* Formulario */
.com-form {
    display: grid; grid-template-columns: 44px 1fr;
    gap: 14px; margin-bottom: 2.2rem; align-items: start;
}
.com-av {
    width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(145deg, var(--color-uttec-blue-dark), var(--color-uttec-green));
    color: #fff; display: flex; align-items: center; justify-content: center;
    font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.05rem;
    box-shadow: 0 4px 14px rgba(0,45,98,.22);
}
.com-field {
    background: #f7f9fc; border: 2px solid #e8ecf4; border-radius: 18px;
    overflow: hidden; transition: border-color .2s, box-shadow .2s, background .2s;
}
.com-field:focus-within {
    border-color: var(--color-uttec-green);
    box-shadow: 0 0 0 4px rgba(0,168,107,.09);
    background: #fff;
}
.com-ta {
    width: 100%; min-height: 90px; padding: 1rem 1.3rem;
    border: none; background: transparent; outline: none;
    font-family: 'Lora', Georgia, serif; font-size: .95rem;
    color: #222; resize: none; line-height: 1.65; display: block;
}
.com-ta::placeholder { color: #bbb; font-style: italic; }
.com-foot {
    padding: .5rem 1rem .85rem;
    display: flex; justify-content: space-between; align-items: center;
}
.com-chars { font-family: 'Nunito', sans-serif; font-size: .73rem; color: #ccc; font-weight: 600; }
.btn-post {
    background: var(--color-uttec-blue-dark); color: #fff;
    border: none; padding: .6rem 1.4rem; border-radius: 10px;
    font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .85rem;
    cursor: pointer; display: flex; align-items: center; gap: 6px;
    transition: background .2s, transform .15s;
    box-shadow: 0 4px 12px rgba(0,45,98,.25);
}
.btn-post:hover { background: var(--color-uttec-green); transform: translateY(-1px); }

/* Lista */
.coms-list { display: flex; flex-direction: column; }
.com-item {
    display: grid; grid-template-columns: 44px 1fr;
    gap: 14px; padding: 1.3rem 0;
    border-bottom: 1px solid #f2f2f2;
    animation: comIn .3s ease both;
}
.com-item:last-child { border-bottom: none; }
@keyframes comIn { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
.com-bub {
    background: #f7f9fc; border-radius: 16px; padding: 1rem 1.3rem;
    border: 1.5px solid #eaeef5;
    transition: border-color .2s;
}
.com-bub:hover { border-color: rgba(0,168,107,.2); }
.com-hd { display: flex; align-items: baseline; gap: 8px; margin-bottom: .45rem; flex-wrap: wrap; }
.com-name { font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .88rem; color: var(--color-uttec-blue-dark); }
.com-date { font-family: 'Nunito', sans-serif; font-size: .72rem; color: #c0c5d0; }
.com-del  {
    margin-left: auto; background: none; border: none;
    color: #d0d5e0; cursor: pointer; font-size: .71rem; font-weight: 700;
    padding: .18rem .5rem; border-radius: 5px;
    font-family: 'Nunito', sans-serif; transition: all .2s;
}
.com-del:hover { color: #e74c3c; background: #fff0f0; }
.com-txt { font-family: 'Lora', serif; font-size: .92rem; color: #3a3a3a; line-height: 1.7; }

.com-empty {
    text-align: center; padding: 3rem 1rem;
    background: #f7f9fc; border-radius: 18px;
    border: 2px dashed #e0e5f0;
}
.com-empty svg { width: 48px; height: 48px; stroke: #d0d5e0; margin: 0 auto .8rem; display: block; }
.com-empty p { font-family: 'Nunito', sans-serif; font-size: .9rem; color: #c0c5d0; font-weight: 700; }

/* ══════════════════════════════════════
   SIDEBAR
══════════════════════════════════════ */
.sidebar { position: sticky; top: 110px; }
.s-card {
    background: #fff; border-radius: 20px; padding: 1.4rem 1.5rem;
    box-shadow: 0 4px 24px rgba(0,45,98,.07);
    border: 1px solid rgba(0,45,98,.05);
    margin-bottom: 1.4rem;
}
.s-label {
    display: block; font-family: 'Nunito', sans-serif;
    font-size: .67rem; font-weight: 800; letter-spacing: 1.6px;
    text-transform: uppercase; color: #bbb;
    margin-bottom: 1rem; padding-bottom: .7rem;
    border-bottom: 1px solid #f2f2f2;
}
.s-stats { display: grid; grid-template-columns: 1fr 1fr; gap: .9rem; }
.s-stat {
    background: linear-gradient(135deg, #f4f8ff, #edf5ff);
    border-radius: 14px; padding: 1rem; text-align: center;
    border: 1px solid rgba(0,45,98,.05);
}
.s-stat-n {
    font-family: 'Instrument Serif', serif; font-size: 2rem; font-weight: 400;
    color: var(--color-uttec-blue-dark); line-height: 1; display: block;
}
.s-stat-l {
    font-family: 'Nunito', sans-serif; font-size: .67rem; color: #aaa;
    margin-top: .3rem; font-weight: 700; text-transform: uppercase; letter-spacing: .9px; display: block;
}
.s-dato { margin-bottom: .9rem; }
.s-dato:last-child { margin-bottom: 0; }
.s-dato-l { font-family: 'Nunito', sans-serif; font-size: .71rem; color: #bbb; font-weight: 700; display: block; margin-bottom: .18rem; }
.s-dato-v { font-family: 'Nunito', sans-serif; font-size: .88rem; font-weight: 700; color: #2a2a2a; display: block; }

/* Chip reacciones en sidebar */
.s-reacs { display: flex; flex-wrap: wrap; gap: 6px; }
.s-reac-chip {
    display: inline-flex; align-items: center; gap: 4px;
    background: #f4f8ff; border: 1.5px solid #e0e8ff;
    border-radius: 50px; padding: .28rem .75rem;
    font-family: 'Nunito', sans-serif; font-size: .8rem; font-weight: 700; color: #555;
}

.btn-copy {
    width: 100%; padding: .8rem;
    background: var(--color-uttec-blue-dark); color: #fff;
    border: none; border-radius: 12px;
    font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .88rem;
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: background .2s, transform .15s;
    box-shadow: 0 4px 14px rgba(0,45,98,.2);
}
.btn-copy:hover { background: var(--color-uttec-green); transform: translateY(-1px); }
.btn-copy.ok { background: var(--color-uttec-green); }

/* ══════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════ */
@media (max-width: 920px) {
    .layout { grid-template-columns: 1fr; }
    .sidebar { position: static; }
    .hero { width: calc(100% + 4rem); margin-left: -2rem; height: 380px; }
    .hero-bottom { padding: 1.5rem 2rem; }
    .hero-h1 { font-size: 1.75rem; }
    .reacciones-wrap { padding: 1.3rem 1.2rem; }
}
</style>

<div id="reading-bar"></div>

<div class="nw">
    <a href="{{ route('estudiante.noticias.foro') }}" class="back-link">
        <i data-feather="arrow-left" style="width:15px;height:15px;"></i> Foro de noticias
    </a>

    {{-- ── HERO ── --}}
    <div class="hero">
        @if($noticia->imagen)
            <img src="{{ Storage::url($noticia->imagen) }}" alt="{{ $noticia->titulo }}">
            <div class="hero-veil"></div>
        @else
            <div class="hero-ph">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3Z"/></svg>
            </div>
            <div class="hero-veil" style="background:linear-gradient(165deg,transparent 30%,rgba(0,10,30,.8));"></div>
        @endif

        <div class="hero-badges">
            <span class="hero-cat">
                <i data-feather="tag" style="width:11px;height:11px;"></i>
                {{ $noticia->categoria }}
            </span>
            <div class="hero-right-badges" style="display:flex;flex-direction:column;gap:7px;align-items:flex-end;">
                <span class="hero-badge-sm">
                    <i data-feather="clock" style="width:12px;height:12px;"></i>
                    {{ max(1, ceil(str_word_count(strip_tags($noticia->contenido)) / 200)) }} min
                </span>
            </div>
        </div>

        <div class="hero-bottom">
            <h1 class="hero-h1">{{ $noticia->titulo }}</h1>
            <div class="hero-meta">
                <span class="hero-meta-chip">
                    <i data-feather="user" style="width:12px;height:12px;"></i>
                    {{ $noticia->autor->nombre ?? 'Administración UTTEC' }}
                </span>
                <span class="hero-meta-sep">·</span>
                <span class="hero-meta-chip">
                    <i data-feather="calendar" style="width:12px;height:12px;"></i>
                    {{ $noticia->created_at->isoFormat('DD [de] MMMM, YYYY') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── LAYOUT ── --}}
    <div class="layout">

        {{-- Columna principal --}}
        <div>

            {{-- Lead --}}
            <p class="art-lead">{{ Str::limit(strip_tags($noticia->contenido), 240) }}</p>

            {{-- Cuerpo --}}
            <div class="art-body" id="art-body">{{ $noticia->contenido }}</div>

            {{-- ── REACCIONES + LIKE ── --}}
            <div class="reacciones-wrap">
                <div class="reacciones-lbl">¿Cómo te pareció?</div>
                <div class="reacciones-row">

                    {{-- 5 Reacciones --}}
                    @php
                        $reacs = [
                            ['k'=>'fuego',    'e'=>'🔥', 'l'=>'¡Genial!'],
                            ['k'=>'aplausos', 'e'=>'👏', 'l'=>'Bravo'],
                            ['k'=>'wow',      'e'=>'😮', 'l'=>'Sorprende'],
                            ['k'=>'piensa',   'e'=>'🤔', 'l'=>'Interesa'],
                            ['k'=>'amor',     'e'=>'❤️', 'l'=>'Me encanta'],
                        ];
                        $counts   = $reaccionesCounts ?? [];
                        $miReaccion = $miReaccion ?? null;
                    @endphp
                    @foreach($reacs as $r)
                    <button
                        class="reac-btn {{ $miReaccion === $r['k'] ? 'active' : '' }}"
                        onclick="reaccionar('{{ $r['k'] }}', this)"
                        data-key="{{ $r['k'] }}"
                        title="{{ $r['l'] }}"
                    >
                        <span class="reac-emoji">{{ $r['e'] }}</span>
                        <span class="reac-label">{{ $r['l'] }}</span>
                        <span class="reac-count" id="rc-{{ $r['k'] }}">{{ $counts[$r['k']] ?? 0 }}</span>
                    </button>
                    @endforeach

                    <div class="reacciones-sep"></div>

                    {{-- Like --}}
                    @php $yaLiked = $noticia->likeDelUsuario($userId); @endphp
                    <button
                        class="like-pill {{ $yaLiked ? 'liked' : '' }}"
                        id="like-btn"
                        onclick="toggleLike({{ $noticia->id_noticia }})"
                        title="Me gusta"
                    >
                        <svg id="heart-svg" class="like-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            fill="{{ $yaLiked ? '#e74c3c' : 'none' }}"
                            stroke="{{ $yaLiked ? '#e74c3c' : '#888' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                        </svg>
                        <span class="like-lbl">Me gusta</span>
                        <span class="like-num" id="like-count">{{ $noticia->totalLikes() }}</span>
                    </button>

                </div>

                {{-- Chip comentarios debajo --}}
                <div class="coms-chip">
                    <i data-feather="message-circle" style="width:15px;height:15px;"></i>
                    <span id="com-count">{{ $noticia->comentarios->count() }}</span>&nbsp;comentario(s)
                </div>
            </div>

            {{-- ── COMENTARIOS ── --}}
            <h3 class="coms-title">Comentarios</h3>

            {{-- Form --}}
            <div class="com-form">
                <div class="com-av">{{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}</div>
                <div class="com-field">
                    <textarea
                        class="com-ta" id="com-ta"
                        placeholder="¿Qué opinas sobre esta noticia?"
                        oninput="updChar(this)" maxlength="500"
                    ></textarea>
                    <div class="com-foot">
                        <span class="com-chars" id="com-chars">0 / 500</span>
                        <button class="btn-post" onclick="enviarCom({{ $noticia->id_noticia }})">
                            <i data-feather="send" style="width:13px;height:13px;"></i> Publicar
                        </button>
                    </div>
                </div>
            </div>

            {{-- Lista --}}
            <div class="coms-list" id="coms-list">
                @php
                    $pal = ['#002D62','#00A86B','#004C99','#1a6b4a','#003580','#005e8a','#004d38'];
                @endphp
                @forelse($noticia->comentarios as $com)
                @php $col = $pal[$com->id_usuario % count($pal)]; @endphp
                <div class="com-item" id="com-{{ $com->id_comentario }}">
                    <div class="com-av" style="background:{{ $col }};width:44px;height:44px;border-radius:50%;flex-shrink:0;">
                        {{ strtoupper(substr($com->usuario->nombre ?? 'U', 0, 1)) }}
                    </div>
                    <div class="com-bub">
                        <div class="com-hd">
                            <span class="com-name">{{ $com->usuario->nombre ?? 'Usuario' }}</span>
                            <span class="com-date">{{ $com->created_at->isoFormat('DD MMM YYYY · HH:mm') }}</span>
                            @if($com->id_usuario === $userId)
                            <button class="com-del" onclick="eliminarCom({{ $com->id_comentario }})">Eliminar</button>
                            @endif
                        </div>
                        <div class="com-txt">{{ $com->comentario }}</div>
                    </div>
                </div>
                @empty
                <div class="com-empty" id="empty-msg">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z"/></svg>
                    <p>Sé el primero en comentar esta noticia.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar">

            {{-- Stats --}}
            <div class="s-card">
                <span class="s-label">Actividad</span>
                <div class="s-stats">
                    <div class="s-stat">
                        <span class="s-stat-n" id="sb-likes">{{ $noticia->totalLikes() }}</span>
                        <span class="s-stat-l">Me gusta</span>
                    </div>
                    <div class="s-stat">
                        <span class="s-stat-n">{{ $noticia->comentarios->count() }}</span>
                        <span class="s-stat-l">Comentarios</span>
                    </div>
                </div>
            </div>

            {{-- Reacciones resumen sidebar --}}
            <div class="s-card">
                <span class="s-label">Reacciones</span>
                <div class="s-reacs" id="sb-reacs">
                    @foreach($reacs as $r)
                    <span class="s-reac-chip" id="sb-rc-{{ $r['k'] }}" style="{{ ($counts[$r['k']] ?? 0) == 0 ? 'opacity:.4' : '' }}">
                        {{ $r['e'] }} <span id="sb-n-{{ $r['k'] }}">{{ $counts[$r['k']] ?? 0 }}</span>
                    </span>
                    @endforeach
                </div>
            </div>

            {{-- Info --}}
            <div class="s-card">
                <span class="s-label">Publicación</span>
                <div class="s-dato">
                    <span class="s-dato-l">Autor</span>
                    <span class="s-dato-v">{{ $noticia->autor->nombre ?? 'Administración' }}</span>
                </div>
                <div class="s-dato">
                    <span class="s-dato-l">Fecha</span>
                    <span class="s-dato-v">{{ $noticia->created_at->isoFormat('DD MMM, YYYY') }}</span>
                </div>
                <div class="s-dato">
                    <span class="s-dato-l">Categoría</span>
                    <span class="s-dato-v">{{ $noticia->categoria }}</span>
                </div>
                <div class="s-dato">
                    <span class="s-dato-l">Lectura</span>
                    <span class="s-dato-v">{{ max(1, ceil(str_word_count(strip_tags($noticia->contenido)) / 200)) }} minuto(s)</span>
                </div>
            </div>

            {{-- Compartir --}}
            <div class="s-card">
                <span class="s-label">Compartir</span>
                <button class="btn-copy" id="btn-copy" onclick="copiar()">
                    <i data-feather="link" style="width:15px;height:15px;"></i> Copiar enlace
                </button>
            </div>

        </aside>
    </div>
</div>

<script>
const CSRF      = document.querySelector('meta[name="csrf-token"]').content;
const miNombre  = @json(Auth::user()->nombre);
const miInicial = "{{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}";
const pal       = ['#002D62','#00A86B','#004C99','#1a6b4a','#003580','#005e8a','#004d38'];
let miReac      = @json($miReaccion ?? null);

const bar  = document.getElementById('reading-bar');
const body = document.getElementById('art-body');
window.addEventListener('scroll', () => {
    if (!body) return;
    const st  = body.offsetTop;
    const end = st + body.offsetHeight - window.innerHeight;
    bar.style.width = Math.min(100, Math.max(0, (scrollY - st + 100) / (end - st + 100) * 100)) + '%';
}, { passive: true });

function updChar(ta) {
    document.getElementById('com-chars').textContent = ta.value.length + ' / 500';
}

function reaccionar(key, btn) {
    const misma = miReac === key;
    document.querySelectorAll('.reac-btn').forEach(b => b.classList.remove('active'));
    if (!misma) btn.classList.add('active');
    miReac = misma ? null : key;

    const el   = document.getElementById('rc-' + key);
    const sbEl = document.getElementById('sb-n-' + key);
    const sbCh = document.getElementById('sb-rc-' + key);
    const n    = parseInt(el.textContent) + (misma ? -1 : 1);
    el.textContent = Math.max(0, n);
    sbEl.textContent = Math.max(0, n);
    sbCh.style.opacity = Math.max(0, n) == 0 ? '.4' : '1';
}

function toggleLike(id) {
    const btn = document.getElementById('like-btn');
    btn.classList.add('pop');
    btn.addEventListener('animationend', () => btn.classList.remove('pop'), { once: true });

    fetch(`/estudiante/noticias/${id}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(d => {
        const ico = document.getElementById('heart-svg');
        document.getElementById('like-count').textContent = d.total;
        document.getElementById('sb-likes').textContent   = d.total;
        if (d.liked) {
            btn.classList.add('liked');
            ico.setAttribute('fill', '#e74c3c');
            ico.setAttribute('stroke', '#e74c3c');
        } else {
            btn.classList.remove('liked');
            ico.setAttribute('fill', 'none');
            ico.setAttribute('stroke', '#888');
        }
    });
}

function enviarCom(id) {
    const ta    = document.getElementById('com-ta');
    const texto = ta.value.trim();
    if (!texto) { ta.focus(); return; }

    fetch(`/estudiante/noticias/${id}/comentar`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json', 'Content-Type': 'application/json' },
        body: JSON.stringify({ comentario: texto })
    })
    .then(r => r.json())
    .then(d => {
        if (d.error) { alert(d.error); return; }
        document.getElementById('empty-msg')?.remove();
        const lista = document.getElementById('coms-list');
        const color = pal[d.id % pal.length];
        const div   = document.createElement('div');
        div.className = 'com-item'; div.id = `com-${d.id}`;
        div.innerHTML = `
            <div class="com-av" style="background:${color};width:44px;height:44px;border-radius:50%;flex-shrink:0;">${miInicial}</div>
            <div class="com-bub">
                <div class="com-hd">
                    <span class="com-name">${miNombre}</span>
                    <span class="com-date">Ahora</span>
                    <button class="com-del" onclick="eliminarCom(${d.id})">Eliminar</button>
                </div>
                <div class="com-txt">${esc(d.texto)}</div>
            </div>`;
        lista.appendChild(div);
        ta.value = '';
        document.getElementById('com-chars').textContent = '0 / 500';
        const c = document.getElementById('com-count');
        c.textContent = parseInt(c.textContent) + 1;
    })
    .catch(() => alert('Error al publicar.'));
}

function eliminarCom(id) {
    if (!confirm('¿Eliminar este comentario?')) return;
    fetch(`/estudiante/noticias/comentario/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(() => {
        document.getElementById(`com-${id}`)?.remove();
        const c = document.getElementById('com-count');
        c.textContent = Math.max(0, parseInt(c.textContent) - 1);
    });
}

/* ── Copiar enlace ── */
function copiar() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = document.getElementById('btn-copy');
        btn.classList.add('ok');
        btn.innerHTML = '<i data-feather="check" style="width:15px;height:15px;"></i> ¡Copiado!';
        feather.replace();
        setTimeout(() => {
            btn.classList.remove('ok');
            btn.innerHTML = '<i data-feather="link" style="width:15px;height:15px;"></i> Copiar enlace';
            feather.replace();
        }, 2400);
    });
}

function esc(s) { return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

feather.replace();
</script>

@endsection