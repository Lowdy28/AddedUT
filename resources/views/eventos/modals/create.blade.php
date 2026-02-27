<div x-show="modalCreate" x-cloak
     class="modal-overlay"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div style="
        background: #ffffff;
        border-radius: 1.25rem;
        width: 95%;
        max-width: 700px;
        max-height: 92vh;
        overflow-y: auto;
        box-shadow: 0 25px 60px rgba(0,0,0,0.45);
        animation: scaleIn .18s ease-out;
        color: #111;
    ">

        {{-- ── HEADER con degradado azul ── --}}
        <div style="
            background: linear-gradient(135deg, #002D62, #004aad);
            border-radius: 1.25rem 1.25rem 0 0;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        ">
            <div>
                <h2 style="color:#fff; font-size:1.5rem; font-weight:800; margin:0;">
                    ✦ Nuevo Taller
                </h2>
                <p style="color:rgba(255,255,255,0.7); font-size:.85rem; margin:.3rem 0 0;">
                    Completa los datos para crear y asignar el taller
                </p>
            </div>
            <button @click="closeAll()" style="
                background: rgba(255,255,255,0.15);
                border: none;
                border-radius: 50%;
                width: 36px; height: 36px;
                color: #fff;
                font-size: 1.1rem;
                cursor: pointer;
                display: flex; align-items: center; justify-content: center;
                transition: background .2s;
            " onmouseover="this.style.background='rgba(255,255,255,0.28)'"
               onmouseout="this.style.background='rgba(255,255,255,0.15)'">✕</button>
        </div>

        {{-- ── BODY ── --}}
        <form id="form-create" @submit.prevent="submitCreate($event)" enctype="multipart/form-data"
              style="padding: 1.75rem 2rem;">
            @csrf

            {{-- Nombre --}}
            <div style="margin-bottom:1.1rem;">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                    Nombre del taller <span style="color:#ef4444;">*</span>
                </label>
                <input type="text" name="nombre" x-model="createData.nombre" required
                       placeholder="Ej. Taller de Voleibol"
                       style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                              border:1.5px solid #d1d5db; background:#f8fafc;
                              color:#111; font-size:.95rem; transition:border-color .2s;"
                       onfocus="this.style.borderColor='#004aad'"
                       onblur="this.style.borderColor='#d1d5db'" />
            </div>

            {{-- Descripción --}}
            <div style="margin-bottom:1.1rem;">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                    Descripción
                </label>
                <textarea name="descripcion" rows="3" x-model="createData.descripcion"
                          placeholder="Describe brevemente el taller..."
                          style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                 border:1.5px solid #d1d5db; background:#f8fafc;
                                 color:#111; font-size:.95rem; resize:vertical; transition:border-color .2s;"
                          onfocus="this.style.borderColor='#004aad'"
                          onblur="this.style.borderColor='#d1d5db'"></textarea>
            </div>

            {{-- Imagen --}}
            <div style="margin-bottom:1.1rem;">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                    Imagen del taller
                </label>
                <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
                    <div style="width:90px; height:68px; border-radius:.6rem; overflow:hidden;
                                border:2px solid #e5e7eb; background:#f1f5f9; flex-shrink:0;">
                        <img id="preview-create-img" src="{{ asset('imagenes/uttec.jpeg') }}"
                             style="width:100%; height:100%; object-fit:cover;" alt="Preview">
                    </div>
                    <div style="flex:1;">
                        <input type="file" name="imagen" accept="image/jpeg,image/png,image/jpg,image/webp"
                               style="width:100%; padding:.5rem .75rem; border-radius:.6rem;
                                      border:1.5px solid #d1d5db; background:#f8fafc;
                                      color:#111; font-size:.85rem; cursor:pointer;"
                               onchange="previewImagen(this, 'preview-create-img')" />
                        <p style="font-size:.75rem; color:#9ca3af; margin-top:.3rem;">JPG, PNG o WEBP · Máx. 3 MB</p>
                    </div>
                </div>
            </div>

            {{-- Separador --}}
            <div style="border-top:1px dashed #e5e7eb; margin:1.25rem 0;"></div>

            {{-- Categoría + Cupos --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.1rem;">
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                        Categoría <span style="color:#ef4444;">*</span>
                    </label>
                    <select name="categoria" x-model="createData.categoria" required
                            style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                   border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.95rem;">
                        <option value="General">General</option>
                        <option value="Academico">Académico</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Deportivo">Deportivo</option>
                    </select>
                </div>
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                        Cupos totales <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="number" name="cupos" x-model="createData.cupos"
                           required min="1" placeholder="30"
                           style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                  border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.95rem;" />
                </div>
            </div>

            {{-- Asignar Profesor --}}
            <div style="margin-bottom:1.1rem;">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                    Asignar Profesor <span style="color:#ef4444;">*</span>
                </label>

                @if(isset($profesoresDisponibles) && $profesoresDisponibles->count() > 0)
                    <select name="id_profesor" x-model="createData.id_profesor" required
                            style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                   border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.95rem;
                                   transition:border-color .2s;"
                            onfocus="this.style.borderColor='#004aad'"
                            onblur="this.style.borderColor='#d1d5db'">
                        <option value="">— Selecciona un profesor disponible —</option>
                        @foreach($profesoresDisponibles as $prof)
                            <option value="{{ $prof->id_usuario }}">
                                {{ $prof->nombre }} · {{ $prof->email }}
                            </option>
                        @endforeach
                    </select>
                    <p style="font-size:.75rem; color:#6b7280; margin-top:.35rem;">
                        ✅ {{ $profesoresDisponibles->count() }} profesor(es) disponible(s) sin taller asignado
                    </p>
                @else
                    <div style="padding:.75rem 1rem; border-radius:.6rem;
                                background:#fef9ec; border:1.5px solid #f59e0b; color:#92400e;
                                font-size:.9rem; display:flex; align-items:center; gap:.5rem;">
                        <span style="font-size:1.1rem;">⚠️</span>
                        Todos los profesores ya tienen un taller asignado. Registra un nuevo profesor primero.
                    </div>
                    <input type="hidden" name="id_profesor" value="" />
                @endif
            </div>

            {{-- Separador --}}
            <div style="border-top:1px dashed #e5e7eb; margin:1.25rem 0;"></div>

            {{-- Fechas --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.1rem;">
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                        Fecha inicio <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="date" name="fecha_inicio" x-model="createData.fecha_inicio" required
                           style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                  border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.95rem;" />
                </div>
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                        Fecha fin <span style="color:#ef4444;">*</span>
                    </label>
                    <input type="date" name="fecha_fin" x-model="createData.fecha_fin" required
                           style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                  border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.95rem;" />
                </div>
            </div>

            {{-- Lugar --}}
            <div style="margin-bottom:1.1rem;">
                <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                    Lugar / Instalación
                </label>
                <input type="text" name="lugar" x-model="createData.lugar"
                       placeholder="Ej. Cancha principal, Aula 3B, Gimnasio..."
                       style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                              border:1.5px solid #d1d5db; background:#f8fafc;
                              color:#111; font-size:.95rem; transition:border-color .2s;"
                       onfocus="this.style.borderColor='#004aad'"
                       onblur="this.style.borderColor='#d1d5db'" />
            </div>

            {{-- Horario + Días --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                        Horario
                    </label>
                    <input type="text" name="horario" x-model="createData.horario"
                           placeholder="Ej. 14:00 – 16:00 hrs"
                           style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                  border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.95rem;" />
                </div>
                <div>
                    <label style="display:block; font-size:.8rem; font-weight:700; color:#004aad; text-transform:uppercase; letter-spacing:.05em; margin-bottom:.4rem;">
                        Días
                    </label>
                    <input type="text" name="dias" x-model="createData.dias"
                           placeholder="Ej. Lunes y Miércoles"
                           style="width:100%; padding:.65rem 1rem; border-radius:.6rem;
                                  border:1.5px solid #d1d5db; background:#f8fafc; color:#111; font-size:.95rem;" />
                </div>
            </div>

            {{-- ── FOOTER botones ── --}}
            <div style="
                border-top: 1px solid #e5e7eb;
                padding-top: 1.25rem;
                display: flex;
                justify-content: flex-end;
                gap: .75rem;
            ">
                <button type="button" @click="closeAll()" style="
                    padding: .6rem 1.5rem;
                    border-radius: .6rem;
                    background: #f3f4f6;
                    color: #374151;
                    font-weight: 700;
                    border: 1.5px solid #d1d5db;
                    cursor: pointer;
                    font-size: .95rem;
                    transition: background .2s;
                " onmouseover="this.style.background='#e5e7eb'"
                   onmouseout="this.style.background='#f3f4f6'">
                    Cancelar
                </button>
                <button type="submit" style="
                    padding: .6rem 1.8rem;
                    border-radius: .6rem;
                    background: linear-gradient(135deg, #004aad, #0066cc);
                    color: #fff;
                    font-weight: 700;
                    border: none;
                    cursor: pointer;
                    font-size: .95rem;
                    box-shadow: 0 4px 14px rgba(0,74,173,0.4);
                    transition: box-shadow .2s;
                " onmouseover="this.style.boxShadow='0 6px 20px rgba(0,74,173,0.6)'"
                   onmouseout="this.style.boxShadow='0 4px 14px rgba(0,74,173,0.4)'">
                    Guardar Taller
                </button>
            </div>
        </form>
    </div>
</div>