{{-- ================= MODAL CREAR TALLER (Máximo Ancho/Altura y Centrado) ================= --}}

{{-- Contenedor principal: Ocupa toda la pantalla (inset-0), centra contenido, alta prioridad (z-[70]) --}}
<div id="modal-crear" class="fixed inset-0 z-[70] hidden items-center justify-center bg-black/60 backdrop-blur-sm p-4 sm:p-6">
    
    {{-- Contenedor del Modal: Ancho Pequeño (max-w-sm), Altura Limitada (max-h-[90vh]) --}}
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm 
                max-h-[80vh] flex flex-col {{-- CLAVE: Añadir flex y flex-col --}}
                scale-100 transition-all relative animate-fade-in-up"> 
        
        {{-- 1. HEADER (Fijo) --}}
        <div class="bg-gray-50 p-6 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Nuevo Taller</h3>
                <p class="text-gray-500 text-sm">Ingresa los detalles de la actividad.</p>
            </div>
            <button onclick="toggleModal('modal-crear')" class="text-gray-400 hover:text-gray-700 bg-white p-2 rounded-full shadow-sm hover:shadow transition">
                <i data-feather="x" class="w-5 h-5"></i>
            </button>
        </div>

        {{-- 2. CUERPO (Scrollable) --}}
        {{-- CLAVE: El contenido del formulario es ahora el que crece (flex-grow) y maneja el scroll (overflow-y-auto) --}}
        <form action="{{ route('eventos.store') }}" method="POST" class="flex flex-col flex-grow overflow-y-auto">
            @csrf
            <input type="hidden" name="creado_por" value="{{ auth()->user()->id_usuario }}">
            <input type="hidden" name="categoria" value="General"> 

            <div class="p-8 space-y-6 flex-grow">
                <div>
                    <label for="nombre" class="text-sm font-bold text-gray-700 block mb-2">Nombre de la Actividad</label>
                    <input type="text" id="nombre" name="nombre" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-uttec-green focus:ring-2 focus:ring-uttec-green/20 transition font-medium placeholder:text-gray-400" placeholder="Ej: Taller de Robótica">
                </div>

                <div>
                    <label for="descripcion" class="text-sm font-bold text-gray-700 block mb-2">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="3" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-uttec-green focus:ring-2 focus:ring-uttec-green/20 transition font-medium placeholder:text-gray-400 resize-none" placeholder="Detalles importantes..."></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha_inicio" class="text-sm font-bold text-gray-700 block mb-2">Inicio</label>
                        <input type="datetime-local" id="fecha_inicio" name="fecha_inicio" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-uttec-green transition text-gray-600 font-medium">
                    </div>
                    <div>
                        <label for="fecha_fin" class="text-sm font-bold text-gray-700 block mb-2">Fin</label>
                        <input type="datetime-local" id="fecha_fin" name="fecha_fin" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-uttec-green transition text-gray-600 font-medium">
                    </div>
                </div>

                <div>
                     <label for="cupos" class="text-sm font-bold text-gray-700 block mb-2">Cupos Disponibles</label>
                    <div class="relative">
                        <i data-feather="users" class="absolute left-4 top-3.5 text-gray-400 w-5 h-5"></i>
                        <input type="number" id="cupos" name="cupos" min="1" value="30" required class="w-full pl-12 pr-4 py-3 rounded-xl bg-gray-50 border border-gray-200 focus:bg-white focus:border-uttec-green focus:ring-2 focus:ring-uttec-green/20 transition font-bold text-gray-700">
                    </div>
                </div>
            </div>

            {{-- 3. FOOTER (Fijo) --}}
            <div class="p-6 flex items-center justify-end gap-4 border-t border-gray-100 flex-shrink-0 bg-white">
                <button type="button" onclick="toggleModal('modal-crear')" class="px-6 py-3 rounded-xl font-bold text-gray-600 hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button type="submit" class="btn-uttec-green px-8 py-3 rounded-xl font-bold shadow-md flex items-center gap-2">
                    <i data-feather="check" class="w-5 h-5"></i> Publicar Actividad
                </button>
            </div>
        </form>
    </div>
</div>