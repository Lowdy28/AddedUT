@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js" defer></script>

<style>
[x-cloak] { display: none !important; }
</style>

<div x-data="modalsHandler()">

    <h1 class="text-3xl font-bold text-white mb-8">Usuarios Registrados</h1>

    <div class="flex justify-between items-center mb-6">
        <form method="GET" action="{{ route('usuarios.index') }}">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                placeholder="Buscar usuario..."
                class="px-4 py-2 border border-gray-300 rounded shadow focus:ring w-72 bg-white text-gray-900 focus:ring-blue-400 focus:border-blue-400" />
        </form>

        <button @click="openCreate()"
            class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 transition">
            Nuevo Usuario
        </button>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Correo</th>
                    <th class="px-4 py-3 text-left">Rol</th>
                    <th class="px-4 py-3 text-left">Activo</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 text-sm">
                @forelse ($usuarios as $u)
                    <tr class="border-b last:border-b-0 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $u->id_usuario }}</td>
                        <td class="px-4 py-3">{{ $u->nombre }}</td>
                        <td class="px-4 py-3">{{ $u->correo }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-xs font-semibold
                                @if($u->rol=='admin') bg-red-100 text-red-700
                                @elseif($u->rol=='profesor') bg-yellow-100 text-yellow-700
                                @else bg-green-100 text-green-700 @endif">
                                {{ ucfirst($u->rol) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($u->activo)
                                <span class="text-green-600 font-semibold">Activo</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                <button 
                                    @click="openEdit({{ $u }})"
                                    class="bg-yellow-400 text-gray-900 px-3 py-1 rounded shadow hover:bg-yellow-500 transition">
                                    Editar
                                </button>

                                <button 
                                    @click="confirmDelete({{ $u->id_usuario }})"
                                    class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            😔 No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $usuarios->appends(['buscar' => request('buscar')])->links() }}
        </div>
    </div>

    @include('usuarios.modals.create')
    @include('usuarios.modals.edit')
</div>

<script>
function modalsHandler() {
    return {
        modalCreate: false,
        modalEdit: false,
        editData: {},

        openCreate() { this.modalCreate = true; },
        openEdit(user) { this.editData = JSON.parse(JSON.stringify(user)); this.modalEdit = true; },
        closeAll() { this.modalCreate = false; this.modalEdit = false; },

        async submitCreate(event) {
            event.preventDefault();
            const form = event.target;
            const data = new FormData(form);

            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: { 
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: data
                });

                const json = await res.json();
                if (!res.ok) throw new Error(json.message || JSON.stringify(json.errors) || 'Error desconocido');

                this.closeAll();

                Swal.fire({
                    title: '¡Éxito!',
                    text: json.message || 'Usuario creado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                }).then(() => location.reload());

            } catch (err) {
                Swal.fire({
                    title: 'Error',
                    text: err.message || 'Ocurrió un error',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        },

        async submitEdit(event, id) {
            event.preventDefault();
            const form = event.target;
            const data = new FormData(form);
            data.append('_method', 'PUT');

            try {
                const res = await fetch(`/usuarios/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: data
                });

                const json = await res.json();
                if (!res.ok) throw new Error(json.message || JSON.stringify(json.errors) || 'Error desconocido');

                this.closeAll();

                Swal.fire({
                    title: '¡Éxito!',
                    text: json.message || 'Usuario actualizado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                }).then(() => location.reload());

            } catch (err) {
                Swal.fire({
                    title: 'Error',
                    text: err.message || 'Ocurrió un error',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        },

        confirmDelete(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/usuarios/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-HTTP-Method-Override': 'DELETE'
                        }
                    }).then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Usuario eliminado',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => location.reload());
                    });
                }
            });
        }
    }
}
</script>

@endsection
