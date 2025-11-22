<div x-show="modalDelete" 
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="modal-content bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl relative"
         style="color:#111 !important;">

        <h2 class="text-2xl font-bold mb-6" style="color:#dc2626 !important;">Eliminar Usuario</h2>

        <p class="mb-6 text-gray-700" style="color:#111 !important;">¿Estás seguro que deseas eliminar este usuario?</p>

        <div class="flex justify-end gap-4">
            <button type="button" @click="closeAll()"
                    class="px-6 py-2 rounded-lg bg-gray-300 text-black font-semibold shadow hover:bg-gray-400 transition"
                    style="color:black !important;">
                Cancelar
            </button>
            <form :action="'/usuarios/' + deleteId" method="POST">
                @csrf
                @method('DELETE')
                <button 
                    @click="openDelete({{ $u->id_usuario }})"
                    class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">
                    Eliminar
                </button>
            </form>
        </div>
    </div>

    <style>
    @keyframes slideDownBounce {
        0%   { transform: translateY(-50px) scale(0.95); opacity: 0; }
        60%  { transform: translateY(10px) scale(1.02); opacity: 1; }
        80%  { transform: translateY(-5px) scale(0.99); }
        100% { transform: translateY(0) scale(1); }
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-content {
        background: #fff;
        border-radius: 1.5rem;
        padding: 2rem;
        max-width: 450px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0,0,0,0.35);
        color: #111 !important;
        animation: slideDownBounce 0.5s ease forwards;
    }
    </style>
</div>
