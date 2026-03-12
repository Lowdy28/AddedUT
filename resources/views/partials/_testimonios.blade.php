{{--
    Partial: _testimonios.blade.php
    Requiere variable $testimonios (Collection de Testimonio con usuario cargado)
    Uso en welcome: @include('partials._testimonios', ['testimonios' => $testimonios])
    Uso en login:   @include('partials._testimonios', ['testimonios' => $testimonios, 'modo' => 'login'])
--}}
@if($testimonios->isNotEmpty())
@php $modo = $modo ?? 'welcome'; @endphp

@if($modo === 'welcome')
{{-- ══════════════════════════════════════════════════════════
     MODO WELCOME — sección completa con fondo oscuro
══════════════════════════════════════════════════════════ --}}
<section style="background:linear-gradient(135deg,#001020 0%,#001a3d 100%);
                padding:5rem 1.5rem; overflow:hidden;">
    <div style="max-width:1100px; margin:0 auto;">

        {{-- Header --}}
        <div style="text-align:center; margin-bottom:3rem;">
            <span style="display:inline-flex; align-items:center; gap:.5rem;
                         background:rgba(0,220,130,.1); border:1px solid rgba(0,220,130,.2);
                         border-radius:50px; padding:.3rem 1rem; font-size:.72rem;
                         font-weight:800; color:#00DC82; letter-spacing:1.4px;
                         text-transform:uppercase; margin-bottom:1rem;">
                <span style="width:6px;height:6px;border-radius:50%;background:#00DC82;
                              box-shadow:0 0 8px #00DC82;display:inline-block;"></span>
                Lo que dicen nuestros usuarios
            </span>
            <h2 style="font-family:'Plus Jakarta Sans',sans-serif; font-size:clamp(1.8rem,3vw,2.4rem);
                        font-weight:800; color:#F1F5F9; letter-spacing:-.5px; line-height:1.2;">
                Opiniones <span style="background:linear-gradient(90deg,#00DC82,#00ffaa);
                                        -webkit-background-clip:text; -webkit-text-fill-color:transparent;
                                        background-clip:text;">reales</span> de la comunidad UTTEC
            </h2>
        </div>

        {{-- Carrusel --}}
        <div style="position:relative; overflow:hidden;" id="test-wrap">
            <div id="test-track"
                 style="display:flex; gap:1.2rem; transition:transform .5s ease; will-change:transform;">
                @foreach($testimonios as $t)
                <div style="min-width:320px; max-width:320px; background:rgba(255,255,255,.04);
                             border:1px solid rgba(255,255,255,.1); border-radius:18px;
                             padding:1.6rem; flex-shrink:0; position:relative; overflow:hidden;">
                    {{-- Comilla decorativa --}}
                    <span style="position:absolute; top:-8px; left:14px; font-size:4.5rem;
                                  font-family:Georgia,serif; color:rgba(0,220,130,.1);
                                  line-height:1; pointer-events:none;">"</span>

                    {{-- Estrellas --}}
                    <div style="display:flex; gap:3px; margin-bottom:.85rem; position:relative; z-index:1;">
                        @for($i=1; $i<=5; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="{{ $i <= $t->estrellas ? '#f59e0b' : 'none' }}"
                             stroke="{{ $i <= $t->estrellas ? '#f59e0b' : '#4b5563' }}" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                        @endfor
                    </div>

                    {{-- Comentario --}}
                    <p style="font-size:.9rem; color:rgba(241,245,249,.78); line-height:1.7;
                               font-style:italic; margin-bottom:1.1rem; position:relative; z-index:1;">
                        "{{ $t->comentario }}"
                    </p>

                    {{-- Autor --}}
                    <div style="display:flex; align-items:center; gap:.7rem; position:relative; z-index:1;">
                        @if(!empty($t->usuario->foto))
                        <img src="{{ asset('storage/' . $t->usuario->foto) }}"
                             alt="{{ $t->usuario->nombre }}"
                             style="width:34px;height:34px;border-radius:50%;flex-shrink:0;
                                    object-fit:cover;border:2px solid rgba(0,220,130,.3);">
                        @else
                        <div style="width:34px; height:34px; border-radius:50%; flex-shrink:0;
                                     background:linear-gradient(135deg,#002D62,#00b868);
                                     display:flex; align-items:center; justify-content:center;
                                     font-size:.78rem; font-weight:800; color:#fff;">
                            {{ strtoupper(substr($t->usuario->nombre ?? 'U', 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <div style="font-size:.84rem; font-weight:700; color:#F1F5F9;">
                                {{ $t->usuario->nombre ?? '—' }}
                            </div>
                            <div style="font-size:.72rem; color:rgba(241,245,249,.4); text-transform:capitalize;">
                                {{ $t->usuario->rol ?? '' }} · UTTEC
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Controles --}}
        <div style="display:flex; justify-content:center; gap:.75rem; margin-top:1.8rem;">
            <button onclick="moverTest(-1)"
                    style="width:40px; height:40px; border-radius:50%; background:rgba(255,255,255,.07);
                           border:1px solid rgba(255,255,255,.15); color:#F1F5F9; font-size:1rem;
                           cursor:pointer; transition:background .2s;"
                    onmouseover="this.style.background='rgba(0,220,130,.15)'"
                    onmouseout="this.style.background='rgba(255,255,255,.07)'">‹</button>
            <button onclick="moverTest(1)"
                    style="width:40px; height:40px; border-radius:50%; background:rgba(255,255,255,.07);
                           border:1px solid rgba(255,255,255,.15); color:#F1F5F9; font-size:1rem;
                           cursor:pointer; transition:background .2s;"
                    onmouseover="this.style.background='rgba(0,220,130,.15)'"
                    onmouseout="this.style.background='rgba(255,255,255,.07)'">›</button>
        </div>
    </div>
</section>

@else
{{-- ══════════════════════════════════════════════════════════
     MODO LOGIN — testimonio rotatorio en el panel izquierdo
     (reemplaza el .pl-card hardcodeado)
══════════════════════════════════════════════════════════ --}}
<div class="pl-card" id="pl-card-dyn" style="min-height:110px;">
    @foreach($testimonios as $i => $t)
    <div class="test-slide" style="display:{{ $i === 0 ? 'block' : 'none' }}">
        {{-- Estrellas --}}
        <div style="display:flex; gap:2px; margin-bottom:.5rem;">
            @for($s=1; $s<=5; $s++)
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                 fill="{{ $s <= $t->estrellas ? '#f59e0b' : 'none' }}"
                 stroke="{{ $s <= $t->estrellas ? '#f59e0b' : '#4b5563' }}" stroke-width="2">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
            @endfor
        </div>
        <p class="pl-card-text">"{{ Str::limit($t->comentario, 120) }}"</p>
        <div class="pl-card-author">
            @if(!empty($t->usuario->foto))
            <img src="{{ asset('storage/' . $t->usuario->foto) }}"
                 alt="{{ $t->usuario->nombre }}"
                 class="pl-card-av"
                 style="object-fit:cover;border:2px solid rgba(0,220,130,.3);">
            @else
            <div class="pl-card-av">
                {{ strtoupper(substr($t->usuario->nombre ?? 'U', 0, 1)) }}
            </div>
            @endif
            <div>
                <div class="pl-card-name">{{ $t->usuario->nombre ?? '—' }}</div>
                <div class="pl-card-role" style="text-transform:capitalize;">
                    {{ $t->usuario->rol ?? '' }} · UTTEC
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<script>
(function(){
    const slides = document.querySelectorAll('.test-slide');
    if (slides.length <= 1) return;
    let cur = 0;
    setInterval(() => {
        slides[cur].style.display = 'none';
        cur = (cur + 1) % slides.length;
        slides[cur].style.display = 'block';
    }, 5000);
})();
</script>
@endif

<script>
@if($modo === 'welcome')
// Carrusel del welcome
(function(){
    let pos = 0;
    const track = document.getElementById('test-track');
    const cardW = 320 + 19; // ancho + gap
    const total = {{ $testimonios->count() }};
    const visible = Math.floor(document.getElementById('test-wrap').offsetWidth / cardW) || 1;
    const max = Math.max(0, total - visible);

    window.moverTest = function(dir) {
        pos = Math.max(0, Math.min(pos + dir, max));
        track.style.transform = `translateX(-${pos * cardW}px)`;
    };

    // Auto-avance cada 4 segundos
    setInterval(() => {
        pos = pos >= max ? 0 : pos + 1;
        track.style.transform = `translateX(-${pos * cardW}px)`;
    }, 4000);
})();
@endif
</script>
@endif
