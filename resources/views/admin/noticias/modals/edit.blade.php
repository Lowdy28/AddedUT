<div x-show="showModalEdit" 
     class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     x-cloak>
    
    <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-2xl shadow-2xl flex flex-col max-h-[90vh]"
         @click.away="showModalEdit = false">
        
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center bg-yellow-600/10 flex-shrink-0">
            <div>
                <h3 class="text-xl font-bold text-white">Editar Noticia</h3>
                <p class="text-[10px] text-yellow-500 font-mono uppercase">ID: <span x-text="editData.id"></span></p>
            </div>
            <button @click="showModalEdit = false" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form @submit.prevent="submitUpdate()" class="flex flex-col overflow-hidden">
            <div class="p-6 space-y-5 overflow-y-auto custom-scroll" style="max-height: 60vh;">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-2 font-mono uppercase text-[10px] tracking-widest">Título</label>
                    <input type="text" x-model="editData.titulo" required
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-white focus:border-yellow-500 outline-none transition shadow-inner">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-2 font-mono uppercase text-[10px] tracking-widest">Categoría</label>
                    <select x-model="editData.categoria" required
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-white outline-none focus:border-yellow-500 transition">
                        <option value="General">General</option>
                        <option value="Deportivo">Deportivo</option>
                        <option value="Cultural">Cultural</option>
                        <option value="Académico">Académico</option>
                        <option value="Aviso Urgente">Aviso Urgente</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-2 font-mono uppercase text-[10px] tracking-widest">Contenido</label>
                    <textarea x-model="editData.contenido" required rows="4"
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl px-4 py-2.5 text-white outline-none focus:border-yellow-500 transition"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-400 mb-3 font-mono uppercase text-[10px] tracking-widest">Imagen de Portada</label>
                    
                    <div class="relative w-full aspect-video rounded-xl overflow-hidden border border-gray-800 bg-gray-950 mb-3">
                        <template x-if="editData.imagen_url && !editData.imagen">
                            <img :src="'/storage/' + editData.imagen_url" 
                                 class="w-full h-full object-cover">
                        </template>
                        
                        <template x-if="!editData.imagen_url && !editData.imagen">
                            <div class="w-full h-full flex items-center justify-center bg-gray-900 italic text-gray-600 text-xs">
                                Sin imagen seleccionada
                            </div>
                        </template>

                        <template x-if="editData.imagen">
                            <div class="w-full h-full flex flex-col items-center justify-center bg-yellow-600/20 border-2 border-yellow-500/50">
                                <svg class="w-12 h-12 text-yellow-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-yellow-500 font-bold text-xs uppercase tracking-tighter" x-text="'LISTO: ' + editData.imagen.name"></p>
                            </div>
                        </template>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="file" x-ref="btnFileInput" @change="editData.imagen = $event.target.files[0]" accept="image/*" class="hidden">
                        
                        <button type="button" @click="$refs.btnFileInput.click()"
                            class="flex-1 bg-gray-800 hover:bg-gray-700 text-gray-300 px-4 py-2.5 rounded-xl border border-gray-700 transition flex items-center justify-center gap-2 group">
                            <svg class="w-5 h-5 text-gray-500 group-hover:text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-widest">Cambiar Imagen</span>
                        </button>

                        <template x-if="editData.imagen">
                            <button type="button" @click="editData.imagen = null" class="text-red-500 hover:text-red-400 p-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-gray-800 flex justify-end gap-3 bg-gray-800/20 flex-shrink-0">
                <button type="button" @click="showModalEdit = false"
                    class="px-5 py-2 text-gray-400 hover:text-white transition font-bold uppercase text-xs tracking-widest">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-8 py-2.5 bg-yellow-600 hover:bg-yellow-700 text-white rounded-xl font-black uppercase text-xs tracking-widest shadow-lg shadow-yellow-900/40 transition active:scale-95">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>