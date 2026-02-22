@extends('layouts.estudiante')
@section('title', 'Foro de Noticias')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    :root {
        --uttec-blue: #002D62;
        --uttec-green: #00A86B;
        --uttec-gold: #FFD700;
        --glass: rgba(255, 255, 255, 0.9);
    }

    /* ── Carrusel Principal (Hero) ── */
    .hero-slider {
        width: 100%;
        height: 450px;
        border-radius: 24px;
        overflow: hidden;
        margin-bottom: 3rem;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .swiper-slide {
        position: relative;
        background: #000;
    }
    .hero-img {
        width: 100%; height: 100%; object-fit: cover;
        opacity: 0.6;
    }
    .hero-content {
        position: absolute; bottom: 0; left: 0; padding: 3rem;
        width: 100%; background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
    }
    .hero-content .tag {
        background: var(--uttec-green); padding: 5px 15px;
        border-radius: 50px; font-size: 0.8rem; font-weight: bold;
    }
    .hero-content h2 { font-size: 2.5rem; margin: 10px 0; font-weight: 800; }

    /* ── Sección de Categorías (Bubbles) ── */
    .categories-bar {
        display: flex; gap: 1rem; overflow-x: auto; padding: 10px 0 30px;
        scrollbar-width: none;
    }
    .category-bubble {
        padding: 10px 20px; border-radius: 50px; background: white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); color: var(--uttec-blue);
        font-weight: 600; white-space: nowrap; transition: 0.3s;
        border: 1px solid transparent;
    }
    .category-bubble:hover, .category-bubble.active {
        background: var(--uttec-blue); color: white; transform: scale(1.05);
    }

    /* ── Grid Estilo "Pinterest / Social" ── */
    .noticias-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2.5rem;
    }
    .noticia-card {
        background: white; border-radius: 20px; overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative; border: 1px solid rgba(0,0,0,0.05);
    }
    .noticia-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px rgba(0,45,98,0.15);
    }
    .img-container {
        height: 220px; position: relative; overflow: hidden;
    }
    .img-container img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
    .noticia-card:hover .img-container img { transform: scale(1.1) rotate(2deg); }

    /* Overlay de interacción rápida */
    .quick-actions {
        position: absolute; top: 15px; right: 15px; display: flex; flex-direction: column; gap: 8px;
        transform: translateX(60px); transition: 0.3s;
    }
    .noticia-card:hover .quick-actions { transform: translateX(0); }
    .action-btn {
        width: 40px; height: 40px; border-radius: 50%; background: var(--glass);
        display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px);
        color: var(--uttec-blue); border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .noticia-info { padding: 1.5rem; }
    .noticia-info h3 { font-size: 1.2rem; color: var(--uttec-blue); font-weight: 700; margin-bottom: 10px; }
    
    /* Footer interactivo */
    .noticia-footer {
        padding: 1rem 1.5rem; background: #f8fafc;
        display: flex; justify-content: space-between; align-items: center;
    }
    .stats { display: flex; gap: 15px; color: #64748b; font-size: 0.85rem; }
    .stats span { display: flex; align-items: center; gap: 4px; }

    /* Estilo para San Valentín o Eventos Especiales */
    .card-special { border: 2px solid #ff4d6d !important; }
    .card-special::before {
        content: "❤️ Especial"; position: absolute; top: 10px; left: 10px; z-index: 10;
        background: #ff4d6d; color: white; padding: 4px 12px; border-radius: 50px; font-size: 0.7rem;
    }
</style>

<div class="foro-container">
    {{-- 1. CARRUSEL DE DESTACADOS (Las últimas 3 noticias) --}}
    <div class="swiper hero-slider">
        <div class="swiper-wrapper">
            @foreach($noticias->take(3) as $destacada)
            <div class="swiper-slide">
                @if($destacada->imagen)
                    <img src="{{ asset('storage/' . $destacada->imagen) }}" class="hero-img">
                @else
                    <div class="hero-img" style="background: var(--uttec-blue);"></div>
                @endif
                <div class="hero-content">
                    <span class="tag">{{ $destacada->categoria }}</span>
                    <h2>{{ $destacada->titulo }}</h2>
                    <a href="{{ route('estudiante.noticias.show', $destacada->id_noticia) }}" class="category-bubble active">Leer Noticia</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    {{-- 2. BARRA DE CATEGORÍAS --}}
    <div class="categories-bar">
        <button class="category-bubble active">Todas</button>
        <button class="category-bubble">Académico</button>
        <button class="category-bubble">Deportes</button>
        <button class="category-bubble">Eventos</button>
        <button class="category-bubble">Cultura</button>
    </div>

    {{-- 3. GRID DE NOTICIAS --}}
    <div class="noticias-grid">
        @forelse($noticias as $noticia)
        @php
            $yaLiked = $noticia->likeDelUsuario($userId);
            // Detección de San Valentín o eventos especiales por categoría o palabras clave
            $esEspecial = Str::contains(Str::lower($noticia->titulo), ['san valentin', 'amor', 'amistad', 'corre']);
        @endphp

        <div class="noticia-card {{ $esEspecial ? 'card-special' : '' }}">
            <div class="img-container">
                @if($noticia->imagen)
                    <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}">
                @else
                    <div style="width:100%; height:100%; background:#e2e8f0; display:flex; align-items:center; justify-content:center;">
                        <i data-feather="image" class="text-gray-400"></i>
                    </div>
                @endif
                
                <div class="quick-actions">
                    <button class="action-btn" onclick="toggleLike(this, {{ $noticia->id_noticia }})" title="Me gusta">
                        <i data-feather="heart" class="{{ $yaLiked ? 'fill-current text-red-500' : '' }}"></i>
                    </button>
                    <a href="{{ route('estudiante.noticias.show', $noticia->id_noticia) }}" class="action-btn" title="Comentar">
                        <i data-feather="message-circle"></i>
                    </a>
                </div>
            </div>

            <div class="noticia-info">
                <small class="text-green-600 font-bold uppercase">{{ $noticia->categoria }}</small>
                <h3>{{ $noticia->titulo }}</h3>
                <p class="text-gray-500 text-sm line-clamp-2">
                    {{ Str::limit(strip_tags($noticia->contenido), 100) }}
                </p>
            </div>

            <div class="noticia-footer">
                <div class="stats">
                    <span><i data-feather="heart" style="width:14px"></i> {{ $noticia->totalLikes() }}</span>
                    <span><i data-feather="message-square" style="width:14px"></i> {{ $noticia->comentarios->count() }}</span>
                </div>
                <a href="{{ route('estudiante.noticias.show', $noticia->id_noticia) }}" class="text-blue-900 font-bold text-sm flex items-center gap-1">
                    Ver más <i data-feather="chevron-right" style="width:16px"></i>
                </a>
            </div>
        </div>
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-400">No hay noticias por el momento.</p>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Inicializar Carrusel
        const swiper = new Swiper('.hero-slider', {
            loop: true,
            autoplay: { delay: 5000 },
            pagination: { el: '.swiper-pagination', clickable: true },
            effect: 'fade',
            fadeEffect: { crossFade: true }
        });

        feather.replace();
    });

    function toggleLike(btn, noticiaId) {
        fetch(`/estudiante/noticias/${noticiaId}/like`, {
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
                icon.classList.add('fill-current', 'text-red-500');
                btn.style.transform = 'scale(1.3)';
                setTimeout(() => btn.style.transform = 'scale(1)', 200);
            } else {
                icon.classList.remove('fill-current', 'text-red-500');
            }
        });
    }
</script>
@endsection
