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

        <form id="form-edit" enctype="multipart/form-data">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                <input type="text" x-model="editData.nombre" name="nombre" required
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Descripción</label>
                <textarea rows="3" x-model="editData.descripcion" name="descripcion"
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            </div>

            {{-- Categoría + Cupos --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Categoría <span class="text-red-500">*</span></label>
                    <select x-model="editData.categoria" name="categoria" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="General">General</option>
                        <option value="Académico">Académico</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Deportivo">Deportivo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cupos totales <span class="text-red-500">*</span></label>
                    <input type="number" x-model="editData.cupos" name="cupos" required min="1"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- Fechas --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha inicio <span class="text-red-500">*</span></label>
                    <input type="date" x-model="editData.fecha_inicio" name="fecha_inicio" required
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Fecha fin <span class="text-red-500">*</span></label>
                    <input type="date" x-model="editData.fecha_fin" name="fecha_fin" required
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- Lugar --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Lugar / Instalación</label>
                <input type="text" x-model="editData.lugar" name="lugar"
                       placeholder="Ej. Cancha principal, Aula 3B..."
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            {{-- Horario + Días --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Horario</label>
                    <input type="text" x-model="editData.horario" name="horario"
                           placeholder="Ej. 14:00 – 16:00 hrs"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Días</label>
                    <input type="text" x-model="editData.dias" name="dias"
                           placeholder="Ej. Lunes y Miércoles"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- ── IMAGEN ── --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto del taller</label>

                {{-- Preview imagen actual --}}
                <div id="editImgPreviewWrap" class="mb-3 rounded-xl overflow-hidden border border-gray-200" style="display:none;">
                    <img id="editImgPreview" src="" alt="Preview"
                         class="w-full object-cover" style="max-height:180px;">
                </div>

                <label for="editImgInput"
                       class="flex flex-col items-center justify-content gap-2 w-full px-4 py-5 rounded-xl border-2 border-dashed border-gray-300 cursor-pointer text-gray-500 text-sm font-semibold hover:border-blue-400 hover:bg-blue-50 transition"
                       style="text-align:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-1" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span id="editImgLabel">Haz clic para cambiar la imagen (jpg, png, webp · máx 3 MB)</span>
                    <span class="text-xs text-gray-400 font-normal">Si no seleccionas una nueva imagen, se conserva la actual</span>
                </label>
                <input id="editImgInput" type="file" name="imagen" accept="image/jpeg,image/png,image/webp"
                       class="hidden"
                       onchange="
                           const f = this.files[0];
                           if (f) {
                               document.getElementById('editImgLabel').textContent = f.name;
                               const reader = new FileReader();
                               reader.onload = e => {
                                   document.getElementById('editImgPreview').src = e.target.result;
                                   document.getElementById('editImgPreviewWrap').style.display = 'block';
                               };
                               reader.readAsDataURL(f);
                           }
                       ">
            </div>

            <div class="flex justify-end gap-4 mt-2">
                <button type="button" @click="closeAll()"
                        class="px-6 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
                    Cancelar
                </button>
                <button type="button" @click="submitEdit($event, editData.id_evento)"
                        class="px-6 py-2 rounded-lg text-white font-semibold transition"
                        style="background-color:#00a86b !important;">
                    💾 Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.effect(() => {
    });
});

window.mostrarImagenActual = function(imagenUrl) {
    if (imagenUrl) {
        document.getElementById('editImgPreview').src = imagenUrl;
        document.getElementById('editImgPreviewWrap').style.display = 'block';
        document.getElementById('editImgLabel').textContent = 'Imagen actual (haz clic para cambiarla)';
    } else {
        document.getElementById('editImgPreviewWrap').style.display = 'none';
        document.getElementById('editImgLabel').textContent = 'Haz clic para subir una imagen';
    }
    // Limpiar el input file
    document.getElementById('editImgInput').value = '';
};
</script>
