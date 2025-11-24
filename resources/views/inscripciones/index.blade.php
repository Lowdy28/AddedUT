@extends('layouts.admin')

@section('content')

<div x-data="inscripcionesController()">

    <h1 class="text-2xl font-bold mb-4 text-white">Inscripciones</h1>

    <!-- Botón crear -->
    <button @click="openCreate()"
            class="bg-green-500 text-black px-4 py-2 rounded-lg font-semibold shadow hover:bg-green-600 transition mb-4">
        Nueva Inscripción
    </button>

    <!-- Tabla -->
    <div class="bg-white rounded-xl p-4 shadow" style="color:#111 !important;">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Usuario</th>
                    <th class="p-2">Evento</th>
                    <th class="p-2">Estado</th>
                    <th class="p-2">Fecha</th>
                    <th class="p-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripciones as $i)
                <tr class="border-b hover:bg-gray-100">
                    <td class="p-2">{{ $i->usuario->nombre }}</td>
                    <td class="p-2">{{ $i->evento->nombre }}</td>
                    <td class="p-2">{{ ucfirst($i->estado) }}</td>
                    <td class="p-2">{{ $i->fecha_inscripcion }}</td>

                    <td class="p-2 text-center">

                        <!-- Editar -->
                        <button 
                            @click="openEdit({
                                id_inscripcion: '{{ $i->id_inscripcion }}',
                                estado: '{{ $i->estado }}'
                            })"
                            class="bg-yellow-400 text-black px-3 py-1 rounded shadow hover:bg-yellow-500 transition">
                            Editar
                        </button>

                        <!-- Eliminar -->
                        <button 
                            @click="openDelete({{ $i->id_inscripcion }})"
                            class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 transition ml-2">
                            Eliminar
                        </button>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $inscripciones->links() }}
        </div>
    </div>

    <!-- Importar modales -->
    @include('inscripciones.modal.create')
    @include('inscripciones.modal.edit')
    @include('inscripciones.modal.delete')

</div>
<script>
function inscripcionesController() {
    return {
        modalCreate: false,
        modalEdit: false,
        modalDelete: false,
        deleteId: null,
        editData: {},

        openCreate() {
            this.modalCreate = true;
        },

        openEdit(data) {
            this.editData = { ...data };
            this.modalEdit = true;
        },

        openDelete(id) {
            this.deleteId = id;
            this.modalDelete = true;
        },

        closeAll() {
            this.modalCreate = false;
            this.modalEdit = false;
            this.modalDelete = false;
            this.deleteId = null;
            this.editData = {};
        }
    };
}
</script>

@endsection
