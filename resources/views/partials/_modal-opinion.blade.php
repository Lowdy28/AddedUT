{{--
    Partial: _modal-opinion.blade.php
    Incluir en dashboards de estudiante y profesor con:
    @include('partials._modal-opinion')
--}}

{{-- Botón flotante — cambia si ya opinó --}}
@php
    $yaOpino = \App\Models\Testimonio::where('id_usuario', auth()->user()->id_usuario)->exists();
@endphp

@if($yaOpino)
{{-- Ya tiene testimonio enviado --}}
<div style="position:fixed; bottom:1.8rem; right:1.8rem; z-index:800;
            display:inline-flex; align-items:center; gap:.5rem;
            background:rgba(0,168,107,.15); border:1px solid rgba(0,168,107,.4);
            color:rgba(255,255,255,.7); border-radius:50px;
            padding:.75rem 1.3rem; font-size:.85rem; font-weight:700;
            font-family:inherit; cursor:default;"
     title="Ya enviaste tu opinión. El admin la revisará pronto.">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"
         stroke="#00DC82" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Opinión enviada ✓
</div>
@else
{{-- Aún no ha opinado --}}
<button onclick="abrirOpinion()"
        style="position:fixed; bottom:1.8rem; right:1.8rem; z-index:800;
               display:inline-flex; align-items:center; gap:.5rem;
               background:linear-gradient(135deg,#002D62,#00A86B);
               color:#fff; border:none; border-radius:50px;
               padding:.75rem 1.3rem; font-size:.85rem; font-weight:700;
               cursor:pointer; box-shadow:0 6px 20px rgba(0,168,107,.35);
               transition:transform .2s, box-shadow .2s; font-family:inherit;"
        onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 10px 28px rgba(0,168,107,.45)'"
        onmouseout="this.style.transform='';this.style.boxShadow='0 6px 20px rgba(0,168,107,.35)'">
    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"
         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
    </svg>
    ¿Qué opinas de AddedUT?
</button>
@endif

{{-- Overlay + Modal --}}
<div id="opinion-overlay"
     style="display:none; position:fixed; inset:0; z-index:900;
            background:rgba(0,0,0,.55); backdrop-filter:blur(4px);
            align-items:center; justify-content:center; padding:1rem;">
    <div id="opinion-modal"
         style="background:#fff; border-radius:20px; padding:2rem;
                max-width:480px; width:100%;
                box-shadow:0 24px 60px rgba(0,0,0,.25);
                animation:modalIn .25s ease;">
        <style>@keyframes modalIn{from{opacity:0;transform:scale(.95)}to{opacity:1;transform:scale(1)}}</style>

        {{-- Header --}}
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:1.5rem;">
            <div>
                <h3 style="font-size:1.15rem; font-weight:800; color:#111827; margin-bottom:.25rem;">
                    Tu opinión importa
                </h3>
                <p style="font-size:.85rem; color:#6b7280; line-height:1.5;">
                    Una vez revisada por el admin aparecerá en la plataforma.
                </p>
            </div>
            <button onclick="cerrarOpinion()"
                    style="background:none; border:none; color:#9ca3af; cursor:pointer;
                           padding:.25rem; font-size:1.2rem; line-height:1; margin-top:-.1rem;">✕</button>
        </div>

        {{-- Estrellas --}}
        <div style="margin-bottom:1.4rem;">
            <label style="display:block; font-size:.8rem; font-weight:700; color:#374151;
                           text-transform:uppercase; letter-spacing:.5px; margin-bottom:.6rem;">
                Calificación
            </label>
            <div id="star-row" style="display:flex; gap:.4rem;">
                @for($i=1; $i<=5; $i++)
                <button type="button"
                        data-val="{{ $i }}"
                        onclick="setStar({{ $i }})"
                        onmouseover="hoverStar({{ $i }})"
                        onmouseout="resetStars()"
                        style="background:none; border:none; cursor:pointer; padding:2px;
                               transition:transform .1s;" class="star-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                         fill="none" stroke="#d1d5db" stroke-width="1.5" class="star-svg"
                         style="transition:fill .15s, stroke .15s;">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                </button>
                @endfor
            </div>
            <input type="hidden" id="estrellas-val" value="0">
            <span id="star-label" style="font-size:.8rem; color:#9ca3af; margin-top:.3rem; display:block;">
                Toca para calificar
            </span>
        </div>

        {{-- Comentario --}}
        <div style="margin-bottom:1.4rem;">
            <label style="display:block; font-size:.8rem; font-weight:700; color:#374151;
                           text-transform:uppercase; letter-spacing:.5px; margin-bottom:.6rem;">
                Tu comentario
            </label>
            <textarea id="opinion-txt" rows="3" maxlength="300"
                      placeholder="Cuéntanos tu experiencia con AddedUT..."
                      oninput="document.getElementById('char-count').textContent=300-this.value.length"
                      style="width:100%; background:#f9fafb; border:1px solid #e5e7eb;
                             border-radius:12px; padding:.85rem 1rem; font-size:.9rem;
                             color:#111827; resize:none; outline:none; font-family:inherit;
                             transition:border-color .2s;"
                      onfocus="this.style.borderColor='#00A86B'; this.style.boxShadow='0 0 0 3px rgba(0,168,107,.1)'"
                      onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow=''"></textarea>
            <span style="font-size:.74rem; color:#9ca3af; display:block; text-align:right; margin-top:.2rem;">
                <span id="char-count">300</span> caracteres restantes
            </span>
        </div>

        {{-- Error / Éxito --}}
        <div id="opinion-msg" style="display:none; border-radius:10px; padding:.75rem 1rem;
                                      font-size:.85rem; font-weight:600; margin-bottom:1rem;"></div>

        {{-- Botón enviar --}}
        <button onclick="enviarOpinion()"
                id="btn-opinion"
                style="width:100%; padding:.9rem; background:linear-gradient(135deg,#00b868,#00DC82);
                       color:#001a1a; border:none; border-radius:12px; font-size:.95rem;
                       font-weight:800; cursor:pointer; transition:opacity .2s; font-family:inherit;">
            Enviar mi opinión
        </button>
    </div>
</div>

<script>
let estrellasSeleccionadas = 0;
const labels = ['','Muy malo 😞','Regular 😐','Bueno 🙂','Muy bueno 😊','Excelente 🤩'];

function abrirOpinion() {
    const ov = document.getElementById('opinion-overlay');
    ov.style.display = 'flex';
    setTimeout(() => ov.style.opacity = 1, 10);
}

function cerrarOpinion() {
    document.getElementById('opinion-overlay').style.display = 'none';
}

function setStar(n) {
    estrellasSeleccionadas = n;
    document.getElementById('estrellas-val').value = n;
    document.getElementById('star-label').textContent = labels[n];
    document.getElementById('star-label').style.color = '#f59e0b';
    pintarEstrellas(n);
}

function hoverStar(n) { pintarEstrellas(n); }
function resetStars()  { pintarEstrellas(estrellasSeleccionadas); }

function pintarEstrellas(n) {
    document.querySelectorAll('.star-svg').forEach((svg, i) => {
        if (i < n) {
            svg.setAttribute('fill', '#f59e0b');
            svg.setAttribute('stroke', '#f59e0b');
        } else {
            svg.setAttribute('fill', 'none');
            svg.setAttribute('stroke', '#d1d5db');
        }
    });
}

function enviarOpinion() {
    const estrellas  = parseInt(document.getElementById('estrellas-val').value);
    const comentario = document.getElementById('opinion-txt').value.trim();
    const msg        = document.getElementById('opinion-msg');
    const btn        = document.getElementById('btn-opinion');

    if (estrellas < 1) {
        mostrarMsg('Por favor selecciona una calificación.', 'error'); return;
    }
    if (comentario.length < 10) {
        mostrarMsg('Tu opinión debe tener al menos 10 caracteres.', 'error'); return;
    }

    btn.disabled = true;
    btn.textContent = 'Enviando...';

    fetch('{{ route("testimonio.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                         || '{{ csrf_token() }}'
        },
        body: JSON.stringify({ estrellas, comentario })
    })
    .then(r => r.json())
    .then(data => {
        if (data.message) {
            mostrarMsg(data.message, 'ok');
            setTimeout(cerrarOpinion, 2500);
        } else {
            mostrarMsg(data.error || 'Error al enviar.', 'error');
        }
    })
    .catch(() => mostrarMsg('Error de conexión. Intenta de nuevo.', 'error'))
    .finally(() => {
        btn.disabled = false;
        btn.textContent = 'Enviar mi opinión';
    });
}

function mostrarMsg(texto, tipo) {
    const msg = document.getElementById('opinion-msg');
    msg.style.display = 'block';
    if (tipo === 'ok') {
        msg.style.background = '#d1fae5';
        msg.style.color = '#065f46';
        msg.style.border = '1px solid #6ee7b7';
    } else {
        msg.style.background = '#fee2e2';
        msg.style.color = '#991b1b';
        msg.style.border = '1px solid #fca5a5';
    }
    msg.textContent = texto;
}

// Cerrar al hacer clic fuera
document.getElementById('opinion-overlay').addEventListener('click', function(e) {
    if (e.target === this) cerrarOpinion();
});
</script>
