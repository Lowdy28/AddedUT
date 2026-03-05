<style>
    /* Forzar labels visibles dentro del modal de crear taller */
    #modal-create-taller label {
        color: #374151 !important;
        font-weight: 600 !important;
    }
    #modal-create-taller input,
    #modal-create-taller textarea,
    #modal-create-taller select {
        color: #111 !important;
        background: #f8fafc !important;
    }
</style>
<div id="modal-create-taller" x-show="modalCreate" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-content z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="bg-white rounded-2xl shadow-2xl relative overflow-hidden"
         style="max-width:700px; width:95%; max-height:92vh; overflow-y:auto; color:#111;">

        {{-- Header azul --}}
        <div style="background: linear-gradient(135deg, #002D62, #004aad); padding: 1.5rem 2rem; position:relative;">
            <button @click="closeAll()"
                    style="position:absolute; top:1rem; right:1rem; background:rgba(255,255,255,0.2);
                           border:none; border-radius:50%; width:36px; height:36px; cursor:pointer;
                           color:white; font-size:1.1rem; display:flex; align-items:center; justify-content:center;">
                ✕
            </button>
            <h2 class="text-2xl font-extrabold text-white">✦ Nuevo Taller</h2>
            <p style="color:rgba(255,255,255,0.7); font-size:.85rem; margin:.3rem 0 0;">
                Completa los datos para crear y asignar el taller
            </p>
        </div>

        {{-- Formulario --}}
        <form id="form-create" @submit.prevent="submitCreate($event)" enctype="multipart/form-data"
              class="p-8">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">
                    Nombre del taller <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nombre" x-model="createData.nombre" required
                       placeholder="Ej. Taller de Voleibol"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            {{-- Descripción --}}
            <div class="mb-4">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">Descripción</label>
                <textarea name="descripcion" rows="3" x-model="createData.descripcion"
                          placeholder="Describe brevemente el taller..."
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
            </div>

            {{-- Categoría + Cupos --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">
                        Categoría <span class="text-red-500">*</span>
                    </label>
                    <select name="categoria" x-model="createData.categoria" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="General">General</option>
                        <option value="Academico">Académico</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Deportivo">Deportivo</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">
                        Cupos totales <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="cupos" x-model="createData.cupos"
                           required min="1" placeholder="30"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- Asignar Profesor --}}
            <div class="mb-4">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">
                    Asignar Profesor <span class="text-red-500">*</span>
                </label>
                @if(isset($profesoresDisponibles) && $profesoresDisponibles->count() > 0)
                    <select name="id_profesor" x-model="createData.id_profesor" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="">— Selecciona un profesor disponible —</option>
                        @foreach($profesoresDisponibles as $prof)
                            <option value="{{ $prof->id_usuario }}">
                                {{ $prof->nombre }} · {{ $prof->email }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        ✅ {{ $profesoresDisponibles->count() }} profesor(es) disponible(s) sin taller asignado
                    </p>
                @else
                    <div class="px-4 py-3 rounded-lg text-sm font-semibold"
                         style="background:#fef9ec; border:1.5px solid #f59e0b; color:#92400e;">
                        ⚠️ Todos los profesores ya tienen un taller asignado. Registra un nuevo profesor primero.
                    </div>
                    <input type="hidden" name="id_profesor" value="" />
                @endif
            </div>

            <hr class="border-dashed border-gray-200 my-5">

            {{-- Fechas --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">
                        Fecha inicio <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="fecha_inicio" x-model="createData.fecha_inicio" required
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">
                        Fecha fin <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="fecha_fin" x-model="createData.fecha_fin" required
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- Lugar --}}
            <div class="mb-4">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">Lugar / Instalación</label>
                <input type="text" name="lugar" x-model="createData.lugar"
                       placeholder="Ej. Cancha principal, Aula 3B, Gimnasio..."
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
            </div>

            {{-- Horario + Días --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">Horario</label>
                    <input type="text" name="horario" x-model="createData.horario"
                           placeholder="Ej. 14:00 – 16:00 hrs"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.25rem;">Días</label>
                    <input type="text" name="dias" x-model="createData.dias"
                           placeholder="Ej. Lunes y Miércoles"
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 shadow-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            {{-- ── FOTO DEL TALLER ── --}}
            <div class="mb-6">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#374151 !important; margin-bottom:.5rem;">Foto del taller</label>

                {{-- Preview --}}
                <div id="createImgPreviewWrap" class="mb-3 rounded-xl overflow-hidden border border-gray-200" style="display:none;">
                    <img id="createImgPreview" src="" alt="Preview"
                         class="w-full object-cover" style="max-height:200px;">
                </div>

                {{-- Zona de upload estilizada --}}
                <label for="createImgInput"
                       class="flex flex-col items-center justify-center gap-2 w-full px-4 py-6 rounded-xl border-2 border-dashed border-gray-300 cursor-pointer text-gray-500 text-sm font-semibold hover:border-blue-400 hover:bg-blue-50 transition"
                       style="text-align:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    <span id="createImgLabel">Haz clic para subir una imagen (jpg, png, webp · máx 3 MB)</span>
                    <span class="text-xs text-gray-400 font-normal">Opcional — si no subes imagen se usará una por defecto</span>
                </label>
                <input id="createImgInput" type="file" name="imagen"
                       accept="image/jpeg,image/png,image/webp"
                       class="hidden"
                       onchange="
                           const f = this.files[0];
                           if (f) {
                               document.getElementById('createImgLabel').textContent = f.name;
                               const reader = new FileReader();
                               reader.onload = e => {
                                   document.getElementById('createImgPreview').src = e.target.result;
                                   document.getElementById('createImgPreviewWrap').style.display = 'block';
                               };
                               reader.readAsDataURL(f);
                           }
                       ">
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-4 pt-2 border-t border-gray-100">
                <button type="button" @click="closeAll()"
                        class="px-6 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-2 rounded-lg text-white font-semibold transition"
                        style="background: linear-gradient(135deg, #004aad, #0066cc); box-shadow: 0 4px 14px rgba(0,74,173,0.35);">
                    💾 Guardar Taller
                </button>
            </div>
        </form>
    </div>
</div>
