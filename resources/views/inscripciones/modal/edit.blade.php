<div x-show="modalEdit" 
     x-cloak
     @click.self="closeAll()"
     class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <div class="bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl"
         style="color:#111 !important;"
         @click.stop>

        <h2 class="text-3xl font-extrabold mb-6" style="color:#004aad !important;">
            Editar Inscripción
        </h2>

        <form method="POST" 
              :action="`/inscripciones/${editData.id_inscripcion}`">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block font-semibold mb-2">Estado</label>
                <select name="estado"
                        x-model="editData.estado"
                        required
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:outline-none">
                    <option value="confirmada">Confirmada</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" 
                        @click="closeAll()"
                        class="px-6 py-3 rounded-lg bg-gray-400 text-white font-semibold shadow-lg hover:bg-gray-500 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-3 rounded-lg bg-green-600 text-white font-semibold shadow-lg hover:bg-green-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>