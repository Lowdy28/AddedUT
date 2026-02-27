<div x-show="modalShow" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="bg-white rounded-2xl shadow-2xl relative overflow-hidden"
         style="max-width:680px; width:95%; max-height:92vh; overflow-y:auto; color:#111;">

        {{-- Header azul con nombre --}}
        <div style="background: linear-gradient(135deg, #002D62, #004aad); padding: 1.5rem 2rem; position:relative;">
            <button @click="closeAll()"
                    style="position:absolute; top:1rem; right:1rem; background:rgba(255,255,255,0.2);
                           border:none; border-radius:50%; width:32px; height:32px; cursor:pointer;
                           color:white; font-size:1.1rem; display:flex; align-items:center; justify-content:center;">
                ✕
            </button>
            <h2 class="text-2xl font-extrabold text-white" x-text="showData.nombre">—</h2>
            <span class="inline-block mt-1 px-3 py-1 rounded text-xs font-bold text-white"
                  style="background:rgba(255,255,255,0.2);"
                  x-text="showData.categoria">—</span>
        </div>

        {{-- Imagen si existe --}}
        <div x-show="showData.imagen_url" style="height:200px; overflow:hidden;">
            <img :src="showData.imagen_url" alt="Imagen del taller"
                 style="width:100%; height:100%; object-fit:cover; filter:brightness(0.9);">
        </div>

        {{-- Contenido --}}
        <div style="padding: 1.5rem 2rem;">

            {{-- Descripción --}}
            <div class="mb-5">
                <h3 class="font-bold text-gray-700 text-sm uppercase tracking-wide mb-2">Descripción</h3>
                <p class="text-gray-700 leading-relaxed text-sm" x-text="showData.descripcion || 'Sin descripción disponible'">—</p>
            </div>

            {{-- Grid de datos clave --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.25rem;">

                <div class="rounded-lg p-3" style="background:#f0fdf4; border:1px solid #bbf7d0;">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Cupos totales</p>
                    <p class="text-2xl font-extrabold text-green-700" x-text="showData.cupos">—</p>
                </div>

                <div class="rounded-lg p-3" style="background:#f5f3ff; border:1px solid #ddd6fe;">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Categoría</p>
                    <p class="text-lg font-bold text-purple-700" x-text="showData.categoria">—</p>
                </div>

                <div class="rounded-lg p-3" style="background:#eff6ff; border:1px solid #bfdbfe;">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Fecha inicio</p>
                    <p class="text-base font-bold text-blue-700" x-text="showData.fecha_inicio ? formatFecha(showData.fecha_inicio) : '—'">—</p>
                </div>

                <div class="rounded-lg p-3" style="background:#fff1f2; border:1px solid #fecdd3;">
                    <p class="text-xs text-gray-500 font-semibold uppercase">Fecha fin</p>
                    <p class="text-base font-bold text-red-600" x-text="showData.fecha_fin ? formatFecha(showData.fecha_fin) : '—'">—</p>
                </div>

            </div>

            {{-- Info adicional --}}
            <div style="border-top:1px solid #e5e7eb; padding-top:1rem; display:flex; flex-direction:column; gap:.6rem;">

                <div x-show="showData.lugar" class="flex items-center gap-2 text-sm text-gray-700">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span><strong>Lugar:</strong> <span x-text="showData.lugar"></span></span>
                </div>

                <div x-show="showData.horario" class="flex items-center gap-2 text-sm text-gray-700">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Horario:</strong> <span x-text="showData.horario"></span></span>
                </div>

                <div x-show="showData.dias" class="flex items-center gap-2 text-sm text-gray-700">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span><strong>Días:</strong> <span x-text="showData.dias"></span></span>
                </div>

                <div x-show="showData.creador" class="flex items-center gap-2 text-sm text-gray-700">
                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span><strong>Profesor:</strong>
                        <span x-text="showData.creador ? showData.creador.nombre : '—'"></span>
                    </span>
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <div style="padding:1rem 2rem; border-top:1px solid #e5e7eb; display:flex; justify-content:flex-end;">
            <button @click="closeAll()"
                    class="px-6 py-2 rounded-lg bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300 transition">
                Cerrar
            </button>
        </div>
    </div>
</div>