<div x-show="modalDelete" 
     x-cloak
     @click.self="closeAll()"
     class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">

    <div class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl"
         @click.stop>

        <h2 class="text-2xl font-bold mb-6 text-red-600">
            Eliminar Inscripción
        </h2>

        <p class="mb-6 text-gray-700 text-lg">
            ¿Estás seguro que deseas eliminar esta inscripción?
        </p>

        <div class="flex justify-end gap-4">
            <button type="button" 
                    @click="closeAll()"
                    class="px-6 py-3 rounded-lg bg-red-600 text-white font-bold shadow-lg hover:bg-red-700 transition">
                Cancelar
            </button>

            <button type="button"
                    @click="confirmarEliminar()"
                    class="px-6 py-3 rounded-lg bg-red-600 text-white font-bold shadow-lg hover:bg-red-700 transition">
                Eliminar
            </button>
        </div>

        <!-- Formulario oculto para eliminar -->
        <form :id="'delete-form-' + deleteId" 
              :action="`/inscripciones/${deleteId}`" 
              method="POST" 
              style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>

<script>
function confirmarEliminar() {
    const deleteId = Alpine.store ? Alpine.raw(this.deleteId) : this.deleteId;
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + deleteId).submit();
        }
    });
}
</script>