<div x-show="modalEdit" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="modal-content bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl relative"
         style="color:#111 !important;">

        <h2 class="text-3xl font-extrabold mb-6" style="color:#004aad !important;">Editar Usuario</h2>

        <form @submit.prevent="submitEdit($event, editData.id_usuario)">
            @csrf
            @method('PUT')

            <input type="hidden" name="activo" :value="editData.activo ? 1 : 0">

            <div class="mb-4">
                <label for="nombre_edit" class="font-semibold" style="color:#111 !important;">Nombre</label>
                <input type="text" name="nombre" id="nombre_edit" x-model="editData.nombre" required
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                       style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;" />
            </div>

            <div class="mb-4">
                <label for="email_edit" class="font-semibold" style="color:#111 !important;">email</label>
                <input type="email" name="email" id="email_edit" x-model="editData.email" required
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                       style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;" />
            </div>

            <div class="mb-4">
                <label for="rol_edit" class="font-semibold" style="color:#111 !important;">Rol</label>
                <select name="rol" id="rol_edit" x-model="editData.rol"
                        class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                        style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;">
                    <option value="estudiante">Estudiante</option>
                    <option value="profesor">Profesor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="password_edit" class="font-semibold" style="color:#111 !important;">Contraseña (Opcional)</label>
                <input type="password" name="password" id="password_edit"
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                       style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;" />
            </div>

            <div class="flex justify-end gap-4">
                <button type="button" @click="closeAll()"
                        class="px-6 py-2 rounded-lg bg-red-500 text-black font-semibold shadow hover:bg-red-600 transition"
                        style="color:black !important;">
                    Cancelar
                </button>
                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-green-500 text-black font-semibold shadow hover:bg-green-600 transition"
                        style="color:black !important;">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>
