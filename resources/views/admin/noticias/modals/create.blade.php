<div x-show="showModalCreate" 
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     x-cloak>
    
    <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-2xl shadow-2xl flex flex-col max-h-[90vh]"
         @click.away="showModalCreate = false">
        
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center bg-gray-800/30">
            <h3 class="text-xl font-bold text-white">Publicar Nueva Noticia</h3>
            <button @click="showModalCreate = false" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <form @submit.prevent="submitCreate()" class="flex flex-col overflow-hidden">
            <div class="p-6 space-y-5 overflow-y-auto" style="max-height: 60vh;">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Título de la Noticia</label>
                    <input type="text" x-model="createData.titulo" required
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:border-blue-500 outline-none transition shadow-inner"
                        placeholder="Ej. Resultados del torneo...">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Categoría</label>
                    <select x-model="createData.categoria" required
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-white outline-none focus:border-blue-500 transition">
                        <option value="General">General</option>
                        <option value="Deportivo">Deportivo</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Académico">Académico</option>
                        <option value="Aviso Urgente">Aviso Urgente</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Contenido / Cuerpo</label>
                    <textarea x-model="createData.contenido" required rows="4"
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-white outline-none focus:border-blue-500 transition"
                        placeholder="Describe la noticia detalladamente..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-300 mb-2">Imagen Portada</label>
                    <div class="relative border-2 border-dashed border-gray-800 rounded-2xl p-6 hover:border-blue-500/50 transition group bg-gray-950/50">
                        <input type="file" @change="createData.imagen = $event.target.files[0]" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        
                        <div class="text-center">
                            <div class="bg-gray-800 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-600/20 transition">
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <p class="text-xs text-gray-400">PNG, JPG hasta 3MB</p>
                            <template x-if="createData.imagen">
                                <p class="mt-2 text-xs text-blue-400 font-medium" x-text="'Seleccionado: ' + createData.imagen.name"></p>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-800 flex justify-end gap-3 bg-gray-800/20">
                <button type="button" @click="showModalCreate = false"
                    class="px-4 py-2 text-gray-400 hover:text-white transition font-medium">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-8 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-bold shadow-lg shadow-blue-900/40 transition active:scale-95">
                    Publicar Ahora
                </button>
            </div>
        </form>
    </div>
</div>