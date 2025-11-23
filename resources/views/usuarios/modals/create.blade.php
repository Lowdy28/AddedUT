<div x-show="modalCreate" x-cloak
     class="modal-overlay fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm"
     x-transition:enter="transition duration-300"
     x-transition:enter-start="opacity-0 scale-90"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-90">

    <div class="modal-content bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl relative"
         style="color:#111 !important;">

        <h2 class="text-3xl font-extrabold mb-6" style="color:#004aad !important;">Nuevo Usuario</h2>

        <form @submit.prevent="submitCreate($event)">
            @csrf

            <!-- Nombre -->
            <div class="mb-4">
                <label for="nombre_create" class="font-semibold" style="color:#111 !important;">Nombre</label>
                <input type="text" name="nombre" id="nombre_create" required
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                       style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email_create" class="font-semibold" style="color:#111 !important;">Email</label>
                <input type="email" name="email" id="email_create" required
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                       style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;" />
            </div>

            <!-- Rol -->
            <div class="mb-4">
                <label for="rol_create" class="font-semibold" style="color:#111 !important;">Rol</label>
                <select name="rol" id="rol_create"
                        class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                        style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;">
                    <option value="estudiante">Estudiante</option>
                    <option value="profesor">Profesor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <!-- Contraseña -->
            <div class="mb-6">
                <label for="password_create" class="font-semibold" style="color:#111 !important;">Contraseña</label>
                <input type="password" name="password" id="password_create" required
                       class="w-full px-4 py-2 mt-1 rounded-lg border border-gray-300 shadow-sm"
                       style="color:#111 !important; background:#f9fafb !important; border:1px solid #d1d5db !important;" />
            </div>

            <!-- Botones -->
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
