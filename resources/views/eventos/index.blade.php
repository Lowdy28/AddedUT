@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js" defer></script>

<style>
[x-cloak] { display: none !important; }
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); display: flex; align-items: center; justify-content: center; z-index: 9999; }
.modal-content { background: #fff; border-radius: 1.5rem; padding: 2rem; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.35); color: #111 !important; }
</style>

<div x-data="eventosHandler()">

    <h1 class="text-3xl font-bold text-white mb-8">Talleres / Eventos</h1>

    <div class="flex justify-between items-center mb-6">
        <form method="GET" action="{{ route('eventos.index') }}">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                placeholder="Buscar taller o evento..."
                class="px-4 py-2 border border-gray-300 rounded shadow focus:ring w-72 bg-white text-gray-900 focus:ring-blue-400 focus:border-blue-400" />
        </form>

        <button @click="openCreate()"
            class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 transition">
            Nuevo Taller
        </button>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Categoría</th>
                    <th class="px-4 py-3 text-left">Profesor</th>
                    <th class="px-4 py-3 text-left">Cupos</th>
                    <th class="px-4 py-3 text-left">Fecha inicio</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 text-sm">
                @forelse ($eventos as $ev)
                    <tr class="border-b last:border-b-0 hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $ev->id_evento }}</td>
                        <td class="px-4 py-3">{{ $ev->nombre }}</td>
                        <td class="px-4 py-3">{{ $ev->categoria }}</td>
                        <td class="px-4 py-3">{{ optional($ev->creador)->nombre ?? '—' }}</td>
                        <td class="px-4 py-3">{{ $ev->cupos }}</td>
                        <td class="px-4 py-3">{{ $ev->fecha_inicio ? \Carbon\Carbon::parse($ev->fecha_inicio)->format('d M, Y') : '—' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                {{-- Botón Ver → ahora abre modal en lugar de redirigir --}}
                                <button @click="openShow({{ $ev->load('creador') }})"
                                    class="bg-blue-600 text-white px-3 py-1 rounded shadow hover:bg-blue-700 transition">
                                    Ver
                                </button>

                                <button @click="openEdit({{ $ev }})"
                                    class="bg-yellow-400 text-gray-900 px-3 py-1 rounded shadow hover:bg-yellow-500 transition">
                                    Editar
                                </button>

                                <button @click="openDelete({{ $ev->id_evento }})"
                                    class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">
                                    Eliminar
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            😔 No hay talleres registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-200">
            {{ $eventos->appends(['buscar' => request('buscar')])->links() }}
        </div>
    </div>

    {{-- Modales --}}
    @include('eventos.modals.create')
    @include('eventos.modals.edit')
    @include('eventos.modals.show')

 
    <div x-show="modalDelete" x-cloak
         class="modal-overlay"
         x-transition:enter="transition duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90">
        <div class="modal-content">
            <h2 class="text-2xl font-bold mb-6 text-red-600">Eliminar Taller</h2>
            <p class="mb-6 text-gray-700">¿Estás seguro que deseas eliminar este taller?</p>
            <div class="flex justify-end gap-4">
                <button @click="closeAll()"
                        class="px-6 py-2 rounded-lg bg-gray-300 text-black font-semibold shadow hover:bg-gray-400 transition">
                    Cancelar
                </button>
                <button @click="submitDelete(deleteId)"
                        class="px-6 py-2 rounded-lg bg-red-600 text-white font-semibold shadow hover:bg-red-700 transition">
                    Eliminar
                </button>
            </div>
        </div>
    </div>

</div>

{{-- AlpineJS Handler --}}
<script>
function eventosHandler() {
    return {
        modalCreate: false,
        modalEdit:   false,
        modalDelete: false,
        modalShow:   false,   

        createData: { nombre: '', descripcion: '', categoria: 'General', cupos: 1, fecha_inicio: '', fecha_fin: '', lugar: '', horario: '', dias: '', id_profesor: '' },
        editData:   { id_evento: '', nombre: '', descripcion: '', categoria: '', cupos: 1, fecha_inicio: '', fecha_fin: '', lugar: '', horario: '', dias: '' },
        showData:   {},       
        deleteId:   null,

        openCreate() {
            this.createData = { nombre: '', descripcion: '', categoria: 'General', cupos: 1, fecha_inicio: '', fecha_fin: '', lugar: '', horario: '', dias: '', id_profesor: '' };
            this.modalCreate = true;
        },

        openEdit(ev) {
            this.editData = JSON.parse(JSON.stringify(ev));
            this.modalEdit = true;
        },

   
        openShow(ev) {
            this.showData = JSON.parse(JSON.stringify(ev));
            this.modalShow = true;
        },

        openDelete(id) {
            this.deleteId = id;
            this.modalDelete = true;
        },

        closeAll() {
            this.modalCreate = false;
            this.modalEdit   = false;
            this.modalDelete = false;
            this.modalShow   = false;  
        },

     
        formatFecha(dateStr) {
            if (!dateStr) return '—';
            const [y, m, d] = dateStr.split('-');
            const meses = ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'];
            return `${d} ${meses[parseInt(m)-1]}, ${y}`;
        },

        async submitCreate(event) {
            const formData = new FormData(document.getElementById('form-create'));
            try {
                const res = await fetch("{{ route('eventos.store') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: formData
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error desconocido');
                this.closeAll();
                Swal.fire({ title: '¡Éxito!', text: json.message, icon: 'success' }).then(() => location.reload());
            } catch(err) {
                Swal.fire({ title: 'Error', text: err.message, icon: 'error' });
            }
        },

        async submitEdit(event, id) {
            const payload = { ...this.editData };
            try {
                const res = await fetch(`/eventos/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });
                const json = await res.json();
                if (!res.ok) throw new Error(json.message || 'Error desconocido');
                this.closeAll();
                Swal.fire({ title: '¡Éxito!', text: json.message, icon: 'success' }).then(() => location.reload());
            } catch(err) {
                Swal.fire({ title: 'Error', text: err.message, icon: 'error' });
            }
        },

        async submitDelete(id) {
            try {
                const res = await fetch(`/eventos/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                if (!res.ok) throw new Error('No se pudo eliminar el taller');
                this.closeAll();
                Swal.fire({ icon: 'success', title: 'Taller eliminado', showConfirmButton: false, timer: 1500 }).then(() => location.reload());
            } catch(err) {
                Swal.fire({ title: 'Error', text: err.message, icon: 'error' });
            }
        }
    }
}
</script>

@endsection