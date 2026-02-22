@extends('layouts.admin')

@section('content')
<div x-data="noticiasManager()" class="container mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white tracking-tight">Gestión de Tablón</h1>
            <p class="text-gray-400">Publica avisos, noticias y eventos para la comunidad estudiantil.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.noticias.index') }}" method="GET" class="relative">
                <input type="text" name="buscar" placeholder="Buscar por título..." 
                    class="bg-gray-800 text-white px-4 py-2 rounded-xl border border-gray-700 focus:ring-2 focus:ring-blue-500 outline-none w-64 transition"
                    value="{{ request('buscar') }}">
            </form>
            <button @click="openCreate()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold shadow-lg shadow-blue-900/20 transition transform active:scale-95">
                + Nueva Noticia
            </button>
        </div>
    </div>

    <div class="bg-gray-900 rounded-2xl shadow-2xl overflow-hidden border border-gray-800">
        <table class="w-full text-left text-gray-300">
            <thead class="bg-gray-800/50 text-gray-400 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="px-6 py-4">Portada</th>
                    <th class="px-6 py-4">Título</th>
                    <th class="px-6 py-4">Categoría</th>
                    <th class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($noticias as $item)
                <tr class="hover:bg-gray-800/40 transition-colors">
                    <td class="px-6 py-4">
                        @if($item->imagen)
                            <img src="{{ asset('storage/' . $item->imagen) }}" class="w-20 h-12 object-cover rounded-lg shadow-inner border border-gray-700">
                        @else
                            <div class="w-20 h-12 bg-gray-800 rounded-lg flex items-center justify-center border border-dashed border-gray-700 text-[10px] text-gray-500 uppercase">Sin Imagen</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-white max-w-xs truncate">{{ $item->titulo }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-900/20 text-blue-400 text-[11px] font-bold rounded-full border border-blue-800/50 uppercase tracking-tighter">
                            {{ $item->categoria }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2">
                            <button @click="openShow({{ json_encode($item) }})" class="p-2 hover:bg-blue-500/10 text-blue-400 rounded-lg transition" title="Ver Detalle">
                                Ver
                            </button>
                            <button @click="openEdit({{ json_encode($item) }})" class="p-2 hover:bg-yellow-500/10 text-yellow-500 rounded-lg transition" title="Editar">
                                Editar
                            </button>
                            <button @click="confirmDelete({{ $item->id_noticia }})" class="p-2 hover:bg-red-500/10 text-red-500 rounded-lg transition" title="Eliminar">
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center text-gray-500 italic">No se encontraron noticias en el sistema.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $noticias->appends(request()->query())->links() }}
    </div>

    @include('admin.noticias.modals.create')
    @include('admin.noticias.modals.edit')
    @include('admin.noticias.modals.show')

</div>

<script>
function noticiasManager() {
    return {
        showModalCreate: false,
        showModalEdit: false,
        showModalView: false,

        createData: { titulo: '', contenido: '', categoria: 'General', imagen: null },
        editData: { id: '', titulo: '', contenido: '', categoria: '', imagen: null },
        viewData: { titulo: '', contenido: '', categoria: '', imagen: '' },

        openCreate() {
            this.createData = { titulo: '', contenido: '', categoria: 'General', imagen: null };
            this.showModalCreate = true;
        },

        openEdit(item) {
            this.editData = {
                id: item.id_noticia, // Ajustado
                titulo: item.titulo, // Ajustado
                contenido: item.contenido, // Ajustado
                categoria: item.categoria, // Ajustado
                imagen_url: item.imagen, // Ajustado
                imagen: null 
            };
            this.showModalEdit = true;
        },

        openShow(item) {
            this.viewData = {
                titulo: item.titulo, // Ajustado
                contenido: item.contenido, // Ajustado
                categoria: item.categoria, // Ajustado
                imagen: item.imagen // Ajustado
            };
            this.showModalView = true;
        },

        async submitCreate() {
            const form = new FormData();
            form.append('titulo', this.createData.titulo);
            form.append('contenido', this.createData.contenido);
            form.append('categoria', this.createData.categoria);
            if (this.createData.imagen) form.append('imagen', this.createData.imagen);

            try {
                const response = await fetch("{{ route('admin.noticias.store') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: form
                });
                const res = await response.json();
                if (response.ok) {
                    Swal.fire({ icon: 'success', title: '¡Publicado!', text: res.message, background: '#111827', color: '#fff' })
                    .then(() => location.reload());
                } else {
                    throw new Error();
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Revisa los campos del formulario.', background: '#111827', color: '#fff' });
            }
        },

        async submitUpdate() {
            const form = new FormData();
            form.append('_method', 'PUT'); 
            form.append('titulo', this.editData.titulo);
            form.append('contenido', this.editData.contenido);
            form.append('categoria', this.editData.categoria);
            if (this.editData.imagen) form.append('imagen', this.editData.imagen);

            try {
                const response = await fetch(`/admin/noticias/${this.editData.id}`, {
                    method: 'POST', 
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: form
                });
                const res = await response.json();
                if (response.ok) {
                    Swal.fire({ icon: 'success', title: 'Actualizado', text: res.message, background: '#111827', color: '#fff' })
                    .then(() => location.reload());
                }
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo actualizar.', background: '#111827', color: '#fff' });
            }
        },

        confirmDelete(id) {
            Swal.fire({
                title: '¿Eliminar noticia?',
                text: "Se borrará permanentemente del servidor.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#374151',
                confirmButtonText: 'Sí, borrar',
                background: '#111827',
                color: '#fff'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const response = await fetch(`/admin/noticias/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    if (response.ok) {
                        location.reload();
                    }
                }
            });
        }
    }
}
</script>
@endsection