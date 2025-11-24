<div x-show="modalEdit" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="modal-content bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl relative">

        <h2 class="text-3xl font-extrabold mb-6" style="color:#004aad !important;">Editar Taller / Evento</h2>

        <form @submit.prevent="submitEdit($event, editData.id_evento)">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nombre_edit" class="font-semibold text-gray-900">Nombre</label>
                <input type="text" id="nombre_edit" x-model="editData.nombre" required
                       placeholder="Nombre del taller o evento"
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm text-gray-900" />
            </div>

            <div class="mb-4">
                <label for="descripcion_edit" class="font-semibold text-gray-900">Descripción</label>
                <textarea id="descripcion_edit" rows="3"
                          x-model="editData.descripcion"
                          placeholder="Descripción del taller o evento (opcional)"
                          class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm text-gray-900"></textarea>
            </div>

            <div class="mb-4">
                <label for="categoria_edit" class="font-semibold text-gray-900">Categoría</label>
                <select id="categoria_edit" x-model="editData.categoria" required
                        class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm text-gray-900">
                    <option value="General">General</option>
                    <option value="Académico">Académico</option>
                    <option value="Cultural">Cultural</option>
                    <option value="Deportivo">Deportivo</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="cupos_edit" class="font-semibold text-gray-900">Cupos</label>
                <input type="number" id="cupos_edit" x-model="editData.cupos" required min="1"
                       placeholder="Cantidad de cupos"
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm text-gray-900" />
            </div>

            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="fecha_inicio_edit" class="font-semibold text-gray-900">Fecha de Inicio</label>
                    <input type="date" id="fecha_inicio_edit" x-model="editData.fecha_inicio" required
                           class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm text-gray-900" />
                </div>

                <div>
                    <label for="fecha_fin_edit" class="font-semibold text-gray-900">Fecha de Fin</label>
                    <input type="date" id="fecha_fin_edit" x-model="editData.fecha_fin" required
                           class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm text-gray-900" />
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <button type="button" @click="closeAll()"
                        class="px-6 py-2 rounded-lg bg-red-500 text-white font-semibold hover:bg-red-600 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-green-500 text-white font-semibold hover:bg-green-600 transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
