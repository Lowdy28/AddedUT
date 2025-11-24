<div x-show="modalCreate" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition>
     
    <div class="modal-content bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl">
        <h2 class="text-3xl font-extrabold mb-6 text-blue-900">Nueva Inscripción</h2>

        <form action="{{ route('inscripciones.store') }}" @submit.prevent="submitCreate($event)">
            @csrf

            <div class="mb-4">
                <label class="font-semibold block mb-1">Usuario</label>
                <select name="id_usuario" required class="w-full px-4 py-2 rounded-lg border">
                    <option value="" disabled selected>Seleccione un usuario</option>
                    @foreach ($usuarios as $u)
                        <option value="{{ $u->id_usuario }}">{{ $u->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label class="font-semibold block mb-1">Evento</label>
                <select name="id_evento" required class="w-full px-4 py-2 rounded-lg border">
                    <option value="" disabled selected>Seleccione un evento</option>
                    @foreach ($eventos as $e)
                        <option value="{{ $e->id_evento }}">
                            {{ $e->nombre }} — Cupo: {{ $e->cupo_disponible }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" @click="closeAll()" 
                        class="px-6 py-2 rounded-lg bg-gray-400 text-black font-bold">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-green-500 text-black font-bold">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>