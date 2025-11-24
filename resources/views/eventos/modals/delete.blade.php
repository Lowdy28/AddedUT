<div x-show="modalDelete" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="modal-content bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl relative">

        <h2 class="text-2xl font-bold mb-6 text-red-600">Eliminar Taller / Evento</h2>

        <p class="mb-6 text-gray-700">¿Estás seguro que deseas eliminar este taller / evento?</p>

        <div class="flex justify-end gap-4">
            <button type="button" @click="closeAll()"
                    class="px-6 py-2 rounded-lg bg-gray-300 text-black font-semibold hover:bg-gray-400 transition">
                Cancelar
            </button>

            <form :action="`/eventos/${deleteId}`" method="POST" @submit.prevent="submitDelete(deleteId)">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>
