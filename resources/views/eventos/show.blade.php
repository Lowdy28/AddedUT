@extends('layouts.admin')

@section('content')

<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-white">Detalle del Taller / Evento</h1>
        <a href="{{ route('eventos.index') }}" 
           class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition">
            ← Volver
        </a>
    </div>

    <!-- Card Principal -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        
        <!-- Header del Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">{{ $evento->nombre }}</h2>
            <p class="text-blue-100 text-sm mt-1">
                <span class="bg-blue-900/50 px-2 py-1 rounded">{{ $evento->categoria }}</span>
            </p>
        </div>

        <!-- Contenido -->
        <div class="p-6">
            <!-- Descripción -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Descripción</h3>
                <p class="text-gray-700 leading-relaxed">
                    {{ $evento->descripcion ?? 'Sin descripción disponible' }}
                </p>
            </div>

            <!-- Grid de Información -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <!-- Cupos -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-green-500 text-white rounded-full p-3 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Cupos Totales</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $evento->cupos }}</p>
                        </div>
                    </div>
                </div>

                <!-- Categoría -->
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-purple-500 text-white rounded-full p-3 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Categoría</p>
                            <p class="text-xl font-bold text-gray-900">{{ $evento->categoria }}</p>
                        </div>
                    </div>
                </div>

                <!-- Fecha Inicio -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-blue-500 text-white rounded-full p-3 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Fecha de Inicio</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $evento->fecha_inicio ? \Carbon\Carbon::parse($evento->fecha_inicio)->format('d/m/Y') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fecha Fin -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="bg-red-500 text-white rounded-full p-3 mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Fecha de Fin</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $evento->fecha_fin ? \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Información Adicional -->
            <div class="border-t border-gray-200 pt-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Información Adicional</h3>
                
                <div class="space-y-2 text-gray-700">
                    @if($evento->lugar)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span><strong>Lugar:</strong> {{ $evento->lugar }}</span>
                    </div>
                    @endif

                    @if($evento->horario)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span><strong>Horario:</strong> {{ $evento->horario }}</span>
                    </div>
                    @endif

                    @if($evento->dias)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span><strong>Días:</strong> {{ $evento->dias }}</span>
                    </div>
                    @endif

                    @if($evento->creador)
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span><strong>Creado por:</strong> {{ $evento->creador->nombre }}</span>
                    </div>
                    @endif

                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <span><strong>ID del Evento:</strong> {{ $evento->id_evento }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer con Acciones -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
            <a href="{{ route('eventos.index') }}" 
               class="text-gray-600 hover:text-gray-800 font-medium transition">
                ← Volver al listado
            </a>
            
            <div class="flex gap-2">
                <a href="{{ route('eventos.index') }}" 
                   class="bg-yellow-400 text-gray-900 px-4 py-2 rounded shadow hover:bg-yellow-500 transition font-medium">
                    Editar Evento
                </a>
            </div>
        </div>

    </div>
</div>

@endsection