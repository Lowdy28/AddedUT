<div x-show="showModalView" 
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     x-cloak>
    
    <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-2xl shadow-2xl flex flex-col max-h-[90vh]"
         @click.away="showModalView = false">
        
        <div class="px-6 py-4 border-b border-gray-800 flex justify-between items-center bg-gray-800/30">
            <h3 class="text-xl font-bold text-white">Detalle de la Noticia</h3>
            <button @click="showModalView = false" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 space-y-5 overflow-y-auto" style="max-height: 60vh;">
            
            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-2 uppercase tracking-wider">Imagen de Portada</label>
                <div class="rounded-xl overflow-hidden border border-gray-800 bg-gray-950">
                    <template x-if="viewData.imagen">
                        <img :src="'/storage/' + viewData.imagen" 
                             class="w-full h-48 object-cover" 
                             alt="Noticia">
                    </template>
                    <template x-if="!viewData.imagen">
                        <div class="w-full h-48 flex items-center justify-center text-gray-600 italic">
                            Sin imagen disponible
                        </div>
                    </template>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-1 uppercase tracking-wider">Título</label>
                <p class="text-xl font-bold text-white" x-text="viewData.titulo"></p>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-1 uppercase tracking-wider">Categoría</label>
                <span class="inline-block px-3 py-1 bg-blue-900/30 text-blue-400 text-xs font-bold rounded-full border border-blue-800/50" x-text="viewData.categoria"></span>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-400 mb-1 uppercase tracking-wider">Descripción</label>
                <div class="text-gray-300 leading-relaxed whitespace-pre-line bg-gray-800/20 p-4 rounded-xl border border-gray-800" x-text="viewData.contenido"></div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-gray-800 flex justify-end bg-gray-800/20">
            <button @click="showModalView = false"
                class="px-8 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-xl font-bold transition active:scale-95">
                Cerrar Vista
            </button>
        </div>
    </div>
</div>