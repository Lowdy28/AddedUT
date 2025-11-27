@extends('layouts.profesor')
@section('title', 'Mis Talleres')

@section('content')

{{-- Script simple para el modal --}}
<script>
    function toggleModal(modalID){
        const modal = document.getElementById(modalID);
        modal.classList.toggle("hidden");
        modal.classList.toggle("flex");
        document.body.style.overflow = modal.classList.contains("flex") ? "hidden" : "auto";
    }
</script>

{{-- Header al estilo de la captura --}}
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
    <div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 flex items-center gap-3">
            <i data-feather="layers" class="w-8 h-8 text-uttec-green"></i>
            Gestión de Actividades
        </h1>
        <p class="text-gray-600 mt-2 text-lg">Administra tus talleres extracurriculares.</p>
    </div>
    
    {{-- Botón de acción principal (Verde como en la captura) --}}
    <button onclick="toggleModal('modal-crear')" class="btn-uttec-green px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-md">
        <i data-feather="plus-square" class="w-5 h-5"></i>
        Crear Nuevo Taller
    </button>
</div>


{{-- Grid de Tarjetas (Estilo Captura) --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($talleres as $taller)
        {{-- TARJETA BLANCA --}}
        <div class="bg-white rounded-[20px] shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group border border-gray-100">
            
            {{-- 1. Encabezado con "Imagen" y Badge --}}
            <div class="h-48 bg-gradient-to-br from-blue-600 to-indigo-800 relative flex items-center justify-center p-4">
                <div class="absolute top-4 left-4 bg-blue-900/80 text-white text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-lg shadow-sm backdrop-blur-sm">
                   Taller
                </div>
                {{-- Icono gigante de fondo si no hay imagen --}}
                <i data-feather="image" class="w-20 h-20 text-white/20"></i>
                <h3 class="absolute bottom-4 left-4 text-white text-xl font-bold drop-shadow-md line-clamp-2 pr-4">
                    {{ $taller->nombre }}
                </h3>
            </div>

            {{-- 2. Cuerpo de la tarjeta --}}
            <div class="p-6">
                {{-- Fechas y Ubicación --}}
                <div class="flex flex-col gap-2 mb-4 text-sm text-gray-600 font-medium">
                    <div class="flex items-center gap-2">
                        <i data-feather="calendar" class="w-4 h-4 text-uttec-green"></i>
                        <span>Inicio: {{ \Carbon\Carbon::parse($taller->fecha_inicio)->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-feather="map-pin" class="w-4 h-4 text-red-500"></i>
                        <span>Campus UTTEC</span>
                    </div>
                </div>

                {{-- Descripción --}}
                <p class="text-gray-500 text-sm mb-6 line-clamp-3 leading-relaxed">
                    {{ $taller->descripcion ?? 'Sin descripción detallada para esta actividad.' }}
                </p>

                {{-- 3. Pie de tarjeta (Acciones de Profesor) --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    
                    {{-- Conteo de Cupos (Estilo badge verde claro de la captura) --}}
                    <div class="flex items-center gap-2 bg-[#e6f4ed] text-uttec-green px-4 py-2 rounded-xl font-bold text-sm">
                        <i data-feather="users" class="w-4 h-4"></i>
                        <span>{{ $taller->inscritos->count() }} / {{ $taller->cupos }} Inscritos</span>
                    </div>

                    {{-- Botones Editar/Eliminar --}}
                    <div class="flex items-center gap-1">
                        <a href="{{ route('eventos.edit', $taller->id_evento) }}" class="p-2 text-gray-400 hover:text-yellow-500 hover:bg-yellow-50 rounded-lg transition" title="Editar">
                            <i data-feather="edit-3" class="w-5 h-5"></i>
                        </a>
                        <form action="{{ route('eventos.destroy', $taller->id_evento) }}" method="POST" onsubmit="return confirm('¿Eliminar este taller?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Eliminar">
                                <i data-feather="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </div>
                </div>
                 {{-- Botón pequeño para ver lista de alumnos --}}
                 <div class="mt-4 text-center">
                    <button onclick="toggleModal('modal-alumnos-{{$taller->id_evento}}')" class="text-sm text-uttec-green hover:underline font-medium w-full py-2 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                        Ver lista de alumnos <i data-feather="chevron-down" class="w-4 h-4 inline"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- MODAL LISTA DE ALUMNOS (No lo incluí antes, pero debe seguir aquí) --}}
        <div id="modal-alumnos-{{$taller->id_evento}}" class="fixed inset-0 z-[60] hidden items-end md:items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div class="bg-white rounded-t-3xl md:rounded-3xl shadow-2xl w-full max-w-md max-h-[80vh] overflow-hidden flex flex-col animate-fade-in-up">
                <div class="p-5 border-b flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-lg text-gray-800">Alumnos en: {{ Str::limit($taller->nombre, 20) }}</h3>
                    <button onclick="toggleModal('modal-alumnos-{{$taller->id_evento}}')" class="text-gray-400 hover:text-gray-700 bg-white p-1 rounded-full shadow-sm"><i data-feather="x" class="w-5 h-5"></i></button>
                </div>
                <div class="p-5 overflow-y-auto">
                    @forelse($taller->inscritos as $inscripcion)
                        <div class="flex items-center gap-3 mb-3 p-2 hover:bg-gray-50 rounded-lg border border-transparent hover:border-gray-100 transition">
                            <div class="w-8 h-8 rounded-full bg-uttec-green/10 text-uttec-green flex items-center justify-center font-bold text-sm">
                                {{ substr($inscripcion->usuario->nombre, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">{{ $inscripcion->usuario->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $inscripcion->usuario->email }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No hay alumnos inscritos.</p>
                    @endforelse
                </div>
            </div>
        </div>
    @empty
        {{-- Estado vacío (Empty State) --}}
        <div class="col-span-full flex flex-col items-center justify-center py-24 bg-white rounded-[20px] shadow-sm border border-gray-200 text-center px-4">
            <div class="bg-gray-100 p-4 rounded-full mb-4">
                <i data-feather="inbox" class="w-12 h-12 text-gray-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">No tienes actividades creadas</h3>
            <p class="text-gray-500 mb-6 max-w-md">Comienza a crear talleres para que los estudiantes puedan inscribirse.</p>
            <button onclick="toggleModal('modal-crear')" class="btn-uttec-green px-6 py-2.5 rounded-full font-bold flex items-center gap-2 shadow">
                Crear mi primera actividad
            </button>
        </div>
    @endforelse
</div>


{{-- Animación para los modales --}}
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.3s ease-out forwards; }
</style>

{{-- CLAVE: Incluir el modal desde el nuevo archivo --}}
@include('profesor.modals.create') 

@endsection