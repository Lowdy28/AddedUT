<div x-show="modalEdit" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="modal-content bg-white rounded-2xl p-8 max-w-2xl w-full shadow-2xl relative overflow-y-auto max-h-[90vh]">

        <h2 class="text-2xl font-extrabold mb-6" style="color:#004aad !important;">
            ✏️ Editar Taller / Evento
        </h2>

        <form @submit.prevent="submitEdit($event, editData.id_evento)">
            @csrf
            @method('PUT')

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                <input type="text" x-model="editData.nombre" required
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                <textarea rows="3" x-model="editData.descripcion"
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            </div>

            {{-- Categoría + Cupos --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Categoría <span class="text-red-500">*</span></label>
                    <select x-model="editData.categoria" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="General">General</option>
                        <option value="Académico">Académico</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Deportivo">Deportivo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cupos totales <span class="text-red-500">*</span></label>
                    <input type="number" x-model="editData.cupos" required min="1"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- Fechas --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha inicio <span class="text-red-500">*</span></label>
                    <input type="date" x-model="editData.fecha_inicio" required
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha fin <span class="text-red-500">*</span></label>
                    <input type="date" x-model="editData.fecha_fin" required
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- Lugar --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Lugar / Instalación</label>
                <input type="text" x-model="editData.lugar"
                       placeholder="Ej. Cancha principal, Aula 3B..."
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            {{-- Horario + Días --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Horario</label>
                    <input type="text" x-model="editData.horario"
                           placeholder="Ej. 14:00 – 16:00 hrs"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Días</label>
                    <input type="text" x-model="editData.dias"
                           placeholder="Ej. Lunes y Miércoles"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <button type="button" @click="closeAll()"
                        class="px-6 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-2 rounded-lg text-white font-semibold transition"
                        style="background-color:#00a86b !important;">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
