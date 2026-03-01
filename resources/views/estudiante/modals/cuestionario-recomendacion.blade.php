{{-- resources/views/estudiante/modals/cuestionario-recomendacion.blade.php --}}

@if($mostrarCuestionario)
<style>
    #modal-cuestionario {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 20, 60, 0.75);
        backdrop-filter: blur(6px);
    }

    .modal-box {
        position: relative;
        background: #fff;
        border-radius: 20px;
        width: 100%;
        max-width: 620px;
        box-shadow: 0 30px 80px rgba(0, 45, 98, 0.35);
        overflow: hidden;
        animation: modalEntra 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    @keyframes modalEntra {
        from { opacity: 0; transform: translateY(30px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header {
        background: linear-gradient(135deg, #002D62 0%, #004C99 100%);
        padding: 2rem 2.5rem 1.5rem;
        color: #fff;
    }

    .modal-header h2 {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 0.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-header p {
        font-size: 0.95rem;
        opacity: 0.8;
    }

    .progress-bar-wrap {
        background: rgba(255,255,255,0.2);
        border-radius: 50px;
        height: 6px;
        margin-top: 1.2rem;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: #00A86B;
        border-radius: 50px;
        transition: width 0.4s ease;
    }

    .modal-body {
        padding: 2rem 2.5rem;
        min-height: 260px;
    }

    .paso {
        display: none;
        animation: fadeSlide 0.3s ease;
    }

    .paso.activo {
        display: block;
    }

    @keyframes fadeSlide {
        from { opacity: 0; transform: translateX(20px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .paso h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #002D62;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .opciones-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.8rem;
    }

    .opcion-btn {
        border: 2px solid #e0e8f4;
        border-radius: 12px;
        padding: 0.9rem 1rem;
        background: #f8fafd;
        cursor: pointer;
        transition: all 0.25s ease;
        font-size: 0.95rem;
        font-weight: 600;
        color: #002D62;
        display: flex;
        align-items: center;
        gap: 10px;
        text-align: left;
    }

    .opcion-btn:hover {
        border-color: #00A86B;
        background: #f0fdf8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 168, 107, 0.15);
    }

    .opcion-btn.seleccionado {
        border-color: #00A86B;
        background: #e6f9f2;
        color: #006644;
        box-shadow: 0 4px 12px rgba(0, 168, 107, 0.2);
    }

    .opcion-btn .icono {
        font-size: 1.4rem;
        line-height: 1;
    }

    .hint-multi {
        font-size: 0.82rem;
        color: #00A86B;
        font-weight: 600;
        margin: -0.6rem 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .hint-multi::before {
        content: '✓';
        background: #e6f9f2;
        color: #00A86B;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 800;
    }

    .opcion-btn.bloqueado {
        opacity: 0.4;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .modal-footer {
        padding: 1rem 2.5rem 1.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f0f0f0;
    }

    .btn-omitir {
        background: none;
        border: none;
        color: #aaa;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 600;
        transition: color 0.2s;
    }

    .btn-omitir:hover { color: #e74c3c; }

    .btn-siguiente {
        background: #00A86B;
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 0.75rem 2rem;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 5px 15px rgba(0, 168, 107, 0.35);
    }

    .btn-siguiente:hover {
        background: #002D62;
        box-shadow: 0 7px 20px rgba(0, 45, 98, 0.35);
        transform: translateY(-2px);
    }

    .btn-siguiente:disabled {
        background: #ccc;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    /* ── Pantalla de carga ── */
    #paso-cargando {
        display: none;
        text-align: center;
        padding: 2rem 0;
    }

    .spinner {
        width: 52px;
        height: 52px;
        border: 5px solid #e0e8f4;
        border-top-color: #00A86B;
        border-radius: 50%;
        animation: girar 0.8s linear infinite;
        margin: 0 auto 1.2rem;
    }

    @keyframes girar {
        to { transform: rotate(360deg); }
    }

    /* ── Pantalla de resultados ── */
    #paso-resultados {
        display: none;
    }

    .resultados-titulo {
        font-size: 1.2rem;
        font-weight: 800;
        color: #002D62;
        margin-bottom: 1.2rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .taller-card-rec {
        display: flex;
        align-items: center;
        gap: 1rem;
        border: 2px solid #e0e8f4;
        border-radius: 14px;
        padding: 1rem;
        margin-bottom: 0.8rem;
        transition: all 0.25s ease;
        text-decoration: none;
        color: inherit;
        background: #f8fafd;
    }

    .taller-card-rec:hover {
        border-color: #00A86B;
        background: #f0fdf8;
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(0, 168, 107, 0.15);
    }

    .taller-img-rec {
        width: 64px;
        height: 64px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid #e0e8f4;
    }

    .taller-info-rec {
        flex: 1;
        min-width: 0;
    }

    .taller-info-rec strong {
        display: block;
        font-size: 1rem;
        font-weight: 700;
        color: #002D62;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .taller-info-rec span {
        font-size: 0.82rem;
        color: #777;
    }

    .score-badge {
        background: linear-gradient(135deg, #002D62, #004C99);
        color: #fff;
        font-weight: 800;
        font-size: 0.95rem;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        white-space: nowrap;
        flex-shrink: 0;
    }
</style>

<div id="modal-cuestionario">
    <div class="modal-backdrop"></div>

    <div class="modal-box">

        {{-- Header --}}
        <div class="modal-header">
            <h2>🎯 Encuentra tu taller ideal</h2>
            <p>5 preguntas rápidas y te recomendamos lo mejor para ti.</p>
            <div class="progress-bar-wrap">
                <div class="progress-bar-fill" id="progress-fill" style="width: 20%"></div>
            </div>
        </div>

        {{-- Body --}}
        <div class="modal-body">

            {{-- Paso 1 --}}
            <div class="paso activo" data-paso="1" data-multi="2">
                <h3>1 de 5 &nbsp;·&nbsp; ¿Qué tipo de actividad te llama más la atención?</h3>
                <p class="hint-multi">Puedes elegir hasta 2 opciones</p>
                <div class="opciones-grid">
                    <button class="opcion-btn" data-campo="tipo_actividad" data-valor="deporte">
                        <span class="icono">⚽</span> Deporte
                    </button>
                    <button class="opcion-btn" data-campo="tipo_actividad" data-valor="arte">
                        <span class="icono">🎨</span> Arte y Cultura
                    </button>
                    <button class="opcion-btn" data-campo="tipo_actividad" data-valor="mente">
                        <span class="icono">♟️</span> Ejercicio Mental
                    </button>
                    <button class="opcion-btn" data-campo="tipo_actividad" data-valor="cultura">
                        <span class="icono">🎭</span> Expresión Escénica
                    </button>
                </div>
            </div>

            {{-- Paso 2 --}}
            <div class="paso" data-paso="2">
                <h3>2 de 5 &nbsp;·&nbsp; ¿Prefieres actividades individuales o en equipo?</h3>
                <div class="opciones-grid">
                    <button class="opcion-btn" data-campo="modalidad" data-valor="individual">
                        <span class="icono">🧘</span> Individual
                    </button>
                    <button class="opcion-btn" data-campo="modalidad" data-valor="equipo">
                        <span class="icono">🤝</span> En equipo
                    </button>
                </div>
            </div>

            {{-- Paso 3 --}}
            <div class="paso" data-paso="3">
                <h3>3 de 5 &nbsp;·&nbsp; ¿Tienes experiencia previa en algún taller?</h3>
                <div class="opciones-grid">
                    <button class="opcion-btn" data-campo="experiencia" data-valor="ninguna">
                        <span class="icono">🌱</span> Ninguna, soy nuevo
                    </button>
                    <button class="opcion-btn" data-campo="experiencia" data-valor="poca">
                        <span class="icono">📚</span> Algo de experiencia
                    </button>
                    <button class="opcion-btn" data-campo="experiencia" data-valor="mucha">
                        <span class="icono">🏆</span> Bastante experiencia
                    </button>
                </div>
            </div>

            {{-- Paso 4 --}}
            <div class="paso" data-paso="4">
                <h3>4 de 5 &nbsp;·&nbsp; ¿Qué horario te viene mejor?</h3>
                <div class="opciones-grid">
                    <button class="opcion-btn" data-campo="horario_preferido" data-valor="manana">
                        <span class="icono">🌅</span> Mañana
                    </button>
                    <button class="opcion-btn" data-campo="horario_preferido" data-valor="tarde">
                        <span class="icono">☀️</span> Tarde
                    </button>
                </div>
            </div>

            {{-- Paso 5 --}}
            <div class="paso" data-paso="5" data-multi="3">
                <h3>5 de 5 &nbsp;·&nbsp; ¿Qué buscas principalmente en un taller?</h3>
                <p class="hint-multi">Puedes elegir hasta 3 opciones</p>
                <div class="opciones-grid">
                    <button class="opcion-btn" data-campo="objetivo" data-valor="competir">
                        <span class="icono">🥇</span> Competir
                    </button>
                    <button class="opcion-btn" data-campo="objetivo" data-valor="aprender">
                        <span class="icono">💡</span> Aprender algo nuevo
                    </button>
                    <button class="opcion-btn" data-campo="objetivo" data-valor="relajarse">
                        <span class="icono">😌</span> Relajarme y distraerme
                    </button>
                    <button class="opcion-btn" data-campo="objetivo" data-valor="socializar">
                        <span class="icono">🎉</span> Conocer gente
                    </button>
                </div>
            </div>

            {{-- Cargando --}}
            <div id="paso-cargando">
                <div class="spinner"></div>
                <p style="font-weight: 700; color: #002D62; font-size: 1.05rem;">Analizando tu perfil...</p>
                <p style="color: #888; font-size: 0.9rem; margin-top: 4px;">Buscando los talleres perfectos para ti</p>
            </div>

            {{-- Resultados --}}
            <div id="paso-resultados">
                <div class="resultados-titulo">🎯 Tus talleres recomendados</div>
                <div id="lista-recomendaciones"></div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="modal-footer">
            <button class="btn-omitir" id="btn-omitir">Saltar por ahora</button>
            <button class="btn-siguiente" id="btn-siguiente" disabled>
                Siguiente <i data-feather="arrow-right" style="width:16px; height:16px;"></i>
            </button>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const totalPasos  = 5;
    let pasoActual    = 1;
    const respuestas  = {};

    const progressFill  = document.getElementById('progress-fill');
    const btnSiguiente  = document.getElementById('btn-siguiente');
    const btnOmitir     = document.getElementById('btn-omitir');
    const pasosCargando = document.getElementById('paso-cargando');
    const pasosResult   = document.getElementById('paso-resultados');
    const listaRec      = document.getElementById('lista-recomendaciones');
    const csrfToken     = document.querySelector('meta[name="csrf-token"]').content;

    const camposPorPaso = {
        1: 'tipo_actividad',
        2: 'modalidad',
        3: 'experiencia',
        4: 'horario_preferido',
        5: 'objetivo',
    };

    function esMulti(numeroPaso) {
        const el = document.querySelector(`.paso[data-paso="${numeroPaso}"]`);
        return el && el.dataset.multi ? parseInt(el.dataset.multi) : 1;
    }

    function seleccionadosEnPaso(numeroPaso) {
        const campo = camposPorPaso[numeroPaso];
        return document.querySelectorAll(`.opcion-btn[data-campo="${campo}"].seleccionado`).length;
    }

    function actualizarBoton() {
        const campo = camposPorPaso[pasoActual];
        const valor = respuestas[campo];
        if (Array.isArray(valor)) {
            btnSiguiente.disabled = valor.length === 0;
        } else {
            btnSiguiente.disabled = !valor;
        }
    }

    function mostrarPaso(num) {
        document.querySelectorAll('.paso').forEach(p => p.classList.remove('activo'));
        const el = document.querySelector(`.paso[data-paso="${num}"]`);
        if (el) el.classList.add('activo');

        progressFill.style.width = ((num / totalPasos) * 100) + '%';
        actualizarBoton();
    }

    document.querySelectorAll('.opcion-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            if (this.classList.contains('bloqueado')) return;

            const campo     = this.dataset.campo;
            const valor     = this.dataset.valor;
            const paso      = parseInt(this.closest('.paso').dataset.paso);
            const maxMulti  = esMulti(paso);

            if (maxMulti === 1) {
                document.querySelectorAll(`.opcion-btn[data-campo="${campo}"]`)
                        .forEach(b => b.classList.remove('seleccionado'));
                this.classList.add('seleccionado');
                respuestas[campo] = valor;

            } else {
                if (this.classList.contains('seleccionado')) {
                    this.classList.remove('seleccionado');
                    const arr = respuestas[campo] || [];
                    respuestas[campo] = arr.filter(v => v !== valor);
                } else {
                    const arr = respuestas[campo] || [];
                    if (arr.length < maxMulti) {
                        this.classList.add('seleccionado');
                        respuestas[campo] = [...arr, valor];
                    }
                }

                const totalSel = seleccionadosEnPaso(paso);
                document.querySelectorAll(`.opcion-btn[data-campo="${campo}"]`).forEach(b => {
                    if (!b.classList.contains('seleccionado')) {
                        b.classList.toggle('bloqueado', totalSel >= maxMulti);
                    }
                });
            }

            actualizarBoton();
            if (typeof feather !== 'undefined') feather.replace();
        });
    });

    btnSiguiente.addEventListener('click', function () {
        if (pasoActual < totalPasos) {
            pasoActual++;
            mostrarPaso(pasoActual);

            if (pasoActual === totalPasos) {
                btnSiguiente.innerHTML = 'Ver recomendaciones <span style="font-size:1.1rem">✨</span>';
            }

            if (typeof feather !== 'undefined') feather.replace();
            return;
        }

        enviarCuestionario();
    });

    btnOmitir.addEventListener('click', function () {
        fetch('{{ route("estudiante.recomendacion.omitir") }}', {
            method:  'POST',
            headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json' },
        }).finally(() => {
            document.getElementById('modal-cuestionario').remove();
        });
    });

    function prepararPayload() {
        const payload = { ...respuestas };

        if (Array.isArray(payload.tipo_actividad)) {
            payload.tipo_actividad = payload.tipo_actividad[0] ?? null;
        }
        if (Array.isArray(payload.objetivo)) {
            payload.objetivo = payload.objetivo[0] ?? null;
        }

        payload.tipo_actividad_extra = Array.isArray(respuestas.tipo_actividad)
            ? respuestas.tipo_actividad
            : [respuestas.tipo_actividad];

        payload.objetivos = Array.isArray(respuestas.objetivo)
            ? respuestas.objetivo
            : [respuestas.objetivo];

        return payload;
    }

    function enviarCuestionario() {
        document.querySelectorAll('.paso').forEach(p => p.classList.remove('activo'));
        pasosCargando.style.display  = 'block';
        pasosResult.style.display    = 'none';
        progressFill.style.width     = '100%';
        btnSiguiente.style.display   = 'none';
        btnOmitir.style.display      = 'none';

        fetch('{{ route("estudiante.recomendacion.guardar") }}', {
            method:  'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'Accept':       'application/json',
            },
            body: JSON.stringify(prepararPayload()),
        })
        .then(r => r.json())
        .then(data => {
            pasosCargando.style.display = 'none';

            if (!data.success || !data.recomendaciones.length) {
                listaRec.innerHTML = '<p style="color:#888; text-align:center; padding: 1rem 0;">No encontramos talleres disponibles en este momento. ¡Vuelve pronto!</p>';
                pasosResult.style.display = 'block';
                btnOmitir.textContent     = 'Cerrar';
                btnOmitir.style.display   = 'inline-block';
                return;
            }

            listaRec.innerHTML = '';

            data.recomendaciones.forEach(taller => {
                const card = document.createElement('a');
                card.href      = taller.url;
                card.className = 'taller-card-rec';
                card.innerHTML = `
                    <img src="${taller.imagen_url}" alt="${taller.nombre}" class="taller-img-rec"
                         onerror="this.src='{{ asset('imagenes/uttec.jpeg') }}'">
                    <div class="taller-info-rec">
                        <strong>${taller.nombre}</strong>
                        <span>${taller.categoria} &nbsp;·&nbsp; ${taller.cupos} cupos disponibles</span>
                    </div>
                    <div class="score-badge">${taller.score}%</div>
                `;
                listaRec.appendChild(card);
            });

            pasosResult.style.display = 'block';
            btnOmitir.textContent     = 'Cerrar';
            btnOmitir.style.display   = 'inline-block';

            btnOmitir.onclick = () => document.getElementById('modal-cuestionario').remove();
        })
        .catch(() => {
            pasosCargando.style.display = 'none';
            listaRec.innerHTML = '<p style="color:#e74c3c; text-align:center;">Ocurrió un error. Intenta de nuevo más tarde.</p>';
            pasosResult.style.display  = 'block';
            btnOmitir.textContent      = 'Cerrar';
            btnOmitir.style.display    = 'inline-block';
        });
    }

    if (typeof feather !== 'undefined') feather.replace();
});
</script>
@endif
