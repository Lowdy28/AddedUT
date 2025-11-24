<div x-show="modalCreate" 
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
            Nueva Inscripción
        </h2>

        <form action="{{ route('inscripciones.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="font-semibold block mb-2">Usuario</label>
                <select name="id_usuario" 
                        required 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:outline-none">
                    <option value="" disabled selected>Seleccione un usuario</option>
                    @foreach ($usuarios as $u)
                        <option value="{{ $u->id_usuario }}">{{ $u->nombre }} - {{ $u->email }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="font-semibold block mb-2">Evento</label>
                <select name="id_evento" 
                        required 
                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-blue-500 focus:outline-none">
                    <option value="" disabled selected>Seleccione un evento</option>
                    @foreach ($eventos as $e)
                        <option value="{{ $e->id_evento }}">
                            {{ $e->nombre }} — Cupos disponibles: {{ $e->cupos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" 
                        @click="closeAll()" 
                        class="px-6 py-3 rounded-lg bg-red-600 text-white font-bold shadow-lg hover:bg-red-700 transition">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-3 rounded-lg bg-green-600 text-white font-bold shadow-lg hover:bg-green-700 transition">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>