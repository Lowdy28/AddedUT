{{--
    ══════════════════════════════════════════════════════════════
    COMPONENTE: toast-alerts.blade.php
    Incluir en layouts/estudiante.blade.php y layouts/profesor.blade.php
    justo antes del </body>:

        @include('components.toast-alerts')

    Úsalo desde cualquier controller con:
        return redirect()->back()->with('success', 'Mensaje aquí');
        return redirect()->back()->with('error',   'Mensaje aquí');
        return redirect()->back()->with('info',    'Mensaje aquí');
        return redirect()->back()->with('warning', 'Mensaje aquí');
    ══════════════════════════════════════════════════════════════
--}}

<style>
    #toast-container {
        position: fixed;
        top: 1.4rem;
        right: 1.4rem;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .toast {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        background: #fff;
        border-radius: 14px;
        padding: 1rem 1.2rem 1rem 1rem;
        min-width: 300px;
        max-width: 400px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.14), 0 2px 8px rgba(0,0,0,0.08);
        border-left: 4px solid #ccc;
        pointer-events: all;
        animation: toastIn 0.4s cubic-bezier(0.25,0.8,0.25,1) forwards;
        position: relative;
        overflow: hidden;
    }

    @keyframes toastIn {
        from { opacity:0; transform: translateX(60px) scale(0.95); }
        to   { opacity:1; transform: translateX(0)    scale(1); }
    }

    @keyframes toastOut {
        from { opacity:1; transform: translateX(0)    scale(1); max-height: 200px; margin-bottom: 0; }
        to   { opacity:0; transform: translateX(60px) scale(0.95); max-height: 0; padding:0; margin:-5px 0; }
    }

    .toast.saliendo { animation: toastOut 0.35s ease forwards; }

    /* Barra de progreso */
    .toast-progress {
        position: absolute;
        bottom: 0; left: 0;
        height: 3px;
        background: currentColor;
        opacity: 0.3;
        width: 100%;
        transform-origin: left;
        animation: toastProgress 4s linear forwards;
    }
    @keyframes toastProgress {
        from { transform: scaleX(1); }
        to   { transform: scaleX(0); }
    }

    /* Tipos */
    .toast.success { border-left-color: #00A86B; }
    .toast.success .toast-icon { background: #edfbf4; color: #00A86B; }
    .toast.success .toast-progress { color: #00A86B; }

    .toast.error { border-left-color: #e74c3c; }
    .toast.error .toast-icon { background: #fff0ef; color: #e74c3c; }
    .toast.error .toast-progress { color: #e74c3c; }

    .toast.warning { border-left-color: #f39c12; }
    .toast.warning .toast-icon { background: #fff8ec; color: #f39c12; }
    .toast.warning .toast-progress { color: #f39c12; }

    .toast.info { border-left-color: #002D62; }
    .toast.info .toast-icon { background: rgba(0,45,98,0.08); color: #002D62; }
    .toast.info .toast-progress { color: #002D62; }

    .toast-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .toast-icon svg { width: 17px; height: 17px; }

    .toast-body { flex: 1; min-width: 0; }
    .toast-title {
        font-size: 0.88rem;
        font-weight: 800;
        color: #111;
        margin-bottom: 2px;
    }
    .toast-msg {
        font-size: 0.83rem;
        color: #666;
        line-height: 1.4;
        word-break: break-word;
    }

    .toast-close {
        background: none;
        border: none;
        cursor: pointer;
        color: #bbb;
        padding: 0;
        display: flex;
        align-items: center;
        transition: color 0.2s;
        flex-shrink: 0;
        margin-top: -2px;
    }
    .toast-close:hover { color: #555; }
    .toast-close svg { width: 14px; height: 14px; }
</style>

<div id="toast-container"></div>

<script>
(function () {
    const ICONS = {
        success: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>`,
        error:   `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>`,
        warning: `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
        info:    `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>`,
    };
    const TITLES = { success: '¡Éxito!', error: 'Error', warning: 'Advertencia', info: 'Información' };

    window.showToast = function (tipo, mensaje, titulo) {
        const container = document.getElementById('toast-container');
        const t = document.createElement('div');
        t.className = `toast ${tipo}`;
        t.innerHTML = `
            <div class="toast-icon">${ICONS[tipo] || ICONS.info}</div>
            <div class="toast-body">
                <div class="toast-title">${titulo || TITLES[tipo] || 'Aviso'}</div>
                <div class="toast-msg">${mensaje}</div>
            </div>
            <button class="toast-close" onclick="cerrarToast(this.closest('.toast'))">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <div class="toast-progress"></div>
        `;
        container.appendChild(t);

        // Auto-cerrar en 4.5s
        setTimeout(() => cerrarToast(t), 4500);
    };

    window.cerrarToast = function (el) {
        if (!el || el.classList.contains('saliendo')) return;
        el.classList.add('saliendo');
        setTimeout(() => el.remove(), 350);
    };

    // Disparar los mensajes de sesión de Laravel al cargar
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            showToast('success', @json(session('success')));
        @endif
        @if(session('error'))
            showToast('error', @json(session('error')));
        @endif
        @if(session('warning'))
            showToast('warning', @json(session('warning')));
        @endif
        @if(session('info'))
            showToast('info', @json(session('info')));
        @endif
        @if($errors->any())
            showToast('error', @json($errors->first()));
        @endif
    });
})();
</script>
