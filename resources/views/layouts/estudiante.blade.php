<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="Sat, 01 Jan 2000 00:00:00 GMT">
    <title>AddedUT - @yield('title', 'Agenda')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        :root {
            --color-uttec-blue-dark: #002D62;
            --color-uttec-green: #00A86B;
            --color-uttec-white: #FFFFFF;
            --color-text-dark: #2c2c2c;
            --color-text-light: #555555;
            --color-accent-blue: #004C99;
            --color-accent-red: #E74C3C;
            --color-glass-light: rgba(255, 255, 255, 0.9);
            --shadow-card: 0 15px 45px rgba(0, 45, 98, 0.15), 0 0 10px rgba(0, 0, 0, 0.05) inset;
            --color-footer-bg: #F4F6F9;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Inter', sans-serif; background: var(--color-footer-bg); color: var(--color-text-dark); min-height: 100vh; line-height: 1.6; }
        a { text-decoration: none; color: inherit; }
        .feather { width: 20px; height: 20px; stroke-width: 2.5; }
        main { padding-top: 100px; padding-bottom: 5rem; max-width: 1300px; margin: auto; padding-left: 3rem; padding-right: 3rem; min-height: calc(100vh - 80px); }

        header { position: fixed; top:0; left:0; width:100%; background: var(--color-glass-light); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0, 45, 98, 0.1); padding: 0.8rem 3rem; display: flex; justify-content: space-between; align-items: center; z-index: 100; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        header .logo { font-size: 2rem; font-weight: 800; letter-spacing: -1px; color: var(--color-uttec-blue-dark); display: flex; align-items: center; gap: 10px; }
        .logo span { color: var(--color-uttec-green); }
        nav { display: flex; align-items: center; gap: 2rem; }
        nav a, nav button { color: var(--color-uttec-blue-dark); font-weight: 600; padding: 0.5rem 0; position: relative; transition: color 0.3s ease; background: none; border: none; cursor: pointer; font-size: 1rem; display: flex; align-items: center; gap: 6px; }
        nav a::after, nav button::after { content: ''; position: absolute; width: 0; height: 3px; bottom: -5px; left: 50%; transform: translateX(-50%); background: var(--color-uttec-green); transition: width 0.3s ease; }
        nav a:hover, nav button:hover { color: var(--color-uttec-green); }
        nav a:hover::after, nav button:hover::after { width: 100%; }
        .logout-btn { color: var(--color-text-dark) !important; margin-left: 1rem; }
        .logout-btn:hover { color: var(--color-accent-red) !important; }

        /* NOTIF WRAPPER */
        .notif-wrapper { position: relative; display: flex; align-items: center; }
        .notif-badge { position: absolute; top: -4px; right: -4px; background: var(--color-accent-red); color: white; font-size: 10px; width: 18px; height: 18px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid white; }

        /* PANEL ESTILO NETFLIX */
        .notif-panel { position: absolute; top: calc(100% + 14px); right: 0; width: 360px; background: rgba(15, 20, 45, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.12); border-radius: 14px; box-shadow: 0 20px 60px rgba(0,0,0,0.6); display: none; z-index: 1000; overflow: hidden; }
        .notif-panel.active { display: block; }
        .notif-panel-header { padding: 14px 16px 10px; font-weight: 800; font-size: .95rem; color: #fff; border-bottom: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; align-items: center; }
        .notif-list { max-height: 380px; overflow-y: auto; }
        .notif-list::-webkit-scrollbar { width: 4px; }
        .notif-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.15); border-radius: 4px; }
        .notif-row { display: flex; gap: 12px; align-items: flex-start; padding: 12px 16px; border-bottom: 1px solid rgba(255,255,255,0.05); cursor: pointer; transition: background .2s; }
        .notif-row:hover { background: rgba(255,255,255,0.06); }
        .notif-row.unread { background: rgba(0,168,107,0.07); }
        .notif-row.unread:hover { background: rgba(0,168,107,0.12); }
        .notif-row-icon { width: 42px; height: 42px; border-radius: 10px; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.1rem; }
        .notif-row-body { flex: 1; min-width: 0; }
        .notif-row-title { font-size: .83rem; font-weight: 700; color: #fff; margin-bottom: 2px; }
        .notif-row-msg { font-size: .77rem; color: rgba(255,255,255,0.6); line-height: 1.4; }
        .notif-row-time { font-size: .7rem; color: rgba(255,255,255,0.35); margin-top: 4px; }
        .notif-unread-dot { width: 8px; height: 8px; border-radius: 50%; background: #00A86B; flex-shrink: 0; margin-top: 6px; }
        .notif-empty { padding: 30px; text-align: center; color: rgba(255,255,255,0.4); font-size: .85rem; }

        /* CHATBOT */
        .chat-btn { position: fixed; bottom: 30px; left: 30px; z-index: 998; width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #002D62, #004C99); border: none; cursor: pointer; box-shadow: 0 4px 20px rgba(0, 45, 98, 0.5); display: flex; align-items: center; justify-content: center; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .chat-btn:hover { transform: scale(1.1); box-shadow: 0 6px 25px rgba(0, 45, 98, 0.7); }
        .chat-btn svg { width: 26px; height: 26px; color: white; }
        .chat-panel { position: fixed; bottom: 100px; left: 30px; width: 340px; height: 450px; background: white; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.18); border: 1px solid #eee; display: none; z-index: 997; flex-direction: column; overflow: hidden; }
        .chat-panel.active { display: flex; }
        .chat-panel-header { background: linear-gradient(135deg, #002D62, #004C99); padding: 14px 16px; color: white; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; justify-content: space-between; gap: 8px; flex-shrink: 0; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 14px; display: flex; flex-direction: column; gap: 10px; }
        .chat-msg { max-width: 80%; padding: 9px 12px; border-radius: 12px; font-size: 0.82rem; line-height: 1.4; }
        .chat-msg.bot { background: #f0f7f4; border: 1px solid #d4edda; color: #333; align-self: flex-start; border-bottom-left-radius: 4px; }
        .chat-msg.user { background: #002D62; color: white; align-self: flex-end; border-bottom-right-radius: 4px; }
        .chat-msg.typing { background: #f0f7f4; border: 1px solid #d4edda; align-self: flex-start; color: #aaa; font-style: italic; }
        .chat-input-area { padding: 10px; border-top: 1px solid #eee; display: flex; gap: 8px; flex-shrink: 0; }
        .chat-input-area input { flex: 1; border: 1px solid #ddd; border-radius: 20px; padding: 8px 14px; font-size: 0.82rem; outline: none; font-family: 'Inter', sans-serif; }
        .chat-input-area input:focus { border-color: #00A86B; }
        .chat-send-btn { background: #00A86B; border: none; border-radius: 50%; width: 34px; height: 34px; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background 0.2s; }
        .chat-send-btn:hover { background: #008f5b; }
        .chat-send-btn svg { width: 16px; height: 16px; color: white; }

        footer { background: var(--color-uttec-white); color: var(--color-text-light); padding: 3rem 0 1rem 0; border-top: 5px solid var(--color-uttec-blue-dark); box-shadow: 0 -5px 15px rgba(0, 45, 98, 0.05); }
        .footer-content { max-width: 1300px; margin: 0 auto; padding: 0 3rem; display: flex; justify-content: space-between; gap: 4rem; flex-wrap: wrap; }
        .footer-col { flex: 1; min-width: 250px; }
        .footer-col h4 { font-size: 1.2rem; color: var(--color-uttec-blue-dark); margin-bottom: 1.5rem; font-weight: 700; border-bottom: 2px solid var(--color-uttec-green); padding-bottom: 0.5rem; }
        .footer-col a { display: block; margin-bottom: 0.8rem; color: var(--color-text-light); transition: color 0.3s ease; font-weight: 500; }
        .footer-col a:hover { color: var(--color-uttec-green); text-decoration: underline; }
        .footer-bottom { text-align: center; padding: 1rem 0 0 0; margin-top: 2rem; border-top: 1px solid rgba(0, 45, 98, 0.1); font-size: 0.9rem; color: #888; }
        #scrollTopButton { display: none; position: fixed; bottom: 30px; right: 30px; z-index: 99; border: none; background: var(--color-uttec-green); color: white; cursor: pointer; padding: 15px; border-radius: 50%; opacity: 0.9; box-shadow: 0 5px 15px rgba(0, 168, 107, 0.6); }
        #scrollTopButton:hover { opacity: 1; transform: translateY(-2px); background: var(--color-uttec-blue-dark); }
    </style>
</head>
<body>

@php $authUser = App\Models\User::find(auth()->id()); @endphp

@include('estudiante.modals.cuestionario-recomendacion', ['mostrarCuestionario' => $mostrarCuestionario ?? false])

<header>
    <a href="{{ route('estudiante.eventos.index') }}" class="logo">
        <i data-feather="book-open" style="color:var(--color-uttec-green);"></i>
        Added<span>UT</span>
    </a>
    <nav>
        <a href="{{ route('estudiante.eventos.index') }}">
            <i data-feather="calendar" class="feather"></i> Eventos
        </a>
        <a href="{{ route('estudiante.noticias.foro') }}">
            <i data-feather="rss" class="feather"></i> Noticias
        </a>

        <div style="display:flex; align-items:center; gap:20px; border-left:1px solid #ddd; padding-left:20px;">

            <div class="notif-wrapper">
                <button id="layoutNotifBtn" style="background:none; border:none; cursor:pointer; position:relative; display:flex; align-items:center; padding:4px;">
                    <i data-feather="bell" style="color:var(--color-uttec-blue-dark); width:22px; height:22px; stroke-width:2.5;"></i>
                    @if($authUser->unreadNotifications->count() > 0)
                        <span class="notif-badge" id="layoutNotifBadge">{{ $authUser->unreadNotifications->count() }}</span>
                    @endif
                </button>

                <div class="notif-panel" id="layoutNotifDropdown">
                    <div class="notif-panel-header">
                        <span>🔔 Notificaciones</span>
                    </div>
                    <div class="notif-list">
                        @forelse($authUser->unreadNotifications as $notification)
                            @php
                                $tipo  = $notification->data['tipo'] ?? 'info';
                                $url   = $notification->data['url'] ?? '#';
                                $icono = match($tipo) {
                                    'cambio'            => '🕐',
                                    'cupos_disponibles' => '🟢',
                                    'sin_cupos'         => '🔴',
                                    'noticia'           => '📰',
                                    default             => '🔔',
                                };
                            @endphp
                            <div class="notif-row unread notif-link" data-url="{{ $url }}">
                                <div class="notif-row-icon">{{ $icono }}</div>
                                <div class="notif-row-body">
                                    <div class="notif-row-title">{{ $notification->data['titulo'] }}</div>
                                    <div class="notif-row-msg">{{ $notification->data['mensaje'] }}</div>
                                    <div class="notif-row-time">{{ $notification->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="notif-unread-dot"></div>
                            </div>
                        @empty
                            <div class="notif-empty">
                                <div style="font-size:1.5rem; margin-bottom:6px;">🔕</div>
                                Sin notificaciones nuevas
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <a href="{{ $authUser->rol === 'profesor' ? route('profesor.profile.edit') : route('estudiante.profile.edit') }}"
                style="display:flex; align-items:center; gap:8px; font-weight:600; color:var(--color-uttec-blue-dark); font-size:0.95rem;">
                @php
                    $fotoUrl = !empty($authUser->foto)
                        ? asset('storage/' . $authUser->foto)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($authUser->nombre) . '&background=002D62&color=fff&size=64';
                @endphp
                <img src="{{ $fotoUrl }}" alt="Foto" style="width:30px; height:30px; border-radius:50%; object-fit:cover; border:2px solid var(--color-uttec-blue-dark);">
                {{ $authUser->nombre }}
            </a>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="logout-btn">
                <i data-feather="log-out" class="feather"></i> Salir
            </button>
        </form>
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer>
    <div class="footer-content">
        <div class="footer-col">
            <h4>Added<span>UT</span></h4>
            <p>Plataforma para la gestión de actividades extracurriculares en la Universidad Tecnológica de Tecámac (UTTEC).</p>
        </div>
        <div class="footer-col">
            <h4>Enlaces Rápidos</h4>
            <a href="{{ route('estudiante.eventos.index') }}">Eventos y Actividades</a>
            <a href="{{ route('estudiante.noticias.foro') }}">Foro de Noticias</a>
            <a href="{{ route('estudiante.profile.edit') }}">Mi Perfil</a>
        </div>
        <div class="footer-col">
            <h4>Contacto</h4>
            <address>Carretera Federal México-Pachuca km 37.5, Tecámac Edo. Méx.</address>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; {{ date('Y') }} Universidad Tecnológica de Tecámac (UTTEC). Todos los derechos reservados.
    </div>
</footer>

<button onclick="window.scrollTo({top:0, behavior:'smooth'})" id="scrollTopButton">
    <i data-feather="arrow-up"></i>
</button>

<!-- CHATBOT -->
<button class="chat-btn" id="chatBtn" title="Asistente IA">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
    </svg>
</button>

<div class="chat-panel" id="chatPanel">
    <div class="chat-panel-header">
        <span>🤖 Asistente AddedUT</span>
        <button id="chatClose" style="background:none; border:none; color:white; cursor:pointer; font-size:1.2rem; line-height:1;">✕</button>
    </div>
    <div class="chat-messages" id="chatMessages">
        <div class="chat-msg bot">¡Hola! 👋 Soy el asistente de AddedUT. Puedo ayudarte con información sobre talleres, eventos e inscripciones. ¿En qué te puedo ayudar?</div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="chatInput" placeholder="Escribe tu pregunta..." maxlength="500">
        <button class="chat-send-btn" id="chatSend">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </button>
    </div>
</div>

@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();

        window.onscroll = function () {
            document.getElementById("scrollTopButton").style.display =
                (document.documentElement.scrollTop > 100) ? "block" : "none";
        };

        // NOTIFICACIONES
        const btn      = document.getElementById('layoutNotifBtn');
        const dropdown = document.getElementById('layoutNotifDropdown');
        let leidas = false;

        if (btn && dropdown) {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                dropdown.classList.toggle('active');

                if (dropdown.classList.contains('active') && !leidas) {
                    leidas = true;
                    fetch('{{ route("notificaciones.markAllRead") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    }).then(function () {
                        const badge = document.getElementById('layoutNotifBadge');
                        if (badge) badge.remove();
                        document.querySelectorAll('.notif-unread-dot').forEach(d => d.remove());
                        document.querySelectorAll('.notif-row.unread').forEach(r => r.classList.remove('unread'));
                    });
                }
            });

            document.addEventListener('click', function (e) {
                if (!dropdown.contains(e.target) && e.target !== btn) {
                    dropdown.classList.remove('active');
                }
            });
        }

        document.querySelectorAll('.notif-link').forEach(function (item) {
            item.addEventListener('click', function () {
                const url = this.getAttribute('data-url');
                if (!url || url === '#') return;
                window.location.href = url;
            });
        });

        // CHATBOT
        const chatBtn   = document.getElementById('chatBtn');
        const chatPanel = document.getElementById('chatPanel');
        const chatClose = document.getElementById('chatClose');
        const chatInput = document.getElementById('chatInput');
        const chatSend  = document.getElementById('chatSend');
        const chatMsgs  = document.getElementById('chatMessages');

        function agregarMensaje(texto, tipo) {
            const div = document.createElement('div');
            div.classList.add('chat-msg', tipo);
            div.textContent = texto;
            chatMsgs.appendChild(div);
            chatMsgs.scrollTop = chatMsgs.scrollHeight;
            return div;
        }

        function enviarMensaje() {
            const texto = chatInput.value.trim();
            if (!texto) return;
            agregarMensaje(texto, 'user');
            chatInput.value = '';
            const typing = agregarMensaje('Escribiendo...', 'typing');
            fetch('{{ route("estudiante.chatbot") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ mensaje: texto })
            })
            .then(r => r.json())
            .then(function (data) {
                typing.remove();
                agregarMensaje(data.respuesta, 'bot');
            })
            .catch(function () {
                typing.remove();
                agregarMensaje('Error al conectar con el asistente. Intenta de nuevo.', 'bot');
            });
        }

        chatBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            chatPanel.classList.toggle('active');
        });
        chatClose.addEventListener('click', function () { chatPanel.classList.remove('active'); });
        chatSend.addEventListener('click', enviarMensaje);
        chatInput.addEventListener('keypress', function (e) { if (e.key === 'Enter') enviarMensaje(); });
        document.addEventListener('click', function (e) {
            if (!chatPanel.contains(e.target) && e.target !== chatBtn) {
                chatPanel.classList.remove('active');
            }
        });
    });
    window.addEventListener('pageshow', function (e) {
            if (e.persisted || (window.performance && window.performance.getEntriesByType('navigation')[0]?.type === 'back_forward')) {
                window.location.reload();
            }
    });
</script>
</body>
</html>
