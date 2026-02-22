@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js" defer></script>

<style>
[x-cloak] { display: none !important; }
.modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.55); backdrop-filter:blur(5px); display:flex; align-items:center; justify-content:center; z-index:9999; }
.modal-content { background:#fff; border-radius:1.5rem; padding:2rem; max-width:580px; width:92%; box-shadow:0 20px 60px rgba(0,0,0,0.35); color:#111 !important; max-height:90vh; overflow-y:auto; }
.modal-content label { color:#333 !important; font-weight:600; }
.modal-content input, .modal-content textarea, .modal-content select {
    color:#000 !important; background:#f8fafc !important;
    border:1px solid #d1d5db !important; border-radius:.5rem;
    padding:.5rem .75rem; width:100%; margin-top:.25rem;
}
.modal-content textarea { min-height:120px; resize:vertical; }
.img-preview { max-height:150px; border-radius:8px; object-fit:cover; margin-top:.5rem; }
</style>

<div x-data="noticiasHandler()">

    <h1 class="text-3xl font-bold text-white mb-8">📰 Foro de Noticias</h1>

    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
        <p class="text-white/70 text-sm">Administra las noticias y anuncios que verán los estudiantes.</p>
        <button @click="openCreate()"
            class="bg-green-600 text-white px-5 py-2 rounded shadow hover:bg-green-700 transition font-semibold">
            + Nueva Noticia
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4 font-semibold">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow border border-gray-200 overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Título</th>
                    <th class="px-4 py-3 text-left">Categoría</th>
                    <th class="px-4 py-3 text-left">Imagen</th>
                    <th class="px-4 py-3 text-center">Publicada</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-900 text-sm">
                @forelse($noticias as $n)
                <tr class="border-b last:border-b-0 hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $n->id_noticia }}</td>
                    <td class="px-4 py-3 font-semibold max-w-xs">{{ Str::limit($n->titulo, 60) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded text-xs font-bold bg-blue-100 text-blue-800">
                            {{ $n->categoria }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($n->imagen)
                            <img src="{{ Storage::url($n->imagen) }}" alt="img" class="h-10 w-16 object-cover rounded">
                        @else
                            <span class="text-gray-400 text-xs">Sin imagen</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($n->publicada)
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">✓ Sí</span>
                        @else
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">✗ No</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $n->created_at->format('d M, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-center gap-2">
                            <button @click="openEdit({{ $n->id_noticia }}, '{{ addslashes($n->titulo) }}', `{{ addslashes($n->contenido) }}`, '{{ $n->categoria }}', {{ $n->publicada ? 'true' : 'false' }}, '{{ $n->imagen ? Storage::url($n->imagen) : '' }}')"
                                class="bg-yellow-400 text-gray-900 px-3 py-1 rounded shadow hover:bg-yellow-500 transition font-semibold">
                                Editar
                            </button>
                            <button @click="confirmDelete({{ $n->id_noticia }}, '{{ addslashes($n->titulo) }}')"
                                class="bg-red-500 text-white px-3 py-1 rounded shadow hover:bg-red-600 transition font-semibold">
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-10 text-center text-gray-400">
                        No hay noticias publicadas aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $noticias->links() }}</div>

    {{-- ── MODAL CREAR ────────────────────────────────── --}}
    <div class="modal-overlay" x-show="showCreate" x-cloak @click.self="showCreate=false">
        <div class="modal-content" @click.stop>
            <h2 class="text-xl font-bold mb-4 text-gray-800">📝 Nueva Noticia</h2>
            <form id="form-create" enctype="multipart/form-data" @submit.prevent="submitCreate()">
                @csrf
                <div class="mb-3">
                    <label>Título *</label>
                    <input type="text" name="titulo" x-model="form.titulo" required maxlength="200">
                </div>
                <div class="mb-3">
                    <label>Contenido *</label>
                    <textarea name="contenido" x-model="form.contenido" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Categoría</label>
                    <select name="categoria" x-model="form.categoria">
                        <option>General</option>
                        <option>Deportes</option>
                        <option>Cultural</option>
                        <option>Académico</option>
                        <option>Ambiental</option>
                        <option>Concursos</option>
                        <option>Otro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Imagen (opcional, máx 3MB)</label>
                    <input type="file" name="imagen" accept="image/*" @change="previewImg($event, 'preview-create')">
                    <img id="preview-create" src="" alt="" style="display:none;" class="img-preview">
                </div>
                <div class="mb-4 flex items-center gap-2">
                    <input type="checkbox" name="publicada" id="pub-create" value="1" x-model="form.publicada" class="w-auto m-0">
                    <label for="pub-create" style="margin:0;">Publicar inmediatamente</label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showCreate=false"
                        class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">Cancelar</button>
                    <button type="submit"
                        class="px-5 py-2 bg-green-600 text-white rounded font-semibold hover:bg-green-700">
                        Publicar
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ── MODAL EDITAR ────────────────────────────────── --}}
    <div class="modal-overlay" x-show="showEdit" x-cloak @click.self="showEdit=false">
        <div class="modal-content" @click.stop>
            <h2 class="text-xl font-bold mb-4 text-gray-800">✏️ Editar Noticia</h2>
            <form :id="`form-edit-${editId}`" enctype="multipart/form-data" @submit.prevent="submitEdit()">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Título *</label>
                    <input type="text" name="titulo" x-model="editForm.titulo" required maxlength="200">
                </div>
                <div class="mb-3">
                    <label>Contenido *</label>
                    <textarea name="contenido" x-model="editForm.contenido" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Categoría</label>
                    <select name="categoria" x-model="editForm.categoria">
                        <option>General</option>
                        <option>Deportes</option>
                        <option>Cultural</option>
                        <option>Académico</option>
                        <option>Ambiental</option>
                        <option>Concursos</option>
                        <option>Otro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Nueva imagen (dejar vacío para mantener la actual)</label>
                    <template x-if="editForm.imagenActual">
                        <img :src="editForm.imagenActual" alt="actual" class="img-preview mb-1">
                    </template>
                    <input type="file" name="imagen" accept="image/*" @change="previewImg($event, 'preview-edit')">
                    <img id="preview-edit" src="" alt="" style="display:none;" class="img-preview">
                </div>
                <div class="mb-4 flex items-center gap-2">
                    <input type="checkbox" name="publicada" id="pub-edit" value="1" x-model="editForm.publicada" class="w-auto m-0">
                    <label for="pub-edit" style="margin:0;">Publicada</label>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showEdit=false"
                        class="px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">Cancelar</button>
                    <button type="submit"
                        class="px-5 py-2 bg-yellow-500 text-white rounded font-semibold hover:bg-yellow-600">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function noticiasHandler() {
    return {
        showCreate: false,
        showEdit: false,
        editId: null,
        form: { titulo:'', contenido:'', categoria:'General', publicada: true },
        editForm: { titulo:'', contenido:'', categoria:'General', publicada: true, imagenActual:'' },

        openCreate() {
            this.form = { titulo:'', contenido:'', categoria:'General', publicada: true };
            this.showCreate = true;
            // Limpiar preview
            const prev = document.getElementById('preview-create');
            if(prev) { prev.src=''; prev.style.display='none'; }
        },

        openEdit(id, titulo, contenido, categoria, publicada, imagenActual) {
            this.editId = id;
            this.editForm = { titulo, contenido, categoria, publicada, imagenActual };
            this.showEdit = true;
        },

        previewImg(event, previewId) {
            const file = event.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(previewId);
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        },

        async submitCreate() {
            const formEl = document.getElementById('form-create');
            const formData = new FormData(formEl);

            const res = await fetch('{{ route("noticias.store") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            });
            const data = await res.json();

            if (res.ok) {
                Swal.fire({ icon:'success', title:'¡Publicada!', text: data.message, timer:1800, showConfirmButton:false })
                    .then(() => location.reload());
            } else {
                const errors = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                Swal.fire({ icon:'error', title:'Error', text: errors });
            }
        },

        async submitEdit() {
            const formEl = document.getElementById(`form-edit-${this.editId}`);
            const formData = new FormData(formEl);
            formData.append('_method', 'PUT');

            const res = await fetch(`/noticias/${this.editId}`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            });
            const data = await res.json();

            if (res.ok) {
                Swal.fire({ icon:'success', title:'Actualizada', text: data.message, timer:1800, showConfirmButton:false })
                    .then(() => location.reload());
            } else {
                const errors = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
                Swal.fire({ icon:'error', title:'Error', text: errors });
            }
        },

        confirmDelete(id, titulo) {
            Swal.fire({
                title: '¿Eliminar noticia?',
                html: `<strong>${titulo}</strong><br>Esta acción es permanente.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Sí, eliminar'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/noticias/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                    }).then(() => location.reload());
                }
            });
        }
    }
}
</script>

@endsection
