@extends('layouts.estudiante')
@section('title', $noticia->titulo)

@section('content')

<style>
    .noticia-detalle-wrap {
        max-width: 860px;
        margin: 0 auto;
    }
    .noticia-detalle-header {
        margin-bottom: 1.5rem;
    }
    .noticia-detalle-header a {
        color: var(--color-uttec-green);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: .95rem;
        text-decoration: none;
    }
    .noticia-detalle-header a:hover { text-decoration: underline; }

    .noticia-card-detail {
        background:#fff;
        border-radius: 20px;
        overflow:hidden;
        box-shadow: 0 12px 40px rgba(0,45,98,0.15);
        margin-bottom: 2.5rem;
    }
    .noticia-cover {
        width:100%; height:320px; object-fit:cover;
        display:block;
    }
    .noticia-cover-placeholder {
        height:200px;
        background: linear-gradient(135deg, var(--color-uttec-blue-dark), var(--color-uttec-green));
        display:flex; align-items:center; justify-content:center;
    }
    .noticia-cover-placeholder svg { width:80px; height:80px; stroke:rgba(255,255,255,0.4); }

    .noticia-content-area { padding: 2rem 2.5rem; }
    .noticia-cat-badge {
        display:inline-block;
        background: var(--color-uttec-blue-dark);
        color:#fff; padding:.3rem .9rem; border-radius:4px;
        font-size:.75rem; font-weight:700; text-transform:uppercase; letter-spacing:.5px;
        margin-bottom:1rem;
    }
    .noticia-titulo {
        font-size:2rem; font-weight:800;
        color: var(--color-uttec-blue-dark); margin-bottom:.8rem; line-height:1.3;
    }
    .noticia-meta-detail {
        font-size:.85rem; color:#888; margin-bottom:1.5rem;
        display:flex; gap:18px; flex-wrap:wrap; align-items:center;
    }
    .noticia-meta-detail svg { width:14px; height:14px; }
    .noticia-cuerpo {
        font-size:1rem; color:#333; line-height:1.75;
        white-space: pre-wrap;
        word-break:break-word;
    }

    /* Acciones */
    .noticia-actions {
        padding: 1.2rem 2.5rem;
        border-top: 1px dashed rgba(0,45,98,0.1);
        display:flex; align-items:center; gap:1.5rem;
    }
    .like-btn-big {
        display:inline-flex; align-items:center; gap:8px;
        background:none; border:2px solid #e0e0e0; border-radius:50px;
        padding:.5rem 1.3rem; cursor:pointer; font-weight:700; font-size:1rem;
        color:#888; transition:all 0.25s;
    }
    .like-btn-big:hover { border-color:#e74c3c; color:#e74c3c; }
    .like-btn-big.liked { border-color:#e74c3c; color:#e74c3c; background:rgba(231,76,60,0.08); }
    .like-btn-big svg { width:20px; height:20px; }

    /* Sección comentarios */
    .comentarios-seccion {
        background:#fff;
        border-radius:20px;
        box-shadow: 0 8px 25px rgba(0,45,98,0.1);
        padding: 2rem 2.5rem;
    }
    .comentarios-seccion h3 {
        font-size:1.4rem; font-weight:800; color: var(--color-uttec-blue-dark);
        margin-bottom:1.5rem; display:flex; align-items:center; gap:10px;
    }

    /* Formulario comentario */
    .comentario-form {
        display:flex; gap:12px; margin-bottom:2rem; align-items:flex-start;
    }
    .avatar-iniciales {
        width:42px; height:42px; border-radius:50%; flex-shrink:0;
        background: var(--color-uttec-blue-dark);
        color:#fff; display:flex; align-items:center; justify-content:center;
        font-weight:700; font-size:1rem;
    }
    .comentario-input {
        flex:1; border:2px solid #e8e8e8; border-radius:12px;
        padding:.8rem 1.1rem; font-family:inherit; font-size:.95rem;
        resize:vertical; min-height:80px; transition:border-color .25s;
        color:#333;
    }
    .comentario-input:focus { outline:none; border-color: var(--color-uttec-green); }
    .enviar-comentario-btn {
        background: var(--color-uttec-green); color:#fff; border:none;
        padding:.7rem 1.3rem; border-radius:10px; font-weight:700; cursor:pointer;
        font-size:.9rem; transition:background .25s; display:flex; align-items:center; gap:6px;
    }
    .enviar-comentario-btn:hover { background: var(--color-uttec-blue-dark); }

    /* Lista de comentarios */
    .comentarios-lista { display:flex; flex-direction:column; gap:1.2rem; }
    .comentario-item {
        display:flex; gap:12px;
    }
    .comentario-burbuja {
        flex:1; background:#f7f8fa; border-radius:12px; padding:1rem 1.2rem;
    }
    .comentario-burbuja .nombre {
        font-weight:700; color: var(--color-uttec-blue-dark); font-size:.9rem; margin-bottom:.3rem;
    }
    .comentario-burbuja .fecha {
        font-size:.75rem; color:#aaa; margin-left:.5rem; font-weight:400;
    }
    .comentario-burbuja .texto { font-size:.95rem; color:#333; line-height:1.5; }
    .comentario-burbuja .eliminar-btn {
        background:none; border:none; color:#ccc; font-size:.8rem; cursor:pointer;
        float:right; margin-top:-1.5rem;
    }
    .comentario-burbuja .eliminar-btn:hover { color:#e74c3c; }

    .empty-comentarios {
        text-align:center; padding:2rem; color:#bbb;
    }
    .empty-comentarios svg { width:40px; height:40px; margin-bottom:.5rem; }
</style>

<div class="noticia-detalle-wrap">

    {{-- Back link --}}
    <div class="noticia-detalle-header">
        <a href="{{ route('estudiante.noticias.foro') }}">
            <i data-feather="arrow-left" class="feather" style="width:16px;height:16px;"></i> Volver al foro
        </a>
    </div>

    {{-- Tarjeta principal --}}
    <div class="noticia-card-detail">
        @if($noticia->imagen)
            <img src="{{ Storage::url($noticia->imagen) }}" alt="{{ $noticia->titulo }}" class="noticia-cover">
        @else
            <div class="noticia-cover-placeholder">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" /></svg>
            </div>
        @endif

        <div class="noticia-content-area">
            <span class="noticia-cat-badge">{{ $noticia->categoria }}</span>
            <h1 class="noticia-titulo">{{ $noticia->titulo }}</h1>
            <div class="noticia-meta-detail">
                <span><i data-feather="user" class="feather"></i> {{ $noticia->autor->nombre ?? 'Admin' }}</span>
                <span><i data-feather="calendar" class="feather"></i> {{ $noticia->created_at->isoFormat('dddd, DD [de] MMMM [de] YYYY') }}</span>
            </div>
            <div class="noticia-cuerpo">{{ $noticia->contenido }}</div>
        </div>

        {{-- Acciones (like) --}}
        <div class="noticia-actions">
            @php $yaLiked = $noticia->likeDelUsuario($userId); @endphp
            <button
                class="like-btn-big {{ $yaLiked ? 'liked' : '' }}"
                id="like-btn-main"
                onclick="toggleLikeDetalle({{ $noticia->id_noticia }})"
            >
                <svg id="heart-icon" xmlns="http://www.w3.org/2000/svg" fill="{{ $yaLiked ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
                Me gusta &nbsp;(<span id="like-count">{{ $noticia->totalLikes() }}</span>)
            </button>

            <span style="color:#aaa; font-size:.9rem; display:flex; align-items:center; gap:6px;">
                <i data-feather="message-circle" class="feather" style="width:18px;height:18px;"></i>
                <span id="comentarios-count">{{ $noticia->comentarios->count() }}</span> comentario(s)
            </span>
        </div>
    </div>

    {{-- Comentarios --}}
    <div class="comentarios-seccion">
        <h3>
            <i data-feather="message-circle" class="feather"></i>
            Comentarios
        </h3>

        {{-- Formulario --}}
        <div class="comentario-form">
            <div class="avatar-iniciales">{{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}</div>
            <div style="flex:1;">
                <textarea class="comentario-input" id="nuevo-comentario" placeholder="Escribe tu comentario aquí..."></textarea>
                <div style="margin-top:.5rem; display:flex; justify-content:flex-end;">
                    <button class="enviar-comentario-btn" onclick="enviarComentario({{ $noticia->id_noticia }})">
                        <i data-feather="send" class="feather" style="width:16px;height:16px;"></i> Publicar
                    </button>
                </div>
            </div>
        </div>

        {{-- Lista --}}
        <div class="comentarios-lista" id="comentarios-lista">
            @forelse($noticia->comentarios as $com)
                <div class="comentario-item" id="com-{{ $com->id_comentario }}">
                    <div class="avatar-iniciales" style="background:var(--color-uttec-green);">
                        {{ strtoupper(substr($com->usuario->nombre ?? 'U', 0, 1)) }}
                    </div>
                    <div class="comentario-burbuja">
                        @if($com->id_usuario === $userId)
                        <button class="eliminar-btn" onclick="eliminarComentario({{ $com->id_comentario }})" title="Eliminar">✕</button>
                        @endif
                        <div class="nombre">
                            {{ $com->usuario->nombre ?? 'Usuario' }}
                            <span class="fecha">{{ $com->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="texto">{{ $com->comentario }}</div>
                    </div>
                </div>
            @empty
                <div class="empty-comentarios" id="empty-msg">
                    <i data-feather="message-square" class="feather"></i>
                    <p>Sé el primero en comentar.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;
const miNombre = "{{ Auth::user()->nombre }}";
const miInicial = "{{ strtoupper(substr(Auth::user()->nombre, 0, 1)) }}";
const miId = {{ Auth::id() }};

function toggleLikeDetalle(noticiaId) {
    fetch(`/estudiante/noticias/${noticiaId}/like`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        const btn = document.getElementById('like-btn-main');
        const icon = document.getElementById('heart-icon');
        document.getElementById('like-count').textContent = data.total;
        if (data.liked) {
            btn.classList.add('liked');
            icon.setAttribute('fill', 'currentColor');
        } else {
            btn.classList.remove('liked');
            icon.setAttribute('fill', 'none');
        }
    });
}

function enviarComentario(noticiaId) {
    const textarea = document.getElementById('nuevo-comentario');
    const texto = textarea.value.trim();
    if (!texto) { textarea.focus(); return; }

    fetch(`/estudiante/noticias/${noticiaId}/comentar`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ comentario: texto })
    })
    .then(r => r.json())
    .then(data => {
        if (data.error) { alert(data.error); return; }

        // Quitar mensaje vacío si existe
        const emptyMsg = document.getElementById('empty-msg');
        if (emptyMsg) emptyMsg.remove();

        const lista = document.getElementById('comentarios-lista');
        const div = document.createElement('div');
        div.className = 'comentario-item';
        div.id = `com-${data.id}`;
        div.innerHTML = `
            <div class="avatar-iniciales" style="background:var(--color-uttec-green);">${miInicial}</div>
            <div class="comentario-burbuja">
                <button class="eliminar-btn" onclick="eliminarComentario(${data.id})" title="Eliminar">✕</button>
                <div class="nombre">${miNombre} <span class="fecha">${data.fecha}</span></div>
                <div class="texto">${escapeHtml(data.texto)}</div>
            </div>
        `;
        lista.appendChild(div);
        textarea.value = '';

        const countEl = document.getElementById('comentarios-count');
        countEl.textContent = parseInt(countEl.textContent) + 1;
    })
    .catch(() => alert('Error al publicar el comentario.'));
}

function eliminarComentario(id) {
    if (!confirm('¿Eliminar este comentario?')) return;
    fetch(`/estudiante/noticias/comentario/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById(`com-${id}`)?.remove();
        const countEl = document.getElementById('comentarios-count');
        const n = parseInt(countEl.textContent) - 1;
        countEl.textContent = Math.max(0, n);
    });
}

function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
</script>
@endsection
