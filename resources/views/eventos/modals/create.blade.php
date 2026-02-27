<div x-show="modalCreate" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="modal-content bg-white rounded-2xl shadow-2xl relative overflow-y-auto"
         style="max-width:680px; width:95%; max-height:92vh; padding:2rem; color:#111;">

        <h2 class="text-2xl font-extrabold mb-5" style="color:#004aad;">
            Nuevo Taller / Evento
        </h2>

        <form id="form-create" @submit.prevent="submitCreate($event)" enctype="multipart/form-data">
            @csrf

            {{-- Nombre --}}
            <div class="mb-4">
                <label class="form-label">Nombre del taller <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nombre" x-model="createData.nombre" required
                       placeholder="Nombre del taller o evento"
                       class="form-input" />
            </div>

            {{-- Descripcion --}}
            <div class="mb-4">
                <label class="form-label">Descripcion</label>
                <textarea name="descripcion" rows="3" x-model="createData.descripcion"
                          placeholder="Describe brevemente el taller o evento"
                          class="form-input" style="resize:vertical;"></textarea>
            </div>

            {{-- Imagen --}}
            <div class="mb-4">
                <label class="form-label">Imagen del taller</label>
                <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
                    <div id="preview-create"
                         style="width:96px; height:72px; border-radius:.6rem; overflow:hidden;
                                border:1.5px solid #d1d5db; background:#f3f4f6; flex-shrink:0;">
                        <img id="preview-create-img" src="{{ asset('imagenes/uttec.jpeg') }}"
                             alt="Preview" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div style="flex:1;">
                        <input type="file" name="imagen" id="imagen_create"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="form-input" style="padding:.45rem .7rem; cursor:pointer;"
                               onchange="previewImagen(this, 'preview-create-img')" />
                        <p style="font-size:.75rem; color:#6b7280; margin-top:.3rem;">
                            JPG, PNG o WEBP. Maximo 3 MB.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Categoria + Cupos --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="mb-4">
                <div>
                    <label class="form-label">Categoria <span style="color:#ef4444;">*</span></label>
                    <select name="categoria" x-model="createData.categoria" required class="form-input">
                        <option value="General">General</option>
                        <option value="Academico">Academico</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Deportivo">Deportivo</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Cupos totales <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="cupos" x-model="createData.cupos"
                           required min="1" placeholder="30" class="form-input" />
                </div>
            </div>

            {{-- Fechas --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="mb-4">
                <div>
                    <label class="form-label">Fecha inicio <span style="color:#ef4444;">*</span></label>
                    <input type="date" name="fecha_inicio" x-model="createData.fecha_inicio"
                           required class="form-input" />
                </div>
                <div>
                    <label class="form-label">Fecha fin <span style="color:#ef4444;">*</span></label>
                    <input type="date" name="fecha_fin" x-model="createData.fecha_fin"
                           required class="form-input" />
                </div>
            </div>

            {{-- Lugar --}}
            <div class="mb-4">
                <label class="form-label">Lugar / Instalacion</label>
                <input type="text" name="lugar" x-model="createData.lugar"
                       placeholder="Cancha principal, Aula 3B, Gimnasio..." class="form-input" />
            </div>

            {{-- Horario + Dias --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;" class="mb-5">
                <div>
                    <label class="form-label">Horario</label>
                    <input type="text" name="horario" x-model="createData.horario"
                           placeholder="14:00 - 16:00 hrs" class="form-input" />
                </div>
                <div>
                    <label class="form-label">Dias</label>
                    <input type="text" name="dias" x-model="createData.dias"
                           placeholder="Lunes y Miercoles" class="form-input" />
                </div>
            </div>

            <div style="display:flex; justify-content:flex-end; gap:.75rem;
                        padding-top:1rem; border-top:1px solid #e5e7eb;">
                <button type="button" @click="closeAll()"
                        style="padding:.6rem 1.4rem; border-radius:.75rem; background:#f3f4f6;
                               color:#374151; font-weight:700; border:none; cursor:pointer;">
                    Cancelar
                </button>
                <button type="submit"
                        style="padding:.6rem 1.6rem; border-radius:.75rem; background:#004aad;
                               color:#fff; font-weight:700; border:none; cursor:pointer;">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
