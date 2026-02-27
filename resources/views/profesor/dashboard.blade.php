@extends('layouts.profesor')
@section('title', 'Noticias')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    :root {
        --uttec-blue: #002D62;
        --uttec-green: #00A86B;
        --glass: rgba(255, 255, 255, 0.9);
    }

    .hero-slider {
        width: 100%; height: 420px;
        border-radius: 20px; overflow: hidden;
        margin-bottom: 2.5rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.18);
    }
    .swiper-slide { position: relative; background: #000; }
    .hero-img { width: 100%; height: 100%; object-fit: cover; opacity: 0.6; }
    .hero-content {
        position: absolute; bottom: 0; left: 0;
        padding: 2.5rem; width: 100%;
        background: linear-gradient(transparent, rgba(0,0,0,0.82));
        color: white;
    }
    .hero-content .tag {
        background: var(--uttec-green); padding: 4px 14px;
        border-radius: 50px; font-size: 0.78rem; font-weight: 700;
    }
    .hero-content h2 { font-size: 2.2rem; margin: 8px 0 0; font-weight: 800; line-height: 1.2; }

    .categories-bar {
        display: flex; gap: .75rem; overflow-x: auto;
        padding: 4px 0 1.5rem; scrollbar-width: none;
    }
    .category-bubble {
        padding: 8px 18px; border-radius: 50px; background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06); color: var(--uttec-blue);
        font-weight: 600; white-space: nowrap; transition: .25s;
        border: 1px solid transparent; font-size: .85rem; cursor: pointer;
    }
    .category-bubble:hover, .category-bubble.active {
        background: var(--uttec-blue); color: white; transform: scale(1.05);
    }

    .noticias-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }
    .noticia-card {
        background: white; border-radius: 18px; overflow: hidden;
        transition: all .35s cubic-bezier(.175,.885,.32,1.275);
        position: relative; border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 2px 12px rgba(0,0,0,.05);
    }
    .noticia-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,45,98,.14);
    }
    .img-container { height: 210px; position: relative; overflow: hidden; }
    .img-container img { width: 100%; height: 100%; object-fit: cover; transition: .5s; }
    .noticia-card:hover .img-container img { transform: scale(1.08) rotate(1deg); }

    .quick-actions {
        position: absolute; top: 12px; right: 12px;
        display: flex; flex-direction: column; gap: 7px;
        transform: translateX(55px); transition: .3s;
    }
    .noticia-card:hover .quick-actions { transform: translateX(0); }
    .action-btn {
        width: 38px; height: 38px; border-radius: 50%;
        background: var(--glass); display: flex; align-items: center;
        justify-content: center; backdrop-filter: blur(5px);
        color: var(--uttec-blue); border: none;
        box-shadow: 0 3px 8px rgba(0,0,0,.12); cursor: pointer;
        text-decoration: none;
    }

    .noticia-info { padding: 1.25rem 1.4rem; }
    .noticia-info h3 { font-size: 1.05rem; color: var(--uttec-blue); font-weight: 700; margin-bottom: 7px; line-height: 1.35; }
    .noticia-footer {
        padding: .85rem 1.4rem; background: #f8fafc;
        display: flex; justify-content: space-between; align-items: center;
        border-top: 1px solid #f1f5f9;
    }
    .stats { display: flex; gap: 12px; color: #64748b; font-size: .82rem; }
    .stats span { display: flex; align-items: center; gap: 3px; }
</style>

{{-- CABECERA --}}
<div style="margin-bottom:1.75rem;">
    <h1 style="font-size:1.8rem; font-weight:800; color:#1e3a8a; display:flex; align-items:center; gap:.5rem;">
        <i data-feather="rss" style="width:24px; height:24px; color:#00a86b;"></i>
        Noticias UTTEC
    </h1>
    <p style="color:#6b7280; font-size:.9rem; margin-top:.3rem;">Mantente al tanto de todo lo que pasa en la universidad</p>
</div>

{{-- CARRUSEL HERO --}}
@if($noticias->count())
<div class="swiper hero-slider">
    <div class="swiper-wrapper">
        @foreach($noticias->take(3) as $destacada)
        <div class="swiper-slide">
            @if($destacada->imagen)
                <img src="{{ asset('storage/' . $destacada->imagen) }}" class="hero-img">
            @else
                <div class="hero-img" style="background:linear-gradient(135deg,#1e3a8a,#00a86b);"></div>
            @endif
            <div class="hero-content">
                <span class="tag">{{ $destacada->categoria }}</span>
                <h2>{{ $destacada->titulo }}</h2>
                <a href="{{ route('profesor.noticias.show', $destacada->id_noticia) }}"
                   style="display:inline-block; margin-top:.75rem; padding:.45rem 1.2rem; background:white; color:#1e3a8a; border-radius:50px; font-weight:700; font-size:.85rem; text-decoration:none;">
                    Leer noticia →
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="swiper-pagination"></div>
</div>
@endif

{{-- CATEGORÍAS --}}
<div class="categories-bar">
    <button class="category-bubble active" onclick="filtrarCategoria(this, '')">Todas</button>
    <button class="category-bubble" onclick="filtrarCategoria(this, 'Académico')">Académico</button>
    <button class="category-bubble" onclick="filtrarCategoria(this, 'Deportes')">Deportes</button>
    <button class="category-bubble" onclick="filtrarCategoria(this, 'Eventos')">Eventos</button>
    <button class="category-bubble" onclick="filtrarCategoria(this, 'Cultura')">Cultura</button>
</div>

{{-- GRID DE NOTICIAS --}}
<div class="noticias-grid" id="noticias-grid">
    @forelse($noticias as $noticia)
    @php $yaLiked = $noticia->likeDelUsuario($userId); @endphp

    <div class="noticia-card" data-categoria="{{ $noticia->categoria }}">
        <div class="img-container">
            @if($noticia->imagen)
                <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}">
            @else
                <div style="width:100%; height:100%; background:linear-gradient(135deg,#e2e8f0,#cbd5e1); display:flex; align-items:center; justify-content:center;">
                    <i data-feather="image" style="color:#94a3b8; width:36px; height:36px;"></i>
                </div>
            @endif

            <div class="quick-actions">
                <button class="action-btn" onclick="toggleLike(this, {{ $noticia->id_noticia }})" title="Me gusta">
                    <i data-feather="heart" style="{{ $yaLiked ? 'fill:#ef4444; color:#ef4444;' : '' }} width:16px; height:16px;"></i>
                </button>
                <a href="{{ route('profesor.noticias.show', $noticia->id_noticia) }}" class="action-btn" title="Ver noticia">
                    <i data-feather="message-circle" style="width:16px; height:16px;"></i>
                </a>
            </div>
        </div>

        <div class="noticia-info">
            <small style="color:#00a86b; font-weight:700; font-size:.75rem; text-transform:uppercase; letter-spacing:.04em;">
                {{ $noticia->categoria }}
            </small>
            <h3>{{ $noticia->titulo }}</h3>
            <p style="color:#6b7280; font-size:.85rem; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">
                {{ Str::limit(strip_tags($noticia->contenido), 100) }}
            </p>
        </div>

        <div class="noticia-footer">
            <div class="stats">
                <span><i data-feather="heart" style="width:13px; height:13px;"></i> {{ $noticia->totalLikes() }}</span>
                <span><i data-feather="message-square" style="width:13px; height:13px;"></i> {{ $noticia->comentarios->count() }}</span>
            </div>
            <a href="{{ route('profesor.noticias.show', $noticia->id_noticia) }}"
               style="color:#1e3a8a; font-weight:700; font-size:.82rem; display:flex; align-items:center; gap:3px; text-decoration:none;">
                Ver más <i data-feather="chevron-right" style="width:14px; height:14px;"></i>
            </a>
        </div>
    </div>

    @empty
        <div style="grid-column:1/-1; text-align:center; padding:3rem; background:white; border-radius:16px;">
            <i data-feather="inbox" style="width:40px; height:40px; color:#94a3b8; display:block; margin:0 auto 1rem;"></i>
            <p style="color:#6b7280;">No hay noticias publicadas por el momento.</p>
        </div>
    @endforelse
</div>

{{-- Paginación --}}
<div style="margin-top:2rem;">
    {{ $noticias->links() }}
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    new Swiper('.hero-slider', {
        loop: true,
        autoplay: { delay: 5000 },
        pagination: { el: '.swiper-pagination', clickable: true },
        effect: 'fade',
        fadeEffect: { crossFade: true }
    });
    feather.replace();
});

function filtrarCategoria(btn, categoria) {
    document.querySelectorAll('.category-bubble').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.noticia-card').forEach(card => {
        const mostrar = !categoria || card.dataset.categoria === categoria;
        card.style.display = mostrar ? '' : 'none';
    });
}

function toggleLike(btn, noticiaId) {
    fetch(`/profesor/noticias/${noticiaId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        const icon = btn.querySelector('svg');
        if (data.liked) {
            icon.style.fill = '#ef4444';
            icon.style.color = '#ef4444';
            btn.style.transform = 'scale(1.3)';
            setTimeout(() => btn.style.transform = 'scale(1)', 200);
        } else {
            icon.style.fill = '';
            icon.style.color = '';
        }
    });
}
</script>

@endsection