{{--
    ══════════════════════════════════════════════════════════════
    COMPONENTE: page-loader.blade.php
    Incluir en layouts/estudiante.blade.php y layouts/profesor.blade.php
    justo DESPUÉS de <body ...> (antes de todo lo demás):

        @include('components.page-loader')

    ══════════════════════════════════════════════════════════════
--}}

<style>
    #page-loader {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1.5rem;
        background: linear-gradient(135deg, #001a3d 0%, #002D62 50%, #003f80 100%);
        transition: opacity .5s ease, visibility .5s ease;
    }

    #page-loader.hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    /* ── Partículas de fondo ── */
    .loader-particles {
        position: absolute;
        inset: 0;
        overflow: hidden;
        pointer-events: none;
    }
    .particle {
        position: absolute;
        border-radius: 50%;
        background: rgba(0, 168, 107, 0.15);
        animation: floatParticle linear infinite;
    }

    @keyframes floatParticle {
        0%   { transform: translateY(110vh) scale(0); opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { transform: translateY(-10vh) scale(1); opacity: 0; }
    }

    /* ── Anillo giratorio exterior ── */
    .loader-ring {
        position: relative;
        width: 160px;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loader-ring::before,
    .loader-ring::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        border: 3px solid transparent;
    }

    .loader-ring::before {
        inset: 0;
        border-top-color: #00A86B;
        border-right-color: rgba(0,168,107,0.3);
        animation: ringSpinA 1.2s linear infinite;
    }

    .loader-ring::after {
        inset: 12px;
        border-bottom-color: rgba(0,168,107,0.5);
        border-left-color: transparent;
        animation: ringSpinB 1.8s linear infinite reverse;
    }

    @keyframes ringSpinA { to { transform: rotate(360deg); } }
    @keyframes ringSpinB { to { transform: rotate(360deg); } }

    /* ── Lechuza SVG central ── */
    .loader-owl {
        width: 90px;
        height: 90px;
        animation: owlBob 1.5s ease-in-out infinite;
        filter: drop-shadow(0 0 18px rgba(0,168,107,0.5));
    }

    @keyframes owlBob {
        0%, 100% { transform: translateY(0) rotate(-3deg); }
        50%       { transform: translateY(-10px) rotate(3deg); }
    }

    /* Ojos parpadeando */
    .owl-eye-l-l, .owl-eye-r-l {
        transform-origin: center;
        animation: loaderBlink 2.5s infinite;
    }
    .owl-eye-r-l { animation-delay: 0.1s; }
    @keyframes loaderBlink {
        0%, 80%, 100% { transform: scaleY(1); }
        85%, 95%      { transform: scaleY(0.05); }
    }

    /* Alas */
    .owl-wing-ll { transform-origin: 30% 50%; animation: wingLAnim 1.5s ease-in-out infinite; }
    .owl-wing-rl { transform-origin: 70% 50%; animation: wingRAnim 1.5s ease-in-out infinite; }
    @keyframes wingLAnim { 0%,100%{transform:rotate(0deg)} 50%{transform:rotate(-12deg)} }
    @keyframes wingRAnim { 0%,100%{transform:rotate(0deg)} 50%{transform:rotate(12deg)} }

    /* ── Texto ── */
    .loader-brand {
        font-family: 'Inter', sans-serif;
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.5px;
    }
    .loader-brand span { color: #00A86B; }

    .loader-dots {
        display: flex;
        gap: 7px;
        margin-top: -.5rem;
    }
    .loader-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: rgba(0,168,107,0.4);
        animation: dotPulse 1.2s ease-in-out infinite;
    }
    .loader-dot:nth-child(2) { animation-delay: .2s; }
    .loader-dot:nth-child(3) { animation-delay: .4s; }
    @keyframes dotPulse {
        0%, 100% { transform: scale(1);   background: rgba(0,168,107,0.4); }
        50%       { transform: scale(1.5); background: #00A86B; }
    }

    /* ── Barra de progreso ── */
    .loader-progress {
        width: 200px;
        height: 3px;
        background: rgba(255,255,255,0.1);
        border-radius: 50px;
        overflow: hidden;
        margin-top: -.5rem;
    }
    .loader-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #00A86B, #00e090);
        border-radius: 50px;
        animation: progressFill 1.6s ease-in-out infinite;
    }
    @keyframes progressFill {
        0%   { width: 0%;   margin-left: 0; }
        50%  { width: 70%;  margin-left: 0; }
        100% { width: 0%;   margin-left: 100%; }
    }

    /* ── Frase de carga ── */
    .loader-msg {
        font-family: 'Inter', sans-serif;
        font-size: .8rem;
        color: rgba(255,255,255,.35);
        letter-spacing: .5px;
        animation: msgFade 3s ease-in-out infinite;
    }
    @keyframes msgFade {
        0%,100% { opacity:.35 }
        50%     { opacity:.7 }
    }
</style>

<div id="page-loader">

    {{-- Partículas de fondo --}}
    <div class="loader-particles" id="loaderParticles"></div>

    {{-- Anillo + lechuza --}}
    <div class="loader-ring">
        <svg class="loader-owl" viewBox="0 0 100 110" xmlns="http://www.w3.org/2000/svg" fill="none">
            <ellipse cx="50" cy="105" rx="22" ry="5" fill="rgba(0,168,107,0.2)"/>
            <ellipse cx="50" cy="68" rx="28" ry="32" fill="#002D62"/>
            <ellipse cx="50" cy="74" rx="17" ry="22" fill="#E8F0F8"/>
            <g class="owl-wing-ll">
                <ellipse cx="27" cy="70" rx="10" ry="18" fill="#003F8A" transform="rotate(-10 27 70)"/>
            </g>
            <g class="owl-wing-rl">
                <ellipse cx="73" cy="70" rx="10" ry="18" fill="#003F8A" transform="rotate(10 73 70)"/>
            </g>
            <circle cx="50" cy="40" r="24" fill="#002D62"/>
            <polygon points="32,20 28,8 38,18" fill="#004C99"/>
            <polygon points="68,20 72,8 62,18" fill="#004C99"/>
            <g class="owl-eye-l-l">
                <circle cx="40" cy="40" r="9" fill="white"/>
                <circle cx="40" cy="40" r="6" fill="#00A86B"/>
                <circle cx="40" cy="40" r="3.5" fill="#001A3A"/>
                <circle cx="42" cy="38" r="1.2" fill="white"/>
            </g>
            <g class="owl-eye-r-l">
                <circle cx="60" cy="40" r="9" fill="white"/>
                <circle cx="60" cy="40" r="6" fill="#00A86B"/>
                <circle cx="60" cy="40" r="3.5" fill="#001A3A"/>
                <circle cx="62" cy="38" r="1.2" fill="white"/>
            </g>
            <polygon points="50,46 45,53 55,53" fill="#F5A623"/>
            <line x1="42" y1="98" x2="38" y2="105" stroke="#F5A623" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="42" y1="105" x2="35" y2="105" stroke="#F5A623" stroke-width="2" stroke-linecap="round"/>
            <line x1="58" y1="98" x2="62" y2="105" stroke="#F5A623" stroke-width="2.5" stroke-linecap="round"/>
            <line x1="62" y1="105" x2="69" y2="105" stroke="#F5A623" stroke-width="2" stroke-linecap="round"/>
        </svg>
    </div>

    {{-- Marca --}}
    <div class="loader-brand">Added<span>UT</span></div>

    {{-- Puntos --}}
    <div class="loader-dots">
        <div class="loader-dot"></div>
        <div class="loader-dot"></div>
        <div class="loader-dot"></div>
    </div>

    {{-- Barra de progreso --}}
    <div class="loader-progress">
        <div class="loader-progress-bar"></div>
    </div>

    {{-- Frase --}}
    <div class="loader-msg">Cargando tu espacio de aprendizaje...</div>
</div>

<script>
(function () {
    // Generar partículas
    const container = document.getElementById('loaderParticles');
    if (container) {
        for (let i = 0; i < 18; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 40 + 10;
            p.style.cssText = `
                width: ${size}px;
                height: ${size}px;
                left: ${Math.random() * 100}%;
                animation-duration: ${Math.random() * 8 + 5}s;
                animation-delay: ${Math.random() * 5}s;
            `;
            container.appendChild(p);
        }
    }

    // Ocultar loader cuando la página termina de cargar
    function hideLoader() {
        const loader = document.getElementById('page-loader');
        if (loader) {
            loader.classList.add('hidden');
            // Eliminar del DOM después de la transición
            setTimeout(() => loader.remove(), 550);
        }
    }

    if (document.readyState === 'complete') {
        setTimeout(hideLoader, 400);
    } else {
        window.addEventListener('load', function () {
            setTimeout(hideLoader, 400);
        });
    }
})();
</script>
